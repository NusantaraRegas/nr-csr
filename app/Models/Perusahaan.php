<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    protected $table = "TBL_PERUSAHAAN";
    protected $primaryKey = "ID_PERUSAHAAN";
    protected $guarded = ["ID_PERUSAHAAN"];
    protected $fillable = ['ID_PERUSAHAAN', 'NAMA_PERUSAHAAN', 'KODE', 'FOTO_PROFILE', 'ALAMAT', 'NO_TELP', 'PIC'];

    public $timestamps = false;

    public function picUser()
    {
        return $this->belongsTo(User::class, 'pic', 'id_user');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id_perusahaan', 'id_perusahaan');
    }

    public function pengirim()
    {
        return $this->hasMany(Pengirim::class, 'id_perusahaan', 'id_perusahaan');
    }

    public function anggaran()
    {
        return $this->hasMany(Anggaran::class, 'id_perusahaan', 'id_perusahaan');
    }
}
