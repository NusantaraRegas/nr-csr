<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BAKN extends Model
{
    protected $table = "tbl_bakn";
    protected $primaryKey = "bakn_id";
    protected $guarded = ["bakn_id"];

    public $timestamps = false;
}
