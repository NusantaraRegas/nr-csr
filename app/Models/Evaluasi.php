<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluasi extends Model
{
    protected $table = "tbl_evaluasi";
    protected $primaryKey = "id_evaluasi";
    protected $guarded = ["id_evaluasi"];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }
}
