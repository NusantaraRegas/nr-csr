<?php

namespace App\Exports;

use App\Models\Proker;
use App\Models\RealisasiAP;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class RealisasiProposalSubsidiaryExport implements FromView, ShouldAutoSize
{
    public function __construct(string $year, string $company)
    {
        $this->year = $year;
        $this->company = $company;
    }

    public function view(): View
    {
        $data = RealisasiAP::where('tahun', $this->year)->where('perusahaan', $this->company)->orderBy('id_proker', 'DESC')->get();

        return view('subsidiary.export.export_realisasi_proposal', [
            'dataRealisasi' => $data,
        ]);
    }

}
