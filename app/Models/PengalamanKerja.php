<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengalamanKerja extends Model
{
    protected $table = "tbl_pengalaman_kerja";
    protected $primaryKey = "pengalaman_id";
    protected $guarded = ["pengalaman_id"];

    public $timestamps = false;
}
