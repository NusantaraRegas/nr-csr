<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExportPopay extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'noPO' => 'required',
            'tglPO' => 'required',
            'namaBank' => 'required',
            'atasNama' => 'required|max:150',
            'cabangBank' => 'required|max:150',
            'noRekening' => 'required|numeric',
        ];
    }
}
