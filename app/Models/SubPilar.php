<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubPilar extends Model
{
    protected $table = "TBL_SUB_PILAR";
    protected $primaryKey = "ID_SUB_PILAR";
    protected $guarded = ["ID_SUB_PILAR"];

    public $timestamps = false;
}
