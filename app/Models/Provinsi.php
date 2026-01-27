<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = "tbl_provinsi";
    protected $primaryKey = "id_provinsi";
    protected $guarded = ["id_provinsi"];

    public $timestamps = false;
}
