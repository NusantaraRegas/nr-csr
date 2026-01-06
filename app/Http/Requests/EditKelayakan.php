<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditKelayakan extends FormRequest
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
            'pengirim' => 'required',
            'noAgenda' => 'required',
            'tglPenerimaan' => 'required',
            'sifat' => 'required',
            'dari' => 'required',
            'noSurat' => 'required',
            'tglSurat' => 'required',
            'perihal' => 'required',
            'alamat' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'pengajuProposal' => 'required',
            'bertindakSebagai' => 'required',
            'noTelp' => 'required|numeric',
            'email' => 'required|email',
            'besarPermohonan' => 'required',
            'digunakanUntuk' => 'required',
            'ruangLingkup' => 'required',
        ];
    }
}
