<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranVendor extends Model
{
    protected $table = "tbl_pembayaran_vendor";
    protected $primaryKey = "id_pembayaran";
    protected $guarded = ["id_pembayaran"];
    public $timestamps = false;
}
