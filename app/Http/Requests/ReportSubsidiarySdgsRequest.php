<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportSubsidiarySdgsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'pilar' => 'required',
            'gols' => 'required',
            'tahun' => 'required',
        ];
    }
}
