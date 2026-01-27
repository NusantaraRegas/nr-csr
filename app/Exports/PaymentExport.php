<?php

namespace App\Exports;

use App\Helper\APIHelper;
use App\Models\Kelayakan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class PaymentExport implements FromView, ShouldAutoSize
{

    public function __construct(string $tgl1, string $tgl2, string $statusPR)
    {
        $this->user_id = "1211";
        $this->tanggal1 = $tgl1;
        $this->tanggal2 = $tgl2;
        $this->status = $statusPR;
    }

    public function view(): View
    {
        $param = array(
            "user_id" => $this->user_id,
            "tanggal1" => $this->tanggal1,
            "tanggal2" => $this->tanggal2,
            "status" => $this->status,
        );

        $release = APIHelper::instance()->httpCallJson('POST', 'https://payment-api.pgn.co.id/api/listPaymentRequestCSRPeriode', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];

        return view('export.payment-all', [
            'dataPayment' => $data
        ]);
    }

}
