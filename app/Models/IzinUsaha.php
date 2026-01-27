<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IzinUsaha extends Model
{
    protected $table = "tbl_izin_usaha";
    protected $primaryKey = "izin_usaha_id";
    protected $guarded = ["izin_usaha_id"];

    public $timestamps = false;
}
