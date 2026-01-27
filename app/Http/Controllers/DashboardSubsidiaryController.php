<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\RealisasiAP;
use Illuminate\Http\Request;
use DB;
use Exception;

class DashboardSubsidiaryController extends Controller
{
    public function index(Request $request)
    {
        $company = session('user')->perusahaan;
        $perusahaanID = session('user')->id_perusahaan;
        $tahun = $request->input('tahun', date("Y"));

        $anggaran = Anggaran::where('id_perusahaan', $perusahaanID)
            ->where('tahun', $tahun)
            ->first();

        if (!empty($anggaran)) {
            $budget = $anggaran->nominal;
        } else {
            $budget = 0;
        }

        if (!empty($anggaran)) {

            $dataTotal = DB::table('tbl_realisasi_ap')
                ->select(DB::raw('SUM(nilai_bantuan) as total'))
                ->where('tahun', $tahun)
                ->where('id_perusahaan', $perusahaanID)
                ->first();

            $persen = round($dataTotal->total / $budget * 100, 2);
            $totalRealisasi = $dataTotal->total;

        } else {
            $persen = 0;
            $totalRealisasi = 0;
        }

        //PLANING PILAR
        $totalPilarLingkungan = DB::table('tbl_proker')
            ->select(DB::raw('pilar, sum(anggaran) as total'))
            ->where('tahun', $tahun)
            ->where('id_perusahaan', $perusahaanID)
            ->where('pilar', 'Lingkungan')
            ->groupBy('pilar')
            ->first();

        if (!empty($totalPilarLingkungan)) {
            $planPilarLingkungan = $totalPilarLingkungan->total;
            $persenPlanPilarLingkungan = round($planPilarLingkungan / $budget * 100, 2);
        } else {
            $planPilarLingkungan = 0;
            $persenPlanPilarLingkungan = 0;
        }

        $totalPilarEkonomi = DB::table('tbl_proker')
            ->select(DB::raw('pilar, sum(anggaran) as total'))
            ->where('tahun', $tahun)
            ->where('id_perusahaan', $perusahaanID)
            ->where('pilar', 'Ekonomi')
            ->groupBy('pilar')
            ->first();

        if (!empty($totalPilarEkonomi)) {
            $planPilarEkonomi = $totalPilarEkonomi->total;
            $persenPlanPilarEkonomi = round($planPilarEkonomi / $budget * 100, 2);
        } else {
            $planPilarEkonomi = 0;
            $persenPlanPilarEkonomi = 0;
        }

        $totalPilarSosial = DB::table('tbl_proker')
            ->select(DB::raw('pilar, sum(anggaran) as total'))
            ->where('tahun', $tahun)
            ->where('id_perusahaan', $perusahaanID)
            ->where('pilar', 'Sosial')
            ->groupBy('pilar')
            ->first();

        if (!empty($totalPilarSosial)) {
            $planPilarSosial = $totalPilarSosial->total;
            $persenPlanPilarSosial = round($planPilarSosial / $budget * 100, 2);
        } else {
            $planPilarSosial = 0;
            $persenPlanPilarSosial = 0;
        }

        //ACTUAL PILAR
        $totalActualPilarLingkungan = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('pilar, sum(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('id_perusahaan', $perusahaanID)
            ->where('pilar', 'Lingkungan')
            ->groupBy('pilar')
            ->first();

        if (!empty($totalActualPilarLingkungan)) {
            $actualPilarLingkungan = $totalActualPilarLingkungan->total;
            $persenActualPilarLingkungan = round($actualPilarLingkungan / $budget * 100, 2);

        } else {
            $actualPilarLingkungan = 0;
            $persenActualPilarLingkungan = 0;
        }

        $totalActualPilarEkonomi = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('pilar, sum(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('id_perusahaan', $perusahaanID)
            ->where('pilar', 'Ekonomi')
            ->groupBy('pilar')
            ->first();

        if (!empty($totalActualPilarEkonomi)) {
            $actualPilarEkonomi = $totalActualPilarEkonomi->total;
            $persenActualPilarEkonomi = round($actualPilarEkonomi / $budget * 100, 2);
        } else {
            $actualPilarEkonomi = 0;
            $persenActualPilarEkonomi = 0;
        }

        $totalActualPilarSosial = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('pilar, sum(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('id_perusahaan', $perusahaanID)
            ->where('pilar', 'Sosial')
            ->groupBy('pilar')
            ->first();

        if (!empty($totalActualPilarSosial)) {
            $actualPilarSosial = $totalActualPilarSosial->total;
            $persenActualPilarSosial = round($actualPilarSosial / $budget * 100, 2);
        } else {
            $actualPilarSosial = 0;
            $persenActualPilarSosial = 0;
        }

        //PLANING PRIORITAS
        $totalPrioritasPendidikan = DB::table('tbl_proker')
            ->select(DB::raw('prioritas, sum(anggaran) as total'))
            ->where('tahun', $tahun)
            ->where('id_perusahaan', $perusahaanID)
            ->where('prioritas', 'Pendidikan')
            ->groupBy('prioritas')
            ->first();

        if (!empty($totalPrioritasPendidikan)) {
            $planPrioritasPendidikan = $totalPrioritasPendidikan->total;
            $persenPlanPrioritasPendidikan = round($planPrioritasPendidikan / $budget * 100, 2);
        } else {
            $planPrioritasPendidikan = 0;
            $persenPlanPrioritasPendidikan = 0;
        }

        $totalPrioritasLingkungan = DB::table('tbl_proker')
            ->select(DB::raw('prioritas, sum(anggaran) as total'))
            ->where('tahun', $tahun)
            ->where('id_perusahaan', $perusahaanID)
            ->where('prioritas', 'Lingkungan')
            ->groupBy('prioritas')
            ->first();

        if (!empty($totalPrioritasLingkungan)) {
            $planPrioritasLingkungan = $totalPrioritasLingkungan->total;
            $persenPlanPrioritasLingkungan = round($planPrioritasLingkungan / $budget * 100, 2);
        } else {
            $planPrioritasLingkungan = 0;
            $persenPlanPrioritasLingkungan = 0;
        }

        $totalPrioritasUMK = DB::table('tbl_proker')
            ->select(DB::raw('prioritas, sum(anggaran) as total'))
            ->where('tahun', $tahun)
            ->where('id_perusahaan', $perusahaanID)
            ->where('prioritas', 'UMK')
            ->groupBy('prioritas')
            ->first();

        if (!empty($totalPrioritasUMK)) {
            $planPrioritasUMK = $totalPrioritasUMK->total;
            $persenPlanPrioritasUMK = round($planPrioritasUMK / $budget * 100, 2);
        } else {
            $planPrioritasUMK = 0;
            $persenPlanPrioritasUMK = 0;
        }

        $totalPrioritasSosialEkonomi = DB::table('tbl_proker')
            ->select(DB::raw('prioritas, sum(anggaran) as total'))
            ->where('tahun', $tahun)
            ->where('id_perusahaan', $perusahaanID)
            ->whereNull('prioritas')
            ->groupBy('prioritas')
            ->first();

        if (!empty($totalPrioritasSosialEkonomi)) {
            $planPrioritasSosialEkonomi = $totalPrioritasSosialEkonomi->total;
            $persenPlanPrioritasSosialEkonomi = round($planPrioritasSosialEkonomi / $budget * 100, 2);
        } else {
            $planPrioritasSosialEkonomi = 0;
            $persenPlanPrioritasSosialEkonomi = 0;
        }

        //ACTUAL PRIORITAS
        $totalActualPrioritasPendidikan = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('prioritas, sum(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('id_perusahaan', $perusahaanID)
            ->where('prioritas', 'Pendidikan')
            ->groupBy('prioritas')
            ->first();

        if (!empty($totalActualPrioritasPendidikan)) {
            $actualPrioritasPendidikan = $totalActualPrioritasPendidikan->total;
            $persenActualPrioritasPendidikan = round($actualPrioritasPendidikan / $budget * 100, 2);
        } else {
            $actualPrioritasPendidikan = 0;
            $persenActualPrioritasPendidikan = 0;
        }

        $totalActualPrioritasLingkungan = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('prioritas, sum(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('id_perusahaan', $perusahaanID)
            ->where('prioritas', 'Lingkungan')
            ->groupBy('prioritas')
            ->first();

        if (!empty($totalActualPrioritasLingkungan)) {
            $actualPrioritasLingkungan = $totalActualPrioritasLingkungan->total;
            $persenActualPrioritasLingkungan = round($actualPrioritasLingkungan / $budget * 100, 2);
        } else {
            $actualPrioritasLingkungan = 0;
            $persenActualPrioritasLingkungan = 0;
        }

        $totalActualPrioritasUMK = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('prioritas, sum(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('id_perusahaan', $perusahaanID)
            ->where('prioritas', 'UMK')
            ->groupBy('prioritas')
            ->first();

        if (!empty($totalActualPrioritasUMK)) {
            $actualPrioritasUMK = $totalActualPrioritasUMK->total;
            $persenActualPrioritasUMK = round($actualPrioritasUMK / $budget * 100, 2);
        } else {
            $actualPrioritasUMK = 0;
            $persenActualPrioritasUMK = 0;
        }

        $totalActualPrioritasSosialEkonomi = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('prioritas, sum(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('id_perusahaan', $perusahaanID)
            ->whereNull('prioritas')
            ->groupBy('prioritas')
            ->first();

        if (!empty($totalActualPrioritasSosialEkonomi)) {
            $actualPrioritasSosialEkonomi = $totalActualPrioritasSosialEkonomi->total;
            $persenActualPrioritasSosialEkonomi = round($actualPrioritasSosialEkonomi / $budget * 100, 2);
        } else {
            $actualPrioritasSosialEkonomi = 0;
            $persenActualPrioritasSosialEkonomi = 0;
        }

        $totalWilayah = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('provinsi, sum(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('id_perusahaan', $perusahaanID)
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
                                ID_PERUSAHAAN = $perusahaanID 
                                AND TAHUN = '$tahun'");

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

        return view('subsidiary.home.dashboard')
            ->with([
                'tahun' => $tahun,
                'comp' => $company,
                'anggaran' => $budget,
                'realisasi' => $totalRealisasi,
                'persen' => $persen,

                'totalPlanPilarLingkungan' => $planPilarLingkungan,
                'totalPlanPilarEkonomi' => $planPilarEkonomi,
                'totalPlanPilarSosial' => $planPilarSosial,
                'totalActualPilarLingkungan' => $actualPilarLingkungan,
                'totalActualPilarEkonomi' => $actualPilarEkonomi,
                'totalActualPilarSosial' => $actualPilarSosial,

                'planPilarLingkungan' => round($persenPlanPilarLingkungan, 2),
                'planPilarEkonomi' => round($persenPlanPilarEkonomi, 2),
                'planPilarSosial' => round($persenPlanPilarSosial, 2),
                'actualPilarLingkungan' => round($persenActualPilarLingkungan, 2),
                'actualPilarEkonomi' => round($persenActualPilarEkonomi, 2),
                'actualPilarSosial' => round($persenActualPilarSosial, 2),

                'totalPlanPrioritasPendidikan' => $planPrioritasPendidikan,
                'totalPlanPrioritasLingkungan' => $planPrioritasLingkungan,
                'totalPlanPrioritasUMK' => $planPrioritasUMK,
                'totalPlanPrioritasSosialEkonomi' => $planPrioritasSosialEkonomi,
                'totalActualPrioritasPendidikan' => $actualPrioritasPendidikan,
                'totalActualPrioritasLingkungan' => $actualPrioritasLingkungan,
                'totalActualPrioritasUMK' => $actualPrioritasUMK,
                'totalActualPrioritasSosialEkonomi' => $actualPrioritasSosialEkonomi,

                'planPrioritasPendidikan' => round($persenPlanPrioritasPendidikan, 2),
                'planPrioritasLingkungan' => round($persenPlanPrioritasLingkungan, 2),
                'planPrioritasUMK' => round($persenPlanPrioritasUMK, 2),
                'planPrioritasSosialEkonomi' => round($persenPlanPrioritasSosialEkonomi, 2),
                'actualPrioritasPendidikan' => round($persenActualPrioritasPendidikan, 2),
                'actualPrioritasLingkungan' => round($persenActualPrioritasLingkungan, 2),
                'actualPrioritasUMK' => round($persenActualPrioritasUMK, 2),
                'actualPrioritasSosialEkonomi' => round($persenActualPrioritasSosialEkonomi, 2),

                'bulanan' => $bulanan,
                'totalWilayah' => $totalWilayah,
                'dataRealisasiBulan' => $dataBulanan[0],
            ]);
    }

    public
    function postBudgetYear(Request $request)
    {
        $this->validate($request, [
            'tahun' => 'required',
        ]);

        return redirect()->route('dashboardSubsidiaryYear', ['year' => encrypt($request->tahun), 'company' => $request->perusahaan]);
    }

    public function indexYear($year, $company)
    {
        try {
            $tahun = decrypt($year);
        } catch (Exception $e) {
            abort(404);
        }

        $anggaran = Anggaran::where('perusahaan', $company)->where('tahun', $tahun)->first();

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

        //PLANING PILAR
        $totalPilarLingkungan = DB::table('tbl_proker')
            ->select(DB::raw('pilar, sum(anggaran) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->where('pilar', 'Lingkungan')
            ->groupBy('pilar')
            ->first();

        if (!empty($totalPilarLingkungan)) {
            $planPilarLingkungan = $totalPilarLingkungan->total;
        } else {
            $planPilarLingkungan = 0;
        }

        $totalPilarEkonomi = DB::table('tbl_proker')
            ->select(DB::raw('pilar, sum(anggaran) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->where('pilar', 'Ekonomi')
            ->groupBy('pilar')
            ->first();

        if (!empty($totalPilarEkonomi)) {
            $planPilarEkonomi = $totalPilarEkonomi->total;
        } else {
            $planPilarEkonomi = 0;
        }

        $totalPilarSosial = DB::table('tbl_proker')
            ->select(DB::raw('pilar, sum(anggaran) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->where('pilar', 'Sosial')
            ->groupBy('pilar')
            ->first();

        if (!empty($totalPilarSosial)) {
            $planPilarSosial = $totalPilarSosial->total;
        } else {
            $planPilarSosial = 0;
        }

        //ACTUAL PILAR
        $totalActualPilarLingkungan = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('pilar, sum(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->where('pilar', 'Lingkungan')
            ->groupBy('pilar')
            ->first();

        if (!empty($totalActualPilarLingkungan)) {
            $actualPilarLingkungan = $totalActualPilarLingkungan->total;
        } else {
            $actualPilarLingkungan = 0;
        }

        $totalActualPilarEkonomi = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('pilar, sum(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->where('pilar', 'Ekonomi')
            ->groupBy('pilar')
            ->first();

        if (!empty($totalActualPilarEkonomi)) {
            $actualPilarEkonomi = $totalActualPilarEkonomi->total;
        } else {
            $actualPilarEkonomi = 0;
        }

        $totalActualPilarSosial = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('pilar, sum(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->where('pilar', 'Sosial')
            ->groupBy('pilar')
            ->first();

        if (!empty($totalActualPilarSosial)) {
            $actualPilarSosial = $totalActualPilarSosial->total;
        } else {
            $actualPilarSosial = 0;
        }

        //PLANING PRIORITAS
        $totalPrioritasPendidikan = DB::table('tbl_proker')
            ->select(DB::raw('prioritas, sum(anggaran) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->where('prioritas', 'Pendidikan')
            ->groupBy('prioritas')
            ->first();

        if (!empty($totalPrioritasPendidikan)) {
            $planPrioritasPendidikan = $totalPrioritasPendidikan->total;
        } else {
            $planPrioritasPendidikan = 0;
        }

        $totalPrioritasLingkungan = DB::table('tbl_proker')
            ->select(DB::raw('prioritas, sum(anggaran) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->where('prioritas', 'Lingkungan')
            ->groupBy('prioritas')
            ->first();

        if (!empty($totalPrioritasLingkungan)) {
            $planPrioritasLingkungan = $totalPrioritasLingkungan->total;
        } else {
            $planPrioritasLingkungan = 0;
        }

        $totalPrioritasUMK = DB::table('tbl_proker')
            ->select(DB::raw('prioritas, sum(anggaran) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->where('prioritas', 'UMK')
            ->groupBy('prioritas')
            ->first();

        if (!empty($totalPrioritasUMK)) {
            $planPrioritasUMK = $totalPrioritasUMK->total;
        } else {
            $planPrioritasUMK = 0;
        }

        $totalPrioritasSosialEkonomi = DB::table('tbl_proker')
            ->select(DB::raw('prioritas, sum(anggaran) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->whereNull('prioritas')
            ->groupBy('prioritas')
            ->first();

        if (!empty($totalPrioritasSosialEkonomi)) {
            $planPrioritasSosialEkonomi = $totalPrioritasSosialEkonomi->total;
        } else {
            $planPrioritasSosialEkonomi = 0;
        }

        //ACTUAL PRIORITAS
        $totalActualPrioritasPendidikan = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('prioritas, sum(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->where('prioritas', 'Pendidikan')
            ->groupBy('prioritas')
            ->first();

        if (!empty($totalActualPrioritasPendidikan)) {
            $actualPrioritasPendidikan = $totalActualPrioritasPendidikan->total;
        } else {
            $actualPrioritasPendidikan = 0;
        }

        $totalActualPrioritasLingkungan = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('prioritas, sum(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->where('prioritas', 'Lingkungan')
            ->groupBy('prioritas')
            ->first();

        if (!empty($totalActualPrioritasLingkungan)) {
            $actualPrioritasLingkungan = $totalActualPrioritasLingkungan->total;
        } else {
            $actualPrioritasLingkungan = 0;
        }

        $totalActualPrioritasUMK = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('prioritas, sum(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->where('prioritas', 'UMK')
            ->groupBy('prioritas')
            ->first();

        if (!empty($totalActualPrioritasUMK)) {
            $actualPrioritasUMK = $totalActualPrioritasUMK->total;
        } else {
            $actualPrioritasUMK = 0;
        }

        $totalActualPrioritasSosialEkonomi = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('prioritas, sum(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->whereNull('prioritas')
            ->groupBy('prioritas')
            ->first();

        if (!empty($totalActualPrioritasSosialEkonomi)) {
            $actualPrioritasSosialEkonomi = $totalActualPrioritasSosialEkonomi->total;
        } else {
            $actualPrioritasSosialEkonomi = 0;
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
                                PERUSAHAAN = '$company' 
                                AND TAHUN = '$tahun'");

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

        return view('subsidiary.home.dashboard')
            ->with([
                'tahun' => $tahun,
                'comp' => $company,
                'anggaran' => $budget,
                'realisasi' => $totalRealisasi,
                'persen' => $persen,

                'totalPlanPilarLingkungan' => $planPilarLingkungan,
                'totalPlanPilarEkonomi' => $planPilarEkonomi,
                'totalPlanPilarSosial' => $planPilarSosial,
                'totalActualPilarLingkungan' => $actualPilarLingkungan,
                'totalActualPilarEkonomi' => $actualPilarEkonomi,
                'totalActualPilarSosial' => $actualPilarSosial,

                'planPilarLingkungan' => round($planPilarLingkungan / $budget * 100, 2),
                'planPilarEkonomi' => round($planPilarEkonomi / $budget * 100, 2),
                'planPilarSosial' => round($planPilarSosial / $budget * 100, 2),
                'actualPilarLingkungan' => round($actualPilarLingkungan / $budget * 100, 2),
                'actualPilarEkonomi' => round($actualPilarEkonomi / $budget * 100, 2),
                'actualPilarSosial' => round($actualPilarSosial / $budget * 100, 2),

                'totalPlanPrioritasPendidikan' => $planPrioritasPendidikan,
                'totalPlanPrioritasLingkungan' => $planPrioritasLingkungan,
                'totalPlanPrioritasUMK' => $planPrioritasUMK,
                'totalPlanPrioritasSosialEkonomi' => $planPrioritasSosialEkonomi,
                'totalActualPrioritasPendidikan' => $actualPrioritasPendidikan,
                'totalActualPrioritasLingkungan' => $actualPrioritasLingkungan,
                'totalActualPrioritasUMK' => $actualPrioritasUMK,
                'totalActualPrioritasSosialEkonomi' => $actualPrioritasSosialEkonomi,

                'planPrioritasPendidikan' => round($planPrioritasPendidikan / $budget * 100, 2),
                'planPrioritasLingkungan' => round($planPrioritasLingkungan / $budget * 100, 2),
                'planPrioritasUMK' => round($planPrioritasUMK / $budget * 100, 2),
                'planPrioritasSosialEkonomi' => round($planPrioritasSosialEkonomi / $budget * 100, 2),
                'actualPrioritasPendidikan' => round($actualPrioritasPendidikan / $budget * 100, 2),
                'actualPrioritasLingkungan' => round($actualPrioritasLingkungan / $budget * 100, 2),
                'actualPrioritasUMK' => round($actualPrioritasUMK / $budget * 100, 2),
                'actualPrioritasSosialEkonomi' => round($actualPrioritasSosialEkonomi / $budget * 100, 2),

                'bulanan' => $bulanan,
                'totalWilayah' => $totalWilayah,
                'dataRealisasiBulan' => $dataBulanan[0],
            ]);
    }
}
