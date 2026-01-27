<?php

namespace App\Exports;

use App\Helper\APIHelper;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class RealisasiProkerID implements FromView, ShouldAutoSize
{
    public function __construct(string $prokerID)
    {
        $this->user_id = "1211";
        $this->budget_name = $prokerID;
        $this->budget_year = date("Y");
    }

    public function view(): View
    {
        $param = array(
            "user_id" => "1211",
            "budget_name" => $this->budget_name,
        );

        if ($this->budget_year > '2022') {
            $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestProkerPopayV4', $param, '');
            $return = json_decode(strstr($release, '{'), true);
            $data = $return['data'];
        }else{
            $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestProker', $param, '');
            $return = json_decode(strstr($release, '{'), true);
            $data = $return['data'];
        }

        return view('export.payment_realisasi', [
            'dataPayment' => $data
        ]);
    }

}
