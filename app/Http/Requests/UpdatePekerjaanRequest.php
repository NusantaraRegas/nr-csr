<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePekerjaanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'pekerjaanID' => 'required',
            'namaPekerjaan' => 'required',
            'ringkasan' => 'required',
            'proker' => 'required',
            'nilaiPerkiraan' => 'required',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:10240',
        ];
    }
}
