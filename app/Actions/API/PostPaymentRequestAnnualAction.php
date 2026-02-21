<?php

namespace App\Actions\API;

use App\Http\Requests\PostPaymentRequestAnnualRequest;

class PostPaymentRequestAnnualAction
{
    public function execute(PostPaymentRequestAnnualRequest $request)
    {
        if (!$request->hasWilayahFilter()) {
            return redirect()->route('listRealisasiAllAnnual', ['year' => $request->tahun]);
        }

        if ($request->kabupaten == 'Semua Kabupaten/Kota') {
            return redirect()->route('listPaymentRequestProvinsi', [
                'year' => $request->tahun,
                'provinsi' => $request->provinsi,
            ]);
        }

        return redirect()->route('listPaymentRequestKabupaten', [
            'year' => $request->tahun,
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
        ]);
    }
}
