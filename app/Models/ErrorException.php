<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorException extends Model
{
    protected $table = "TBL_EXCEPTION";
    protected $primaryKey = "ERROR_ID";
    protected $guarded = ["ERROR_ID"];

    public $timestamps = false;
}
