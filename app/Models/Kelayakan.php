<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelayakan extends Model
{
    protected $table = "tbl_kelayakan";
    protected $primaryKey = "id_kelayakan";
    protected $guarded = ['id_kelayakan'];

    public $timestamps = false;

    // RELASI: 1 kelayakan memiliki banyak lampiran
    public function lampiran()
    {
        return $this->hasMany(Lampiran::class, 'id_kelayakan', 'id_kelayakan');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_kelayakan', 'id_kelayakan');
    }

    public function proker()
    {
        return $this->hasOne(Proker::class, 'id_proker', 'id_proker');
    }
}
