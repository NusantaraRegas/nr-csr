<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BASTDana extends Model
{
    protected $table = "TBL_BAST_DANA";
    protected $primaryKey = "ID_BAST_DANA";
    protected $guarded = ["ID_BAST_DANA"];

    public $timestamps = false;

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id', 'id_user');
    }
}
