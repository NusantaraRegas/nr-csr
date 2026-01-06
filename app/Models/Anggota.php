<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = "tbl_anggota";
    protected $primaryKey = "id_anggota";
    protected $guarded = ["id_anggota"];

    public $timestamps = false;
}
