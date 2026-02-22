<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKelayakanProposalRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'kelayakanID' => 'required',
            'noAgenda' => 'required|max:100',
            'tglPenerimaan' => 'required|date',
            'pengirim' => 'required',
            'noSurat' => 'required|max:100',
            'tglSurat' => 'required|date',
            'sifat' => 'required',
            'digunakanUntuk' => 'required|string|max:200',
            'jenis' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'noAgenda.required' => 'No Agenda harus diisi',
            'noAgenda.max' => 'No Agenda maksimal 100 karakter',
            'tglPenerimaan.required' => 'Tanggal penerimaan harus diisi',
            'tglPenerimaan.date' => 'Format tanggal penerimaan tidak valid',
            'pengirim.required' => 'Pengirim harus diisi',
            'noSurat.required' => 'Nomor surat harus diisi',
            'noSurat.max' => 'Nomor surat maksimal 100 karakter',
            'tglSurat.required' => 'Tanggal surat harus diisi',
            'tglSurat.date' => 'Format tanggal surat tidak valid',
            'sifat.required' => 'Sifat surat harus diisi',
            'digunakanUntuk.required' => 'Perihal harus diisi',
            'digunakanUntuk.max' => 'Perihal maksimal 200 karakter',
            'jenis.required' => 'Jenis proposal harus dipilih',
        ];
    }
}
