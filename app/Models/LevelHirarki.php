<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelHirarki extends Model
{
    protected $table = "tbl_level_hirarki";
    protected $primaryKey = "id";
    protected $guarded = ["id"];

    public $timestamps = false;

    public function hirarki()
    {
        return $this->hasOne(Hirarki::class, 'id_level', 'id');
    }
}
