<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hirarki extends Model
{
    protected $table = "TBL_HIRARKI";
    protected $primaryKey = "ID";
    protected $guarded = ["ID"];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'ID_USER', 'ID_USER');
    }

    public function level()
    {
        return $this->belongsTo(LevelHirarki::class, 'ID', 'ID_LEVEL');
    }
}
