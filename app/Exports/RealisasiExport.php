<?php

namespace App\Exports;

use App\Models\Issue;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class RealisasiExport implements FromView, ShouldAutoSize
{
    public function __construct(string $eb, string $tahun)
    {
        $this->eb = $eb;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        return view('export.payment_realisasi', [
            'eb' => $this->eb,
            'tahun' => $this->tahun,
            'dataPayment' =>
                DB::table('V_REALISASI_PROVINSI')
                    ->select('V_REALISASI_PROVINSI.*')
                    ->get()
        ]);
    }

}
