<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewYKPP extends Model
{
    protected $table = "nr_csr.v_ykpp";

    public function proker()
    {
        return $this->hasOne(Proker::class, 'id_proker', 'id_proker');
    }
}
