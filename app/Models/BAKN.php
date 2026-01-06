<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BAKN extends Model
{
    protected $table = "TBL_BAKN";
    protected $primaryKey = "BAKN_ID";
    protected $guarded = ["BAKN_ID"];

    public $timestamps = false;
}
