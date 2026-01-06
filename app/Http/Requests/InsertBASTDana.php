<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertBASTDana extends FormRequest
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
            'noAgenda' => 'required',
            'pilar' => 'required',
            'bantuanUntuk' => 'required',
            'proposalDari' => 'required',
            'alamat' => 'required',
            'kabupaten' => 'required',
            'penanggungJawab' => 'required',
            'bertindakSebagai' => 'required',
            'noSurat' => 'required',
            'tglSurat' => 'required',
            'perihal' => 'required',
            'noPelimpahan' => 'required',
            'tglPelimpahan' => 'required',
            //'pihakKedua' => 'required',
//            'namaBank' => 'required',
//            'noRekening' => 'required',
//            'atasNama' => 'required',
            'namaPejabat' => 'required',
            'jabatanPejabat' => 'required',
        ];
    }
}
