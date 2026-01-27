<?php

namespace App\Exports;

use App\Models\Proker;
use App\Models\RealisasiAP;
use App\Models\ViewRealisasiAP;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class RealisasiSDGsSubsidiaryExport implements FromView, ShouldAutoSize
{
    public function __construct(string $pilar, string $gols, string $year)
    {
        $this->pilar = $pilar;
        $this->gols = $gols;
        $this->company = session('user')->perusahaan;
        $this->year = $year;
    }

    public function view(): View
    {
        if ($this->gols == 'All Goals'){
            $data = ViewRealisasiAP::where('pilar', $this->pilar)->where('perusahaan', $this->company)->where('tahun', $this->year)->orderBy('tgl_realisasi', 'ASC')->get();
        }else{
            $data = ViewRealisasiAP::where('pilar', $this->pilar)->where('gols', $this->gols)->where('perusahaan', $this->company)->where('tahun', $this->year)->orderBy('tgl_realisasi', 'ASC')->get();
        }

        return view('subsidiary.export.export_realisasi_proposal', [
            'dataRealisasi' => $data,
        ]);
    }

}
