<?php

namespace App\Exports;

use App\Models\Proker;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class ProkerSubsidiaryExport implements FromView, ShouldAutoSize
{
    public function __construct(string $year, string $company)
    {
        $this->year = $year;
        $this->company = $company;
    }

    public function view(): View
    {
        $data = Proker::where('tahun', $this->year)->where('perusahaan', $this->company)->orderBy('id_proker', 'ASC')->orderBy('tahun', 'ASC')->get();

        return view('subsidiary.export.proker', [
            'dataProker' => $data,
        ]);
    }

}
