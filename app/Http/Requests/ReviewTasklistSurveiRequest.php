<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewTasklistSurveiRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'surveiID' => 'required',
            'hasilSurvei' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'hasilSurvei.required' => 'Hasil survei harus diisi.',
            'surveiID.required' => 'Data survei tidak valid.',
        ];
    }
}
