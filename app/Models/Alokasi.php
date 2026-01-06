<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alokasi extends Model
{
    protected $table = "tbl_alokasi";
    protected $primaryKey = "id_alokasi";
    protected $guarded = ["id_alokasi"];

    public $timestamps = false;
}
