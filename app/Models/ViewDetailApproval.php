<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewDetailApproval extends Model
{
    protected $table = "v_detail_approval";

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
