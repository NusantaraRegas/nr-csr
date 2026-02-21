<?php

namespace App\Http\Controllers;

use App\Services\Auth\AuthContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Helper\APIHelper;
use App\Http\Requests\InsertPeriode;
use App\Http\Requests\PostDashboardAnnualRequest;
use App\Http\Requests\PostDashboardSubsidiaryRequest;
use App\Actions\Dashboard\PostDashboardAnnualAction;
use App\Actions\Dashboard\PostDashboardSubsidiaryAction;
use App\Models\Anggaran;
use App\Models\DetailApproval;
use App\Models\Perusahaan;
use App\Models\Survei;
use App\Models\ViewEvaluasi;
use App\Models\ViewSurvei;

use App\Models\Problem;
use App\Models\Penugasan;

class DashboardController extends Controller
{
    /**
     * @var AuthContext
     */
    protected $authContext;

    public function __construct(AuthContext $authContext)
    {
        $this->authContext = $authContext;
    }

    public function home()
    {
        return view('home.home');
    }

    public function index(Request $request)
    {
        $perusahaanID = $this->authContext->perusahaanId();
        $tahun = $request->input('tahun', date("Y"));

        // Ambil data perusahaan yang dipilih
        $company = Perusahaan::findOrFail($perusahaanID);

        $budget = Anggaran::where('id_perusahaan', $perusahaanID)
            ->where('tahun', $tahun)
            ->first();

        $realisasi = DB::table('v_pembayaran')
            ->select(DB::raw('SUM(subtotal) as total'))
            ->where('tahun', $tahun)
            ->first(); 

        $totalRealisasi = $realisasi->total ?? 0;
        $sisa = $budget->nominal - $totalRealisasi;

        $prokerPilar = DB::table('tbl_proker')
            ->select('pilar', DB::raw('SUM(anggaran) as total'))
            ->where('id_perusahaan', $perusahaanID)
            ->where('tahun', $tahun)
            ->groupBy('pilar')
            ->get();

        $realisasiPilar = DB::table('v_pembayaran')
            ->select('pilar', DB::raw('SUM(subtotal) as total'))
            ->where('tahun', $tahun)
            ->groupBy('pilar')
            ->get();

        $prokerPrioritas = DB::table('tbl_proker')
            ->select('prioritas', DB::raw('SUM(anggaran) as total'))
            ->where('id_perusahaan', $perusahaanID)
            ->where('tahun', $tahun)
            ->groupBy('prioritas')
            ->get();   

        $realisasiPrioritas = DB::table('v_pembayaran')
            ->select('prioritas', DB::raw('SUM(subtotal) as total'))
            ->where('tahun', $tahun)
            ->groupBy('prioritas')
            ->get();   
        
        $dataRealisasi = DB::table('v_pembayaran')
            ->selectRaw("TO_CHAR(approve_date, 'MM') as bulan, SUM(subtotal) as total")
            ->whereRaw("EXTRACT(YEAR FROM approve_date) = ?", [$tahun])
            ->groupBy(DB::raw("TO_CHAR(approve_date, 'MM')"))
            ->get();

        $dataTotalPilar = $realisasiPilar->map(function ($row) use ($tahun) {
            return [
                'name' => $row->pilar ?: 'Tanpa Pilar',
                'y'    => (float) $row->total,
                'url'  => route('indexPembayaran', ['tahun' => $tahun, 'pilar' => $row->pilar]),
            ];
        })->toArray();

        $dataTotalPrioritas = $realisasiPrioritas->map(function ($row) use ($tahun) {
            return [
                'name' => $row->prioritas ?: 'Tanpa Prioritas',
                'y'    => (float) $row->total,
                'url'  => route('indexPembayaran', ['tahun' => $tahun, 'prioritas' => $row->prioritas]),
            ];
        })->toArray();

        $bulanIndo = [
            '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr',
            '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Agu',
            '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des'
        ];

        // Inisialisasi 12 bulan dengan nilai 0
        $realisasiDefault = collect($bulanIndo)->map(function ($label, $kode) {
            return [
                'code' => $kode,
                'name' => $label,
                'total' => 0,
            ];
        });

        $realisasiPerBulan = $realisasiDefault->map(function ($item) use ($dataRealisasi) {
            $found = $dataRealisasi->firstWhere('bulan', $item['code']);
            return [
                'name' => $item['name'],
                'y'    => $found ? (float) $found->total : 0
            ];
        })->values();

        $dataAnggaran = Anggaran::where('id_perusahaan', $perusahaanID)
            ->orderByDesc('tahun')
            ->get();
        
        // Anggaran per perusahaan
        $anggaranAP = DB::table('tbl_anggaran as a')
            ->join('tbl_perusahaan as p', 'a.id_perusahaan', '=', 'p.id_perusahaan')
            ->select(
                'a.id_perusahaan',
                'p.nama_perusahaan',
                'a.nominal'
            )
            ->where('a.tahun', $tahun)
            ->whereNotIn('a.id_perusahaan', [1])
            ->get();

        // Realisasi per perusahaan (di-SUM terlebih dahulu)
        $realisasiAP = DB::table('tbl_realisasi_ap as r')
            ->select(
                'r.id_perusahaan',
                DB::raw('SUM(r.nilai_bantuan) as nilai_realisasi')
            )
            ->where('r.tahun', $tahun)
            ->groupBy('r.id_perusahaan')
            ->get()
            ->keyBy('id_perusahaan'); // supaya mudah diakses

        $categories    = [];
        $anggaranData  = [];
        $realisasiData = [];

        foreach ($anggaranAP as $row) {
            $categories[]   = $row->nama_perusahaan;
            $anggaranData[] = (int) $row->nominal;
            $realisasiData[] = isset($realisasiAP[$row->id_perusahaan])
                ? (int) $realisasiAP[$row->id_perusahaan]->nilai_realisasi
                : 0;
        }

        return view('home.dashboard')
            ->with([
                'tahun' => $tahun,
                'anggaran' => $budget->nominal,
                'perusahaan' => $company,
                'realisasi' => $totalRealisasi,
                'sisa' => $sisa,
                'dataAnggaran' => $dataAnggaran,
                'dataTotalPilar' => $dataTotalPilar,
                'dataTotalPrioritas' => $dataTotalPrioritas,
                'realisasiPerBulan' => $realisasiPerBulan,
                'categories'    => $categories,
                'anggaranData'  => $anggaranData,
                'realisasiData' => $realisasiData,
            ]);
    }

    public function postAnnual(PostDashboardAnnualRequest $request, PostDashboardAnnualAction $action)
    {
        return $action->execute($request);
    }

    public function indexAnnual($year)
    {

        try {
            $tahun = decrypt($year);
        } catch (Exception $e) {
            abort(404);
        }

        $company = $this->authContext->perusahaan();
        $anggaran = Anggaran::where('perusahaan', $company)->where('tahun', $tahun)->first();
        $anggaranAP = Anggaran::whereNotIn('perusahaan', ['PT Nusantara Regas'])->where('tahun', $tahun)->get();
        $jumlahAnggaranAP = Anggaran::whereNotIn('perusahaan', ['PT Nusantara Regas'])->where('tahun', $tahun)->count();
        $username = $this->authContext->username();

        $perusahaan = Perusahaan::whereIn('kategori', ['Subholding'])->orderBy('id_perusahaan', 'ASC')->get();

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
        );

        if ($tahun > '2022') {
            //+++++++++TOTAL REALISASI PROGREES+++++++++//
            $releaseRealisasiProgress = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiProgressPopayV4', $param, '');
            $returnRealisasiProgress = json_decode(strstr($releaseRealisasiProgress, '{'), true);
            $dataRealisasiProgress = $returnRealisasiProgress['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI PAID+++++++++//
            $releaseRealisasiPAID = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiPAIDPopayV4', $param, '');
            $returnRealisasiPAID = json_decode(strstr($releaseRealisasiPAID, '{'), true);
            $dataRealisasiPAID = $returnRealisasiPAID['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI PROPOSAL+++++++++//
            $releaseProposal = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getProposalPopayV4', $param, '');
            $returnProposal = json_decode(strstr($releaseProposal, '{'), true);
            $dataProposal = $returnProposal['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI PROPOSAL PAID+++++++++//
            $releaseProposalPAID = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getProposalPAIDPopayV4', $param, '');
            $returnProposalPAID = json_decode(strstr($releaseProposalPAID, '{'), true);
            $dataProposalPAID = $returnProposalPAID['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI PROPOSAL PROGRESS+++++++++//
            $releaseProposalProgress = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getProposalProgressPopayV4', $param, '');
            $returnProposalProgress = json_decode(strstr($releaseProposalProgress, '{'), true);
            $dataProposalProgress = $returnProposalProgress['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI OPERASIONAL+++++++++//
            $releaseOperasional = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getOperasionalPopayV4', $param, '');
            $returnOperasional = json_decode(strstr($releaseOperasional, '{'), true);
            $dataOperasional = $returnOperasional['data'][0];
            //+++++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI OPERASIONAL PAID+++++++++//
            $releaseOperasionalPAID = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getOperasionalPAIDPopayV4', $param, '');
            $returnOperasionalPAID = json_decode(strstr($releaseOperasionalPAID, '{'), true);
            $dataOperasionalPAID = $returnOperasionalPAID['data'][0];
            //+++++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI OPERASIONAL PROGRESS+++++++++//
            $releaseOperasionalProgress = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getOperasionalProgressPopayV4', $param, '');
            $returnOperasionalProgress = json_decode(strstr($releaseOperasionalProgress, '{'), true);
            $dataOperasionalProgress = $returnOperasionalProgress['data'][0];
            //+++++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++PILAR LINGKUNGAN+++++++++//
            $releasePilarLingkungan = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPilarLingkunganPopayV4', $param, '');
            $returnPilarLingkungan = json_decode(strstr($releasePilarLingkungan, '{'), true);
            $dataPilarLingkungan = $returnPilarLingkungan['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            if (!empty($dataPilarLingkungan)) {
                $totalPilarLingkungan = $dataPilarLingkungan[0]['total'];
            } else {
                $totalPilarLingkungan = 0;
            }

            //+++++++++PILAR EKONOMI+++++++++//
            $releasePilarEkonomi = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPilarEkonomiPopayV4', $param, '');
            $returnPilarEkonomi = json_decode(strstr($releasePilarEkonomi, '{'), true);
            $dataPilarEkonomi = $returnPilarEkonomi['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            if (!empty($dataPilarEkonomi)) {
                $totalPilarEkonomi = $dataPilarEkonomi[0]['total'];
            } else {
                $totalPilarEkonomi = 0;
            }

            //+++++++++PILAR SOSIAL+++++++++//
            $releasePilarSosial = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPilarSosialPopayV4', $param, '');
            $returnPilarSosial = json_decode(strstr($releasePilarSosial, '{'), true);
            $dataPilarSosial = $returnPilarSosial['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            if (!empty($dataPilarSosial)) {
                $totalPilarSosial = $dataPilarSosial[0]['total'];
            } else {
                $totalPilarSosial = 0;
            }

            //+++++++++REALISASI PROVINSI+++++++++//
            $releaseProvinsi = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getProvinsiPopayV4', $param, '');
            $returnProvinsi = json_decode(strstr($releaseProvinsi, '{'), true);
            $dataProvinsi = $returnProvinsi['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++REALISASI TPB+++++++++//
            $releaseTPB = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getTPBPopayV4', $param, '');
            $returnTPB = json_decode(strstr($releaseTPB, '{'), true);
            $dataTPB = $returnTPB['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            $tpb = [];
            foreach ($dataTPB as $t) {
                $tpb[] = $t['tpb'];
            }

            $statusTPB = [];
            foreach ($dataTPB as $st) {
                $statusTPB[] = round($st['total'] / $anggaran->nominal * 100, 2);
            }

            //+++++++++PRIORITAS PENDIDIKAN+++++++++//
            $releasePrioritasPendidikan = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPrioritasPendidikanPopayV4', $param, '');
            $returnPrioritasPendidikan = json_decode(strstr($releasePrioritasPendidikan, '{'), true);
            $dataPrioritasPendidikan = $returnPrioritasPendidikan['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            if (!empty($dataPrioritasPendidikan)) {
                $totalPrioritasPendidikan = $dataPrioritasPendidikan[0]['total'];
            } else {
                $totalPrioritasPendidikan = 0;
            }

            //+++++++++PRIORITAS LINGKUNGAN+++++++++//
            $releasePrioritasLingkungan = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPrioritasLingkunganPopayV4', $param, '');
            $returnPrioritasLingkungan = json_decode(strstr($releasePrioritasLingkungan, '{'), true);
            $dataPrioritasLingkungan = $returnPrioritasLingkungan['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            if (!empty($dataPrioritasLingkungan)) {
                $totalPrioritasLingkungan = $dataPrioritasLingkungan[0]['total'];
            } else {
                $totalPrioritasLingkungan = 0;
            }

            //+++++++++PRIORITAS UMK+++++++++//
            $releasePrioritasUMK = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPrioritasUMKPopayV4', $param, '');
            $returnPrioritasUMK = json_decode(strstr($releasePrioritasUMK, '{'), true);
            $dataPrioritasUMK = $returnPrioritasUMK['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            if (!empty($dataPrioritasUMK)) {
                $totalPrioritasUMK = $dataPrioritasUMK[0]['total'];
            } else {
                $totalPrioritasUMK = 0;
            }

            //+++++++++PRIORITAS SOSIAL EKONOMI+++++++++//
            $releasePrioritasSosialEkonomi = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPrioritasSosialEkonomiPopayV4', $param, '');
            $returnPrioritasSosialEkonomi = json_decode(strstr($releasePrioritasSosialEkonomi, '{'), true);
            $dataPrioritasSosialEkonomi = $returnPrioritasSosialEkonomi['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

        } else {
            //+++++++++TOTAL REALISASI PROGREES+++++++++//
            $releaseRealisasiProgress = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiProgress', $param, '');
            $returnRealisasiProgress = json_decode(strstr($releaseRealisasiProgress, '{'), true);
            $dataRealisasiProgress = $returnRealisasiProgress['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI PAID+++++++++//
            $releaseRealisasiPAID = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiPAID', $param, '');
            $returnRealisasiPAID = json_decode(strstr($releaseRealisasiPAID, '{'), true);
            $dataRealisasiPAID = $returnRealisasiPAID['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI PROPOSAL+++++++++//
            $releaseProposal = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getProposal', $param, '');
            $returnProposal = json_decode(strstr($releaseProposal, '{'), true);
            $dataProposal = $returnProposal['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI PROPOSAL PAID+++++++++//
            $releaseProposalPAID = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getProposalPAID', $param, '');
            $returnProposalPAID = json_decode(strstr($releaseProposalPAID, '{'), true);
            $dataProposalPAID = $returnProposalPAID['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI PROPOSAL PROGRESS+++++++++//
            $releaseProposalProgress = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getProposalProgress', $param, '');
            $returnProposalProgress = json_decode(strstr($releaseProposalProgress, '{'), true);
            $dataProposalProgress = $returnProposalProgress['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI OPERASIONAL+++++++++//
            $releaseOperasional = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getOperasional', $param, '');
            $returnOperasional = json_decode(strstr($releaseOperasional, '{'), true);
            $dataOperasional = $returnOperasional['data'][0];
            //+++++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI OPERASIONAL PAID+++++++++//
            $releaseOperasionalPAID = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getOperasionalPAID', $param, '');
            $returnOperasionalPAID = json_decode(strstr($releaseOperasionalPAID, '{'), true);
            $dataOperasionalPAID = $returnOperasionalPAID['data'][0];
            //+++++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI OPERASIONAL PROGRESS+++++++++//
            $releaseOperasionalProgress = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getOperasionalProgress', $param, '');
            $returnOperasionalProgress = json_decode(strstr($releaseOperasionalProgress, '{'), true);
            $dataOperasionalProgress = $returnOperasionalProgress['data'][0];
            //+++++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++PILAR LINGKUNGAN+++++++++//
            $releasePilarLingkungan = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPilarLingkungan', $param, '');
            $returnPilarLingkungan = json_decode(strstr($releasePilarLingkungan, '{'), true);
            $dataPilarLingkungan = $returnPilarLingkungan['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            if (!empty($dataPilarLingkungan)) {
                $totalPilarLingkungan = $dataPilarLingkungan[0]['total'];
            } else {
                $totalPilarLingkungan = 0;
            }

            //+++++++++PILAR EKONOMI+++++++++//
            $releasePilarEkonomi = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPilarEkonomi', $param, '');
            $returnPilarEkonomi = json_decode(strstr($releasePilarEkonomi, '{'), true);
            $dataPilarEkonomi = $returnPilarEkonomi['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            if (!empty($dataPilarEkonomi)) {
                $totalPilarEkonomi = $dataPilarEkonomi[0]['total'];
            } else {
                $totalPilarEkonomi = 0;
            }

            //+++++++++PILAR SOSIAL+++++++++//
            $releasePilarSosial = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPilarSosial', $param, '');
            $returnPilarSosial = json_decode(strstr($releasePilarSosial, '{'), true);
            $dataPilarSosial = $returnPilarSosial['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            if (!empty($dataPilarSosial)) {
                $totalPilarSosial = $dataPilarSosial[0]['total'];
            } else {
                $totalPilarSosial = 0;
            }

            //+++++++++REALISASI PROVINSI+++++++++//
            $releaseProvinsi = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getProvinsi', $param, '');
            $returnProvinsi = json_decode(strstr($releaseProvinsi, '{'), true);
            $dataProvinsi = $returnProvinsi['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++REALISASI TPB+++++++++//
            $releaseTPB = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getTPB', $param, '');
            $returnTPB = json_decode(strstr($releaseTPB, '{'), true);
            $dataTPB = $returnTPB['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            $tpb = [];
            foreach ($dataTPB as $t) {
                $tpb[] = $t['tpb'];
            }

            $statusTPB = [];
            foreach ($dataTPB as $st) {
                $statusTPB[] = round($st['total'] / $anggaran->nominal * 100, 2);
            }

            //+++++++++PRIORITAS PENDIDIKAN+++++++++//
            $releasePrioritasPendidikan = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPrioritasPendidikan', $param, '');
            $returnPrioritasPendidikan = json_decode(strstr($releasePrioritasPendidikan, '{'), true);
            $dataPrioritasPendidikan = $returnPrioritasPendidikan['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            if (!empty($dataPrioritasPendidikan)) {
                $totalPrioritasPendidikan = $dataPrioritasPendidikan[0]['total'];
            } else {
                $totalPrioritasPendidikan = 0;
            }

            //+++++++++PRIORITAS LINGKUNGAN+++++++++//
            $releasePrioritasLingkungan = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPrioritasLingkungan', $param, '');
            $returnPrioritasLingkungan = json_decode(strstr($releasePrioritasLingkungan, '{'), true);
            $dataPrioritasLingkungan = $returnPrioritasLingkungan['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            if (!empty($dataPrioritasLingkungan)) {
                $totalPrioritasLingkungan = $dataPrioritasLingkungan[0]['total'];
            } else {
                $totalPrioritasLingkungan = 0;
            }

            //+++++++++PRIORITAS UMK+++++++++//
            $releasePrioritasUMK = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPrioritasUMK', $param, '');
            $returnPrioritasUMK = json_decode(strstr($releasePrioritasUMK, '{'), true);
            $dataPrioritasUMK = $returnPrioritasUMK['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            if (!empty($dataPrioritasUMK)) {
                $totalPrioritasUMK = $dataPrioritasUMK[0]['total'];
            } else {
                $totalPrioritasUMK = 0;
            }

            //+++++++++PRIORITAS SOSIAL EKONOMI+++++++++//
            $releasePrioritasSosialEkonomi = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPrioritasSosialEkonomi', $param, '');
            $returnPrioritasSosialEkonomi = json_decode(strstr($releasePrioritasSosialEkonomi, '{'), true);
            $dataPrioritasSosialEkonomi = $returnPrioritasSosialEkonomi['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

        }

        if (!empty($dataPrioritasSosialEkonomi)) {
            $totalPrioritasSosialEkonomi = $dataPrioritasSosialEkonomi[0]['total'];
        } else {
            $totalPrioritasSosialEkonomi = 0;
        }

        if ($dataRealisasiProgress['total'] == '') {
            $totalRealisasiProgress = 0;
        } else {
            $totalRealisasiProgress = $dataRealisasiProgress['total'];
        }

        if ($dataRealisasiPAID['total'] == '') {
            $totalRealisasiPAID = 0;
        } else {
            $totalRealisasiPAID = $dataRealisasiPAID['total'];
        }

        if ($dataOperasional['total'] == '') {
            $totalOperasional = 0;
        } else {
            $totalOperasional = $dataOperasional['total'];
        }

        if ($dataOperasionalPAID['total'] == '') {
            $totalOperasionalPAID = 0;
        } else {
            $totalOperasionalPAID = $dataOperasionalPAID['total'];
        }

        if ($dataOperasionalProgress['total'] == '') {
            $totalOperasionalProgress = 0;
        } else {
            $totalOperasionalProgress = $dataOperasionalProgress['total'];
        }

        if ($dataProposal['total'] == '') {
            $totalCostProposal = 0;
        } else {
            $totalCostProposal = $dataProposal['total'];
        }

        if ($dataProposalPAID['total'] == '') {
            $totalCostProposalPAID = 0;
        } else {
            $totalCostProposalPAID = $dataProposalPAID['total'];
        }

        if ($dataProposalProgress['total'] == '') {
            $totalCostProposalProgress = 0;
        } else {
            $totalCostProposalProgress = $dataProposalProgress['total'];
        }

        //PRIORITAS
        $planPendidikan = DB::table('tbl_proker')
            ->select(DB::raw('sum(anggaran) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->where('prioritas', 'Pendidikan')
            ->groupBy('prioritas')
            ->first();

        if (!empty($planPendidikan)) {
            $totalPlanPendidikan = $planPendidikan->total;
        } else {
            $totalPlanPendidikan = 0;
        }

        $planLingkungan = DB::table('tbl_proker')
            ->select(DB::raw('sum(anggaran) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->where('prioritas', 'Lingkungan')
            ->groupBy('prioritas')
            ->first();

        if (!empty($planLingkungan)) {
            $totalPlanLingkungan = $planLingkungan->total;
        } else {
            $totalPlanLingkungan = 0;
        }

        $planUMK = DB::table('tbl_proker')
            ->select(DB::raw('sum(anggaran) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->where('prioritas', 'UMK')
            ->groupBy('prioritas')
            ->first();

        if (!empty($planUMK)) {
            $totalPlanUMK = $planUMK->total;
        } else {
            $totalPlanUMK = 0;
        }

        $planSosialEkonomi = DB::table('tbl_proker')
            ->select(DB::raw('sum(anggaran) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->whereNull('prioritas')
            ->groupBy('prioritas')
            ->first();

        if (!empty($planSosialEkonomi)) {
            $totalPlanSosialEkonomi = $planSosialEkonomi->total;
        } else {
            $totalPlanSosialEkonomi = 0;
        }

        //PILAR
        $planPilarLingkungan = DB::table('tbl_proker')
            ->select(DB::raw('sum(anggaran) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->where('pilar', 'Lingkungan')
            ->groupBy('pilar')
            ->first();

        if (!empty($planPilarLingkungan)) {
            $totalPlanPilarLingkungan = $planPilarLingkungan->total;
        } else {
            $totalPlanPilarLingkungan = 0;
        }

        $planPilarEkonomi = DB::table('tbl_proker')
            ->select(DB::raw('sum(anggaran) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->where('pilar', 'Ekonomi')
            ->groupBy('pilar')
            ->first();

        if (!empty($planPilarEkonomi)) {
            $totalPlanPilarEkonomi = $planPilarEkonomi->total;
        } else {
            $totalPlanPilarEkonomi = 0;
        }

        $planPilarSosial = DB::table('tbl_proker')
            ->select(DB::raw('sum(anggaran) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->where('pilar', 'Sosial')
            ->groupBy('pilar')
            ->first();

        if (!empty($planPilarSosial)) {
            $totalPlanPilarSosial = $planPilarSosial->total;
        } else {
            $totalPlanPilarSosial = 0;
        }

        $jumlahReviewSurvei = Survei::where('status', 'Forward')->where('survei2', $username)->count();
        $jumlahCreateSuvei = DB::table('V_EVALUASI')
            ->where(function ($query) use ($username) {
                $query->where('EVALUATOR1', $username)
                    ->where('STATUS', 'Survei');
            })
            ->orWhere(function ($query) use ($username) {
                $query->where('EVALUATOR2', $username)
                    ->where('STATUS', 'Survei');
            })
            ->count();

        $role = $this->authContext->role();
        if ($role == 'Manager') {
            $jumlahApproveSurvei = ViewSurvei::where('status', 'Approved 2')->where('kadiv', $username)->count();
            $jumlahApproveEvaluasi = ViewEvaluasi::where('status', 'Approved 2')->where('kadiv', $username)->count();
        } elseif ($role == 'Supervisor 1') {
            $jumlahApproveSurvei = ViewSurvei::where('status', 'Approved 1')->where('kadep', $username)->count();
            $jumlahApproveEvaluasi = ViewEvaluasi::where('status', 'Approved 1')->where('kadep', $username)->count();
        } else {
            $jumlahApproveSurvei = 0;
            $jumlahApproveEvaluasi = 0;
        }

        $dataRealisasiSubsidiary = [];
        foreach ($anggaranAP as $tap) {
            $realisasiAP = DB::table('tbl_realisasi_ap')
                ->select(DB::raw('sum(nilai_bantuan) as total'))
                ->where('tahun', $tahun)
                ->where('perusahaan', $tap->perusahaan)
                ->groupBy('perusahaan')
                ->first();

            if (!empty($realisasiAP)) {
                $totalRealisasiAP = $realisasiAP->total;
            } else {
                $totalRealisasiAP = 0;
            }

            $dataRealisasiSubsidiary[] = [
                'perusahaan' => $tap->perusahaan,
                'anggaran' => $tap->nominal,
                'realisasi' => $totalRealisasiAP,
            ];
        }

        $subsidiary = [];
        foreach ($anggaranAP as $ap) {
            $subsidiary[] = $ap->perusahaan;
        }

        $statusSubsidiary = [];
        foreach ($anggaranAP as $aap) {
            $totalSubsidiary = DB::table('tbl_realisasi_ap')
                ->select(DB::raw('sum(nilai_bantuan) as total'))
                ->where('tahun', $tahun)
                ->where('perusahaan', $aap->perusahaan)
                ->groupBy('perusahaan')
                ->first();

            if (!empty($totalSubsidiary)) {
                $totalSub = $totalSubsidiary->total;
            } else {
                $totalSub = 0;
            }

            $statusSubsidiary[] = round($totalSub / $aap->nominal * 100, 2);
        }

        return view('home.dashboard')
            ->with([
                'dataPerusahaan' => $perusahaan,
                'anggaran' => $anggaran->nominal,
                'anggaranAP' => $anggaranAP,
                'jumlahAnggaranAP' => $jumlahAnggaranAP,
                'subsidiary' => $subsidiary,
                'statusSubsidiary' => $statusSubsidiary,
                'dataRealisasiSubsidiary' => $dataRealisasiSubsidiary,
                'totalRealisasiPAID' => $totalRealisasiPAID,
                'totalRealisasiProgress' => $totalRealisasiProgress,
                'totalOperasional' => $totalOperasional,
                'totalOperasionalPAID' => $totalOperasionalPAID,
                'totalOperasionalProgress' => $totalOperasionalProgress,
                'totalCostProposal' => $totalCostProposal,
                'totalCostProposalPAID' => $totalCostProposalPAID,
                'totalCostProposalProgress' => $totalCostProposalProgress,
                'tahun' => $tahun,
                'comp' => $company,
                'totalPlanPilarLingkungan' => $totalPlanPilarLingkungan,
                'totalPlanPilarEkonomi' => $totalPlanPilarEkonomi,
                'totalPlanPilarSosial' => $totalPlanPilarSosial,
                'totalActualPilarLingkungan' => $totalPilarLingkungan,
                'totalActualPilarEkonomi' => $totalPilarEkonomi,
                'totalActualPilarSosial' => $totalPilarSosial,
                'planPilarLingkungan' => round($totalPlanPilarLingkungan / $anggaran->nominal * 100, 2),
                'planPilarEkonomi' => round($totalPlanPilarEkonomi / $anggaran->nominal * 100, 2),
                'planPilarSosial' => round($totalPlanPilarSosial / $anggaran->nominal * 100, 2),
                'actualPilarLingkungan' => round($totalPilarLingkungan / $anggaran->nominal * 100, 2),
                'actualPilarEkonomi' => round($totalPilarEkonomi / $anggaran->nominal * 100, 2),
                'actualPilarSosial' => round($totalPilarSosial / $anggaran->nominal * 100, 2),
                'dataProvinsi' => $dataProvinsi,
                'dataTPB' => $dataTPB,
                'tpb' => $tpb,
                'statusTPB' => $statusTPB,
                'jumlahReviewSurvei' => $jumlahReviewSurvei,
                'jumlahApproveSurvei' => $jumlahApproveSurvei,
                'jumlahApproveEvaluasi' => $jumlahApproveEvaluasi,
                'jumlahCreateSurvei' => $jumlahCreateSuvei,
                'totalPlanPendidikan' => $totalPlanPendidikan,
                'totalPlanLingkungan' => $totalPlanLingkungan,
                'totalPlanUMK' => $totalPlanUMK,
                'totalPlanSosialEkonomi' => $totalPlanSosialEkonomi,
                'totalActualPendidikan' => $totalPrioritasPendidikan,
                'totalActualLingkungan' => $totalPrioritasLingkungan,
                'totalActualUMK' => $totalPrioritasUMK,
                'totalActualSosialEkonomi' => $totalPrioritasSosialEkonomi,
                'planPendidikan' => round($totalPlanPendidikan / $anggaran->nominal * 100, 2),
                'planLingkungan' => round($totalPlanLingkungan / $anggaran->nominal * 100, 2),
                'planUMK' => round($totalPlanUMK / $anggaran->nominal * 100, 2),
                'planSosialEkonomi' => round($totalPlanSosialEkonomi / $anggaran->nominal * 100, 2),
                'actualPendidikan' => round($totalPrioritasPendidikan / $anggaran->nominal * 100, 2),
                'actualLingkungan' => round($totalPrioritasLingkungan / $anggaran->nominal * 100, 2),
                'actualUMK' => round($totalPrioritasUMK / $anggaran->nominal * 100, 2),
                'actualSosialEkonomi' => round($totalPrioritasSosialEkonomi / $anggaran->nominal * 100, 2),
            ]);
    }

    public function postSubsidiary(PostDashboardSubsidiaryRequest $request, PostDashboardSubsidiaryAction $action)
    {
        return $action->execute($request);
    }

    public function indexSubsidiaryAnnual($year, $company)
    {
        try {
            $tahun = decrypt($year);
        } catch (Exception $e) {
            abort(404);
        }

        $anggaran = Anggaran::where('perusahaan', $company)->where('tahun', $tahun)->first();
        $perusahaan = Perusahaan::whereIn('kategori', ['Holding', 'Subholding'])->orderBy('id_perusahaan', 'ASC')->get();

        if (!empty($anggaran)) {
            $budget = $anggaran->nominal;
        } else {
            $budget = 0;
        }

        if (!empty($anggaran)) {

            $dataTotal = DB::table('tbl_realisasi_ap')
                ->select(DB::raw('SUM(nilai_bantuan) as total'))
                ->where('tahun', $tahun)
                ->where('perusahaan', $company)
                ->first();

            $persen = round($dataTotal->total / $budget * 100, 2);
            $totalRealisasi = $dataTotal->total;

        } else {
            $persen = 0;
            $totalRealisasi = 0;
        }

        $totalPilar = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('pilar, sum(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->groupBy('pilar')
            ->get();

        $pilar = [];
        foreach ($totalPilar as $tp) {
            $pilar[] = $tp->pilar;
        }

        $statusPilar = [];
        foreach ($totalPilar as $tp) {
            $statusPilar[] = round($tp->total / $budget * 100, 2);
        }

//        $totalTPB = DB::table('tbl_realisasi_ap')
//            ->select(DB::raw('gols, sum(nilai_bantuan) as total'))
//            ->where('tahun', $tahun)
//            ->where('perusahaan', $company)
//            ->groupBy('gols')
//            ->get();
//
//        $goals = [];
//        foreach ($totalTPB as $tpb) {
//            $goals[] = $tpb->gols;
//        }
//
//        $statusGoals = [];
//        foreach ($totalTPB as $tpb) {
//            $statusGoals[] = round($tpb->total / $budget * 100, 2);
//        }

        $totalPriortas = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('prioritas, sum(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->groupBy('prioritas')
            ->get();

        function prioritas($prio)
        {
            $priority = $prio;
            switch ($priority) {
                case "" :
                    $priority = "Sosial/Ekonomi";
                    break;
            }
            return $priority;
        }

        $prioritas = [];
        foreach ($totalPriortas as $p) {
            $prioritas[] = prioritas($p->prioritas);
        }

        $statusPrioritas = [];
        foreach ($totalPriortas as $pp) {
            $statusPrioritas[] = round($pp->total / $budget * 100, 2);
        }

        $totalWilayah = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('provinsi, sum(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->groupBy('provinsi')
            ->get();

        $dataBulanan = DB::select("SELECT
                                SUM( CASE WHEN TO_CHAR( TGL_REALISASI, 'MM' ) = 01 THEN NILAI_BANTUAN ELSE 0 END ) AS JANUARI,
                                SUM( CASE WHEN TO_CHAR( TGL_REALISASI, 'MM' ) = 02 THEN NILAI_BANTUAN ELSE 0 END ) AS FEBRUARI,
                                SUM( CASE WHEN TO_CHAR( TGL_REALISASI, 'MM' ) = 03 THEN NILAI_BANTUAN ELSE 0 END ) AS MARET,
                                SUM( CASE WHEN TO_CHAR( TGL_REALISASI, 'MM' ) = 04 THEN NILAI_BANTUAN ELSE 0 END ) AS APRIL,
                                SUM( CASE WHEN TO_CHAR( TGL_REALISASI, 'MM' ) = 05 THEN NILAI_BANTUAN ELSE 0 END ) AS MEI,
                                SUM( CASE WHEN TO_CHAR( TGL_REALISASI, 'MM' ) = 06 THEN NILAI_BANTUAN ELSE 0 END ) AS JUNI,
                                SUM( CASE WHEN TO_CHAR( TGL_REALISASI, 'MM' ) = 07 THEN NILAI_BANTUAN ELSE 0 END ) AS JULI,
                                SUM( CASE WHEN TO_CHAR( TGL_REALISASI, 'MM' ) = 08 THEN NILAI_BANTUAN ELSE 0 END ) AS AGUSTUS,
                                SUM( CASE WHEN TO_CHAR( TGL_REALISASI, 'MM' ) = 09 THEN NILAI_BANTUAN ELSE 0 END ) AS SEPTEMBER,
                                SUM( CASE WHEN TO_CHAR( TGL_REALISASI, 'MM' ) = 10 THEN NILAI_BANTUAN ELSE 0 END ) AS OKTOBER,
                                SUM( CASE WHEN TO_CHAR( TGL_REALISASI, 'MM' ) = 11 THEN NILAI_BANTUAN ELSE 0 END ) AS NOVEMBER,
                                SUM( CASE WHEN TO_CHAR( TGL_REALISASI, 'MM' ) = 12 THEN NILAI_BANTUAN ELSE 0 END ) AS DESEMBER 
                            FROM
                                TBL_REALISASI_AP 
                            WHERE
                                PERUSAHAAN = ? 
                                AND TAHUN = ?", [$company, $tahun]);

        $bulanan = [];
        foreach ($dataBulanan as $d) {
            $bulanan = [
                round($d->januari),
                round($d->februari),
                round($d->maret),
                round($d->april),
                round($d->mei),
                round($d->juni),
                round($d->juli),
                round($d->agustus),
                round($d->september),
                round($d->oktober),
                round($d->november),
                round($d->desember),
            ];
        }

        return view('home.dashboardSubsidiary')
            ->with([
                'tahun' => $tahun,
                'comp' => $company,
                'anggaran' => $budget,
                'dataPerusahaan' => $perusahaan,
                'realisasi' => $totalRealisasi,
                'persen' => $persen,
                'totalPilar' => $totalPilar,
                'pilar' => $pilar,
                'statusPilar' => $statusPilar,
                'bulanan' => $bulanan,
//                'totalTPB' => $totalTPB,
//                'goals' => $goals,
//                'statusGoals' => $statusGoals,
                'totalPrioritas' => $totalPriortas,
                'prioritas' => $prioritas,
                'statusPrioritas' => $statusPrioritas,
                'totalWilayah' => $totalWilayah,
                'dataRealisasiBulan' => $dataBulanan[0],
            ]);
    }

    public function inputPeriode(InsertPeriode $request)
    {

        $tglAwal = date("Y-m-d", strtotime($request->tanggal1));
        $tglAkhir = date("Y-m-d", strtotime($request->tanggal2));

        #Validasi Tanggal
        $tanggal1 = new \DateTime($tglAwal);
        $tanggal2 = new \DateTime($tglAkhir);

        $interval = date_diff($tanggal1, $tanggal2);
        $jumlahHari = $interval->format('%R%a');

        if ($jumlahHari < 0) {
            return redirect()->back()->with('gagal', 'Tanggal yang anda pilih tidak valid!');
        } else {
            return redirect()->route('dashboard-Periode', ['awal' => "$request->tanggal1", 'akhir' => "$request->tanggal2"]);
        }

    }

    public function tahun($tahunAnggaran)
    {
        $tahun = $tahunAnggaran;

        $anggaran = Anggaran::where('tahun', $tahun)->first();

        $totalProposal = DB::table('V_SUM_SEKTOR2')
            ->select(DB::raw('sum(JUMLAH) as total'))
            ->where([
                ['tahun', $tahun],
                //['status', '=', 'PAID'],
            ])
            ->first();

        if ($totalCostProposal == '') {
            $total = 0;
        } else {
            $total = $totalCostProposal;
        }

        $nominalSektor = DB::table('V_SUM_SEKTOR2')
            ->select('SEKTOR_BANTUAN', DB::raw('sum(jumlah) as jumlah'))
            ->where('TAHUN', $tahun)
            ->where('STATUS', 'PAID')
            ->groupBy('SEKTOR_BANTUAN')
            ->orderBy('SEKTOR_BANTUAN', 'ASC')
            ->get();

        $nominalStatus = DB::table('V_SUM_SEKTOR2')
            ->select(DB::raw('sum(JUMLAH) as total'))
            ->where([
                ['tahun', $tahun],
            ])
            ->first();

        //Persentase status DRAFT
        $nominalDraft = DB::table('V_SUM_SEKTOR2')
            ->select(DB::raw('sum(JUMLAH) as total'))
            ->where([
                ['status', 'DRAFT'],
                ['tahun', $tahun],
            ])
            ->first();

        if ($nominalDraft->total == '') {
            $nilaiDraft = 0;
            $persenDraft = 0;
        } else {
            $persenDraft = round($nominalDraft->total / $nominalStatus->total * 100, 2);
            $nilaiDraft = $nominalDraft->total;
        }

        //Persentase status ON PROGRESS
        $nominalOnProgress = DB::table('V_SUM_SEKTOR2')
            ->select(DB::raw('sum(JUMLAH) as total'))
            ->where([
                ['status', 'IN PROGRESS'],
                ['tahun', $tahun],
            ])
            ->first();

        if ($nominalOnProgress->total == '') {
            $nilaiOnProgress = 0;
            $persenOnProgress = 0;
        } else {
            $persenOnProgress = round($nominalOnProgress->total / $nominalStatus->total * 100, 2);
            $nilaiOnProgress = $nominalOnProgress->total;
        }

        //Persentase status REJECTED
        $nominalRejected = DB::table('V_SUM_SEKTOR2')
            ->select(DB::raw('sum(JUMLAH) as total'))
            ->where([
                ['status', 'REJECTED'],
                ['tahun', $tahun],
            ])
            ->first();

        if ($nominalRejected->total == '') {
            $persenRejected = 0;
            $nilaiRejected = 0;
        } else {
            $persenRejected = round($nominalRejected->total / $nominalStatus->total * 100, 2);
            $nilaiRejected = $nominalRejected->total;
        }

        //Persentase status RELEASED
        $nominalReleased = DB::table('V_SUM_SEKTOR2')
            ->select(DB::raw('sum(JUMLAH) as total'))
            ->where([
                ['status', 'RELEASED'],
                ['tahun', $tahun],
            ])
            ->first();

        if ($nominalReleased->total == '') {
            $persenReleased = 0;
            $nilaiReleased = 0;
        } else {
            $nilaiReleased = $nominalReleased->total;
            $persenReleased = round($nominalReleased->total / $nominalStatus->total * 100, 2);
        }

        //Persentase status PAID
        $nominalPaid = DB::table('V_SUM_SEKTOR2')
            ->select(DB::raw('sum(JUMLAH) as total'))
            ->where([
                ['status', 'PAID'],
                ['tahun', $tahun],
            ])
            ->first();

        if ($nominalPaid->total == '') {
            $nilaiPaid = 0;
            $persenPaid = 0;
        } else {
            $persenPaid = round($nominalPaid->total / $nominalStatus->total * 100, 2);
            $nilaiPaid = $nominalPaid->total;
        }

        //Korban Bencana Alam
        $sektor1 = DB::table('V_SUM_SEKTOR2')
            ->select(DB::raw('sum(JUMLAH) as total'))
            ->where([
                ['tahun', $tahun],
                //['status', '=', 'PAID']
            ])
            ->whereIn('sektor_bantuan', ['810', '811', '812'])
            ->first();

        if ($sektor1->total == '') {
            $nilaiSektor1 = 0;
            $persenSektor1 = 0;
        } else {
            $nilaiSektor1 = $sektor1->total;
            $persenSektor1 = round($sektor1->total / $totalCostProposal * 100, 2);
        }

        //Pendidikan dan/atau Pelatihan
        $sektor2 = DB::table('V_SUM_SEKTOR2')
            ->select(DB::raw('sum(JUMLAH) as total'))
            ->where([
                ['tahun', $tahun],
                //['status', '=', 'PAID']
            ])
            ->whereIn('sektor_bantuan', ['820', '821', '822'])
            ->first();

        if ($sektor2->total == '') {
            $nilaiSektor2 = 0;
            $persenSektor2 = 0;
        } else {
            $nilaiSektor2 = $sektor2->total;
            $persenSektor2 = round($sektor2->total / $totalCostProposal * 100, 2);
        }

        //Peningkatan Kesehatan
        $sektor3 = DB::table('V_SUM_SEKTOR2')
            ->select(DB::raw('sum(JUMLAH) as total'))
            ->where([
                ['tahun', $tahun],
                //['status', '=', 'PAID']
            ])
            ->whereIn('sektor_bantuan', ['830', '831', '832'])
            ->first();

        if ($sektor3->total == '') {
            $nilaiSektor3 = 0;
            $persenSektor3 = 0;
        } else {
            $nilaiSektor3 = $sektor3->total;
            $persenSektor3 = round($sektor3->total / $totalCostProposal * 100, 2);
        }

        //Pengembangan Prasarana dan/atau Sarana Umum
        $sektor4 = DB::table('V_SUM_SEKTOR2')
            ->select(DB::raw('sum(JUMLAH) as total'))
            ->where([
                ['tahun', $tahun],
                //['status', '=', 'PAID']
            ])
            ->whereIn('sektor_bantuan', ['840', '841', '842'])
            ->first();

        if ($sektor4->total == '') {
            $nilaiSektor4 = 0;
            $persenSektor4 = 0;
        } else {
            $nilaiSektor4 = $sektor4->total;
            $persenSektor4 = round($sektor4->total / $totalCostProposal * 100, 2);
        }

        //Sarana Ibadah
        $sektor5 = DB::table('V_SUM_SEKTOR2')
            ->select(DB::raw('sum(JUMLAH) as total'))
            ->where([
                ['tahun', $tahun],
                //['status', '=', 'PAID']
            ])
            ->whereIn('sektor_bantuan', ['850', '851', '852'])
            ->first();

        if ($sektor5->total == '') {
            $nilaiSektor5 = 0;
            $persenSektor5 = 0;
        } else {
            $nilaiSektor5 = $sektor5->total;
            $persenSektor5 = round($sektor5->total / $totalCostProposal * 100, 2);
        }

        //Pelestarian Alam
        $sektor6 = DB::table('V_SUM_SEKTOR2')
            ->select(DB::raw('sum(JUMLAH) as total'))
            ->where([
                ['tahun', $tahun],
                //['status', '=', 'PAID']
            ])
            ->whereIn('sektor_bantuan', ['860', '861', '862'])
            ->first();

        if ($sektor6->total == '') {
            $nilaiSektor6 = 0;
            $persenSektor6 = 0;
        } else {
            $nilaiSektor6 = $sektor6->total;
            $persenSektor6 = round($sektor6->total / $totalCostProposal * 100, 2);
        }

        //Pengentasan Kemiskinan
        $sektor7 = DB::table('V_SUM_SEKTOR2')
            ->select(DB::raw('sum(JUMLAH) as total'))
            ->where([
                ['tahun', $tahun],
                //['status', '=', 'PAID']
            ])
            ->whereIn('sektor_bantuan', ['870', '871', '872'])
            ->first();

        if ($sektor7->total == '') {
            $nilaiSektor7 = 0;
            $persenSektor7 = 0;
        } else {
            $nilaiSektor7 = $sektor7->total;
            $persenSektor7 = round($sektor7->total / $totalCostProposal * 100, 2);
        }

        //Periode Bulan
        $nominalProposal = DB::table('V_BULAN')
            ->selectRaw('SUM(JUMLAH) AS jumlah, BULAN, TAHUN')
            ->where('TAHUN', $tahun)
            ->groupBy('BULAN', 'TAHUN')
            ->orderBy('BULAN', 'ASC')
            ->get();
        $grafikProposal = DB::table('V_BULAN')
            ->selectRaw('COUNT(*) AS jumlah, BULAN, TAHUN')
            ->where('TAHUN', $tahun)
            ->groupBy('BULAN', 'TAHUN')
            ->orderBy('BULAN', 'ASC')
            ->get();

        function bulan($bln)
        {
            $bulan = $bln;
            switch ($bulan) {
                case 1 :
                    $bulan = "Januari";
                    break;
                case 2 :
                    $bulan = "Februari";
                    break;
                case 3 :
                    $bulan = "Maret";
                    break;
                case 4 :
                    $bulan = "April";
                    break;
                case 5 :
                    $bulan = "Mei";
                    break;
                case 6 :
                    $bulan = "Juni";
                    break;
                case 7 :
                    $bulan = "Juli";
                    break;
                case 8 :
                    $bulan = "Agustus";
                    break;
                case 9 :
                    $bulan = "September";
                    break;
                case 10 :
                    $bulan = "Oktober";
                    break;
                case 11 :
                    $bulan = "November";
                    break;
                case 12 :
                    $bulan = "Desember";
                    break;
            }
            return $bulan;
        }

        $dataBulan = [];
        foreach ($grafikProposal as $ss) {
            $dataBulan[] = bulan($ss->bulan);
        }

        $dataJumlah = [];
        foreach ($grafikProposal as $ss) {
            $dataJumlah[] = round($ss->jumlah);
        }

        return view('home.dashboard')
            ->with([
                'anggaran' => $anggaran->nominal,
                'totalProposal' => $totalProposal,
                'nominalProposal' => $nominalProposal,
                'dataBulan' => $dataBulan,
                'dataJumlah' => $dataJumlah,
                'tahun' => $tahun,
                'persenDraft' => $persenDraft,
                'persenOnProgress' => $persenOnProgress,
                'persenRejected' => $persenRejected,
                'persenReleased' => $persenReleased,
                'persenPaid' => $persenPaid,
                'nilaiDraft' => $nilaiDraft,
                'nilaiOnProgress' => $nilaiOnProgress,
                'nilaiRejected' => $nilaiRejected,
                'nilaiReleased' => $nilaiReleased,
                'nilaiPaid' => $nilaiPaid,
                'nominalStatus' => $nominalStatus,
                'nilaiSektor1' => $nilaiSektor1,
                'persenSektor1' => $persenSektor1,
                'nilaiSektor2' => $nilaiSektor2,
                'persenSektor2' => $persenSektor2,
                'nilaiSektor3' => $nilaiSektor3,
                'persenSektor3' => $persenSektor3,
                'nilaiSektor4' => $nilaiSektor4,
                'persenSektor4' => $persenSektor4,
                'nilaiSektor5' => $nilaiSektor5,
                'persenSektor5' => $persenSektor5,
                'nilaiSektor6' => $nilaiSektor6,
                'persenSektor6' => $persenSektor6,
                'nilaiSektor7' => $nilaiSektor7,
                'persenSektor7' => $persenSektor7,
            ]);
    }

    public function board()
    {
        $tahun = date("Y");

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
        );

        $releaseProposal = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getProposal', $param, '');
        $returnProposal = json_decode(strstr($releaseProposal, '{'), true);
        $dataProposal = $returnProposal['data'][0];

        $releaseSektor = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getSektor', $param, '');
        $returnSektor = json_decode(strstr($releaseSektor, '{'), true);
        $dataSektor = $returnSektor['data_sektor'];
        $dataPerSektor = $returnSektor['categories'];
        $dataPerDataSektor = $returnSektor['data'];
        $dataPerDataSektorTotal = $returnSektor['total'];
        $dataPerDataSektorPersen = $returnSektor['persen'];

        $releaseProvinsi = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getProvinsi', $param, '');
        $returnProvinsi = json_decode(strstr($releaseProvinsi, '{'), true);
        $dataProvinsi = $returnProvinsi['data_provinsi'];
        $dataPerProvinsi = $returnProvinsi['categories'];
        $dataPerDataProvinsi = $returnProvinsi['data'];
        $dataPerDataProvinsiTotal = $returnProvinsi['total'];

        $releasePaid = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPaid', $param, '');
        $returnPaid = json_decode(strstr($releasePaid, '{'), true);
        $dataPaid = $returnPaid['data'][0];

        $releaseSektorBulan = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getSektorBulan', $param, '');
        $returnSektorBulan = json_decode(strstr($releaseSektorBulan, '{'), true);
        $dataSektorBulan = $returnSektorBulan['data'];

        if ($dataProposal['total'] == '') {
            $totalCostProposal = 0;
        } else {
            $totalCostProposal = $dataProposal['total'];
        }

        if ($dataPaid['total'] == '' or $dataPaid['total'] == null) {
            $totalPaid = 0;
        } else {
            $totalPaid = $dataPaid['total'];
        }

        $anggaran = Anggaran::where('tahun', $tahun)->first();

        //HEWAN QURBAN
        $totalSapi = DB::table('tbl_sub_proposal')
            ->select(DB::raw('sum(sapi) as total'))
            ->first();

        $totalKambing = DB::table('tbl_sub_proposal')
            ->select(DB::raw('sum(kambing) as total'))
            ->first();

        $totalProvinsiSapi = DB::table('v_provinsi_sapi')
            ->select('v_provinsi_sapi.*')
            ->count();

        $totalProvinsiKambing = DB::table('v_provinsi_kambing')
            ->select('v_provinsi_kambing.*')
            ->count();

        $totalKabupatenSapi = DB::table('v_kabupaten_sapi')
            ->select('v_kabupaten_sapi.*')
            ->count();

        $totalKabupatenKambing = DB::table('v_kabupaten_kambing')
            ->select('v_kabupaten_kambing.*')
            ->count();


        $totalQurban = $totalSapi->total + $totalKambing->total;

        $persenSapi = round($totalSapi->total / $totalQurban * 100, 2);
        $persenKambing = round($totalKambing->total / $totalQurban * 100, 2);

        //Periode Bulan
        $nominalProposal = DB::table('V_BULAN')
            ->selectRaw('SUM(JUMLAH) AS jumlah, BULAN, TAHUN')
            ->where('TAHUN', $tahun)
            ->groupBy('BULAN', 'TAHUN')
            ->orderBy('BULAN', 'ASC')
            ->get();
        $grafikProposal = DB::table('V_BULAN')
            ->selectRaw('COUNT(*) AS jumlah, BULAN, TAHUN')
            ->where('TAHUN', $tahun)
            ->groupBy('BULAN', 'TAHUN')
            ->orderBy('BULAN', 'ASC')
            ->get();

        function bulan($bln)
        {
            $bulan = $bln;
            switch ($bulan) {
                case 1 :
                    $bulan = "Januari";
                    break;
                case 2 :
                    $bulan = "Februari";
                    break;
                case 3 :
                    $bulan = "Maret";
                    break;
                case 4 :
                    $bulan = "April";
                    break;
                case 5 :
                    $bulan = "Mei";
                    break;
                case 6 :
                    $bulan = "Juni";
                    break;
                case 7 :
                    $bulan = "Juli";
                    break;
                case 8 :
                    $bulan = "Agustus";
                    break;
                case 9 :
                    $bulan = "September";
                    break;
                case 10 :
                    $bulan = "Oktober";
                    break;
                case 11 :
                    $bulan = "November";
                    break;
                case 12 :
                    $bulan = "Desember";
                    break;
            }
            return $bulan;
        }

        $dataBulan = [];
        foreach ($grafikProposal as $ss) {
            $dataBulan[] = bulan($ss->bulan);
        }

        $dataJumlah = [];
        foreach ($grafikProposal as $ss) {
            $dataJumlah[] = round($ss->jumlah);
        }

        return view('home.board')
            ->with([
                'anggaran' => $anggaran->nominal,
                'totalCostProposal' => $totalCostProposal,
                'nominalProposal' => $nominalProposal,
                'dataBulan' => $dataBulan,
                'dataJumlah' => $dataJumlah,
                'tahun' => $tahun,
                'nilaiPaid' => $totalPaid,
                'dataSektor' => $dataSektor,
                'dataSektorBulan' => $dataSektorBulan,
                'dataPerSektor' => $dataPerSektor,
                'dataPerDataSektor' => $dataPerDataSektor,
                'dataPerDataSektorTotal' => $dataPerDataSektorTotal,
                'dataPerDataSektorPersen' => $dataPerDataSektorPersen,
                'dataProvinsi' => $dataProvinsi,
                'dataPerProvinsi' => $dataPerProvinsi,
                'dataPerDataProvinsi' => $dataPerDataProvinsi,
                'dataPerDataProvinsiTotal' => $dataPerDataProvinsiTotal,
                'totalSapi' => $totalSapi->total,
                'totalKambing' => $totalKambing->total,
                'persenSapi' => $persenSapi,
                'persenKambing' => $persenKambing,
                'totalProvinsiSapi' => $totalProvinsiSapi,
                'totalProvinsiKambing' => $totalProvinsiKambing,
                'totalKabupatenSapi' => $totalKabupatenSapi,
                'totalKabupatenKambing' => $totalKabupatenKambing,
            ]);
    }
}
