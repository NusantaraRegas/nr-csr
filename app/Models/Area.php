<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = "tbl_area";

    protected $primaryKey = "id_area";

    protected $guarded = ["id_area"];

    public $timestamps = false;
}
