<?php

namespace App\Exports;

use App\Models\Proker;
use App\Models\RealisasiAP;
use App\Models\ViewRealisasiAP;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class RealisasiProkerSubsidiaryExport implements FromView, ShouldAutoSize
{
    public function __construct(string $prokerID)
    {
        $this->prokerID = $prokerID;
        $this->company = session('user')->perusahaan;
    }

    public function view(): View
    {
        $data = RealisasiAP::where('id_proker', $this->prokerID)->where('perusahaan', $this->company)->orderBy('tgl_realisasi', 'ASC')->get();

        return view('subsidiary.export.export_realisasi_proposal', [
            'dataRealisasi' => $data,
        ]);
    }

}
