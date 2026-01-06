<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lembaga extends Model
{
    protected $table = "tbl_lembaga";

    protected $primaryKey = "id_lembaga";

    protected $guarded = ["id_lembaga"];

    public $timestamps = false;
}
