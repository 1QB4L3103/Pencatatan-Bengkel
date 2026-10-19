<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    // Tampilkan daftar barang & fitur pencarian
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $barang = Barang::when($search, function ($query, $search) {
            return $query->where('nama_barang', 'like', "%{$search}%");
        })->orderBy('id_barang', 'desc')->paginate(10);

        return view('barang.index', compact('barang', 'search'));
    }

    // Simpan barang baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:100',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'satuan'      => 'required|string|max:20',
        ]);

        Barang::create([
            'nama_barang' => $request->nama_barang,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'satuan'      => $request->satuan,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    // Update data barang
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:100',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'satuan'      => 'required|string|max:20',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update([
            'nama_barang' => $request->nama_barang,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'satuan'      => $request->satuan,
        ]);

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil diperbarui!');
    }

    // Hapus barang
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus!');
    }
}