<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Barang;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung transaksi dan pendapatan hari ini
        $hariIni = Carbon::today();
        $transaksiHariIni = Transaksi::whereDate('tanggal', $hariIni)->count();
        $pendapatanHariIni = Transaksi::whereDate('tanggal', $hariIni)->sum('total_harga');

        // 2. Hitung barang yang stoknya menipis (misalnya stok <= 5)
        $stokMenipis = Barang::where('stok', '<=', 5)->count();

        // 3. Ambil 5 transaksi terbaru untuk ditampilkan di tabel
        $transaksiTerbaru = Transaksi::orderBy('tanggal', 'desc')->take(5)->get();

        return view('dashboard', compact(
            'transaksiHariIni',
            'pendapatanHariIni',
            'stokMenipis',
            'transaksiTerbaru'
        ));
    }
}