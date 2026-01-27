<?php

namespace App\Exports;

use App\Helper\APIHelper;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class RealisasiProposal implements FromView, ShouldAutoSize
{

    public function __construct(string $tahun)
    {
        $this->user_id = "1211";
        $this->budget_year = $tahun;
    }

    public function view(): View
    {
        $param = array(
            "user_id" => $this->user_id,
            "budget_year" => $this->budget_year,
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestProposalPAID', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];

        return view('export.payment_realisasi', [
            'dataPayment' => $data
        ]);
    }

}
