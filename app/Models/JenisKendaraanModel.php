<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisKendaraanModel extends Model
{
    protected $table = 'jenis_kendaraan'; // Nama tabel di database
    protected $primaryKey = 'id_jenis_kendaraan'; // Primary key tabel

    protected $fillable = [
        'kode_jenis_kendaraan',
        'nama_jenis_kendaraan',
    ];

    // Tambahkan timestamps jika menggunakan created_at dan updated_at
    public $timestamps = true;

    // Relasi ke tabel kendaraan
    public function kendaraan()
    {
        return $this->hasMany(KendaraanModel::class, 'id_jenis_kendaraan', 'id_jenis_kendaraan');
    }

    public function peminjaman()
    {
        return $this->hasMany(PeminjamanModel::class, 'id_peminjaman', 'id_peminjaman');
    }
}
