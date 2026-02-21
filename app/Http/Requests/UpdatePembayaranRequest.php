<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePembayaranRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'deskripsi' => 'required|string|max:500',
            'termin' => 'required',
            'metode' => 'required',
            'jumlahPembayaranAsli' => 'required|numeric',
            'fee' => 'required|numeric|min:0|max:100',
        ];
    }

    public function messages()
    {
        return [
            'deskripsi.required' => 'Deskripsi pembayaran harus diisi',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter',
            'termin.required' => 'Termin pembayaran harus dipilih',
            'metode.required' => 'Metode harus dipilih',
            'jumlahPembayaranAsli.required' => 'Jumlah pembayaran harus diisi',
            'fee.required' => 'Fee pembayaran harus diisi',
        ];
    }
}
