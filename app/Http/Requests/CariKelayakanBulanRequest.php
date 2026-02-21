<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CariKelayakanBulanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'bulan' => 'required',
            'tahun' => 'required',
        ];
    }
}
