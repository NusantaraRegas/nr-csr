<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogRelokasi extends Model
{
    protected $table = "tbl_log_relokasi";
    protected $primaryKey = "id_log";
    protected $guarded = ["id_log"];

    public $timestamps = false;
}
