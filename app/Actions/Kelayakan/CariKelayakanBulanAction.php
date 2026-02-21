<?php

namespace App\Actions\Kelayakan;

use App\Http\Requests\CariKelayakanBulanRequest;

class CariKelayakanBulanAction
{
    public function execute(CariKelayakanBulanRequest $request)
    {
        return redirect()->route('dataBulan', [
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
        ]);
    }
}
