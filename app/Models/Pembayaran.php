<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = "tbl_pembayaran";
    protected $primaryKey = "id_pembayaran";
    protected $guarded = ["id_pembayaran"];

    public $timestamps = false;

    // RELASI: setiap pembayaran milik satu kelayakan
    public function kelayakan()
    {
        return $this->belongsTo(Kelayakan::class, 'id_kelayakan', 'id_kelayakan');
    }
}
