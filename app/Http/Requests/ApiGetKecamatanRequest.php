<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiGetKecamatanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'provinsi' => 'required|string|max:100',
            'kabupaten' => 'required|string|max:100',
        ];
    }
}
