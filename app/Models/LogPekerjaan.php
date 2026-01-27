<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogPekerjaan extends Model
{
    protected $table = "tbl_log_pekerjaan";
    protected $primaryKey = "id_log";
    protected $guarded = ["id_log"];

    public $timestamps = false;
}
