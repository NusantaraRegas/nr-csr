<?php

namespace App\Http\Controllers;

use App\Exports\PaymentExport;
use App\Exports\RealisasiAll;
use App\Exports\RealisasiExport;
use App\Exports\RealisasiKabupaten;
use App\Exports\RealisasiMonthly;
use App\Exports\RealisasiPeriode;
use App\Exports\RealisasiProkerID;
use App\Exports\RealisasiProposal;
use App\Exports\RealisasiProposalJenis;
use App\Exports\RealisasiProposalJenisPeriode;
use App\Exports\RealisasiProposalPeriode;
use App\Exports\RealisasiProposalProvinsi;
use App\Exports\RealisasiProvinsi;
use App\Helper\APIHelper;
use App\Http\Requests\ExportProposal;
use App\Http\Requests\ExportRealisasi;
use App\Imports\KelayakanImport;
use App\Models\Provinsi;
use App\Models\SektorBantuan;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view('report.export_proposal');
    }

    public function exportPaymentRequest($tahun)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("dmYHis");

        $namaFile = "RealisasiPaymentRequest".$tanggalMenit.".xlsx";
        return Excel::download(new RealisasiAll($tahun), $namaFile);
    }

    public function exportPaymentRequestMonthly($bulan, $tahun)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("dmYHis");

        $namaFile = "RealisasiPaymentRequest".$tanggalMenit.".xlsx";
        return Excel::download(new RealisasiMonthly($bulan, $tahun), $namaFile);
    }

    public function exportPaymentRequestPeriode($tanggal1, $tanggal2)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("dmYHis");

        $namaFile = "RealisasiPaymentRequest".$tanggalMenit.".xlsx";
        return Excel::download(new RealisasiPeriode($tanggal1, $tanggal2), $namaFile);
    }

    public function exportPaymentRequestProvinsi($tahun, $provinsi)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("dmYHis");

        $namaFile = "RealisasiPaymentRequest".$tanggalMenit.".xlsx";
        return Excel::download(new RealisasiProvinsi($tahun, $provinsi), $namaFile);
    }

    public function exportPaymentRequestKabupaten($tahun, $provinsi, $kabupaten)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("dmYHis");

        $namaFile = "RealisasiPaymentRequest".$tanggalMenit.".xlsx";
        return Excel::download(new RealisasiKabupaten($tahun, $provinsi, $kabupaten), $namaFile);
    }

    public function exportPaymentRequestProker($prokerID)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("dmYHis");

        $namaFile = "RealisasiPaymentRequestP".$tanggalMenit.".xlsx";
        return Excel::download(new RealisasiProkerID($prokerID), $namaFile);
    }

    public function cariPeriode(ExportProposal $request)
    {
        $tanggal1 = date('Y-m-d', strtotime($request->tanggal1));
        $tanggal2 = date('Y-m-d', strtotime($request->tanggal2));

        #Validasi Tanggal
        $tgl1 = new \DateTime($tanggal1);
        $tgl2 = new \DateTime($tanggal2);

        $interval = date_diff($tgl1, $tgl2);
        $Hari = $interval->format('%R%a');
        $jumlahHari = $Hari + 1;

        if ($jumlahHari > 0) {
            return redirect()->route('export-all', ['tanggal1' => $tanggal1, 'tanggal2' => $tanggal2]);
        } else {
            return redirect()->back()->with('gagal', 'Tanggal pencarian tidak valid');
        }
    }

    public function exportPeriodePaymentRequest(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("dmYHis");

        $tgl1 = date('Y-m-d', strtotime($request->tanggal1));
        $tgl2 = date('Y-m-d', strtotime($request->tanggal2));
        $statusPR = $request->status;

        $namaFile = $tanggalMenit . '_paymentReport.xlsx';
        return Excel::download(new PaymentExport($tgl1, $tgl2, $statusPR), $namaFile);
    }

    public function exportYearPaymentRequest($tahun)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("dmYHis");

        $namaFile = $tanggalMenit . '_paymentRequest.xlsx';
        return Excel::download(new PaymentExport($tahun), $namaFile);
    }

    public function indexRealisasi()
    {
        return view('report.export_provinsi');
    }

    public function cariPeriodeRealisasi(ExportRealisasi $request)
    {
        return redirect()->route('export-all-realisasi', ['eb' => $request->eb, 'tahun' => $request->tahun]);
    }

    public function exportRealisasi($eb,$tahun)
    {

        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("dmYHis");

        $namaFile = $tanggalMenit . '_realisasiReport.xlsx';
        return Excel::download(new RealisasiExport($eb, $tahun), $namaFile);
    }

    public function exportRealisasiProposal($tahun)
    {

        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("dmYHis");
        $tahun = date("Y");

        $namaFile = $tanggalMenit . '_RealisasiProposal.xlsx';
        return Excel::download(new RealisasiProposal($tahun), $namaFile);
    }

    public function exportRealisasiProposalPeriode($tanggal1, $tanggal2)
    {

        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("dmYHis");

        $tgl1 = date('Y-m-d', strtotime($tanggal1));
        $tgl2 = date('Y-m-d', strtotime($tanggal2));

        $namaFile = $tanggalMenit . '_RealisasiProposal.xlsx';
        return Excel::download(new RealisasiProposalPeriode($tgl1, $tgl2), $namaFile);
    }

    public function exportRealisasiProposalProvinsi($tahun, $provinsi)
    {

        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("dmYHis");

        $namaFile = $tanggalMenit . '_RealisasiProposal.xlsx';
        return Excel::download(new RealisasiProposalProvinsi($tahun, $provinsi), $namaFile);
    }

    public function exportRealisasiProposalJenis($tahun, $jenis)
    {

        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("dmYHis");

        $namaFile = $tanggalMenit . '_RealisasiProposal.xlsx';
        return Excel::download(new RealisasiProposalJenis($tahun, $jenis), $namaFile);
    }

    public function exportRealisasiProposalPeriodeJenis($tanggal1, $tanggal2, $jenis)
    {

        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("dmYHis");

        $tgl1 = date('Y-m-d', strtotime($tanggal1));
        $tgl2 = date('Y-m-d', strtotime($tanggal2));

        $namaFile = $tanggalMenit . '_RealisasiProposal.xlsx';
        return Excel::download(new RealisasiProposalJenisPeriode($tgl1, $tgl2, $jenis), $namaFile);
    }

    public function printPaymentRequest($tahun)
    {

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
        );

        if ($tahun > '2022'){
            $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestCSRPopayV4', $param, '');
            $return = json_decode(strstr($release, '{'), true);
            $data = $return['data'];
        }else{
            $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestCSR', $param, '');
            $return = json_decode(strstr($release, '{'), true);
            $data = $return['data'];
        }

        return view('print.realisasi_all')
            ->with([
                'dataPayment' => $data,
                'tahun' => $tahun,
            ]);
    }

    public function printPaymentRequestMonthly($bulan, $tahun)
    {

        $param = array(
            "user_id" => "1211",
            "bulan" => $bulan,
            "budget_year" => $tahun,
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestAllCSRPAIDBulan', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];

        return view('print.realisasi_all')
            ->with([
                'dataPayment' => $data,
                'tahun' => $tahun,
            ]);
    }

    public function printPaymentRequestPeriode($tanggal1, $tanggal2)
    {

        $param = array(
            "user_id" => "1211",
            "tanggal1" => $tanggal1,
            "tanggal2" => $tanggal2,
        );

        $tgl1 = date("d-M-Y", strtotime($tanggal1));
        $tgl2 = date("d-M-Y", strtotime($tanggal2));

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestProposalPeriodePAID', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];

        return view('print.realisasi_all')
            ->with([
                'dataPayment' => $data,
                'tahun' => "$tgl1 S.d $tgl2",
            ]);
    }

    public function printPaymentRequestProvinsi($tahun, $provinsi)
    {

        $param = array(
            "user_id" => "1211",
            "attribute3" => $provinsi,
            "budget_year" => $tahun,
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestProvinsi', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];

        return view('print.realisasi_all')
            ->with([
                'dataPayment' => $data,
                'tahun' => $tahun,
            ]);
    }

    public function printPaymentRequestKabupaten($tahun, $provinsi, $kabupaten)
    {

        $param = array(
            "user_id" => "1211",
            "attribute3" => $provinsi,
            "attribute4" => $kabupaten,
            "budget_year" => $tahun,
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestKabupaten', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];

        return view('print.realisasi_all')
            ->with([
                'dataPayment' => $data,
                'tahun' => $tahun,
            ]);
    }

    public function printPaymentRequestProposal($tahun)
    {
        $year = $tahun;

        $param = array(
            "user_id" => "1211",
            "budget_year" => $year,
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestProposalPAID', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];

        return view('print.realisasi_proposal')
            ->with([
                'dataPayment' => $data,
                'tahun' => $tahun,
            ]);
    }

    public function printPaymentRequestProposalPeriode($tanggal1, $tanggal2)
    {

        $param = array(
            "user_id" => "1211",
            "tanggal1" => $tanggal1,
            "tanggal2" => $tanggal2,
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestProposalPeriodePAID', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];

        return view('print.realisasi_proposal_periode')
            ->with([
                'dataPayment' => $data,
                'tanggal1' => $tanggal1,
                'tanggal2' => $tanggal2,
            ]);
    }

    public function printPaymentRequestProposalJenis($tahun, $jenis)
    {
        $year = $tahun;

        $param = array(
            "user_id" => "1211",
            "budget_year" => $year,
            "attribute1" => $jenis,
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestProposalJenis', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];

        return view('print.realisasi_proposal')
            ->with([
                'dataPayment' => $data,
                'tahun' => $tahun,
            ]);
    }

    public function printPaymentRequestProposalPeriodeJenis($tanggal1, $tanggal2, $jenis)
    {

        $param = array(
            "user_id" => "1211",
            "tanggal1" => $tanggal1,
            "tanggal2" => $tanggal2,
            "attribute1" => $jenis,
        );

        $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestProposalJenisPeriode', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];

        return view('print.realisasi_proposal_periode')
            ->with([
                'dataPayment' => $data,
                'tanggal1' => $tanggal1,
                'tanggal2' => $tanggal2,
            ]);
    }

    public function uploadKelayakan(Request $request)
    {

        try {
            Excel::import(new KelayakanImport, $request->file('fileUpload'));
            return redirect()->route('dataKelayakan')->with('sukses', 'Data kelayakan berhasil diimport');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Data kelayakan gagal diimport');
        }
    }

}
