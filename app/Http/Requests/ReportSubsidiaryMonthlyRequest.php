<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportSubsidiaryMonthlyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'bulan1' => 'required',
            'bulan2' => 'required',
            'tahun' => 'required',
        ];
    }
}
