<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SPK extends Model
{
    protected $table = "TBL_SPK";
    protected $primaryKey = "ID_SPK";
    protected $guarded = ["ID_SPK"];

    public $timestamps = false;
}
