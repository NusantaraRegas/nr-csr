<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentVendor extends Model
{
    protected $table = "TBL_ASSESSMENT_VENDOR";
    protected $primaryKey = "ASSESSMENT_ID";
    protected $guarded = ["ASSESSMENT_ID"];

    public $timestamps = false;
}
