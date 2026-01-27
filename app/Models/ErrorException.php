<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorException extends Model
{
    protected $table = "tbl_exception";
    protected $primaryKey = "error_id";
    protected $guarded = ["error_id"];

    public $timestamps = false;
}
