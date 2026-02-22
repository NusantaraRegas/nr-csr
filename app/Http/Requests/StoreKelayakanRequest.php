<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKelayakanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'noAgenda' => 'required|unique:tbl_kelayakan,no_agenda|max:100',
            'tglPenerimaan' => 'required|date',
            'pengirim' => 'required',
            'noSurat' => 'required|max:100',
            'tglSurat' => 'required|date',
            'sifat' => 'required',
            'digunakanUntuk' => 'required|string|max:200',
            'jenis' => 'required',
            'dari' => 'required|string|max:150',
            'alamat' => 'required|string|max:255',
            'besarPermohonanAsli' => 'required|numeric',
            'perihal' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kabupaten' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kelurahan' => 'required|string|max:100',
            'deskripsiBantuan' => 'required|string|max:500',
            'disposisi' => 'required|file|mimes:pdf',
            'lampiran' => 'required|file|mimes:pdf',
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
            'dari.required' => 'Nama lembaga harus dipilih',
            'besarPermohonan.required' => 'Besar permohonan harus diisi',
            'besarPermohonan.regex' => 'Format besar permohonan hanya angka, koma, dan titik',
            'perihal.required' => 'Kategori bantuan harus diisi',
            'provinsi.required' => 'Provinsi harus diisi',
            'kabupaten.required' => 'Kabupaten/Kota harus diisi',
            'kecamatan.required' => 'Kecamatan harus diisi',
            'kelurahan.required' => 'Kelurahan harus diisi',
            'deskripsiBantuan.required' => 'Deskripsi bantuan harus diisi',
            'deskripsiBantuan.max' => 'Deskripsi maksimal 500 karakter',
            'disposisi.required' => 'Disposisi wajib diunggah',
            'disposisi.mimes' => 'Disposisi harus berformat PDF',
            'lampiran.required' => 'Proposal/Surat wajib diunggah',
            'lampiran.mimes' => 'Proposal/Surat harus berformat PDF',
        ];
    }
}
