<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SektorBantuan extends Model
{
    protected $table = "tbl_sektor";
    protected $primaryKey = "id_sektor";
    protected $guarded = ["id_sektor"];
    public $timestamps = false;
}
