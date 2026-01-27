<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailSPK extends Model
{
    protected $table = "tbl_detail_spk";
    protected $primaryKey = "id_detail_spk";
    protected $guarded = ["id_detail_spk"];

    public $timestamps = false;
}
