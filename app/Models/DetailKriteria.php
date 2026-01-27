<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailKriteria extends Model
{
    protected $table = "tbl_detail_kriteria";

    protected $primaryKey = "id_detail_kriteria";

    protected $guarded = ["id_detail_kriteria"];

    public $timestamps = false;
}
