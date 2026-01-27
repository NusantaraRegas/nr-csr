<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogVendor extends Model
{
    protected $table = "tbl_log_vendor";
    protected $primaryKey = "lod_id";
    protected $guarded = ["log_id"];

    public $timestamps = false;
}
