<?php

namespace App\Exports;

use App\Helper\APIHelper;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class RealisasiProposalJenisPeriode implements FromView, ShouldAutoSize
{

    public function __construct(string $tgl1, string $tgl2, string $jenis)
    {
        $this->user_id = "1211";
        $this->tanggal1 = $tgl1;
        $this->tanggal2 = $tgl2;
        $this->attribute1 = $jenis;
    }


    public function view(): View
    {

        $param = array(
            "user_id" => "1211",
            "tanggal1" => $this->tanggal1,
            "tanggal2" => $this->tanggal2,
            "attribute1" => $this->attribute1,
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestProposalJenisPeriode', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];

        return view('export.payment_realisasi', [
            'dataPayment' => $data
        ]);
    }

}
