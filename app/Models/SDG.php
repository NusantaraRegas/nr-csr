<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SDG extends Model
{
    protected $table = "tbl_sdg";
    protected $primaryKey = "id_sdg";
    protected $guarded = ["id_sdg"];

    public $timestamps = false;
}
