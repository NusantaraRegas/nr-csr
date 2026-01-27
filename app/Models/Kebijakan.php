<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kebijakan extends Model
{
    protected $table = "tbl_kebijakan";
    protected $primaryKey = "id_kebijakan";
    protected $guarded = ["id_kebijakan"];

    public $timestamps = false;
}
