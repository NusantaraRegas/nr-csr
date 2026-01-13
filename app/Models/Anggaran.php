<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggaran extends Model
{
    protected $table = 'tbl_anggaran';
    protected $primaryKey = 'id_anggaran';
    protected $guarded = ['id_anggaran'];

    public $timestamps = false;

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }

}
