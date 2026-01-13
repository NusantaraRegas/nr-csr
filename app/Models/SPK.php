<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SPK extends Model
{
    protected $table = "tbl_spk";
    protected $primaryKey = "id_spk";
    protected $guarded = ["id_spk"];

    public $timestamps = false;
}
