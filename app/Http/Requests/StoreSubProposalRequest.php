<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubProposalRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'noAgenda' => 'required|string|max:100',
            'namaKetua' => 'required|string|max:255',
            'namaLembaga' => 'required|string|max:255',
            'alamat' => 'required|string',
            'provinsi' => 'required|string|max:100',
            'kabupaten' => 'required|string|max:100',
            'kambing' => 'nullable|numeric|min:0',
            'hargaKambing' => 'nullable|string|max:100',
            'sapi' => 'nullable|numeric|min:0',
            'hargaSapi' => 'nullable|string|max:100',
        ];
    }
}
