<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exception extends Model
{
    protected $table = "tbl_error";
    protected $primaryKey = "error_id";
    protected $guarded = ["error_id"];

    public $timestamps = false;
}
