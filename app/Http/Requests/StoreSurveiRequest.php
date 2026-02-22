<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSurveiRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'kelayakanID' => 'required',
            'bantuan' => 'required|in:Dana,Barang',
            'usulan' => 'required|in:Disarankan,Dipertimbangkan,Tidak Memenuhi Kriteria',
            'nilaiBantuanAsli' => 'required|numeric|min:1',
            'reviewer' => 'required|string|max:200',
        ];
    }

    public function messages()
    {
        return [
            'bantuan.required' => 'Jenis bantuan wajib dipilih.',
            'usulan.required' => 'Rekomendasi/usulan wajib dipilih.',
            'nilaiBantuanAsli.required' => 'Nilai bantuan asli wajib diisi.',
            'reviewer.required' => 'Reviewer wajib dipilih.',
        ];
    }
}
