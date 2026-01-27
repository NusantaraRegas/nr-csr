<?php

namespace App\Http\Controllers;

use App\Exports\RealisasiMonthly;
use App\Exports\RealisasiProposalSubsidiaryExport;
use App\Models\Anggaran;
use App\Models\Kelayakan;
use App\Models\Lampiran;
use App\Models\LampiranAP;
use App\Models\Lembaga;
use App\Models\Pengirim;
use App\Models\Pilar;
use App\Models\Proker;
use App\Models\Provinsi;
use App\Models\RealisasiAP;
use App\Models\SektorBantuan;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Mail;
use Exception;

class RealisasiSubsidiaryController extends Controller
{
    public function indexProposalProvinsi($year, $provinsi)
    {
        $company = session('user')->perusahaan;
        $tahun = $year;
        $status = $provinsi;
        $tanggal = date("Y-m-d");
        $bulan = "";

        $data = RealisasiAP::where('tahun', $tahun)->where('perusahaan', $company)->where('provinsi', $provinsi)->orderBy('tgl_realisasi', 'DESC')->get();
        $jumlahData = RealisasiAP::where('tahun', $tahun)->where('perusahaan', $company)->where('provinsi', $provinsi)->count();
        $prov = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::table('TBL_WILAYAH')->select('city_name')->groupBy('city_name')->get();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        $dataTotal = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('SUM(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->where('provinsi', $provinsi)
            ->where('jenis', 'Proposal')
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
                'bulan' => $bulan,
                'dataRealisasi' => $data,
                'jumlahData' => $jumlahData,
                'dataProvinsi' => $prov,
                'dataKabupaten' => $kabupaten,
                'dataPilar' => $pilar,
                'total' => $dataTotal->total,
                'persen' => $persen,
            ]);
    }

    public function indexProposalKabupaten($year, $provinsi, $kabupaten)
    {
        $company = session('user')->perusahaan;
        $tahun = $year;
        $status = "Kabupaten";
        $tanggal = date("Y-m-d");
        $bulan = "";

        $data = RealisasiAP::where('tahun', $tahun)->where('perusahaan', $company)->where('provinsi', $provinsi)->where('kabupaten', $kabupaten)->orderBy('tgl_realisasi', 'DESC')->get();
        $jumlahData = RealisasiAP::where('tahun', $tahun)->where('perusahaan', $company)->where('provinsi', $provinsi)->where('kabupaten', $kabupaten)->count();
        $prov = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kab = DB::table('TBL_WILAYAH')->select('city_name')->groupBy('city_name')->get();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        $dataTotal = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('SUM(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->where('provinsi', $provinsi)
            ->where('kabupaten', $kabupaten)
            ->where('jenis', 'Proposal')
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
                'bulan' => $bulan,
                'dataRealisasi' => $data,
                'jumlahData' => $jumlahData,
                'dataProvinsi' => $prov,
                'dataKabupaten' => $kab,
                'dataPilar' => $pilar,
                'total' => $dataTotal->total,
                'persen' => $persen,
            ]);
    }

    public function createProposal()
    {
        $company = session('user')->perusahaan;
        $tahun = date("Y");

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::table('TBL_WILAYAH')->select('city_name')->groupBy('city_name')->get();
        $lembaga = Lembaga::where('perusahaan', $company)->orderBy('nama_lembaga', 'ASC')->get();
        $pengirim = Pengirim::where('perusahaan', $company)->orderBy('pengirim', 'ASC')->get();
        $proker = Proker::where('tahun', $tahun)->where('perusahaan', $company)->orderBy('id_proker', 'ASC')->get();

        $user = User::where([
            ['username', '!=', session('user')->username],
            ['status', '=', 'Active'],
        ])->orderBy('nama', 'ASC')->get();
        return view('subsidiary.realisasi.proposal')
            ->with([
                'comp' => $company,
                'tahun' => $tahun,
                'dataLembaga' => $lembaga,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataPengirim' => $pengirim,
                'dataProker' => $proker,
                'dataUser' => $user,
            ]);
    }

    public function indexNonProposal()
    {
        $company = session('user')->perusahaan;
        $tahun = date("Y");
        $status = "All Data";
        $tanggal = date("Y-m-d");
        $bulan = "";

        $data = RealisasiAP::where('tahun', $tahun)->where('perusahaan', $company)->where('jenis', 'Non Proposal')->orderBy('tgl_realisasi', 'DESC')->get();
        $jumlahData = RealisasiAP::where('tahun', $tahun)->where('perusahaan', $company)->count();
        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::table('TBL_WILAYAH')->select('city_name')->groupBy('city_name')->get();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        $dataTotal = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('SUM(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->where('jenis', 'Non Proposal')
            ->first();

        if (!empty($anggaran)) {
            $persen = round($dataTotal->total / $anggaran->nominal * 100, 2);
        }else{
            $persen = 0;
        }
        return view('subsidiary.report.indexNonProposal')
            ->with([
                'comp' => $company,
                'tahun' => $tahun,
                'status' => $status,
                'tanggal' => $tanggal,
                'bulan' => $bulan,
                'dataRealisasi' => $data,
                'jumlahData' => $jumlahData,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataPilar' => $pilar,
                'total' => $dataTotal->total,
                'persen' => $persen,
            ]);
    }

    public function createNonProposal()
    {
        $perusahaanID = session('user')->id_perusahaan;
        $company = session('user')->perusahaan;
        $tahun = date("Y");

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::table('TBL_WILAYAH')->select('city_name')->groupBy('city_name')->get();
        $lembaga = Lembaga::where('perusahaan', $company)->orderBy('nama_lembaga', 'ASC')->get();
        $pengirim = Pengirim::where('perusahaan', $company)->orderBy('pengirim', 'ASC')->get();
        $proker = Proker::where('id_perusahaan', $perusahaanID)->orderBy('tahun', 'DESC')->orderBy('id_proker', 'ASC')->get();

        $user = User::where([
            ['username', '!=', session('user')->username],
            ['status', '=', 'Active'],
        ])->orderBy('nama', 'ASC')->get();
        return view('subsidiary.realisasi.non_proposal')
            ->with([
                'comp' => $company,
                'tahun' => $tahun,
                'dataLembaga' => $lembaga,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataPengirim' => $pengirim,
                'dataProker' => $proker,
                'dataUser' => $user,
            ]);
    }

    public function storeProposal(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("Y-m-d H:i:s");
        $company = session('user')->perusahaan;
        $tahun = date("Y");

        $this->validate($request, [
            'noProposal' => 'required',
            'tglProposal' => 'required',
            'pengirim' => 'required',
            //'lampiran' => 'required|nullable|max:100000',
            'perihal' => 'required',
            'tglRealisasi' => 'required',
            'prokerID' => 'required',
            'proker' => 'required',
            'pilar' => 'required',
            'gols' => 'required',
            'nilaiBantuan' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'deskripsi' => 'required',
//            'namaYayasan' => 'required',
//            'alamat' => 'required',
//            'pic' => 'required',
//            'jabatan' => 'required',
//            'noTelp' => 'required',
        ]);

        $data = [
            'no_proposal' => strtoupper($request->noProposal),
            'tgl_proposal' => date("Y-m-d", strtotime($request->tglProposal)),
            'pengirim' => $request->pengirim,
            'tgl_realisasi' => date('Y-m-d', strtotime($request->tglRealisasi)),
            'perihal' => ucwords($request->perihal),
            'id_proker' => $request->prokerID,
            'proker' => $request->proker,
            'pilar' => $request->pilar,
            'gols' => $request->gols,
            'nilai_bantuan' => str_replace(".", "", $request->nilaiBantuan),
            'status' => "In Progress",
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'deskripsi' => ucwords($request->deskripsi),
            'nama_yayasan' => $request->namaYayasan,
            'alamat' => $request->alamat,
            'pic' => $request->pic,
            'jabatan' => $request->jabatan,
            'no_telp' => $request->noTelp,
            'created_by' => session('user')->username,
            'created_date' => $tanggalMenit,
            'jenis' => $request->jenis,
            'perusahaan' => $company,
            'tahun' => $tahun,
            'status_date' => $tanggalMenit,
        ];

        try {
            DB::table('tbl_realisasi_ap')->insert($data);

            $lastID = DB::table('tbl_realisasi_ap')->latest('created_date')->first();

            if ($request->hasFile('lampiran')) {
                $image = $request->file('lampiran');
                $name = str_replace(' ', '-', $image->getClientOriginalName());
                $type = $image->getClientOriginalExtension();
                $featured_new_name = time() . $name ."." . $type;
                $image->move('attachment', $featured_new_name);

                $dataLampiran = [
                    'ID_REALISASI' => $lastID->id_realisasi,
                    'NAMA' => 'Proposal',
                    'LAMPIRAN' => $featured_new_name,
                    'UPLOAD_BY' => session('user')->username,
                    'UPLOAD_DATE' => $tanggalMenit,
                ];
                DB::table('tbl_lampiran_ap')->insert($dataLampiran);
            }

            return redirect()->route('indexRealisasiSubsidiary')->with('berhasil', 'Realisasi anggaran berhasil disimpan');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Realisasi anggaran gagal disimpan');
        }
    }

    public function storeNonProposal(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $tanggalMenit = date("Y-m-d H:i:s");
        $company = session('user')->perusahaan;
        $tahun = date("Y");

        $this->validate($request, [
            'tglRealisasi' => 'required',
            'prokerID' => 'required',
            'proker' => 'required',
            'pilar' => 'required',
            'gols' => 'required',
            'nilaiBantuan' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'deskripsi' => 'required',
        ]);

        $anggaranTersedia = str_replace(".", "", $request->anggaranTersedia);
        $nominalRealisasi = str_replace(".", "", $request->nilaiBantuan);

        if ($anggaranTersedia < $nominalRealisasi) {
            return redirect()->back()->with('peringatan', "Anggaran tidak tersedia!!! silahkan untuk merelokasi anggaran");
        }

        $data = [
            'tgl_realisasi' => date('Y-m-d', strtotime($request->tglRealisasi)),
            'id_proker' => $request->prokerID,
            'proker' => $request->proker,
            'pilar' => $request->pilar,
            'gols' => $request->gols,
            'prioritas' => $request->prioritas,
            'nilai_bantuan' => str_replace(".", "", $request->nilaiBantuan),
            'status' => "In Progress",
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
            'deskripsi' => ucwords($request->deskripsi),
            'nama_yayasan' => $request->namaYayasan,
            'alamat' => $request->alamat,
            'pic' => $request->pic,
            'jabatan' => $request->jabatan,
            'no_telp' => $request->noTelp,
            'created_by' => session('user')->username,
            'created_date' => $tanggalMenit,
            'jenis' => $request->jenis,
            'id_perusahaan' => session('user')->id_perusahaan,
            'tahun' => $tahun,
            'status_date' => $tanggalMenit,
        ];

        try {
            DB::table('tbl_realisasi_ap')->insert($data);

            $lastID = DB::table('tbl_realisasi_ap')->latest('created_date')->first();

            if ($request->hasFile('lampiran')) {
                $image = $request->file('lampiran');
                $name = str_replace(' ', '-', $image->getClientOriginalName());
                $type = $image->getClientOriginalExtension();
                $featured_new_name = time() . $name ."." . $type;
                $image->move('attachment', $featured_new_name);

                $dataLampiran = [
                    'ID_REALISASI' => $lastID->id_realisasi,
                    'NAMA' => 'Dokumentasi',
                    'LAMPIRAN' => $featured_new_name,
                    'UPLOAD_BY' => session('user')->username,
                    'UPLOAD_DATE' => $tanggalMenit,
                ];
                DB::table('tbl_lampiran_ap')->insert($dataLampiran);
            }

            return redirect()->route('indexRealisasiSubsidiary')->with('berhasil', 'Realisasi anggaran berhasil disimpan');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Realisasi anggaran gagal disimpan');
        }
    }

    public function editProposal($realisasiID)
    {

        try {
            $logID = decrypt($realisasiID);
        } catch (Exception $e) {
            abort(404);
        }

        $company = session('user')->perusahaan;
        $tahun = date("Y");

        $data = RealisasiAP::where('id_realisasi', $logID)->first();
        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::table('TBL_WILAYAH')->select('city_name')->groupBy('city_name')->get();
        $lembaga = Lembaga::where('perusahaan', $company)->orderBy('nama_lembaga', 'ASC')->get();
        $pengirim = Pengirim::where('perusahaan', $company)->orderBy('pengirim', 'ASC')->get();
        $proker = Proker::where('tahun', $tahun)->where('perusahaan', $company)->orderBy('id_proker', 'ASC')->get();

        $prokerRealisasi = Proker::where('id_proker', $data->id_proker)->first();

        $dataRealisasi = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('sum(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->where('id_proker', $data->id_proker)
            ->first();

        if (!empty($dataRealisasi)) {
            $totalRealisasi = $dataRealisasi->total;
        }else{
            $totalRealisasi = 0;
        }

        $totalAnggaran = $prokerRealisasi->anggaran;

        $terpakai = $totalAnggaran - $totalRealisasi;

        return view('subsidiary.realisasi.edit_proposal')
            ->with([
                'comp' => $company,
                'tahun' => $tahun,
                'data' => $data,
                'dataLembaga' => $lembaga,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataPengirim' => $pengirim,
                'dataProker' => $proker,
                'terpakai' => $terpakai,
            ]);
    }

    public function editNonProposal($realisasiID)
    {

        try {
            $logID = decrypt($realisasiID);
        } catch (Exception $e) {
            abort(404);
        }

        $company = session('user')->perusahaan;
        $tahun = date("Y");

        $data = RealisasiAP::where('id_realisasi', $logID)->first();
        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::table('TBL_WILAYAH')->select('city_name')->groupBy('city_name')->get();
        $lembaga = Lembaga::where('perusahaan', $company)->orderBy('nama_lembaga', 'ASC')->get();
        $pengirim = Pengirim::where('perusahaan', $company)->orderBy('pengirim', 'ASC')->get();
        $proker = Proker::where('tahun', $tahun)->where('perusahaan', $company)->orderBy('id_proker', 'ASC')->get();

        $prokerRealisasi = Proker::where('id_proker', $data->id_proker)->first();

        $dataRealisasi = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('sum(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->where('id_proker', $data->id_proker)
            ->first();

        if (!empty($dataRealisasi)) {
            $totalRealisasi = $dataRealisasi->total;
        }else{
            $totalRealisasi = 0;
        }

        $totalAnggaran = $prokerRealisasi->anggaran;

        $terpakai = $totalAnggaran - $totalRealisasi;

        return view('subsidiary.realisasi.edit_non_proposal')
            ->with([
                'comp' => $company,
                'tahun' => $tahun,
                'data' => $data,
                'dataLembaga' => $lembaga,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataPengirim' => $pengirim,
                'dataProker' => $proker,
                'terpakai' => $terpakai,
            ]);
    }

    public function updateProposal(Request $request)
    {
        try {
            $logID = decrypt($request->realisasiID);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'noProposal' => 'required',
            'tglProposal' => 'required',
            'pengirim' => 'required',
            'perihal' => 'required',
            'tglRealisasi' => 'required',
            'prokerID' => 'required',
            'proker' => 'required',
            'pilar' => 'required',
            'gols' => 'required',
            'nilaiBantuan' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'deskripsi' => 'required',
//            'namaYayasan' => 'required',
//            'alamat' => 'required',
//            'pic' => 'required',
//            'jabatan' => 'required',
//            'noTelp' => 'required',
        ]);

        $data = [
            'no_proposal' => strtoupper($request->noProposal),
            'tgl_proposal' => date("Y-m-d", strtotime($request->tglProposal)),
            'pengirim' => $request->pengirim,
            'perihal' => ucwords($request->perihal),
            'tgl_realisasi' => date('Y-m-d', strtotime($request->tglRealisasi)),
            'id_proker' => $request->prokerID,
            'proker' => $request->proker,
            'pilar' => $request->pilar,
            'gols' => $request->gols,
            'prioritas' => $request->prioritas,
            'nilai_bantuan' => str_replace(".", "", $request->nilaiBantuan),
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
            'deskripsi' => ucwords($request->deskripsi),
            'nama_yayasan' => $request->namaYayasan,
            'alamat' => $request->alamat,
            'pic' => $request->pic,
            'jabatan' => $request->jabatan,
            'no_telp' => $request->noTelp,
        ];

        try {
            RealisasiAP::where('id_realisasi', $logID)->update($data);

            if ($request->hasFile('lampiran')) {
                $image = $request->file('lampiran');
                $name = str_replace(' ', '-', $image->getClientOriginalName());
                $type = $image->getClientOriginalExtension();
                $featured_new_name = time() . $name ."." . $type;
                $image->move('attachment', $featured_new_name);

                $dataLampiran = [
                    'ID_REALISASI' => $logID,
                    'NAMA' => 'Proposal',
                    'LAMPIRAN' => $featured_new_name,
                    'UPLOAD_BY' => session('user')->username,
                ];

                LampiranAP::where('id_lampiran', $logID)->where('nama', 'Proposal')->update($dataLampiran);
            }

            return redirect()->route('indexRealisasiSubsidiary')->with('berhasil', 'Realisasi anggaran berhasil diupdate');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Realisasi anggaran gagal diupdate');
        }
    }

    public function updateNonProposal(Request $request)
    {
        try {
            $logID = decrypt($request->realisasiID);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'tglRealisasi' => 'required',
            'prokerID' => 'required',
            'proker' => 'required',
            'pilar' => 'required',
            'gols' => 'required',
            'nilaiBantuan' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'deskripsi' => 'required',
        ]);

        $data = [
            'tgl_realisasi' => date('Y-m-d', strtotime($request->tglRealisasi)),
            'id_proker' => $request->prokerID,
            'proker' => $request->proker,
            'pilar' => $request->pilar,
            'gols' => $request->gols,
            'prioritas' => $request->prioritas,
            'nilai_bantuan' => str_replace(".", "", $request->nilaiBantuan),
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'deskripsi' => ucwords($request->deskripsi),
            'nama_yayasan' => $request->namaYayasan,
            'alamat' => $request->alamat,
            'pic' => $request->pic,
            'jabatan' => $request->jabatan,
            'no_telp' => $request->noTelp,
        ];

        try {
            RealisasiAP::where('id_realisasi', $logID)->update($data);
            return redirect()->route('indexRealisasiSubsidiary')->with('berhasil', 'Realisasi anggaran berhasil diupdate');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Realisasi anggaran gagal diupdate');
        }
    }

    public function delete($realisasiID)
    {
        try {
            $logID = decrypt($realisasiID);
        } catch (Exception $e) {
            abort(404);
        }

        RealisasiAP::where('id_realisasi', $logID)->delete();
        return redirect()->back()->with('berhasil', 'Data realisasi berhasil dihapus');
    }

    public function sisaAnggaran($prokerID)
    {
        $tahun = date("Y");
        $company = session('user')->perusahaan;
        $proker = Proker::where('id_proker', $prokerID)->first();

        $data = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('sum(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->where('id_proker', $prokerID)
            ->first();

        if (!empty($data)) {
            $totalRealisasi = $data->total;
        }else{
            $totalRealisasi = 0;
        }

        $totalAnggaran = $proker->anggaran;

        $terpakai = $totalAnggaran - $totalRealisasi;

        echo $output = '<option>' . number_format($terpakai,0,',','.') . '</option>';
    }
}
