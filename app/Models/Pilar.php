<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pilar extends Model
{
    protected $table = "tbl_pilar";
    protected $primaryKey = "id_pilar";
    protected $guarded = ["id_pilar"];

    public $timestamps = false;
}
