<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exception extends Model
{
    protected $table = "TBL_ERROR";
    protected $primaryKey = "ERROR_ID";
    protected $guarded = ["ERROR_ID"];

    public $timestamps = false;
}
