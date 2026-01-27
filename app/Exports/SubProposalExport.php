<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class SubProposalExport implements FromView, ShouldAutoSize
{
    public function __construct(string $noAgenda)
    {
        $this->noAgenda = $noAgenda;
    }

    public function view(): View
    {
        return view('export.sub_proposal', [
            'noAgenda' => $this->noAgenda,
            'dataProposal' =>
                DB::table('TBL_SUB_PROPOSAL')
                    ->select('TBL_SUB_PROPOSAL.*')
                    ->where('no_agenda',$this->noAgenda)
                    ->get()
        ]);
    }

}
