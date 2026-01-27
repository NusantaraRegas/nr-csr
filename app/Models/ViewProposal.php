<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewProposal extends Model
{
    protected $table = "v_proposal";

    public function proker()
    {
        return $this->hasOne(Proker::class, 'id_proker', 'id_proker');
    }
}
