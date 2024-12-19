<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KendaraanModel extends Model
{
    protected $table = 'kendaraan'; // Nama tabel di database
    protected $primaryKey = 'id_kendaraan'; // Primary key tabel

    protected $fillable = [
        'id_jenis_kendaraan',
        'nama_kendaraan',
        'no_kendaraan',
        'tanggal_produksi_kendaraan',
        'status',
    ];

    // Relasi ke tabel jenis_kendaraan
    public function jenisKendaraan(): BelongsTo
    {
        return $this->belongsTo(JenisKendaraanModel::class, 'id_jenis_kendaraan', 'id_jenis_kendaraan');
    }

    // Aksesors untuk status
    public function getStatusAttribute($value)
    {
        return ucfirst($value); // Menampilkan status dengan huruf kapital pertama
    }
}
