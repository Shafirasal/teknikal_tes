<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PeminjamanModel extends Model
{
    protected $table = 'peminjaman'; // Nama tabel di database
    protected $primaryKey = 'id_peminjaman'; // Primary key tabel

    protected $fillable = [
            'id_kendaraan',
            'id_perusahaan',
            'id_jenis_kendaraan',
            'driver_id',
            'koordinator_id',
            'nama_peminjaman',
            'tujuan_peminjaman',
            'tanggal_peminjaman',
            'tanggal_berakhir_peminjaman',
            'status'
        
    ];

    // Relasi ke tabel kendaraan
    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(KendaraanModel::class, 'id_kendaraan', 'id_kendaraan');
    }

    // Relasi ke tabel user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'user_id');
    }

    // Relasi ke tabel perusahaan
    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(PerusahaanModel::class, 'id_perusahaan', 'id_perusahaan');
    }

    // Aksesors atau mutators jika diperlukan
    public function getStatusAttribute($value)
    {
        return ucfirst($value); // Ubah status menjadi huruf kapital di awal
    }

    
    public function jeniskendaraan(): BelongsTo
    {
        return $this->belongsTo(JenisKendaraanModel::class, 'id_jenis_kendaraan', 'id_jenis_kendaraan');
    }

    public function driver()
    {
        return $this->belongsTo(UserModel::class, 'driver_id', 'user_id')
                    ->where('id_level', 2); // Hanya driver dengan level 2
    }
    
    public function koordinator()
    {
        return $this->belongsTo(UserModel::class, 'koordinator_id', 'user_id')
                    ->where('id_level', 3); // Hanya koordinator dengan level 3
    }
    
}
