<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = "tbl_bank";
    protected $primaryKey = "bank_id";
    protected $guarded = ["bank_id"];

    public $timestamps = false;
}
