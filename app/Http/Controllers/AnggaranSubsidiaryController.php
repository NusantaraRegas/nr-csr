<?php

namespace App\Http\Controllers;

use App\Exports\ProkerExport;
use App\Exports\ProkerSubsidiaryExport;
use App\Exports\RealisasiExport;
use App\Exports\RealisasiProker;
use App\Helper\APIHelper;
use App\Http\Requests\InsertAlokasi;
use App\Http\Requests\InsertRelokasi;
use App\Models\Alokasi;
use App\Models\Kelayakan;
use App\Models\Perusahaan;
use App\Models\Pilar;
use App\Models\Proker;
use App\Models\Provinsi;
use App\Models\Anggaran;
use App\Models\ViewAnggaran;
use App\Models\Relokasi;
use App\Models\SDG;
use App\Models\SektorBantuan;
use Illuminate\Http\Request;
use App\Http\Requests\InsertAnggaran;
use DB;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class AnggaranSubsidiaryController extends Controller
{
    public function index()
    {
        $perusahaanID = session('user')->id_perusahaan;

        $data = ViewAnggaran::where('id_perusahaan', $perusahaanID)
            ->orderByDesc('tahun')   // jika 'tahun' VARCHAR(4), urutannya masih aman
            ->get();

        $company = Perusahaan::findOrFail($perusahaanID);

        return view('subsidiary.transaksi.anggaran', [
            'dataAnggaran' => $data,
            'comp' => $company->nama_perusahaan,
        ]);
    }

    public function indexProker(Request $request)
    {
        $perusahaanID = session('user')->id_perusahaan;
        $company = session('user')->perusahaan;
        $tahun    = $request->input('tahun', date("Y"));

        $anggaran = Anggaran::where('tahun', $tahun)->where('id_perusahaan', $perusahaanID)->first();

        if (empty($anggaran->nominal)) {
            $nominal = 0;
        } else {
            $nominal = $anggaran->nominal;
        }

        $data = Proker::where('tahun', $tahun)->where('id_perusahaan', $perusahaanID)->orderBy('id_proker', 'ASC')->orderBy('tahun', 'ASC')->get();
        $jumlahData = Proker::where('tahun', $tahun)->where('id_perusahaan', $perusahaanID)->count();

        $totalAlokasi = DB::table('tbl_proker')
            ->select(DB::raw('SUM(anggaran) as total'))
            ->where('tahun', $tahun)
            ->where('id_perusahaan', $perusahaanID)
            ->first();

        $pilar = Pilar::orderBy('kode', 'ASC')->get();
        $gols = SDG::orderBy('id_sdg', 'ASC')->get();
        return view('subsidiary.transaksi.proker')
            ->with([
                'dataProker' => $data,
                'jumlahData' => $jumlahData,
                'dataPilar' => $pilar,
                'dataGols' => $gols,
                'tahun' => $tahun,
                'comp' => $company,
                'anggaran' => $nominal,
                'totalAlokasi' => $totalAlokasi->total,
            ]);
    }

    public function postProkerYear(Request $request)
    {
        $this->validate($request, [
            'tahun' => 'required',
        ]);

        return redirect()->route('indexProkerSubsidiaryYear', ['year' => $request->tahun]);
    }

    public function indexProkerYear($year)
    {
        $company = session('user')->perusahaan;
        $tahun = $year;

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        if (empty($anggaran->nominal)) {
            $nominal = 0;
        } else {
            $nominal = $anggaran->nominal;
        }

        $data = Proker::where('tahun', $tahun)->where('perusahaan', $company)->orderBy('id_proker', 'ASC')->orderBy('tahun', 'ASC')->get();
        $jumlahData = Proker::where('tahun', $tahun)->where('perusahaan', $company)->count();

        $totalAlokasi = DB::table('tbl_proker')
            ->select(DB::raw('SUM(anggaran) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->first();

        $pilar = Pilar::orderBy('kode', 'ASC')->get();
        $gols = SDG::orderBy('id_sdg', 'ASC')->get();
        return view('subsidiary.transaksi.proker')
            ->with([
                'dataProker' => $data,
                'jumlahData' => $jumlahData,
                'dataPilar' => $pilar,
                'dataGols' => $gols,
                'tahun' => $tahun,
                'comp' => $company,
                'anggaran' => $nominal,
                'totalAlokasi' => $totalAlokasi->total,
            ]);
    }

    public function storeProker(Request $request)
    {
        $this->validate($request, [
            'proker' => 'required',
            'pilar' => 'required',
            'gols' => 'required',
            'alokasi' => 'required',
            'tahun' => 'required',
        ]);

        $dataProker = [
            'proker' => $request->proker,
            'pilar' => $request->pilar,
            'gols' => $request->gols,
            'anggaran' => str_replace(".", "", $request->alokasi),
            'tahun' => $request->tahun,
            'prioritas' => $request->prioritas,
            'id_perusahaan' => session('user')->id_perusahaan,
        ];

        try {
            DB::table('tbl_proker')->insert($dataProker);
            return redirect()->back()->with('berhasil', "Program kerja berhasil disimpan");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Program kerja gagal disimpan');
        }
    }

    public function updateProker(Request $request)
    {
        try {
            $logID = decrypt($request->prokerID);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'proker' => 'required',
            'pilar' => 'required',
            'gols' => 'required',
            'alokasi' => 'required',
            'tahun' => 'required',
        ]);

        $dataUpdate = [
            'proker' => $request->proker,
            'pilar' => $request->pilar,
            'gols' => $request->gols,
            'anggaran' => str_replace(".", "", $request->alokasi),
            'tahun' => $request->tahun,
            'prioritas' => $request->prioritas,
        ];

        try {
            Proker::where('id_proker', $logID)->update($dataUpdate);
            return redirect()->back()->with('berhasil', "Program kerja berhasil diubah");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Program kerja gagal diubah');
        }
    }

    public function printProker($year, $company)
    {
        $tahun = $year;
        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        $data = Proker::where('tahun', $tahun)->where('perusahaan', $company)->orderBy('id_proker', 'ASC')->orderBy('tahun', 'ASC')->get();
        $jumlahData = Proker::where('tahun', $tahun)->where('perusahaan', $company)->count();

        $totalAlokasi = DB::table('tbl_proker')
            ->select(DB::raw('SUM(anggaran) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->first();
        return view('subsidiary.print.proker')
            ->with([
                'dataProker' => $data,
                'jumlahData' => $jumlahData,
                'tahun' => $tahun,
                'comp' => $company,
                'anggaran' => $anggaran->nominal,
                'totalAlokasi' => $totalAlokasi->total,
            ]);
    }

    public function exportProker($year, $company)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("dmYHis");

        $namaFile = $tanggalMenit . 'proker.xlsx';
        return Excel::download(new ProkerSubsidiaryExport($year, $company), $namaFile);
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

        $prokerNonRelokasi = DB::select("SELECT * FROM TBL_PROKER WHERE ID_PROKER NOT IN ($kalimat) AND TAHUN = '$tahun' AND PERUSAHAAN = '$company'");
        $jumlahProkerNonRelokasi = DB::select("SELECT count(*) as TOTAL FROM TBL_PROKER WHERE ID_PROKER NOT IN ($kalimat) AND TAHUN = '$tahun' AND PERUSAHAAN = '$company'");

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
                'jumlahProkerNonRelokasi' => $jumlahProkerNonRelokasi[0]->total,
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
        $tahun = $year;
        $company = session('user')->perusahaan;
        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
        );

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
        $prokerNonRelokasi = DB::select("SELECT * FROM TBL_PROKER WHERE ID_PROKER NOT IN ($kalimat) AND TAHUN = '$tahun' AND PERUSAHAAN = '$company'");

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

        return view('print.realisasi_proker')
            ->with([
                'tahun' => $tahun,
                'comp' => $company,
                'anggaran' => $anggaran->nominal,
                'realisasi' => $totalRealisasi,
                'progress' => $totalProgress,
                'dataProker' => $dataProker,
                'prokerNonRelokasi' => $prokerNonRelokasi,
            ]);
    }

    public function exportRealisasi($year)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("dmYHis");

        $namaFile = $tanggalMenit . '_realisasiProker.xlsx';
        return Excel::download(new RealisasiProker($year), $namaFile);
    }
}
