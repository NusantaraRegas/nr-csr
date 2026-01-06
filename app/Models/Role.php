<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "tbl_role";
    protected $primaryKey = "id_role";
    protected $guarded = ["id_role"];

    public $timestamps = false;
}
