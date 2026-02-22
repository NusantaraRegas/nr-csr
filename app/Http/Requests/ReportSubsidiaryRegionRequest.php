<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportSubsidiaryRegionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'tahun' => 'required',
        ];
    }
}
