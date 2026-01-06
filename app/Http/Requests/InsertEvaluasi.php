<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertEvaluasi extends FormRequest
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
            'rencanaAnggaran' => 'required',
            'dokumen' => 'required',
            'denah' => 'required',
            'perkiraanDana' => 'required',
            'syarat' => 'required',
            'catatan' => 'required',
            'evaluator1' => 'required',
            'evaluator2' => 'required',
        ];
    }
}
