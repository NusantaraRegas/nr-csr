<?php

namespace App\Exports;

use App\Helper\APIHelper;
use App\Models\Anggaran;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class RealisasiProker implements FromView, ShouldAutoSize
{
    public function __construct(string $year)
    {
        $this->user_id = "1211";
        $this->budget_year = $year;
        $this->company = session('user')->perusahaan;
    }

    public function view(): View
    {
        $param = array(
            "user_id" => $this->user_id,
            "budget_year" => $this->budget_year,
        );

        $anggaran = Anggaran::where('tahun', $this->budget_year)->where('perusahaan', $this->company)->first();

        if ($this->budget_year > '2022') {
            //+++++++++TOTAL REALISASI PROGRESS+++++++++//
            $releaseProgress = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiProgressPopayV4', $param, '');
            $returnProgress = json_decode(strstr($releaseProgress, '{'), true);
            $dataProgress = $returnProgress['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI PAID+++++++++//
            $releasePAID = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiPAIDPopayV4', $param, '');
            $returnPAID = json_decode(strstr($releasePAID, '{'), true);
            $dataPAID = $returnPAID['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI PAID+++++++++//
            $releaseProker = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/summaryRealisasiProkerPopayV4', $param, '');
            $returnProker = json_decode(strstr($releaseProker, '{'), true);
            $dataProker = $returnProker['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            foreach ($dataProker as $d) {
                $dataProkerRealisasi[] =
                    $d['proker_id'];
            }

            $kalimat = implode(", ", $dataProkerRealisasi);
            $prokerNonRelokasi = DB::select("SELECT * FROM TBL_PROKER WHERE ID_PROKER NOT IN ($kalimat) AND TAHUN = '$this->budget_year' AND PERUSAHAAN = '$this->company'");

            if ($dataProgress['total'] == '') {
                $totalProgress = 0;
            } else {
                $totalProgress = $dataProgress['total'];
            }

            if ($dataPAID['total'] == '') {
                $totalRealisasi = 0;
            } else {
                $totalRealisasi = $dataPAID['total'];
            }
        } else {
            //+++++++++TOTAL REALISASI PROGRESS+++++++++//
            $releaseProgress = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiProgress', $param, '');
            $returnProgress = json_decode(strstr($releaseProgress, '{'), true);
            $dataProgress = $returnProgress['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI PAID+++++++++//
            $releasePAID = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiPAID', $param, '');
            $returnPAID = json_decode(strstr($releasePAID, '{'), true);
            $dataPAID = $returnPAID['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI PAID+++++++++//
            $releaseProker = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/summaryRealisasiProker', $param, '');
            $returnProker = json_decode(strstr($releaseProker, '{'), true);
            $dataProker = $returnProker['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            foreach ($dataProker as $d) {
                $dataProkerRealisasi[] =
                    $d['proker_id'];
            }

            $kalimat = implode(", ", $dataProkerRealisasi);
            $prokerNonRelokasi = DB::select("SELECT * FROM TBL_PROKER WHERE ID_PROKER NOT IN ($kalimat) AND TAHUN = '$this->budget_year' AND PERUSAHAAN = '$this->company'");

            if ($dataProgress['total'] == '') {
                $totalProgress = 0;
            } else {
                $totalProgress = $dataProgress['total'];
            }

            if ($dataPAID['total'] == '') {
                $totalRealisasi = 0;
            } else {
                $totalRealisasi = $dataPAID['total'];
            }
        }

        return view('export.realisasi_proker', [
            'anggaran' => $anggaran->nominal,
            'realisasi' => $totalRealisasi,
            'progress' => $totalProgress,
            'dataProker' => $dataProker,
            'prokerNonRelokasi' => $prokerNonRelokasi,
        ]);
    }

}
