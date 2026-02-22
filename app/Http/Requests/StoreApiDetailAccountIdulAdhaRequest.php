<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApiDetailAccountIdulAdhaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'prID' => 'required',
            'coaAccount' => 'required',
            'ppn' => 'required',
        ];
    }
}
