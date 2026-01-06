<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KTPVendor extends Model
{
    protected $table = "tbl_ktp_pengurus";
    protected $primaryKey = "ktp_id";
    protected $guarded = ["ktp_id"];

    public $timestamps = false;
}
