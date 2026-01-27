<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertSPK extends FormRequest
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
            'judulKegiatan' => 'required',
            'nama' => 'required',
            'jabatan' => 'required',
            'perusahaan' => 'required',
            'alamat' => 'required',
            'noPenawaran' => 'required',
            'tglPenawaran' => 'required',
            'noBAST' => 'required',
            'tglBAST' => 'required',
            'nilaiPengadaan' => 'required',
            'termin' => 'required',
            'termin1' => 'required',
            'pengadilan' => 'required',
            'tglBatasWaktu' => 'required',
            'namaBank' => 'required',
            'noRekening' => 'required',
            'atasNama' => 'required',
            'cabang' => 'required',
            'namaPejabat' => 'required',
            'jabatanPejabat' => 'required',
        ];
    }
}
