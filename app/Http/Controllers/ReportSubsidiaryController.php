<?php

namespace App\Http\Controllers;

use App\Exports\RealisasiMonthlySubsidiaryExport;
use App\Exports\RealisasiPeriodeSubsidiaryExport;
use App\Exports\RealisasiPrioritySubsidiaryExport;
use App\Exports\RealisasiProkerAnnualSubsidiaryExport;
use App\Exports\RealisasiProkerSubsidiaryExport;
use App\Exports\RealisasiProposalSubsidiaryExport;
use App\Exports\RealisasiRegionSubsidiaryExport;
use App\Exports\RealisasiSDGsSubsidiaryExport;
use App\Models\Anggaran;
use App\Models\LampiranAP;
use App\Models\Pilar;
use App\Models\Proker;
use App\Models\Provinsi;
use App\Models\RealisasiAP;
use App\Models\ViewRealisasiAP;
use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Mail;
use Exception;

class ReportSubsidiaryController extends Controller
{
    public function index(Request $request)
    {
        $tahun    = $request->input('tahun', date("Y"));

        $company = session('user')->perusahaan;
        $perusahaanID = session('user')->id_perusahaan;
        
        $status = "All Data";
        $tanggal = date("Y-m-d");

        $data = RealisasiAP::where('tahun', $tahun)->where('id_perusahaan', $perusahaanID)->orderBy('tgl_realisasi', 'ASC')->get();
        $jumlahData = RealisasiAP::where('tahun', $tahun)->where('id_perusahaan', $perusahaanID)->count();
        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::table('TBL_WILAYAH')->select('city_name')->groupBy('city_name')->get();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();

        $anggaran = Anggaran::where('tahun', $tahun)->where('id_perusahaan', $perusahaanID)->first();

        $dataTotal = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('SUM(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('id_perusahaan', $perusahaanID)
            ->first();

        if (!empty($anggaran)) {
            $persen = round($dataTotal->total / $anggaran->nominal * 100, 2);
        }else{
            $persen = 0;
        }

        return view('subsidiary.report.indexProposal')
            ->with([
                'comp' => $company,
                'tahun' => $tahun,
                'status' => $status,
                'tanggal' => $tanggal,
                'dataRealisasi' => $data,
                'jumlahData' => $jumlahData,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataPilar' => $pilar,
                'total' => $dataTotal->total,
                'persen' => $persen,
            ]);
    }

    public function view($realisasiID)
    {
        try {
            $logID = decrypt($realisasiID);
        } catch (Exception $e) {
            abort(404);
        }

        $data = RealisasiAP::where('id_realisasi', $logID)->first();
        $lampiran = LampiranAP::where('id_realisasi', $logID)->get();
        $jumlahLampiran = LampiranAP::where('id_realisasi', $logID)->count();
        $company = $data->perusahaan;

        return view('subsidiary.report.detailRealisasi')
            ->with([
                'data' => $data,
                'dataLampiran' => $lampiran,
                'jumlahLampiran' => $jumlahLampiran,
                'comp' => $company,
            ]);
    }

    public function postRealisasiSubsidiaryAnnual(Request $request)
    {
        $this->validate($request, [
            'tahun' => 'required',
        ]);

        return redirect()->route('indexRealisasiSubsidiaryAnnual', ['year' => encrypt($request->tahun)]);
    }

    public function indexAnnual($year)
    {
        try {
            $tahun = decrypt($year);
        } catch (Exception $e) {
            abort(404);
        }

        $company = session('user')->perusahaan;
        $status = "All Data";
        $tanggal = date("Y-m-d");

        $data = RealisasiAP::where('tahun', $tahun)->where('perusahaan', $company)->orderBy('tgl_realisasi', 'ASC')->get();
        $jumlahData = RealisasiAP::where('tahun', $tahun)->where('perusahaan', $company)->count();
        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::table('TBL_WILAYAH')->select('city_name')->groupBy('city_name')->get();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        $dataTotal = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('SUM(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->first();

        if (!empty($anggaran)) {
            $persen = round($dataTotal->total / $anggaran->nominal * 100, 2);
        }else{
            $persen = 0;
        }

        return view('subsidiary.report.indexProposal')
            ->with([
                'comp' => $company,
                'tahun' => $tahun,
                'status' => $status,
                'tanggal' => $tanggal,
                'dataRealisasi' => $data,
                'jumlahData' => $jumlahData,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataPilar' => $pilar,
                'total' => $dataTotal->total,
                'persen' => $persen,
            ]);
    }

    public function postRealisasiSubsidiaryMonthly(Request $request)
    {
        $this->validate($request, [
            'bulan1' => 'required',
            'bulan2' => 'required',
        ]);

        return redirect()->route('indexRealisasiSubsidiaryMonthly', ['bulan1' => $request->bulan1, 'bulan2' => $request->bulan2, 'year' => encrypt($request->tahun)]);
    }

    public function indexMonthly($bulan1, $bulan2, $year)
    {
        try {
            $tahun = decrypt($year);
        } catch (Exception $e) {
            abort(404);
        }

        $company = session('user')->perusahaan;
        $status = "Monthly";
        $tanggal = date("Y-m-d");

        $data = ViewRealisasiAP::whereBetween('bulan', [$bulan1, $bulan2])->where('tahun', $tahun)->where('perusahaan', $company)->orderBy('tgl_realisasi', 'ASC')->get();

        $jumlahData = ViewRealisasiAP::whereBetween('bulan', [$bulan1, $bulan2])->where('tahun', $tahun)->where('perusahaan', $company)->count();
        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::table('TBL_WILAYAH')->select('city_name')->groupBy('city_name')->get();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        $dataTotal = DB::table('v_realisasi_ap')
            ->select(DB::raw('SUM(nilai_bantuan) as total'))
            ->whereBetween('bulan', [$bulan1, $bulan2])
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->first();

        if (!empty($anggaran)) {
            $persen = round($dataTotal->total / $anggaran->nominal * 100, 2);
        }else{
            $persen = 0;
        }

        return view('subsidiary.report.indexProposal')
            ->with([
                'comp' => $company,
                'tahun' => $tahun,
                'bulan1' => $bulan1,
                'bulan2' => $bulan2,
                'status' => $status,
                'tanggal' => $tanggal,
                'dataRealisasi' => $data,
                'jumlahData' => $jumlahData,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataPilar' => $pilar,
                'total' => $dataTotal->total,
                'persen' => $persen,
            ]);
    }

    public function postRealisasiSubsidiaryPeriode(Request $request)
    {
        $this->validate($request, [
            'tanggal1' => 'required',
            'tanggal2' => 'required',
        ]);

        return redirect()->route('indexRealisasiSubsidiaryPeriode', ['tanggal1' => $request->tanggal1, 'tanggal2' => $request->tanggal2]);
    }

    public function indexPeriode($tanggal1, $tanggal2)
    {
        $tahun = date("Y");
        $company = session('user')->perusahaan;
        $status = "Periode";
        $tanggal = date("Y-m-d");

        $tgl1 = date("Y-m-d", strtotime($tanggal1));
        $tgl2 = date("Y-m-d", strtotime($tanggal2));

        $data = ViewRealisasiAP::whereBetween('tgl_realisasi', [$tgl1, $tgl2])->where('perusahaan', $company)->orderBy('tgl_realisasi', 'ASC')->get();
        $jumlahData = ViewRealisasiAP::whereBetween('tgl_realisasi', [$tgl1, $tgl2])->where('perusahaan', $company)->count();

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::table('TBL_WILAYAH')->select('city_name')->groupBy('city_name')->get();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        $dataTotal = DB::table('v_realisasi_ap')
            ->select(DB::raw('SUM(nilai_bantuan) as total'))
            ->whereBetween('tgl_realisasi', [$tgl1, $tgl2])
            ->where('perusahaan', $company)
            ->first();

        if (!empty($anggaran)) {
            $persen = round($dataTotal->total / $anggaran->nominal * 100, 2);
        }else{
            $persen = 0;
        }

        return view('subsidiary.report.indexProposal')
            ->with([
                'comp' => $company,
                'tahun' => $tahun,
                'status' => $status,
                'tanggal' => $tanggal,
                'tanggal1' => $tgl1,
                'tanggal2' => $tgl2,
                'dataRealisasi' => $data,
                'jumlahData' => $jumlahData,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataPilar' => $pilar,
                'total' => $dataTotal->total,
                'persen' => $persen,
            ]);
    }

    public function postRealisasiSubsidiaryRegion(Request $request)
    {
        $this->validate($request, [
            'provinsi' => 'required',
            'kabupaten' => 'required',
        ]);

        return redirect()->route('indexRealisasiSubsidiaryRegion', ['provinsi' => $request->provinsi, 'kabupaten' => encrypt($request->kabupaten), 'year' => encrypt($request->tahun)]);
    }

    public function indexRegion($provinsi, $kabupaten, $year)
    {
        try {
            $tahun = decrypt($year);
            $kabu = decrypt($kabupaten);
        } catch (Exception $e) {
            abort(404);
        }

        $company = session('user')->perusahaan;
        $status = "Region";
        $tanggal = date("Y-m-d");

        if ($kabu == 'Semua Kabupaten/Kota'){
            $data = ViewRealisasiAP::where('provinsi', $provinsi)->where('perusahaan', $company)->where('tahun', $tahun)->orderBy('tgl_realisasi', 'ASC')->get();
            $jumlahData = ViewRealisasiAP::where('provinsi', $provinsi)->where('perusahaan', $company)->where('tahun', $tahun)->count();

            $dataTotal = DB::table('v_realisasi_ap')
                ->select(DB::raw('SUM(nilai_bantuan) as total'))
                ->where('provinsi', $provinsi)
                ->where('perusahaan', $company)
                ->where('tahun', $tahun)
                ->first();
        }else{
            $data = ViewRealisasiAP::where('provinsi', $provinsi)->where('kabupaten', $kabu)->where('perusahaan', $company)->where('tahun', $tahun)->orderBy('tgl_realisasi', 'ASC')->get();
            $jumlahData = ViewRealisasiAP::where('provinsi', $provinsi)->where('kabupaten', $kabu)->where('perusahaan', $company)->where('tahun', $tahun)->count();

            $dataTotal = DB::table('v_realisasi_ap')
                ->select(DB::raw('SUM(nilai_bantuan) as total'))
                ->where('provinsi', $provinsi)
                ->where('kabupaten', $kabu)
                ->where('perusahaan', $company)
                ->where('tahun', $tahun)
                ->first();
        }

        $prov = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kab = DB::table('TBL_WILAYAH')->select('city_name')->groupBy('city_name')->get();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        if (!empty($anggaran)) {
            $persen = round($dataTotal->total / $anggaran->nominal * 100, 2);
        }else{
            $persen = 0;
        }

        return view('subsidiary.report.indexProposal')
            ->with([
                'comp' => $company,
                'tahun' => $tahun,
                'provinsi' => $provinsi,
                'kabupaten' => $kabu,
                'status' => $status,
                'tanggal' => $tanggal,
                'dataRealisasi' => $data,
                'jumlahData' => $jumlahData,
                'dataProvinsi' => $prov,
                'dataKabupaten' => $kab,
                'dataPilar' => $pilar,
                'total' => $dataTotal->total,
                'persen' => $persen,
            ]);
    }

    public function postRealisasiSubsidiarySDGs(Request $request)
    {
        $this->validate($request, [
            'pilar' => 'required',
            'gols' => 'required',
        ]);

        return redirect()->route('indexRealisasiSubsidiarySDGs', ['pilar' => $request->pilar, 'gols' => $request->gols, 'year' => encrypt($request->tahun)]);
    }

    public function indexSDGs($pilar, $gols, $year)
    {
        try {
            $tahun = decrypt($year);
        } catch (Exception $e) {
            abort(404);
        }

        $company = session('user')->perusahaan;
        $status = "SDGs";
        $tanggal = date("Y-m-d");

        if ($gols == 'All Goals'){
            $data = ViewRealisasiAP::where('pilar', $pilar)->where('perusahaan', $company)->where('tahun', $tahun)->orderBy('tgl_realisasi', 'ASC')->get();
            $jumlahData = ViewRealisasiAP::where('pilar', $pilar)->where('perusahaan', $company)->where('tahun', $tahun)->count();

            $dataTotal = DB::table('v_realisasi_ap')
                ->select(DB::raw('SUM(nilai_bantuan) as total'))
                ->where('pilar', $pilar)
                ->where('perusahaan', $company)
                ->where('tahun', $tahun)
                ->first();
        }else{
            $data = ViewRealisasiAP::where('pilar', $pilar)->where('gols', $gols)->where('perusahaan', $company)->where('tahun', $tahun)->orderBy('tgl_realisasi', 'ASC')->get();
            $jumlahData = ViewRealisasiAP::where('pilar', $pilar)->where('gols', $gols)->where('perusahaan', $company)->where('tahun', $tahun)->count();

            $dataTotal = DB::table('v_realisasi_ap')
                ->select(DB::raw('SUM(nilai_bantuan) as total'))
                ->where('pilar', $pilar)
                ->where('gols', $gols)
                ->where('perusahaan', $company)
                ->where('tahun', $tahun)
                ->first();
        }

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::table('TBL_WILAYAH')->select('city_name')->groupBy('city_name')->get();

        $plr = Pilar::orderBy('id_pilar', 'ASC')->get();

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        if (!empty($anggaran)) {
            $persen = round($dataTotal->total / $anggaran->nominal * 100, 2);
        }else{
            $persen = 0;
        }

        return view('subsidiary.report.indexProposal')
            ->with([
                'comp' => $company,
                'tahun' => $tahun,
                'pilar' => $pilar,
                'gols' => $gols,
                'status' => $status,
                'tanggal' => $tanggal,
                'dataRealisasi' => $data,
                'jumlahData' => $jumlahData,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataPilar' => $plr,
                'total' => $dataTotal->total,
                'persen' => $persen,
            ]);
    }

    public function postRealisasiSubsidiaryPriority(Request $request)
    {
        $this->validate($request, [
            'prioritas' => 'required',
        ]);

        return redirect()->route('indexRealisasiSubsidiaryPriority', ['prioritas' => $request->prioritas, 'year' => encrypt($request->tahun)]);
    }

    public function indexPriority($prioritas, $year)
    {
        try {
            $tahun = decrypt($year);
        } catch (Exception $e) {
            abort(404);
        }

        $company = session('user')->perusahaan;
        $status = "Priority";
        $tanggal = date("Y-m-d");

        $data = RealisasiAP::where('prioritas', $prioritas)->where('perusahaan', $company)->where('tahun', $tahun)->orderBy('tgl_realisasi', 'ASC')->get();
        $jumlahData = RealisasiAP::where('prioritas', $prioritas)->where('perusahaan', $company)->where('tahun', $tahun)->count();

        $dataTotal = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('SUM(nilai_bantuan) as total'))
            ->where('prioritas', $prioritas)
            ->where('perusahaan', $company)
            ->where('tahun', $tahun)
            ->first();

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::table('TBL_WILAYAH')->select('city_name')->groupBy('city_name')->get();

        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        if (!empty($anggaran)) {
            $persen = round($dataTotal->total / $anggaran->nominal * 100, 2);
        }else{
            $persen = 0;
        }

        return view('subsidiary.report.indexProposal')
            ->with([
                'comp' => $company,
                'tahun' => $tahun,
                'prioritas' => $prioritas,
                'status' => $status,
                'tanggal' => $tanggal,
                'dataRealisasi' => $data,
                'jumlahData' => $jumlahData,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataPilar' => $pilar,
                'total' => $dataTotal->total,
                'persen' => $persen,
            ]);
    }

    public function indexProkerID($prokerID)
    {
        try {
            $logID = decrypt($prokerID);
        } catch (Exception $e) {
            abort(404);
        }

        $proker = Proker::where('id_proker', $logID)->first();

        $company = $proker->perusahaan;
        $tahun = $proker->tahun;
        $status = "Proker";
        $tanggal = date("Y-m-d");

        $data = RealisasiAP::where('id_proker', $logID)->orderBy('tgl_realisasi', 'ASC')->get();
        $jumlahData = RealisasiAP::where('id_proker', $logID)->count();

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::table('TBL_WILAYAH')->select('city_name')->groupBy('city_name')->get();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        $dataTotal = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('SUM(nilai_bantuan) as total'))
            ->where('id_proker', $logID)
            ->first();

        if (!empty($anggaran)) {
            $persen = round($dataTotal->total / $anggaran->nominal * 100, 2);
        }else{
            $persen = 0;
        }

        return view('subsidiary.report.indexProposal')
            ->with([
                'comp' => $company,
                'tahun' => $tahun,
                'prokerID' => $logID,
                'status' => $status,
                'tanggal' => $tanggal,
                'dataRealisasi' => $data,
                'jumlahData' => $jumlahData,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataPilar' => $pilar,
                'total' => $dataTotal->total,
                'persen' => $persen,
            ]);
    }

    public function indexProker()
    {
        $tahun = date("Y");
        $company = session('user')->perusahaan;

        $proker = Proker::where('tahun', $tahun)->where('perusahaan', $company)->orderBy('id_proker', 'ASC')->get();
        $jumlahProker = Proker::where('tahun', $tahun)->where('perusahaan', $company)->count();

        $dataTotal = DB::table('v_realisasi_ap')
            ->select(DB::raw('SUM(nilai_bantuan) as total'))
            ->where('perusahaan', $company)
            ->where('tahun', $tahun)
            ->first();

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        if (!empty($anggaran)) {
            $budget = $anggaran->nominal;
            $persen = round($dataTotal->total / $anggaran->nominal * 100, 2);
        }else{
            $budget = 0;
            $persen = 0;
        }

        return view('subsidiary.report.indexRealisasiProker')
            ->with([
                'comp' => $company,
                'tahun' => $tahun,
                'realisasi' => $dataTotal->total,
                'anggaran' => $budget,
                'persen' => $persen,
                'dataProker' => $proker,
                'jumlahData' => $jumlahProker,
            ]);
    }

    public function postRealisasiProkerAnnualSubsidiary(Request $request)
    {
        $this->validate($request, [
            'tahun' => 'required',
        ]);

        return redirect()->route('indexRealisasiProkerAnnualSubsidiary', ['company' => $request->perusahaan, 'year' => encrypt($request->tahun)]);
    }

    public function indexProkerAnnual($company, $year)
    {
        try {
            $tahun = decrypt($year);
        } catch (Exception $e) {
            abort(404);
        }

        $proker = Proker::where('tahun', $tahun)->where('perusahaan', $company)->orderBy('id_proker', 'ASC')->get();
        $jumlahProker = Proker::where('tahun', $tahun)->where('perusahaan', $company)->count();

        $dataTotal = DB::table('v_realisasi_ap')
            ->select(DB::raw('SUM(nilai_bantuan) as total'))
            ->where('perusahaan', $company)
            ->where('tahun', $tahun)
            ->first();

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        if (!empty($anggaran)) {
            $budget = $anggaran->nominal;
            $persen = round($dataTotal->total / $anggaran->nominal * 100, 2);
        }else{
            $budget = 0;
            $persen = 0;
        }

        return view('subsidiary.report.indexRealisasiProker')
            ->with([
                'comp' => $company,
                'tahun' => $tahun,
                'realisasi' => $dataTotal->total,
                'anggaran' => $budget,
                'persen' => $persen,
                'dataProker' => $proker,
                'jumlahData' => $jumlahProker,
            ]);
    }

    public function printRealisasiProposal($year, $company)
    {
        $tahun = $year;

        $data = RealisasiAP::where('tahun', $tahun)->where('perusahaan', $company)->orderBy('tgl_realisasi', 'ASC')->get();

        $dataTotal = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('SUM(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->first();

        return view('subsidiary.print.print_raelisasi_proposal')
            ->with([
                'comp' => $company,
                'tahun' => $tahun,
                'dataRealisasi' => $data,
                'total' => $dataTotal->total,
            ]);
    }

    public function exportRealisasiProposal($year, $company)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("dmYHis");

        $namaFile = "RealisasiAnggaranCSR".$tanggalMenit.".xlsx";
        return Excel::download(new RealisasiProposalSubsidiaryExport($year, $company), $namaFile);
    }

    public function printRealisasiMonthlySubsidiary($bulan1, $bulan2, $year)
    {
        try {
            $tahun = decrypt($year);
        } catch (Exception $e) {
            abort(404);
        }

        $company = session('user')->perusahaan;
        $data = ViewRealisasiAP::whereBetween('bulan', [$bulan1, $bulan2])->where('tahun', $tahun)->where('perusahaan', $company)->orderBy('tgl_realisasi', 'ASC')->get();

        $dataTotal = DB::table('v_realisasi_ap')
            ->select(DB::raw('SUM(nilai_bantuan) as total'))
            ->whereBetween('bulan', [$bulan1, $bulan2])
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->first();

        return view('subsidiary.print.print_raelisasi_proposal')
            ->with([
                'comp' => $company,
                'tahun' => $tahun,
                'dataRealisasi' => $data,
                'total' => $dataTotal->total,
            ]);
    }

    public function exportRealisasiMonthlySubsidiary($bulan1, $bulan2, $year)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("dmYHis");

        $namaFile = "RealisasiAnggaranCSR".$tanggalMenit.".xlsx";
        return Excel::download(new RealisasiMonthlySubsidiaryExport($bulan1, $bulan2, $year), $namaFile);
    }

    public function printRealisasiPeriodeSubsidiary($tanggal1, $tanggal2, $year)
    {
        try {
            $tahun = decrypt($year);
        } catch (Exception $e) {
            abort(404);
        }

        $tgl1 = date("Y-m-d", strtotime($tanggal1));
        $tgl2 = date("Y-m-d", strtotime($tanggal2));

        $company = session('user')->perusahaan;
        $data = ViewRealisasiAP::whereBetween('tgl_realisasi', [$tgl1, $tgl2])->where('perusahaan', $company)->orderBy('tgl_realisasi', 'ASC')->get();

        $dataTotal = DB::table('v_realisasi_ap')
            ->select(DB::raw('SUM(nilai_bantuan) as total'))
            ->whereBetween('tgl_realisasi', [$tgl1, $tgl2])
            ->where('perusahaan', $company)
            ->first();

        return view('subsidiary.print.print_raelisasi_proposal')
            ->with([
                'comp' => $company,
                'tahun' => $tahun,
                'dataRealisasi' => $data,
                'total' => $dataTotal->total,
            ]);
    }

    public function exportRealisasiPeriodeSubsidiary($tanggal1, $tanggal2)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("dmYHis");

        $namaFile = "RealisasiAnggaranCSR".$tanggalMenit.".xlsx";
        return Excel::download(new RealisasiPeriodeSubsidiaryExport($tanggal1, $tanggal2), $namaFile);
    }

    public function printRealisasiRegionSubsidiary($provinsi, $kabupaten, $year)
    {
        try {
            $tahun = decrypt($year);
            $kabu = decrypt($kabupaten);
        } catch (Exception $e) {
            abort(404);
        }

        $company = session('user')->perusahaan;

        if ($kabu == 'Semua Kabupaten/Kota'){
            $data = ViewRealisasiAP::where('provinsi', $provinsi)->where('perusahaan', $company)->where('tahun', $tahun)->orderBy('tgl_realisasi', 'ASC')->get();
            $dataTotal = DB::table('v_realisasi_ap')
                ->select(DB::raw('SUM(nilai_bantuan) as total'))
                ->where('provinsi', $provinsi)
                ->where('perusahaan', $company)
                ->where('tahun', $tahun)
                ->first();
        }else{
            $data = ViewRealisasiAP::where('provinsi', $provinsi)->where('kabupaten', $kabu)->where('perusahaan', $company)->where('tahun', $tahun)->orderBy('tgl_realisasi', 'ASC')->get();
            $dataTotal = DB::table('v_realisasi_ap')
                ->select(DB::raw('SUM(nilai_bantuan) as total'))
                ->where('provinsi', $provinsi)
                ->where('kabupaten', $kabu)
                ->where('perusahaan', $company)
                ->where('tahun', $tahun)
                ->first();
        }

        return view('subsidiary.print.print_raelisasi_proposal')
            ->with([
                'comp' => $company,
                'tahun' => $tahun,
                'dataRealisasi' => $data,
                'total' => $dataTotal->total,
            ]);
    }

    public function exportRealisasiRegionSubsidiary($provinsi, $kabupaten, $year)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("dmYHis");

        $namaFile = "RealisasiAnggaranCSR".$tanggalMenit.".xlsx";
        return Excel::download(new RealisasiRegionSubsidiaryExport($provinsi, $kabupaten, $year), $namaFile);
    }

    public function printRealisasiSDGsSubsidiary($pilar, $gols, $year)
    {
        try {
            $tahun = decrypt($year);
        } catch (Exception $e) {
            abort(404);
        }

        $company = session('user')->perusahaan;

        if ($gols == 'All Goals'){
            $data = ViewRealisasiAP::where('pilar', $pilar)->where('perusahaan', $company)->where('tahun', $tahun)->orderBy('tgl_realisasi', 'ASC')->get();
            $dataTotal = DB::table('v_realisasi_ap')
                ->select(DB::raw('SUM(nilai_bantuan) as total'))
                ->where('pilar', $pilar)
                ->where('perusahaan', $company)
                ->where('tahun', $tahun)
                ->first();
        }else{
            $data = ViewRealisasiAP::where('pilar', $pilar)->where('gols', $gols)->where('perusahaan', $company)->where('tahun', $tahun)->orderBy('tgl_realisasi', 'ASC')->get();
            $dataTotal = DB::table('v_realisasi_ap')
                ->select(DB::raw('SUM(nilai_bantuan) as total'))
                ->where('pilar', $pilar)
                ->where('gols', $gols)
                ->where('perusahaan', $company)
                ->where('tahun', $tahun)
                ->first();
        }

        return view('subsidiary.print.print_raelisasi_proposal')
            ->with([
                'comp' => $company,
                'tahun' => $tahun,
                'dataRealisasi' => $data,
                'total' => $dataTotal->total,
            ]);
    }

    public function exportRealisasiSDGsSubsidiary($pilar, $gols, $year)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("dmYHis");

        $namaFile = "RealisasiAnggaranCSR".$tanggalMenit.".xlsx";
        return Excel::download(new RealisasiSDGsSubsidiaryExport($pilar, $gols, $year), $namaFile);
    }

    public function printRealisasiPrioritySubsidiary($prioritas, $year)
    {
        try {
            $tahun = decrypt($year);
        } catch (Exception $e) {
            abort(404);
        }

        $company = session('user')->perusahaan;
        $data = RealisasiAP::where('prioritas', $prioritas)->where('perusahaan', $company)->where('tahun', $tahun)->orderBy('tgl_realisasi', 'ASC')->get();

        $dataTotal = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('SUM(nilai_bantuan) as total'))
            ->where('prioritas', $prioritas)
            ->where('perusahaan', $company)
            ->where('tahun', $tahun)
            ->first();

        return view('subsidiary.print.print_raelisasi_proposal')
            ->with([
                'comp' => $company,
                'tahun' => $tahun,
                'dataRealisasi' => $data,
                'total' => $dataTotal->total,
            ]);
    }

    public function exportRealisasiPrioritySubsidiary($prioritas, $year)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("dmYHis");

        $namaFile = "RealisasiAnggaranCSR".$tanggalMenit.".xlsx";
        return Excel::download(new RealisasiPrioritySubsidiaryExport($prioritas, $year), $namaFile);
    }

    public function printRealisasiProkerSubsidiary($prokerID)
    {
        try {
            $logID = decrypt($prokerID);
        } catch (Exception $e) {
            abort(404);
        }

        $proker = Proker::where('id_proker', $logID)->first();

        $company = $proker->perusahaan;
        $tahun = $proker->tahun;

        $data = RealisasiAP::where('id_proker', $logID)->orderBy('tgl_realisasi', 'ASC')->get();

        $dataTotal = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('SUM(nilai_bantuan) as total'))
            ->where('id_proker', $logID)
            ->where('perusahaan', $company)
            ->where('tahun', $tahun)
            ->first();

        return view('subsidiary.print.print_raelisasi_proposal')
            ->with([
                'comp' => $company,
                'tahun' => $tahun,
                'dataRealisasi' => $data,
                'total' => $dataTotal->total,
            ]);
    }

    public function exportRealisasiProkerSubsidiary($prokerID)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("dmYHis");

        $namaFile = "RealisasiAnggaranCSR".$tanggalMenit.".xlsx";
        return Excel::download(new RealisasiProkerSubsidiaryExport($prokerID), $namaFile);
    }

    public function printRealisasiProkerAnnualSubsidiary($year)
    {
        try {
            $tahun = decrypt($year);
        } catch (Exception $e) {
            abort(404);
        }

        $company = session('user')->perusahaan;

        $proker = Proker::where('tahun', $tahun)->where('perusahaan', $company)->orderBy('id_proker', 'ASC')->get();

        $dataTotal = DB::table('v_realisasi_ap')
            ->select(DB::raw('SUM(nilai_bantuan) as total'))
            ->where('perusahaan', $company)
            ->where('tahun', $tahun)
            ->first();

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        return view('subsidiary.print.realisasi_proker_subsidiary')
            ->with([
                'comp' => $company,
                'tahun' => $tahun,
                'dataProker' => $proker,
                'anggaran' => $anggaran->nominal,
                'total' => $dataTotal->total,
            ]);
    }

    public function exportRealisasiProkerAnnualSubsidiary($year)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("dmYHis");

        $namaFile = "RealisasiAnggaranCSR".$tanggalMenit.".xlsx";
        return Excel::download(new RealisasiProkerAnnualSubsidiaryExport($year), $namaFile);
    }

}
