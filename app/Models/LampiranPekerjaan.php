<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LampiranPekerjaan extends Model
{
    protected $table = "tbl_lampiran_pekerjaan";
    protected $primaryKey = "lampiran_id";
    protected $guarded = ["lampiran_id"];

    public $timestamps = false;
}
