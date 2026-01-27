<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SPH extends Model
{
    protected $table = "tbl_sph";
    protected $primaryKey = "sph_id";
    protected $guarded = ["sph_id"];

    public $timestamps = false;
}
