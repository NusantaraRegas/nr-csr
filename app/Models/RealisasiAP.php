<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RealisasiAP extends Model
{
    protected $table = "tbl_realisasi_ap";
    protected $primaryKey = "id_realisasi";
    protected $guarded = ["id_realisasi"];

    public $timestamps = false;
}
