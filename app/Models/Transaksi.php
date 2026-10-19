<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi'; // Menentukan nama tabel secara manual agar tidak mencari 'transaksis'
    protected $primaryKey = 'id_transaksi'; // Karena primary key kita bukan 'id' biasa
    public $incrementing = false; // Karena id_transaksi berupa teks/string (misal: TRX-...)
    protected $keyType = 'string';
    
    public $timestamps = false; // Karena tabel kita tidak ada kolom created_at & updated_at bawaan

    protected $fillable = [
        'id_transaksi',
        'tanggal',
        'no_polisi',
        'nama_pelanggan',
        'total_harga'
    ];
}