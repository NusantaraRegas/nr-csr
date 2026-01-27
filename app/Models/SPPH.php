<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SPPH extends Model
{
    protected $table = "tbl_spph";
    protected $primaryKey = "spph_id";
    protected $guarded = ["spph_id"];

    public $timestamps = false;
}
