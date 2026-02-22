<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKelayakanPenerimaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'kelayakanID' => 'required',
            'dari' => 'required|string|max:150',
            'alamat' => 'required|string|max:255',
            'besarPermohonanAsli' => 'required|numeric',
            'perihal' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kabupaten' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kelurahan' => 'required|string|max:100',
            'deskripsiBantuan' => 'required|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'dari.required' => 'Nama lembaga harus dipilih',
            'besarPermohonanAsli.required' => 'Besar permohonan harus diisi',
            'besarPermohonanAsli.regex' => 'Format besar permohonan hanya angka, koma, dan titik',
            'perihal.required' => 'Kategori bantuan harus diisi',
            'provinsi.required' => 'Provinsi harus diisi',
            'kabupaten.required' => 'Kabupaten/Kota harus diisi',
            'kecamatan.required' => 'Kecamatan harus diisi',
            'kelurahan.required' => 'Kelurahan harus diisi',
            'deskripsiBantuan.required' => 'Deskripsi bantuan harus diisi',
            'deskripsiBantuan.max' => 'Deskripsi maksimal 500 karakter',
        ];
    }
}
