<?php

namespace App\Actions\Kelayakan;

use App\Http\Requests\CariKelayakanTahunRequest;

class CariKelayakanTahunAction
{
    public function execute(CariKelayakanTahunRequest $request)
    {
        return redirect()->route('dataTahun', $request->tahun);
    }
}
