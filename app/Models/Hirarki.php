<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hirarki extends Model
{
    protected $table = "tbl_hirarki";
    protected $primaryKey = "id";
    protected $guarded = ["id"];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function level()
    {
        return $this->belongsTo(LevelHirarki::class, 'id_level', 'id');
    }
}
