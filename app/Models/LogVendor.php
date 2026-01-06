<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogVendor extends Model
{
    protected $table = "TBL_LOG_VENDOR";
    protected $primaryKey = "LOG_ID";
    protected $guarded = ["LOG_ID"];

    public $timestamps = false;
}
