<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BASTDana extends Model
{
    protected $table = "tbl_bast_dana";
    protected $primaryKey = "id_bast_dana";
    protected $guarded = ["id_bast_dana"];

    public $timestamps = false;

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id', 'id_user');
    }
}
