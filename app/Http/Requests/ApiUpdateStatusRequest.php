<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiUpdateStatusRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'pembayaran_id' => 'required|integer|min:1',
            'pr_id' => 'required|string|max:100',
        ];
    }
}
