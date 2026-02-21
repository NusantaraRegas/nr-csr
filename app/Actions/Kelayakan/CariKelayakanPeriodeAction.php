<?php

namespace App\Actions\Kelayakan;

use App\Http\Requests\CariKelayakanPeriodeRequest;

class CariKelayakanPeriodeAction
{
    public function execute(CariKelayakanPeriodeRequest $request)
    {
        $tanggal1 = strtoupper(date('Y-m-d', strtotime($request->tanggal1)));
        $tanggal2 = strtoupper(date('Y-m-d', strtotime($request->tanggal2)));

        $hasWilayah = $request->hasWilayahFilter();
        $hasPilar = $request->hasPilarFilter();
        $hasJenis = $request->hasJenisFilter();

        if (!$hasWilayah && !$hasPilar && !$hasJenis) {
            return redirect()->route('data-periode', [
                'tanggal1' => $tanggal1,
                'tanggal2' => $tanggal2,
            ]);
        }

        if ($hasWilayah && !$hasPilar && !$hasJenis) {
            return redirect()->route('data-provinsi', [
                'tanggal1' => $tanggal1,
                'tanggal2' => $tanggal2,
                'provinsi' => $request->provinsi,
                'kabupaten' => encrypt($request->kabupaten),
            ]);
        }

        if ($hasWilayah && $hasPilar && !$hasJenis) {
            return redirect()->route('dataProvinsiSDGs', [
                'tanggal1' => $tanggal1,
                'tanggal2' => $tanggal2,
                'provinsi' => $request->provinsi,
                'kabupaten' => encrypt($request->kabupaten),
                'pilar' => $request->pilar,
                'gols' => $request->gols,
            ]);
        }

        if ($hasWilayah && !$hasPilar && $hasJenis) {
            return redirect()->route('dataProvinsiJenis', [
                'tanggal1' => $tanggal1,
                'tanggal2' => $tanggal2,
                'provinsi' => $request->provinsi,
                'kabupaten' => encrypt($request->kabupaten),
                'jenis' => $request->jenis,
            ]);
        }

        if ($hasWilayah && $hasPilar && $hasJenis) {
            return redirect()->route('dataProvinsiSDGsJenis', [
                'tanggal1' => $tanggal1,
                'tanggal2' => $tanggal2,
                'provinsi' => $request->provinsi,
                'kabupaten' => encrypt($request->kabupaten),
                'pilar' => $request->pilar,
                'gols' => $request->gols,
                'jenis' => $request->jenis,
            ]);
        }

        if (!$hasWilayah && $hasPilar && !$hasJenis) {
            return redirect()->route('dataSDGs', [
                'tanggal1' => $tanggal1,
                'tanggal2' => $tanggal2,
                'pilar' => $request->pilar,
                'gols' => $request->gols,
            ]);
        }

        if (!$hasWilayah && $hasPilar && $hasJenis) {
            return redirect()->route('dataSDGsJenis', [
                'tanggal1' => $tanggal1,
                'tanggal2' => $tanggal2,
                'pilar' => $request->pilar,
                'gols' => $request->gols,
                'jenis' => $request->jenis,
            ]);
        }

        if (!$hasWilayah && !$hasPilar && $hasJenis) {
            return redirect()->route('dataJenis', [
                'tanggal1' => $tanggal1,
                'tanggal2' => $tanggal2,
                'jenis' => $request->jenis,
            ]);
        }

        return redirect()->route('data-periode', [
            'tanggal1' => $tanggal1,
            'tanggal2' => $tanggal2,
        ]);
    }
}
