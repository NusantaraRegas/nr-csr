<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    protected $table = "tbl_wilayah";

    protected $primaryKey = "id_wilayah";

    protected $guarded = ["id_wilayah"];

    public $timestamps = false;
}
