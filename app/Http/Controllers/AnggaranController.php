<?php

namespace App\Http\Controllers;

use App\Exports\RealisasiExport;
use App\Exports\RealisasiProker;
use App\Helper\APIHelper;
use App\Http\Requests\InsertAlokasi;
use App\Http\Requests\InsertRelokasi;
use App\Models\Alokasi;
use App\Models\Perusahaan;
use App\Models\Pilar;
use App\Models\Proker;
use App\Models\Provinsi;
use App\Models\Anggaran;
use App\Models\Relokasi;
use App\Models\SDG;
use App\Models\SektorBantuan;
use Illuminate\Http\Request;
use App\Http\Requests\InsertAnggaran;
use DB;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class AnggaranController extends Controller
{
    public function index(Request $request)
    {
        $perusahaanID = $request->input('perusahaan', session('user')->id_perusahaan);

        // Validate that perusahaanID exists
        if (!$perusahaanID) {
            return redirect()->route('dashboard')->with('gagal', 'ID Perusahaan tidak ditemukan. Silakan hubungi administrator.');
        }

        $data = Anggaran::when($perusahaanID, function ($q) use ($perusahaanID) {
                return $q->where('id_perusahaan', $perusahaanID);
            })
            ->orderByDesc('tahun')
            ->get();

        // Ambil data perusahaan yang dipilih dengan error handling
        $company = Perusahaan::find($perusahaanID);
        
        if (!$company) {
            return redirect()->route('dashboard')->with('gagal', 'Data perusahaan tidak ditemukan. Silakan hubungi administrator.');
        }

        $perusahaan = Perusahaan::orderBy('id_perusahaan')->get();

        return view('transaksi.anggaran')
            ->with([
                'dataAnggaran'   => $data,
                'perusahaan'     => $company,
                'dataPerusahaan' => $perusahaan,
            ]);
    }

    public function cariPerusahaan(Request $request)
    {
        $this->validate($request, [
            'perusahaan' => 'required',
            'tahun' => 'required',
        ]);

        return redirect()->route('indexCompany', ['year' => $request->tahun, 'company' => encrypt($request->perusahaan)]);
    }

    public function indexPerusahaan($year, $company)
    {

        try {
            $logID = decrypt($company);
        } catch (Exception $e) {
            abort(404);
        }

        $comp = $logID;

        if ($logID == "Semua Perusahaan") {
            if ($year == "Semua Tahun") {
                $data = Anggaran::orderBy('tahun')->get();
                $jumlahData = Anggaran::count();
            } else {
                $data = Anggaran::where('tahun', $year)->orderBy('tahun')->get();
                $jumlahData = Anggaran::where('tahun', $year)->count();
            }
        } elseif ($year == "Semua Tahun") {
            if ($logID == "Semua Perusahaan") {
                $data = Anggaran::orderBy('tahun')->get();
                $jumlahData = Anggaran::count();
            } else {
                $data = Anggaran::where('perusahaan', $logID)->orderBy('tahun')->get();
                $jumlahData = Anggaran::where('perusahaan', $logID)->count();
            }
        } else {
            $data = Anggaran::where('tahun', $year)->where('perusahaan', $comp)->orderBy('tahun')->get();
            $jumlahData = Anggaran::where('tahun', $year)->where('perusahaan', $comp)->count();
        }

        $perusahaan = Perusahaan::whereIn('kategori', ['Holding', 'Subholding'])->orderBy('id_perusahaan', 'ASC')->get();
        return view('transaksi.anggaran')
            ->with([
                'dataAnggaran' => $data,
                'jumlahData' => $jumlahData,
                'dataPerusahaan' => $perusahaan,
                'comp' => $comp,
                'tahun' => $year
            ]);
    }

    public function view($budegetID)
    {
        try {
            $logID = decrypt($budegetID);
        } catch (Exception $e) {
            abort(404);
        }

        $company = session('user')->perusahaan;
        $tahun = date("Y");

        $dataAnggaran = Anggaran::where('id_anggaran', $logID)->first();
        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $sektor = DB::table('TBL_SEKTOR')
            ->whereNotIn('SEKTOR_BANTUAN', function ($query) use ($logID) {
                $query->select('SEKTOR_BANTUAN')
                    ->from('TBL_RELOKASI')
                    ->where('ID_ANGGARAN', $logID);
            })
            ->get();
        $jumlahRelokasi = DB::table('TBL_RELOKASI')
            ->select(DB::raw('count(*) as jumlah'))
            ->where('id_anggaran', $logID)
            ->first();
        $relokasi = Relokasi::where('id_anggaran', $logID)->get();
        $alokasi = DB::table('TBL_RELOKASI')
            ->select(DB::raw('sum(NOMINAL_RELOKASI) as jumlah'))
            ->where('id_anggaran', $logID)
            ->first();

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
        );

        //+++++++++TOTAL REALISASI BULAN+++++++++//
        $releaseRealisasiBulan = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiBulan', $param, '');
        $returnRealisasiBulan = json_decode(strstr($releaseRealisasiBulan, '{'), true);
        $dataRealisasiBulan = $returnRealisasiBulan['data'][0];
        //++++++++++++++++++++++++++++++++++++++++++//

        return view('transaksi.detail_anggaran')
            ->with([
                'tahun' => $tahun,
                'comp' => $company,
                'data' => $dataAnggaran,
                'dataProvinsi' => $provinsi,
                'dataSektor' => $sektor,
                'jumlahRelokasi' => $jumlahRelokasi->jumlah,
                'dataRelokasi' => $relokasi,
                'dataAlokasi' => $alokasi->jumlah,
                'dataRealisasiBulan' => $dataRealisasiBulan,
            ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun'   => 'required',
            'nominalAsli' => 'required|numeric',
        ], [
            'tahun.required'   => 'Tahun anggaran harus dipilih',
            'nominalAsli.required' => 'Nominal anggaran harus diisi',
            'nominalAsli.numeric'  => 'Nominal harus berupa angka',
        ]);

        $perusahaanID = session('user')->id_perusahaan;

        // Cek duplikat (prevent 2x anggaran untuk tahun yang sama)
        $exists = DB::table('tbl_anggaran')
            ->where('id_perusahaan', $perusahaanID)
            ->where('tahun', $request->tahun)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('gagalDetail', "Anggaran untuk tahun {$request->tahun} sudah ada.");
        }

        try {
            DB::table('tbl_anggaran')->insert([
                'nominal'       => $request->nominalAsli,
                'tahun'         => $request->tahun,
                'id_perusahaan' => $perusahaanID,
            ]);

            return redirect()->back()->with('berhasil', "Anggaran tahun {$request->tahun} berhasil disimpan");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', "Gagal menyimpan anggaran: " . $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $anggaranID = decrypt($request->anggaranID);
        } catch (Exception $e) {
            abort(404);
        }

        $request->validate([
            'tahun'   => 'required|integer',
            'nominalAsli' => 'required|numeric',
        ], [
            'tahun.required'   => 'Tahun anggaran harus dipilih',
            'nominalAsli.required' => 'Nominal anggaran harus diisi',
            'nominalAsli.numeric'  => 'Nominal harus berupa angka',
        ]);

        $dataAnggaran = [
            'nominal' => $request->nominalAsli,
            'tahun' => $request->tahun,
        ];

        try {
            Anggaran::where('id_anggaran', $anggaranID)->update($dataAnggaran);
            return redirect()->back()->with('berhasil', "Anggaran tahun $request->tahun berhasil diubah");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', "Anggaran tahun $request->tahun gagal diubah");
        }
    }

    public function delete($id)
    {
        try {
            $anggaranID = decrypt($id);
        } catch (Exception $e) {
            abort(404);
        }

        $anggaran = Anggaran::findOrFail($anggaranID);

        if (!$anggaran) {
            return redirect()->back()->with('gagalDetail', 'Data anggaran tidak ditemukan.');
        }

        Anggaran::where('id_anggaran', $anggaranID)->delete();
        return redirect()->back()->with('berhasil', "Anggaran tahun $anggaran->tahun berhasil dihapus");
    }

    public function insertRelokasi(InsertRelokasi $request)
    {
        try {
            $logID = decrypt($request->idanggaran);
        } catch (Exception $e) {
            abort(404);
        }

        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date("d-M-Y");

        $dataRelokasi = [
            'id_anggaran' => $logID,
            'sektor_bantuan' => $request->sektor,
            'nominal_relokasi' => $request->nominal,
            'relokasi_by' => session('user')->username,
            'relokasi_date' => $tanggal,
            'updated_date' => $tanggal,
            'updated_by' => session('user')->username,
            'tahun' => $request->tahun,
        ];

        try {
            Relokasi::create($dataRelokasi);
            return redirect()->back()->with('sukses', "Alokasi anggaran berhasil disimpan");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Alokasi anggaran gagal disimpan');
        }
    }

    public function insertAlokasi(InsertAlokasi $request)
    {
        try {
            $logID = decrypt($request->idrelokasi);
            $sektor = decrypt($request->sektor);
        } catch (Exception $e) {
            abort(404);
        }

        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date("d-M-Y");

        $dataUpdate = [
            'updated_date' => $tanggal,
            'updated_by' => session('user')->username,
        ];

        $dataAlokasi = [
            'id_relokasi' => $logID,
            'proker' => $request->proker,
            'provinsi' => $request->provinsi,
            'tahun' => $request->tahun,
            'nominal_alokasi' => $request->nominal,
            'sektor_bantuan' => $sektor,
        ];

        try {
            Relokasi::where('id_relokasi', $logID)->update($dataUpdate);
            Alokasi::create($dataAlokasi);
            return redirect()->back()->with('sukses', "Alokasi anggaran berhasil disimpan");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Alokasi anggaran gagal disimpan');
        }
    }

    public function deleteAlokasi($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }

        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date("d-M-Y");

        $alokasi = Alokasi::where('id_alokasi', $logID)->first();
        $dataUpdate = [
            'updated_date' => $tanggal,
            'updated_by' => session('user')->username,
        ];

        Relokasi::where('id_relokasi', $alokasi->id_relokasi)->update($dataUpdate);
        Alokasi::where('id_alokasi', $logID)->delete();
        return redirect()->back()->with('sukses', "Data proker berhasil dihapus");
    }

    public function editAlokasi(InsertAlokasi $request)
    {
        try {
            $logID = decrypt($request->idalokasi);
        } catch (Exception $e) {
            abort(404);
        }

        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date("d-M-Y");

        $alokasi = Alokasi::where('id_alokasi', $logID)->first();
        $dataUpdateRe = [
            'updated_date' => $tanggal,
            'updated_by' => session('user')->username,
        ];

        $dataUpdate = [
            'provinsi' => $request->provinsi,
            'nominal_alokasi' => $request->nominal,
        ];

        try {
            Relokasi::where('id_relokasi', $alokasi->id_relokasi)->update($dataUpdateRe);
            Alokasi::where('id_alokasi', $logID)->update($dataUpdate);
            return redirect()->back()->with('sukses', "Data proker berhasil diubah");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Data proker gagal diubah');
        }
    }

    public function editNominal(Request $request)
    {
        try {
            $logID = decrypt($request->idrelokasi);
        } catch (Exception $e) {
            abort(404);
        }

        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date("d-M-Y");

        $dataUpdate = [
            'nominal_relokasi' => $request->nominal,
            'updated_date' => $tanggal,
            'updated_by' => session('user')->username,
        ];

        try {
            Relokasi::where('id_relokasi', $logID)->update($dataUpdate);
            return redirect()->back()->with('sukses', "Nominal alokasi berhasil diubah");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Nominal alokasi gagal diubah');
        }
    }

    public function monitoring()
    {
        $tahun = date("Y");
        $company = session('user')->perusahaan;
        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();
        $jumlahProker = Proker::where('tahun', $tahun)->where('perusahaan', $company)->count();

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
        );

        if ($tahun > '2022'){
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

            //+++++++++TOTAL REALISASI ALL+++++++++//
            $releaseProker = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/summaryRealisasiProkerPopayV4', $param, '');
            $returnProker = json_decode(strstr($releaseProker, '{'), true);
            $dataProker = $returnProker['data'];
            //++++++++++++++++++++++++++++++++++++++++++//
        }else{
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

            //+++++++++TOTAL REALISASI ALL+++++++++//
            $releaseProker = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/summaryRealisasiProker', $param, '');
            $returnProker = json_decode(strstr($releaseProker, '{'), true);
            $dataProker = $returnProker['data'];
            //++++++++++++++++++++++++++++++++++++++++++//
        }

        $excludedProkerIds = $this->extractProkerIds((array) $dataProker);
        [$prokerNonRelokasi, $jumlahProkerNonRelokasi] = $this->fetchNonRelokasiProker($tahun, $company, $excludedProkerIds);

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

        if ($tahun > '2022'){

            //+++++++++TOTAL REALISASI BULAN+++++++++//
            $releaseRealisasiBulan = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiBulanPopayV4', $param, '');
            $returnRealisasiBulan = json_decode(strstr($releaseRealisasiBulan, '{'), true);
            $dataRealisasiBulan = $returnRealisasiBulan['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL PILAR+++++++++//
            $releasePilar = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPilarPopayV4', $param, '');
            $returnPilar = json_decode(strstr($releasePilar, '{'), true);
            $dataPilar = $returnPilar['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL TPB+++++++++//
            $releaseTPB = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getTPBPopayV4', $param, '');
            $returnTPB = json_decode(strstr($releaseTPB, '{'), true);
            $dataTPB = $returnTPB['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++PERSENTASE PRIORITAS+++++++++//
            $releasePrioritas = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPrioritasPopayV4', $param, '');
            $returnPrioritas = json_decode(strstr($releasePrioritas, '{'), true);
            $dataPrioritas = $returnPrioritas['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++PERSENTASE TOTAL PRIORITAS+++++++++//
            $releaseTotalPrioritas = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getTotalPrioritasPopayV4', $param, '');
            $returnTotalPrioritas = json_decode(strstr($releaseTotalPrioritas, '{'), true);
            $dataTotalPrioritas = $returnTotalPrioritas['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//
        }else{

            //+++++++++TOTAL REALISASI BULAN+++++++++//
            $releaseRealisasiBulan = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiBulan', $param, '');
            $returnRealisasiBulan = json_decode(strstr($releaseRealisasiBulan, '{'), true);
            $dataRealisasiBulan = $returnRealisasiBulan['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL PILAR+++++++++//
            $releasePilar = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPilar', $param, '');
            $returnPilar = json_decode(strstr($releasePilar, '{'), true);
            $dataPilar = $returnPilar['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL TPB+++++++++//
            $releaseTPB = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getTPB', $param, '');
            $returnTPB = json_decode(strstr($releaseTPB, '{'), true);
            $dataTPB = $returnTPB['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++PERSENTASE PRIORITAS+++++++++//
            $releasePrioritas = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPrioritas', $param, '');
            $returnPrioritas = json_decode(strstr($releasePrioritas, '{'), true);
            $dataPrioritas = $returnPrioritas['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++PERSENTASE TOTAL PRIORITAS+++++++++//
            $releaseTotalPrioritas = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getTotalPrioritas', $param, '');
            $returnTotalPrioritas = json_decode(strstr($releaseTotalPrioritas, '{'), true);
            $dataTotalPrioritas = $returnTotalPrioritas['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//
        }

        if ($dataTotalPrioritas['total'] == '') {
            $totalPrioritas = 0;
        } else {
            $totalPrioritas = $dataTotalPrioritas['total'];
        }

        if ($dataTotalPrioritas['total'] == '') {
            $persenPrioritas = 0;
        } else {
            $persenPrioritas = round($dataTotalPrioritas['total'] / $anggaran->nominal * 100, 2);
        }

        $dataNamaPrioritas = [];
        foreach ($dataPrioritas as $dp) {
            $dataNamaPrioritas[] = $dp['prioritas'];
        }

        $dataPersenPrioritas = [];
        foreach ($dataPrioritas as $dp) {
            $dataPersenPrioritas[] = round($dp['total'] / $anggaran->nominal * 100, 2);
        }

        $dataNamaPilar = [];
        foreach ($dataPilar as $p) {
            $dataNamaPilar[] = $p['pilar'];
        }

        $dataTotalPilar = [];
        foreach ($dataPilar as $d) {
            $dataTotalPilar[] = round($d['total']);
        }

        return view('transaksi.detail_anggaran')
            ->with([
                'tahun' => $tahun,
                'comp' => $company,
                'jumlahProker' => $jumlahProker,
                'anggaran' => $anggaran->nominal,
                'realisasi' => $totalRealisasi,
                'progress' => $totalProgress,
                'dataProker' => $dataProker,
                'dataRealisasiBulan' => $dataRealisasiBulan,
                'jumlahProkerNonRelokasi' => $jumlahProkerNonRelokasi,
                'prokerNonRelokasi' => $prokerNonRelokasi,
                'dataPrioritas' => $dataPrioritas,
                'dataNamaPrioritas' => $dataNamaPrioritas,
                'dataPersenPrioritas' => $dataPersenPrioritas,
                'totalPrioritas' => $totalPrioritas,
                'persenPrioritas' => $persenPrioritas,
                'dataNamaPilar' => $dataNamaPilar,
                'dataTotalPilar' => $dataTotalPilar,
                'dataTPB' => $dataTPB,
            ]);
    }

    public function postMonitoringAnnual(Request $request)
    {
        $this->validate($request, [
            'tahun' => 'required',
        ]);

        return redirect()->route('monitoringBudgetAnnual', ['year' => encrypt($request->tahun)]);
    }

    public function monitoringAnnual($year)
    {
        try {
            $tahun = decrypt($year);
        } catch (Exception $e) {
            abort(404);
        }

        $company = session('user')->perusahaan;
        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();
        $jumlahProker = Proker::where('tahun', $tahun)->where('perusahaan', $company)->count();

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
        );

        if ($tahun > '2022'){
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

            //+++++++++TOTAL REALISASI ALL+++++++++//
            $releaseProker = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/summaryRealisasiProkerPopayV4', $param, '');
            $returnProker = json_decode(strstr($releaseProker, '{'), true);
            $dataProker = $returnProker['data'];
            //++++++++++++++++++++++++++++++++++++++++++//
        }else{
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

            //+++++++++TOTAL REALISASI ALL+++++++++//
            $releaseProker = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/summaryRealisasiProker', $param, '');
            $returnProker = json_decode(strstr($releaseProker, '{'), true);
            $dataProker = $returnProker['data'];
            //++++++++++++++++++++++++++++++++++++++++++//
        }

        $excludedProkerIds = $this->extractProkerIds((array) $dataProker);
        [$prokerNonRelokasi, $jumlahProkerNonRelokasi] = $this->fetchNonRelokasiProker($tahun, $company, $excludedProkerIds);

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

        if ($tahun > '2022'){

            //+++++++++TOTAL REALISASI BULAN+++++++++//
            $releaseRealisasiBulan = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiBulanPopayV4', $param, '');
            $returnRealisasiBulan = json_decode(strstr($releaseRealisasiBulan, '{'), true);
            $dataRealisasiBulan = $returnRealisasiBulan['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL PILAR+++++++++//
            $releasePilar = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPilarPopayV4', $param, '');
            $returnPilar = json_decode(strstr($releasePilar, '{'), true);
            $dataPilar = $returnPilar['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL TPB+++++++++//
            $releaseTPB = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getTPBPopayV4', $param, '');
            $returnTPB = json_decode(strstr($releaseTPB, '{'), true);
            $dataTPB = $returnTPB['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++PERSENTASE PRIORITAS+++++++++//
            $releasePrioritas = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPrioritasPopayV4', $param, '');
            $returnPrioritas = json_decode(strstr($releasePrioritas, '{'), true);
            $dataPrioritas = $returnPrioritas['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++PERSENTASE TOTAL PRIORITAS+++++++++//
            $releaseTotalPrioritas = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getTotalPrioritasPopayV4', $param, '');
            $returnTotalPrioritas = json_decode(strstr($releaseTotalPrioritas, '{'), true);
            $dataTotalPrioritas = $returnTotalPrioritas['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//
        }else{

            //+++++++++TOTAL REALISASI BULAN+++++++++//
            $releaseRealisasiBulan = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiBulan', $param, '');
            $returnRealisasiBulan = json_decode(strstr($releaseRealisasiBulan, '{'), true);
            $dataRealisasiBulan = $returnRealisasiBulan['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL PILAR+++++++++//
            $releasePilar = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPilar', $param, '');
            $returnPilar = json_decode(strstr($releasePilar, '{'), true);
            $dataPilar = $returnPilar['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL TPB+++++++++//
            $releaseTPB = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getTPB', $param, '');
            $returnTPB = json_decode(strstr($releaseTPB, '{'), true);
            $dataTPB = $returnTPB['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++PERSENTASE PRIORITAS+++++++++//
            $releasePrioritas = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPrioritas', $param, '');
            $returnPrioritas = json_decode(strstr($releasePrioritas, '{'), true);
            $dataPrioritas = $returnPrioritas['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++PERSENTASE TOTAL PRIORITAS+++++++++//
            $releaseTotalPrioritas = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getTotalPrioritas', $param, '');
            $returnTotalPrioritas = json_decode(strstr($releaseTotalPrioritas, '{'), true);
            $dataTotalPrioritas = $returnTotalPrioritas['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//
        }

        if ($dataTotalPrioritas['total'] == '') {
            $totalPrioritas = 0;
        } else {
            $totalPrioritas = $dataTotalPrioritas['total'];
        }

        if ($dataTotalPrioritas['total'] == '') {
            $persenPrioritas = 0;
        } else {
            $persenPrioritas = round($dataTotalPrioritas['total'] / $anggaran->nominal * 100, 2);
        }

        $dataNamaPrioritas = [];
        foreach ($dataPrioritas as $dp) {
            $dataNamaPrioritas[] = $dp['prioritas'];
        }

        $dataPersenPrioritas = [];
        foreach ($dataPrioritas as $dp) {
            $dataPersenPrioritas[] = round($dp['total'] / $anggaran->nominal * 100, 2);
        }

        $dataNamaPilar = [];
        foreach ($dataPilar as $p) {
            $dataNamaPilar[] = $p['pilar'];
        }

        $dataTotalPilar = [];
        foreach ($dataPilar as $d) {
            $dataTotalPilar[] = round($d['total']);
        }

        return view('transaksi.detail_anggaran')
            ->with([
                'tahun' => $tahun,
                'comp' => $company,
                'jumlahProker' => $jumlahProker,
                'anggaran' => $anggaran->nominal,
                'realisasi' => $totalRealisasi,
                'progress' => $totalProgress,
                'dataProker' => $dataProker,
                'dataRealisasiBulan' => $dataRealisasiBulan,
                'jumlahProkerNonRelokasi' => $jumlahProkerNonRelokasi,
                'prokerNonRelokasi' => $prokerNonRelokasi,
                'dataPrioritas' => $dataPrioritas,
                'dataNamaPrioritas' => $dataNamaPrioritas,
                'dataPersenPrioritas' => $dataPersenPrioritas,
                'totalPrioritas' => $totalPrioritas,
                'persenPrioritas' => $persenPrioritas,
                'dataNamaPilar' => $dataNamaPilar,
                'dataTotalPilar' => $dataTotalPilar,
                'dataTPB' => $dataTPB,
            ]);
    }

    public function postMonitoringMonthly(Request $request)
    {
        $this->validate($request, [
            'tanggal1' => 'required',
            'tanggal2' => 'required',
        ]);

        return redirect()->route('monitoringBudgetMonthly', ['tanggal1' => encrypt($request->tanggal1), 'tanggal2' => encrypt($request->tanggal2)]);
    }


    public function monitoringMonthly($tanggal1, $tanggal2)
    {
        try {
            $tgl1 = decrypt($tanggal1);
            $tgl2 = decrypt($tanggal2);
            $tahun = date("Y", strtotime($tgl1));;
        } catch (Exception $e) {
            abort(404);
        }

        $company = session('user')->perusahaan;
        $totalAnggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();
        $jumlahProker = Proker::where('tahun', $tahun)->where('perusahaan', $company)->count();

        if (!empty($totalAnggaran)) {
            $anggaran = $totalAnggaran->nominal;
        } else {
            $anggaran = 0;
        }

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
        );

        $paramMonthly = array(
            "user_id" => "1211",
            "date1" => $tgl1,
            "date2" => $tgl2,
            "budget_year" => $tahun,
        );

        if ($tahun > '2022'){
            //+++++++++TOTAL REALISASI PROGRESS+++++++++//
            $releaseProgress = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiProgressPopayV4Month', $paramMonthly, '');
            $returnProgress = json_decode(strstr($releaseProgress, '{'), true);
            $dataProgress = $returnProgress['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI PAID+++++++++//
            $releasePAID = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiPAIDPopayV4Month', $paramMonthly, '');
            $returnPAID = json_decode(strstr($releasePAID, '{'), true);
            $dataPAID = $returnPAID['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI ALL+++++++++//
            $releaseProker = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/summaryRealisasiProkerPopayV4Month', $paramMonthly, '');
            $returnProker = json_decode(strstr($releaseProker, '{'), true);
            $dataProker = $returnProker['data'];
            //++++++++++++++++++++++++++++++++++++++++++//
        }else{
            //+++++++++TOTAL REALISASI PROGRESS+++++++++//
            $releaseProgress = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiProgressMonth', $paramMonthly, '');
            $returnProgress = json_decode(strstr($releaseProgress, '{'), true);
            $dataProgress = $returnProgress['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI PAID+++++++++//
            $releasePAID = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiPAIDMonth', $paramMonthly, '');
            $returnPAID = json_decode(strstr($releasePAID, '{'), true);
            $dataPAID = $returnPAID['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL REALISASI ALL+++++++++//
            $releaseProker = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/summaryRealisasiProkerMonth', $paramMonthly, '');
            $returnProker = json_decode(strstr($releaseProker, '{'), true);
            $dataProker = $returnProker['data'];
            //++++++++++++++++++++++++++++++++++++++++++//
        }

        $excludedProkerIds = $this->extractProkerIds((array) $dataProker);
        [$prokerNonRelokasi, $jumlahProkerNonRelokasi] = $this->fetchNonRelokasiProker($tahun, $company, $excludedProkerIds);

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

        if ($tahun > '2022'){

            //+++++++++TOTAL REALISASI BULAN+++++++++//
            $releaseRealisasiBulan = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiBulanPopayV4', $paramMonthly, '');
            $returnRealisasiBulan = json_decode(strstr($releaseRealisasiBulan, '{'), true);
            $dataRealisasiBulan = $returnRealisasiBulan['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL PILAR+++++++++//
            $releasePilar = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPilarPopayV4Month', $paramMonthly, '');
            $returnPilar = json_decode(strstr($releasePilar, '{'), true);
            $dataPilar = $returnPilar['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL TPB+++++++++//
            $releaseTPB = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getTPBPopayV4', $paramMonthly, '');
            $returnTPB = json_decode(strstr($releaseTPB, '{'), true);
            $dataTPB = $returnTPB['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++PERSENTASE PRIORITAS+++++++++//
            $releasePrioritas = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPrioritasPopayV4Month', $paramMonthly, '');
            $returnPrioritas = json_decode(strstr($releasePrioritas, '{'), true);
            $dataPrioritas = $returnPrioritas['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++PERSENTASE TOTAL PRIORITAS+++++++++//
            $releaseTotalPrioritas = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getTotalPrioritasPopayV4Month', $paramMonthly, '');
            $returnTotalPrioritas = json_decode(strstr($releaseTotalPrioritas, '{'), true);
            $dataTotalPrioritas = $returnTotalPrioritas['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//
        }else{
            //+++++++++TOTAL REALISASI BULAN+++++++++//
            $releaseRealisasiBulan = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getRealisasiBulan', $param, '');
            $returnRealisasiBulan = json_decode(strstr($releaseRealisasiBulan, '{'), true);
            $dataRealisasiBulan = $returnRealisasiBulan['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL PILAR+++++++++//
            $releasePilar = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPilarMonth', $paramMonthly, '');
            $returnPilar = json_decode(strstr($releasePilar, '{'), true);
            $dataPilar = $returnPilar['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++TOTAL TPB+++++++++//
            $releaseTPB = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getTPBMonth', $paramMonthly, '');
            $returnTPB = json_decode(strstr($releaseTPB, '{'), true);
            $dataTPB = $returnTPB['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++PERSENTASE PRIORITAS+++++++++//
            $releasePrioritas = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getPrioritasMonth', $paramMonthly, '');
            $returnPrioritas = json_decode(strstr($releasePrioritas, '{'), true);
            $dataPrioritas = $returnPrioritas['data'];
            //++++++++++++++++++++++++++++++++++++++++++//

            //+++++++++PERSENTASE TOTAL PRIORITAS+++++++++//
            $releaseTotalPrioritas = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/getTotalPrioritas', $paramMonthly, '');
            $returnTotalPrioritas = json_decode(strstr($releaseTotalPrioritas, '{'), true);
            $dataTotalPrioritas = $returnTotalPrioritas['data'][0];
            //++++++++++++++++++++++++++++++++++++++++++//
        }

        if ($dataTotalPrioritas['total'] == '') {
            $totalPrioritas = 0;
        } else {
            $totalPrioritas = $dataTotalPrioritas['total'];
        }

        if ($dataTotalPrioritas['total'] == '') {
            $persenPrioritas = 0;
        } else {
            $persenPrioritas = round($dataTotalPrioritas['total'] / $anggaran * 100, 2);
        }

        $dataNamaPrioritas = [];
        foreach ($dataPrioritas as $dp) {
            $dataNamaPrioritas[] = $dp['prioritas'];
        }

        $dataPersenPrioritas = [];
        foreach ($dataPrioritas as $dp) {
            $dataPersenPrioritas[] = round($dp['total'] / $anggaran * 100, 2);
        }

        $dataNamaPilar = [];
        foreach ($dataPilar as $p) {
            $dataNamaPilar[] = $p['pilar'];
        }

        $dataTotalPilar = [];
        foreach ($dataPilar as $d) {
            $dataTotalPilar[] = round($d['total']);
        }

        return view('transaksi.detail_anggaran')
            ->with([
                'tahun' => $tahun,
                'comp' => $company,
                'jumlahProker' => $jumlahProker,
                'anggaran' => $anggaran,
                'realisasi' => $totalRealisasi,
                'progress' => $totalProgress,
                'dataProker' => $dataProker,
                'dataRealisasiBulan' => $dataRealisasiBulan,
                'jumlahProkerNonRelokasi' => $jumlahProkerNonRelokasi,
                'prokerNonRelokasi' => $prokerNonRelokasi,
                'dataPrioritas' => $dataPrioritas,
                'dataNamaPrioritas' => $dataNamaPrioritas,
                'dataPersenPrioritas' => $dataPersenPrioritas,
                'totalPrioritas' => $totalPrioritas,
                'persenPrioritas' => $persenPrioritas,
                'dataNamaPilar' => $dataNamaPilar,
                'dataTotalPilar' => $dataTotalPilar,
                'dataTPB' => $dataTPB,
            ]);
    }

    public function printRealisasi($year)
    {

        try {
            $tahun = decrypt($year);
        } catch (Exception $e) {
            abort(404);
        }

        $company = session('user')->perusahaan;
        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
        );

        if ($tahun > '2022'){
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

            $excludedProkerIds = $this->extractProkerIds((array) $dataProker);
            [$prokerNonRelokasi, $jumlahProkerNonRelokasi] = $this->fetchNonRelokasiProker($tahun, $company, $excludedProkerIds);

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
        }else{
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

            $excludedProkerIds = $this->extractProkerIds((array) $dataProker);
            [$prokerNonRelokasi, $jumlahProkerNonRelokasi] = $this->fetchNonRelokasiProker($tahun, $company, $excludedProkerIds);

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

        return view('print.realisasi_proker')
            ->with([
                'tahun' => $tahun,
                'comp' => $company,
                'anggaran' => $anggaran->nominal,
                'realisasi' => $totalRealisasi,
                'progress' => $totalProgress,
                'totalRealisasi' => $totalProgress + $totalRealisasi,
                'dataProker' => $dataProker,
                'jumlahProkerNonRelokasi' => $jumlahProkerNonRelokasi,
                'prokerNonRelokasi' => $prokerNonRelokasi,
            ]);
    }

    private function extractProkerIds(array $dataProker)
    {
        $ids = [];
        foreach ($dataProker as $row) {
            if (isset($row['proker_id']) && is_numeric($row['proker_id'])) {
                $ids[] = (int) $row['proker_id'];
            }
        }

        $ids = array_values(array_unique($ids));

        return empty($ids) ? [0] : $ids;
    }

    private function fetchNonRelokasiProker($tahun, $company, array $excludedProkerIds)
    {
        $baseQuery = DB::table('TBL_PROKER')
            ->where('TAHUN', $tahun)
            ->where('PERUSAHAAN', $company)
            ->whereNotIn('ID_PROKER', $excludedProkerIds);

        $prokerNonRelokasi = $baseQuery->get();
        $jumlahProkerNonRelokasi = (clone $baseQuery)->count();

        return [$prokerNonRelokasi, $jumlahProkerNonRelokasi];
    }

    public function exportRealisasi($year)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("dmYHis");

        $namaFile = $tanggalMenit . '_realisasiProker.xlsx';
        return Excel::download(new RealisasiProker($year), $namaFile);
    }
}
