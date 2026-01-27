<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lampiran extends Model
{
    protected $table = "tbl_lampiran";
    protected $primaryKey = "id_lampiran";
    protected $guarded = ["id_lampiran"];

    public $timestamps = false;

    // RELASI: setiap lampiran milik satu kelayakan
    public function kelayakan()
    {
        return $this->belongsTo(Kelayakan::class, 'id_kelayakan', 'id_kelayakan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }
}
