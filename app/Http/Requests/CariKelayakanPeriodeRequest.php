<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CariKelayakanPeriodeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'tanggal1' => 'required',
            'tanggal2' => 'required',
        ];

        if ($this->hasWilayahFilter()) {
            $rules['provinsi'] = 'required';
            $rules['kabupaten'] = 'required';
        }

        if ($this->hasPilarFilter()) {
            $rules['pilar'] = 'required';
            $rules['gols'] = 'required';
        }

        if ($this->hasJenisFilter()) {
            $rules['jenis'] = 'required';
        }

        return $rules;
    }

    public function hasWilayahFilter()
    {
        return $this->input('checkBookWilayah') != '';
    }

    public function hasPilarFilter()
    {
        return $this->input('checkBookPilar') != '';
    }

    public function hasJenisFilter()
    {
        return $this->input('checkBookJenis') != '';
    }
}
