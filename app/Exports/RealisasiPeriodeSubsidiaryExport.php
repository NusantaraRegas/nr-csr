<?php

namespace App\Exports;

use App\Models\Proker;
use App\Models\RealisasiAP;
use App\Models\ViewRealisasiAP;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class RealisasiPeriodeSubsidiaryExport implements FromView, ShouldAutoSize
{
    public function __construct(string $tanggal1, string $tanggal2)
    {
        $this->tanggal1 = $tanggal1;
        $this->tanggal2 = $tanggal2;
        $this->company = session('user')->perusahaan;
    }

    public function view(): View
    {
        $data = ViewRealisasiAP::whereBetween('tgl_realisasi', [$this->tanggal1, $this->tanggal2])->where('perusahaan', $this->company)->orderBy('tgl_realisasi', 'ASC')->get();

        return view('subsidiary.export.export_realisasi_proposal', [
            'dataRealisasi' => $data,
        ]);
    }

}
