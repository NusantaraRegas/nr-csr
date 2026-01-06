<?php

namespace App\Exports;

use App\Models\Proker;
use App\Models\RealisasiAP;
use App\Models\ViewRealisasiAP;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class RealisasiPrioritySubsidiaryExport implements FromView, ShouldAutoSize
{
    public function __construct(string $prioritas, string $year)
    {
        $this->prioritas = $prioritas;
        $this->company = session('user')->perusahaan;
        $this->year = $year;
    }

    public function view(): View
    {
        $data = RealisasiAP::where('prioritas', $this->prioritas)->where('perusahaan', $this->company)->where('tahun', $this->year)->orderBy('tgl_realisasi', 'ASC')->get();

        return view('subsidiary.export.export_realisasi_proposal', [
            'dataRealisasi' => $data,
        ]);
    }

}
