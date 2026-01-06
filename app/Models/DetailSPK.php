<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailSPK extends Model
{
    protected $table = "TBL_DETAIL_SPK";
    protected $primaryKey = "ID_DETAIL_SPK";
    protected $guarded = ["ID_DETAIL_SPK"];

    public $timestamps = false;
}
