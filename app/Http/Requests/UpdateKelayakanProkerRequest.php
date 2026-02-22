<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKelayakanProkerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'kelayakanID' => 'required',
            'prokerID' => 'required',
            'pilar' => 'required|max:100',
            'tpb' => 'required|max:200',
        ];
    }

    public function messages()
    {
        return [
            'prokerID.required' => 'Program kerja harus dipilih',
            'pilar.required' => 'Pilar harus diisi',
            'tpb.required' => 'TPB harus diisi',
        ];
    }
}
