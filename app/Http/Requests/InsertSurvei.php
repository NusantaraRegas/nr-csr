<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertSurvei extends FormRequest
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
            'usulan' => 'required',
            'bantuan' => 'required',
            'nilaiBantuan' => 'required',
            'survei' => 'required',
            'termin' => 'required',
            'survei1' => 'required',
            'survei2' => 'required',
        ];
    }
}
