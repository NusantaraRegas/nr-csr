<?php

namespace App\Exports;

use App\Models\Proker;
use App\Models\RealisasiAP;
use App\Models\ViewRealisasiAP;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class RealisasiMonthlySubsidiaryExport implements FromView, ShouldAutoSize
{
    public function __construct(string $bulan1, string $bulan2, string $year)
    {
        $this->bulan1 = $bulan1;
        $this->bulan2 = $bulan2;
        $this->company = session('user')->perusahaan;
        $this->year = $year;
    }

    public function view(): View
    {
        $data = ViewRealisasiAP::whereBetween('bulan', [$this->bulan1, $this->bulan2])->where('tahun', $this->year)->where('perusahaan', $this->company)->orderBy('tgl_realisasi', 'ASC')->get();

        return view('subsidiary.export.export_realisasi_proposal', [
            'dataRealisasi' => $data,
        ]);
    }

}
