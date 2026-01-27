<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    protected $table = "tbl_perusahaan";
    protected $primaryKey = "id_perusahaan";
    protected $guarded = ["id_perusahaan"];
    protected $fillable = ['id_perusahaan', 'nama_perusahaan', 'kode', 'foto_profile', 'alamat', 'no_telp', 'pic'];

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
