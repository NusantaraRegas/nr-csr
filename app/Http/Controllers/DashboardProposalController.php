<?php

namespace App\Http\Controllers;
use App\Models\Kelayakan;
use Illuminate\Http\Request;
use DB;

class DashboardProposalController extends Controller
{
    public function index()
    {
        $tahun = date("Y");

        $total = Kelayakan::whereYear('tgl_terima', $tahun)->count();
        $draft = Kelayakan::where('status', 'Draft')->whereYear('tgl_terima', $tahun)->count();
        $evaluasi = Kelayakan::where('status', 'Evaluasi')->whereYear('tgl_terima', $tahun)->count();
        $survei = Kelayakan::where('status', 'Survei')->whereYear('tgl_terima', $tahun)->count();
        $rejected = Kelayakan::where('status', 'Rejected')->whereYear('tgl_terima', $tahun)->count();
        $approved = Kelayakan::where('status', 'Approved')->whereYear('tgl_terima', $tahun)->count();

        $dataSektor = DB::select("SELECT SEKTOR_BANTUAN, SUM(JUMLAH) AS JUMLAH, TAHUN FROM V_SEKTOR WHERE TAHUN = '$tahun' GROUP BY SEKTOR_BANTUAN, TAHUN");
        $dataJenis = DB::select("SELECT JENIS, SUM(JUMLAH) AS JUMLAH, TAHUN FROM V_JENIS WHERE TAHUN = '$tahun' GROUP BY JENIS, TAHUN");

        function bencana($ben)
        {
            $bencana = $ben;
            Switch ($bencana) {
                case "Bencana Alam dan Bencana Non Alam Termasuk Yang Disebabkan Oleh Wabah" :
                    $bencana = "Bencana Alam";
                    Break;
            }
            return $bencana;
        }

        $sektor = [];
        foreach ($dataSektor as $s) {
            $sektor[] = [
                'name' => bencana($s->sektor_bantuan),
                'y' => round($s->jumlah),
            ];
        }

        $jenis = [];
        foreach ($dataJenis as $j) {
            $jenis[] = [
                'name' => $j->jenis,
                'y' => round($j->jumlah),
            ];
        }

        function bulan($bln)
        {
            $bulan = $bln;
            Switch ($bulan) {
                case 1 :
                    $bulan = "Januari";
                    Break;
                case 2 :
                    $bulan = "Februari";
                    Break;
                case 3 :
                    $bulan = "Maret";
                    Break;
                case 4 :
                    $bulan = "April";
                    Break;
                case 5 :
                    $bulan = "Mei";
                    Break;
                case 6 :
                    $bulan = "Juni";
                    Break;
                case 7 :
                    $bulan = "Juli";
                    Break;
                case 8 :
                    $bulan = "Agustus";
                    Break;
                case 9 :
                    $bulan = "September";
                    Break;
                case 10 :
                    $bulan = "Oktober";
                    Break;
                case 11 :
                    $bulan = "November";
                    Break;
                case 12 :
                    $bulan = "Desember";
                    Break;
            }
            return $bulan;
        }

//        $dataBulan = [];
//        foreach ($grafikProposal as $ss) {
//            $dataBulan[] = bulan($ss->bulan);
//        }

        return view('home.dashboard_proposal')
            ->with([
                'tahun' => $tahun,
                'total' => $total,
                'draft' => $draft,
                'evaluasi' => $evaluasi,
                'survei' => $survei,
                'rejected' => $rejected,
                'approved' => $approved,
                'dataSektor' => $dataSektor,
                'sektor' => $sektor,
                'dataJenis' => $dataJenis,
                'jenis' => $jenis,
            ]);
    }

    public function indexTahun($tahun)
    {
        $total = Kelayakan::whereYear('tgl_terima', $tahun)->count();
        $draft = Kelayakan::where('status', 'Draft')->whereYear('tgl_terima', $tahun)->count();
        $evaluasi = Kelayakan::where('status', 'Evaluasi')->whereYear('tgl_terima', $tahun)->count();
        $survei = Kelayakan::where('status', 'Survei')->whereYear('tgl_terima', $tahun)->count();
        $rejected = Kelayakan::where('status', 'Rejected')->whereYear('tgl_terima', $tahun)->count();
        $approved = Kelayakan::where('status', 'Approved')->whereYear('tgl_terima', $tahun)->count();

        $dataSektor = DB::select("SELECT SEKTOR_BANTUAN, SUM(JUMLAH) AS JUMLAH, TAHUN FROM V_SEKTOR WHERE TAHUN = '$tahun' GROUP BY SEKTOR_BANTUAN, TAHUN");
        $dataJenis = DB::select("SELECT JENIS, SUM(JUMLAH) AS JUMLAH, TAHUN FROM V_JENIS WHERE TAHUN = '$tahun' GROUP BY JENIS, TAHUN");

        function bencana($ben)
        {
            $bencana = $ben;
            Switch ($bencana) {
                case "Bencana Alam dan Bencana Non Alam Termasuk Yang Disebabkan Oleh Wabah" :
                    $bencana = "Bencana Alam";
                    Break;
            }
            return $bencana;
        }

        $sektor = [];
        foreach ($dataSektor as $s) {
            $sektor[] = [
                'name' => bencana($s->sektor_bantuan),
                'y' => round($s->jumlah),
            ];
        }

        $jenis = [];
        foreach ($dataJenis as $j) {
            $jenis[] = [
                'name' => $j->jenis,
                'y' => round($j->jumlah),
            ];
        }

        function bulan($bln)
        {
            $bulan = $bln;
            Switch ($bulan) {
                case 1 :
                    $bulan = "Januari";
                    Break;
                case 2 :
                    $bulan = "Februari";
                    Break;
                case 3 :
                    $bulan = "Maret";
                    Break;
                case 4 :
                    $bulan = "April";
                    Break;
                case 5 :
                    $bulan = "Mei";
                    Break;
                case 6 :
                    $bulan = "Juni";
                    Break;
                case 7 :
                    $bulan = "Juli";
                    Break;
                case 8 :
                    $bulan = "Agustus";
                    Break;
                case 9 :
                    $bulan = "September";
                    Break;
                case 10 :
                    $bulan = "Oktober";
                    Break;
                case 11 :
                    $bulan = "November";
                    Break;
                case 12 :
                    $bulan = "Desember";
                    Break;
            }
            return $bulan;
        }

//        $dataBulan = [];
//        foreach ($grafikProposal as $ss) {
//            $dataBulan[] = bulan($ss->bulan);
//        }

        return view('home.dashboard_proposal')
            ->with([
                'tahun' => $tahun,
                'total' => $total,
                'draft' => $draft,
                'evaluasi' => $evaluasi,
                'survei' => $survei,
                'rejected' => $rejected,
                'approved' => $approved,
                'dataSektor' => $dataSektor,
                'sektor' => $sektor,
                'dataJenis' => $dataJenis,
                'jenis' => $jenis,
            ]);
    }
}
