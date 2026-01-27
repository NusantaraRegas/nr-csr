<?php

namespace App\Exports;

use App\Models\Proker;
use App\Models\RealisasiAP;
use App\Models\ViewRealisasiAP;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class RealisasiRegionSubsidiaryExport implements FromView, ShouldAutoSize
{
    public function __construct(string $provinsi, string $kabupaten, string $year)
    {
        try {
            $kabu = decrypt($kabupaten);
        } catch (Exception $e) {
            abort(404);
        }

        $this->provinsi = $provinsi;
        $this->kabupaten = $kabu;
        $this->company = session('user')->perusahaan;
        $this->year = $year;
    }

    public function view(): View
    {
        if ($this->kabupaten == 'Semua Kabupaten/Kota'){
            $data = ViewRealisasiAP::where('provinsi', $this->provinsi)->where('perusahaan', $this->company)->where('tahun', $this->year)->orderBy('tgl_realisasi', 'ASC')->get();
        }else{
            $data = ViewRealisasiAP::where('provinsi', $this->provinsi)->where('kabupaten', $this->kabupaten)->where('perusahaan', $this->company)->where('tahun', $this->year)->orderBy('tgl_realisasi', 'ASC')->get();
        }

        return view('subsidiary.export.export_realisasi_proposal', [
            'dataRealisasi' => $data,
        ]);
    }

}
