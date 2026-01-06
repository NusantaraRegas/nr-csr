<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proker extends Model
{
    protected $table = "TBL_PROKER";
    protected $primaryKey = "ID_PROKER";
    protected $guarded = ["ID_PROKER"];

    public $timestamps = false;

    public function kelayakan()
    {
        return $this->hasMany(Kelayakan::class, 'id_proker', 'id_proker');
    }
}
