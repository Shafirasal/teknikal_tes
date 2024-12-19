<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Yajra\DataTables\Html\Editor\Fields\Hidden;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class UserModel extends Authenticable implements JWTSubject
{
    use HasFactory, Notifiable;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return[];
    }

    protected $table = 'users';    
    protected $primaryKey = 'user_id'; 

    protected $fillable = [
        'id_level',
        'password',
        'username',
        'nama',
        'alamat',
        'email',
        'jenis_kelamin',
        'avatar',
        'created_at',
        'updated_at'
    ];

      // Kolom timestamps (created_at, updated_at) - default diaktifkan
      public $timestamps = true;
    protected $hidden = ['password']; // jangan ditampilkan saat select

    protected $casts = ['password' => 'hashed']; // casting password agar otomatis di hash
    
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'id_level', 'id_level');
    }

    // Mendapatkan nama role
    public function getRoleName(): string {
        return $this->level->level_nama;
    }

    // Cek apakah user memiliki role tertentu
    public function hasRole($role): bool {
        return $this->level->kode_level == $role;
    }

    // Mendapatkan kode role
    public function getRole() {
        return $this->level->kode_level;
    }

    public function peminjaman()
    {
        return $this->hasMany(PeminjamanModel::class, 'user_id', 'user_id');
    }

    public function driverPeminjaman()
{
    return $this->hasMany(PeminjamanModel::class, 'driver_id', 'user_id');
}

public function koordinatorPeminjaman()
{
    return $this->hasMany(PeminjamanModel::class, 'koordinator_id', 'user_id');
}

}