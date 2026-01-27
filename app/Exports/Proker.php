<?php

namespace App\Exports;

use App\Helper\APIHelper;
use App\Models\Anggaran;
use App\Models\Pilar;
use App\Models\SDG;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class Proker implements FromView, ShouldAutoSize
{
    public function __construct(string $year)
    {
        $this->year = $year;
        $this->company = session('user')->perusahaan;
    }

    public function view(): View
    {
        $data = Proker::where('tahun', $this->year)->where('perusahaan', $this->company)->orderBy('id_proker', 'ASC')->orderBy('tahun', 'ASC')->get();

        return view('export.proker', [
            'dataProker' => $data,
        ]);
    }

}
