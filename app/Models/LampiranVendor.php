<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LampiranVendor extends Model
{
    protected $table = "tbl_lampiran_vendor";
    protected $primaryKey = "lampiran_id";
    protected $guarded = ["lampiran_id"];

    public $timestamps = false;
}
