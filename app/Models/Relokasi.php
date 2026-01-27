<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relokasi extends Model
{
    protected $table = "tbl_relokasi";
    protected $primaryKey = "id_relokasi";
    protected $guarded = ["id_relokasi"];

    public $timestamps = false;
}
