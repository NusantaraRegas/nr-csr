<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKelayakanBankRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'kelayakanID' => 'required',
            'namaBank' => 'required',
            'noRekening' => 'required|numeric',
            'atasNama' => 'required|max:100|min:3',
        ];
    }

    public function messages()
    {
        return [
            'namaBank.required' => 'Nama bank harus diisi',
            'noRekening.required' => 'No rekening harus diisi',
            'atasNama.required' => 'Atas nama harus diisi',
            'atasNama.max' => 'Atas nama maksimal 100 karakter',
            'atasNama.min' => 'Atas nama minimal 3 karakter',
        ];
    }
}
