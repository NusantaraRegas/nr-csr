<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proker extends Model
{
    protected $table = "nr_csr.tbl_proker";
    protected $primaryKey = "id_proker";
    protected $guarded = ["id_proker"];

    public $timestamps = false;

    public function kelayakan()
    {
        return $this->hasMany(Kelayakan::class, 'id_proker', 'id_proker');
    }
}
