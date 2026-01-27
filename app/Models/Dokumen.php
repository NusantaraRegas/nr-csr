<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $table = "tbl_dokumen";
    protected $primaryKey = "id";
    protected $guarded = ["id"];

    public $timestamps = false;
}
