<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerusahaanModel extends Model
{
    protected $table = 'perusahaan'; // Nama tabel di database
    protected $primaryKey = 'id_perusahaan'; // Primary key tabel

    protected $fillable = [
        'kode_perusahaan',
        'nama_perusahaan',
        'lokasi',
    ];

    // Tambahkan timestamps jika menggunakan created_at dan updated_at
    public $timestamps = true;
}
