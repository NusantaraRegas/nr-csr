<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = "TBL_USER";
    protected $primaryKey = "ID_USER";
    protected $guarded = ["ID_USER"];
    protected $hidden = ['PASSWORD', 'REMEMBER_TOKEN'];

    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';

    public function hirarki()
    {
        return $this->hasOne(Hirarki::class, 'ID_USER', 'ID_USER');
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