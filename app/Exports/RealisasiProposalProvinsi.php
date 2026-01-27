<?php

namespace App\Exports;

use App\Helper\APIHelper;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class RealisasiProposalProvinsi implements FromView, ShouldAutoSize
{

    public function __construct(string $tahun, string $provinsi)
    {
        $this->user_id = "1211";
        $this->tahun = $tahun;
        $this->provinsi = $provinsi;
    }

    public function view(): View
    {

        $param = array(
            "user_id" => "1211",
            "tahun" => $this->tahun,
            "provinsi" => $this->provinsi,
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestProposalProvinsiPAID', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];

        return view('export.payment_realisasi', [
            'dataPayment' => $data
        ]);
    }

}
