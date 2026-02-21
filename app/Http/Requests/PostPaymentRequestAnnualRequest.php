<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostPaymentRequestAnnualRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'tahun' => 'required',
        ];

        if ($this->hasWilayahFilter()) {
            $rules['provinsi'] = 'required';
            $rules['kabupaten'] = 'required';
        }

        return $rules;
    }

    public function hasWilayahFilter()
    {
        return $this->input('checkBookWilayah') != '';
    }
}
