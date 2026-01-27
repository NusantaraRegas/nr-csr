<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    protected $table = "tbl_pekerjaan";
    protected $primaryKey = "pekerjaan_id";
    protected $guarded = ["pekerjaan_id"];

    public $timestamps = false;
}
