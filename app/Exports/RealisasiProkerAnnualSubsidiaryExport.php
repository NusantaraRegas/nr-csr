<?php

namespace App\Exports;

use App\Models\Proker;
use App\Models\RealisasiAP;
use App\Models\ViewRealisasiAP;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class RealisasiProkerAnnualSubsidiaryExport implements FromView, ShouldAutoSize
{
    public function __construct(string $year)
    {
        $this->year = $year;
        $this->company = session('user')->perusahaan;
    }

    public function view(): View
    {
        $proker = Proker::where('tahun', $this->year)->where('perusahaan', $this->company)->orderBy('id_proker', 'ASC')->get();

        return view('subsidiary.export.realisasi_proker_subsidiary', [
            'dataProker' => $proker,
            'tahun' => $this->year,
            'comp' => $this->company,
        ]);
    }

}
