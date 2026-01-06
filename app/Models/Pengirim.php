<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengirim extends Model
{
    protected $table = "tbl_pengirim";
    protected $primaryKey = "id_pengirim";
    protected $guarded = ["id_pengirim"];

    public $timestamps = false;

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }
}
