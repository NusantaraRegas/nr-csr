<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubProposal extends Model
{
    protected $table = "tbl_sub_proposal";
    protected $primaryKey = "id_sub_proposal";
    protected $guarded = ["id_sub_proposal"];

    public $timestamps = false;
}
