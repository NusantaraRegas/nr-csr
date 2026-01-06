<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelHirarki extends Model
{
    protected $table = "TBL_LEVEL_HIRARKI";
    protected $primaryKey = "ID";
    protected $guarded = ["ID"];

    public $timestamps = false;

    public function hirarki()
{
    return $this->hasOne(Hirarki::class, 'ID_LEVEL', 'ID');
}
}
