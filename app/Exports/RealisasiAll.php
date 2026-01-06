<?php

namespace App\Exports;

use App\Helper\APIHelper;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class RealisasiAll implements FromView, ShouldAutoSize
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

        if ($this->budget_year > '2022'){
            $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestCSRPopayV4', $param, '');
            $return = json_decode(strstr($release, '{'), true);
            $data = $return['data'];
        }else{
            $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestCSR', $param, '');
            $return = json_decode(strstr($release, '{'), true);
            $data = $return['data'];
        }

        return view('export.payment_realisasi', [
            'dataPayment' => $data
        ]);
    }

}
