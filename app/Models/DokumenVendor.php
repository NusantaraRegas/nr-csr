<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenVendor extends Model
{
    protected $table = "tbl_dokumen_vendor";
    protected $primaryKey = "dokumen_id";
    protected $guarded = ["dokumen_id"];

    public $timestamps = false;
}
