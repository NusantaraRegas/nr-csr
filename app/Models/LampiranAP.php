<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LampiranAP extends Model
{
    protected $table = "tbl_lampiran_ap";
    protected $primaryKey = "id_lampiran";
    protected $guarded = ["id_lampiran"];

    public $timestamps = false;
}
