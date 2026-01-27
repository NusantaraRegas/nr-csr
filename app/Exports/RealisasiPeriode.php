<?php

namespace App\Exports;

use App\Helper\APIHelper;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class RealisasiPeriode implements FromView, ShouldAutoSize
{
    public function __construct(string $tanggal1, string $tanggal2)
    {
        $this->user_id = "1211";
        $this->tanggal1 = $tanggal1;
        $this->tanggal2 = $tanggal2;
        $this->budget_year = date("Y");
    }

    public function view(): View
    {
        $param = array(
            "user_id" => $this->user_id,
            "tanggal1" => $this->tanggal1,
            "tanggal2" => $this->tanggal2,
        );

        if ($this->budget_year > '2022') {
            $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestProposalPeriodePAIDPopayV4', $param, '');
            $return = json_decode(strstr($release, '{'), true);
            $data = $return['data'];
        }else{
            $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestProposalPeriodePAID', $param, '');
            $return = json_decode(strstr($release, '{'), true);
            $data = $return['data'];
        }

        return view('export.payment_realisasi', [
            'dataPayment' => $data,
        ]);
    }

}
