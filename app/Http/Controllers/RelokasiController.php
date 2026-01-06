<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\LogRelokasi;
use App\Models\Perusahaan;
use App\Models\Pilar;
use App\Models\Proker;
use App\Models\Relokasi;
use App\Models\SDG;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Exception;

class RelokasiController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua perusahaan untuk dropdown
        $dataPerusahaan = Perusahaan::orderBy('id_perusahaan', 'ASC')->get();

        // Ambil filter dari request (tanpa fallback ke session untuk fleksibilitas)
        $perusahaanID = $request->input('perusahaan', session('user')->id_perusahaan);
        $tahun = $request->input('tahun', date("Y")); // Default ke tahun ini

        $dataAnggaran = collect(); // untuk isi dropdown tahun
        $company = null;
        $anggaran = null;
        $nominal = 0;

        // Ambil relokasi
        $relokasiQuery = Relokasi::query()->orderBy('id_relokasi', 'ASC');

        if ($perusahaanID) {
            $relokasiQuery->where('id_perusahaan', $perusahaanID);

            // Ambil perusahaan yang dipilih
            $company = Perusahaan::find($perusahaanID);

            // Ambil data anggaran untuk perusahaan tsb
            $dataAnggaran = Anggaran::where('id_perusahaan', $perusahaanID)
                ->orderByDesc('tahun')
                ->get();

            // Ambil anggaran berdasarkan tahun
            $anggaran = Anggaran::where('id_perusahaan', $perusahaanID)
                ->where('tahun', $tahun)
                ->first();

            $nominal = $anggaran->nominal ?? 0;
        }

        // Filter tahun jika dipilih
        if ($tahun) {
            $relokasiQuery->where('tahun', $tahun);
        }

        $relokasi = $relokasiQuery->get();

        return view('master.relokasi')->with([
            'dataRelokasi' => $relokasi,
            'dataPerusahaan' => $dataPerusahaan,
            'tahun' => $tahun,
            'perusahaan' => $company,
            'dataAnggaran' => $dataAnggaran,
            'anggaran' => $nominal,
        ]);
    }

    public function create()
    {
        $company = session('user')->perusahaan;
        $tahun = date("Y");

        $proker = Proker::where('tahun', $tahun)->where('perusahaan', $company)->orderBy('id_proker', 'ASC')->get();
        $jumlahProker = Proker::where('tahun', $tahun)->where('perusahaan', $company)->count();

        return view('master.input_relokasi')
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

            return redirect()->route('indexRelokasi')->with('berhasil', "Relokasi anggaran berhasil disimpan");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Relokasi anggaran gagal disimpan');
        }
    }

    public function delete($relokasiID)
    {
        try {
            $logID = decrypt($relokasiID);
        } catch (Exception $e) {
            abort(404);
        }

        Relokasi::where('id_relokasi', $logID)->delete();
        //LogRelokasi::where('id_relokasi', $logID)->delete();
        return redirect()->back()->with('berhasil', "Relokasi berhasil dihapus");
    }
}
