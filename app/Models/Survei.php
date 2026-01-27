<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survei extends Model
{
    protected $table = "tbl_survei";
    protected $primaryKey = "id_survei";
    protected $guarded = ["id_survei"];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }
}
