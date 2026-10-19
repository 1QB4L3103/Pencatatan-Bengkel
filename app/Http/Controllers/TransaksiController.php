<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function create()
    {
        $barang = Barang::where('stok', '>', 0)->get();
        return view('transaksi.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_polisi' => 'required|string|max:20',
            'items' => 'required|array|min:1',
        ]);

        try {
            DB::beginTransaction();

            $tanggalHariIni = Carbon::now()->format('Ymd');
            $jumlahHariIni = Transaksi::whereDate('tanggal', Carbon::today())->count() + 1;
            $idTransaksi = 'TRX-' . $tanggalHariIni . '-' . str_pad($jumlahHariIni, 4, '0', STR_PAD_LEFT);

            $totalHarga = 0;
            $detailData = [];

            foreach ($request->items as $item) {
                $jenis = $item['jenis'] ?? 'barang';

                if ($jenis === 'barang') {
                    $barang = Barang::findOrFail($item['id_barang']);

                    if ($barang->stok < $item['qty']) {
                        return back()->with('error', "Stok barang '{$barang->nama_barang}' tidak mencukupi!");
                    }

                    $subtotal = $barang->harga * $item['qty'];
                    $totalHarga += $subtotal;

                    // Potong stok
                    $barang->decrement('stok', $item['qty']);

                    $detailData[] = [
                        'id_transaksi' => $idTransaksi,
                        'id_barang'    => $barang->id_barang,
                        'nama_item'    => $barang->nama_barang,
                        'harga'        => $barang->harga,
                        'qty'          => $item['qty'],
                        'subtotal'     => $subtotal,
                    ];
                } else { // Jenis: Jasa
                    $hargaJasa = (float) $item['harga_jasa'];
                    $totalHarga += $hargaJasa;

                    $detailData[] = [
                        'id_transaksi' => $idTransaksi,
                        'id_barang'    => null,
                        'nama_item'    => $item['nama_jasa'],
                        'harga'        => $hargaJasa,
                        'qty'          => 1,
                        'subtotal'     => $hargaJasa,
                    ];
                }
            }

            // Simpan Transaksi Utama
            Transaksi::create([
                'id_transaksi'   => $idTransaksi,
                'tanggal'        => Carbon::now(),
                'no_polisi'      => strtoupper($request->no_polisi),
                'nama_pelanggan' => $request->nama_pelanggan ?? 'Umum',
                'total_harga'    => $totalHarga,
            ]);

            // Simpan Detail Transaksi
            foreach ($detailData as $detail) {
                DetailTransaksi::create($detail);
            }

            DB::commit();

            return redirect()->route('transaksi.create')->with('success', "Transaksi berhasil disimpan! No: {$idTransaksi}");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

        // Tampilkan Halaman Riwayat Transaksi
    public function riwayat(Request $request)
    {
        $search = $request->input('search');

        $transaksi = Transaksi::when($search, function ($query, $search) {
            return $query->where('no_polisi', 'like', "%{$search}%")
                        ->orWhere('id_transaksi', 'like', "%{$search}%")
                        ->orWhere('nama_pelanggan', 'like', "%{$search}%");
        })->orderBy('tanggal', 'desc')->paginate(10);

        return view('transaksi.riwayat', compact('transaksi', 'search'));
    }

    // Get Detail Transaksi via AJAX untuk Modal
    public function detail($id)
    {
        $transaksi = Transaksi::where('id_transaksi', $id)->firstOrFail();
        $detail = DetailTransaksi::where('id_transaksi', $id)->get();

        return response()->json([
            'transaksi' => $transaksi,
            'detail' => $detail
        ]);
    }
}