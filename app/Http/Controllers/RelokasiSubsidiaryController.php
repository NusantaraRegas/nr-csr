<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\Perusahaan;
use App\Models\Proker;
use App\Models\Relokasi;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Exception;

class RelokasiSubsidiaryController extends Controller
{
    public function index()
    {
        $company = session('user')->perusahaan;
        $tahun = date("Y");
        $perusahaan = Perusahaan::orderBy('id_perusahaan', 'ASC')->get();

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        if (empty($anggaran->nominal)) {
            $nominal = 0;
        }else{
            $nominal = $anggaran->nominal;
        }

        $relokasi = Relokasi::where('tahun', $tahun)->where('perusahaan', $company)->orderBy('id_relokasi', 'ASC')->get();
        $jumlahRelokasi = Relokasi::where('tahun', $tahun)->where('perusahaan', $company)->count();

        return view('subsidiary.transaksi.indexRelokasi')
            ->with([
                'dataRelokasi' => $relokasi,
                'jumlahRelokasi' => $jumlahRelokasi,
                'dataPerusahaan' => $perusahaan,
                'tahun' => $tahun,
                'comp' => $company,
                'anggaran' => $nominal,
            ]);
    }

    public function create()
    {
        $company = session('user')->perusahaan;
        $tahun = date("Y");

        $proker = Proker::where('tahun', $tahun)->where('perusahaan', $company)->orderBy('id_proker', 'ASC')->get();
        $jumlahProker = Proker::where('tahun', $tahun)->where('perusahaan', $company)->count();

        return view('subsidiary.transaksi.createRelokasi')
            ->with([
                'dataProker' => $proker,
                'jumlahData' => $jumlahProker,
                'tahun' => $tahun,
                'comp' => $company,
            ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'prokerAsal' => 'required',
            'prokerTujuan' => 'required',
            'nominalAsal' => 'required',
            'nominalTujuan' => 'required',
            'nominalRelokasi' => 'required',
        ]);

        $tahun = date("Y");
        $tanggal = date("Y-m-d H:i:s");

        $approver = User::where('role', 'Manager')->first();
        $prokerAsal = Proker::where('id_proker', $request->prokerIDAsal)->first();
        $prokerTujuan = Proker::where('id_proker', $request->prokerIDTujuan)->first();
        $nominalRelokasi = "Rp$request->nominalRelokasi";

        $totalAsal = $prokerAsal->anggaran - str_replace(".", "", $request->nominalRelokasi);
        $totalTujuan = $prokerTujuan->anggaran + str_replace(".", "", $request->nominalRelokasi);

        $data = [
            'proker_asal' => $request->prokerIDAsal,
            'nominal_asal' => str_replace(".", "", $request->nominalAsal),
            'proker_tujuan' => $request->prokerIDTujuan,
            'nominal_tujuan' => str_replace(".", "", $request->nominalTujuan),
            'nominal_relokasi' => str_replace(".", "", $request->nominalRelokasi),
            'request_by' => session('user')->username,
            'request_date' => $tanggal,
            'status' => 'Draft',
            'approver' => $approver->username,
            'tahun' => $tahun,
            'perusahaan' => session('user')->perusahaan,
            'status_date' => $tanggal,
        ];

        $dataLog = [
            'id_proker' => $request->prokerIDAsal,
            'keterangan' => "Relokasi untuk program kerja $prokerTujuan->proker sebesar $nominalRelokasi",
            'status' => 'Draft',
            'status_date' => $tanggal,
        ];

        $dataAsal = [
            'anggaran' => $totalAsal
        ];

        $dataTujuan = [
            'anggaran' => $totalTujuan
        ];

        try {
            DB::table('tbl_relokasi')->insert($data);
            DB::table('tbl_log_relokasi')->insert($dataLog);

            Proker::where('id_proker', $request->prokerIDAsal)->update($dataAsal);
            Proker::where('id_proker', $request->prokerIDTujuan)->update($dataTujuan);

            return redirect()->route('indexRelokasiSubsidiary')->with('berhasil', "Relokasi anggaran berhasil disimpan");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Relokasi anggaran gagal disimpan');
        }
    }

}
