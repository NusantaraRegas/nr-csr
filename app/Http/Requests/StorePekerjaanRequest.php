<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePekerjaanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'namaPekerjaan' => 'required',
            'ringkasan' => 'required',
            'proker' => 'required',
            'nilaiPerkiraan' => 'required',
            'lampiran' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:10240',
        ];
    }
}
