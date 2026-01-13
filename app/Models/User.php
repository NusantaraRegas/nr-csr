<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // Postgres normalized schema uses lowercase, unquoted identifiers
    protected $table = "tbl_user";
    protected $primaryKey = "id_user";
    protected $guarded = ["id_user"];
    protected $hidden = ['password', 'remember_token'];

    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';

    // Cast id_perusahaan to integer to prevent decimal issues
    protected $casts = [
        'id_perusahaan' => 'integer',
    ];

    public function hirarki()
    {
        return $this->hasOne(Hirarki::class, 'id_user', 'id_user');
    }

    public function perusahaan()
    {
        return $this->hasOne(Perusahaan::class, 'pic', 'id_user');
    }

    public function namaPerusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }

    // RELASI: 1 user memiliki banyak log
    public function log()
    {
        return $this->hasMany(Log::class, 'created_by', 'id_user');
    }

    public function lampiran()
    {
        return $this->hasMany(Lampiran::class, 'created_by', 'id_user');
    }

    public function evaluasi()
    {
        return $this->hasMany(Evaluasi::class, 'created_by', 'id_user');
    }
}
