<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentVendor extends Model
{
    protected $table = "tbl_assessment_vendor";
    protected $primaryKey = "assessment_id";
    protected $guarded = ["assessment_id"];

    public $timestamps = false;
}
