<?php

namespace App\Http\Controllers;

use App\Models\ViewProposal;
use App\Models\ViewYKPP;
use App\Models\Anggaran;
use App\Models\Kelayakan;
use App\Models\Pengirim;
use App\Models\Perusahaan;
use App\Models\Pilar;
use App\Models\Provinsi;
use App\Models\RealisasiAP;
use App\Models\SektorBantuan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Mail;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // ====== Filter dari GET ======
        $tahun = (int) $request->query('tahun', date('Y'));

        // perusahaan dari filter (GET) atau default dari session user
        $comp = $request->query('perusahaan', 18 ?? null);
        $comp = is_numeric($comp) ? (int) $comp : null;

        $perusahaanAktif = Perusahaan::findOrFail($comp);

        $status  = "All Data";
        $tanggal = date("Y-m-d");

        // ====== Data master untuk dropdown/filters ======
        $dataPerusahaan = Perusahaan::whereNotIn('id_perusahaan', [1])
            ->where('status', 'Active')
            ->orderBy('id_perusahaan', 'ASC')
            ->get();

        $dataProvinsi  = Provinsi::orderBy('provinsi', 'ASC')->get();
        $dataKabupaten = DB::table('TBL_WILAYAH')->select('city_name')->groupBy('city_name')->get();
        $dataPilar     = Pilar::orderBy('id_pilar', 'ASC')->get();

        // ====== Base query realisasi (biar tidak ngulang) ======
        $realisasiQuery = RealisasiAP::query()
            ->where('tahun', $tahun);

        // kalau perusahaan terpilih ada, baru filter
        if (!empty($comp)) {
            $realisasiQuery->where('id_perusahaan', $comp);
        }

        // ====== Data utama ======
        $dataRealisasi = (clone $realisasiQuery)
            ->orderBy('tgl_realisasi', 'ASC')
            ->get();

        $jumlahData = (clone $realisasiQuery)->count();

        $total = (clone $realisasiQuery)->sum('nilai_bantuan'); // lebih simple daripada DB::raw SUM

        // ====== Anggaran + persen ======
        $anggaran = Anggaran::where('tahun', $tahun)
            ->when(!empty($comp), fn($q) => $q->where('id_perusahaan', $comp))
            ->first();

        $nominalAnggaran = $anggaran->nominal ?? 0;

        $persen = ($nominalAnggaran > 0)
            ? round(($total / $nominalAnggaran) * 100, 2)
            : 0;

        return view('report.data_realisasi_subsidiary', [
            'comp'          => $comp,
            'perusahaanAktif'          => $perusahaanAktif,
            'dataPerusahaan'=> $dataPerusahaan,
            'tahun'         => $tahun,
            'status'        => $status,
            'tanggal'       => $tanggal,
            'dataRealisasi' => $dataRealisasi,
            'jumlahData'    => $jumlahData,
            'dataProvinsi'  => $dataProvinsi,
            'dataKabupaten' => $dataKabupaten,
            'dataPilar'     => $dataPilar,
            'total'         => $total,
            'persen'        => $persen,
        ]);
    }

    public function indexOld(Request $request)
    {
        $tahun    = $request->input('tahun', date("Y"));
        $perusahaanID = $request->input('perusahaan', session('user')->id_perusahaan);


        $company = RealisasiAP::where('tahun', $tahun)->get();

        if (!empty($company)) {
            $comp = $company[0]->id_perusahaan;
        } else {
            $comp = '';
        }

        $status = "All Data";
        $tanggal = date("Y-m-d");

        $data = RealisasiAP::where('tahun', $tahun)->where('perusahaan', $comp)->orderBy('tgl_realisasi', 'ASC')->get();
        $jumlahData = RealisasiAP::where('tahun', $tahun)->where('perusahaan', $comp)->count();
        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::table('TBL_WILAYAH')->select('city_name')->groupBy('city_name')->get();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();
        $perusahaan = Perusahaan::whereNotIn('id_perusahaan', [1])->where('status', 'Active')->orderBy('id_perusahaan', 'ASC')->get();

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $comp)->first();

        $dataTotal = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('SUM(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $comp)
            ->first();

        if (!empty($anggaran)) {
            $persen = round($dataTotal->total / $anggaran->nominal * 100, 2);
        } else {
            $persen = 0;
        }

        return view('report.data_realisasi_subsidiary')
            ->with([
                'comp' => $comp,
                'dataPerusahaan' => $perusahaan,
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

    public function postDetailRealisasiSubsidiaryAnnual(Request $request)
    {
        $this->validate($request, [
            'perusahaan' => 'required',
            'tahun' => 'required',
        ]);

        return redirect()->route('detailRealisasiSubsidiaryAnnual', ['year' => encrypt($request->tahun), 'company' => $request->perusahaan]);
    }

    public function postSubsidiary(Request $request)
    {
        $this->validate($request, [
            'perusahaan' => 'required',
        ]);

        if ($request->perusahaan == 'PT Nusantara Regas') {
            return redirect()->route('dashboardAnnual', ['year' => encrypt($request->tahun)]);
        } else {
            return redirect()->route('dashboardSubsidiaryAnnual', ['year' => encrypt($request->tahun), 'company' => $request->perusahaan]);
        }
    }

    public function indexAnnual($year, $company)
    {
        try {
            $tahun = decrypt($year);
        } catch (Exception $e) {
            abort(404);
        }

        $status = "All Data";
        $tanggal = date("Y-m-d");

        $data = RealisasiAP::where('tahun', $tahun)->where('perusahaan', $company)->orderBy('tgl_realisasi', 'ASC')->get();
        $jumlahData = RealisasiAP::where('tahun', $tahun)->where('perusahaan', $company)->count();
        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::table('TBL_WILAYAH')->select('city_name')->groupBy('city_name')->get();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();
        $perusahaan = Perusahaan::whereNotIn('nama_perusahaan', ['PT Nusantara Regas'])->where('status', 'Active')->orderBy('id_perusahaan', 'ASC')->get();

        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $company)->first();

        $dataTotal = DB::table('tbl_realisasi_ap')
            ->select(DB::raw('SUM(nilai_bantuan) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $company)
            ->first();

        if (!empty($anggaran)) {
            $persen = round($dataTotal->total / $anggaran->nominal * 100, 2);
        } else {
            $persen = 0;
        }

        return view('report.data_realisasi_subsidiary')
            ->with([
                'comp' => $company,
                'dataPerusahaan' => $perusahaan,
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

    public function listPaymentYKPP(Request $request)
    {
        $tahun          = $request->input('tahun', date("Y"));
        $status         = $request->input('status');
        $pilarFilter    = $request->input('pilar');
        $tpbFilter    = $request->input('tpb');
        $prioritas    = $request->input('prioritas');
        $perusahaanID   = session('user')->id_perusahaan;

        $anggaran = Anggaran::where('id_perusahaan', $perusahaanID)
            ->orderBy('tahun', 'DESC')
            ->take(5)
            ->get(); 

        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();

        $query = ViewYKPP::where('tahun_ykpp', $tahun);

        if ($status) {
            $query->where('status_ykpp', $status);
        }

        if ($pilarFilter) {
            $query->where('pilar', $pilarFilter);
        }

        if ($tpbFilter) {
            $query->where('gols', $tpbFilter);
        }
        
        if ($prioritas) {
            $query->where('prioritas', $prioritas);
        }

        $pembayaran = $query->orderBy('create_date', 'DESC')->get();

        $sumQuery = DB::table('v_ykpp')
            ->where('tahun_ykpp', $tahun);

        if ($status) {
            $sumQuery->where('status_ykpp', $status);
        }

        if ($pilarFilter) {
            $sumQuery->where('pilar', $pilarFilter);
        }

        if ($tpbFilter) {
            $sumQuery->where('gols', $tpbFilter);
        }

        if ($prioritas) {
            $sumQuery->where('prioritas', $prioritas);
        }

        $totalPenyaluran = $sumQuery->sum('jumlah_pembayaran');
        $totalFee        = $sumQuery->sum('fee');
        $totalPembayaran = $sumQuery->sum('subtotal');

        return view('report.data_pembayaran_ktt', [
            'tahun' => $tahun,
            'dataAnggaran' => $anggaran,
            'dataPilar' => $pilar,
            'dataKelayakan' => $pembayaran,
            'totalPenyaluran' => $totalPenyaluran,
            'totalFee' => $totalFee,
            'totalPembayaran' => $totalPembayaran,
        ]);
    }

    public function printPaymentYKPP()
    {
        $tahun = date("Y");
        $data = ViewYKPP::where('tahun_ykpp', $tahun)->orderBy('create_date', 'DESC')->get();

        $totalPenyaluran = DB::table('tbl_kelayakan')
            ->select(DB::raw('sum(nominal_approved) as total'))
            ->whereYear('tgl_terima', $tahun)
            ->where('ykpp', 'Yes')
            ->first();

        $totalFee = DB::table('tbl_kelayakan')
            ->select(DB::raw('sum(nominal_fee) as total'))
            ->whereYear('tgl_terima', $tahun)
            ->where('ykpp', 'Yes')
            ->first();

        $totalPembayaran = DB::table('tbl_kelayakan')
            ->select(DB::raw('sum(total_ykpp) as total'))
            ->whereYear('tgl_terima', $tahun)
            ->where('ykpp', 'Yes')
            ->first();

        return view('print.list_ykpp')
            ->with([

                'dataKelayakan' => $data,
                'tahun' => $tahun,
                'totalPenyaluran' => $totalPenyaluran->total,
                'totalFee' => $totalFee->total,
                'totalPembayaran' => $totalPembayaran->total,
            ]);
    }

    public function postPaymentYKPPYear(Request $request)
    {
        $this->validate($request, [
            'tahun' => 'required',
        ]);

        return redirect()->route('listPaymentYKPPYear', encrypt($request->tahun));
    }

    public function listPaymentYKPPYear($year)
    {
        try {
            $tahun = decrypt($year);
        } catch (Exception $e) {
            abort(404);
        }

        function tanggal_indo($tanggal)
        {
            $bulan = array(1 => 'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            );
            $split = explode('-', $tanggal);
            return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
        }

        $tanggalNow = date("Y-m-d");
        $sektor = SektorBantuan::all();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();
        $provinsi = Provinsi::all();
        $pengirim = Pengirim::orderBy('pengirim', 'ASC')->get();
        $data = Kelayakan::whereYear('tgl_terima', $tahun)->where('ykpp', 'Yes')->orderBy('create_date', 'DESC')->get();
        $jumlahData = Kelayakan::whereYear('tgl_terima', $tahun)->where('ykpp', 'Yes')->count();

        $totalPembayaran = DB::table('tbl_kelayakan')
            ->select(DB::raw('sum(nominal_approved) as total'))
            ->whereYear('tgl_terima', $tahun)
            ->where('ykpp', 'Yes')
            ->first();

        return view('report.data_pembayaran_ktt')
            ->with([
                'dataSektor' => $sektor,
                'dataPilar' => $pilar,
                'dataProvinsi' => $provinsi,
                'dataKelayakan' => $data,
                'jumlahData' => $jumlahData,
                'dataPengirim' => $pengirim,
                'tahun' => $tahun,
                'tanggal' => $tanggalNow,
                'keterangan' => "Tahun $tahun",
            ]);
    }

    public function listPaymentYKPPOpen()
    {
        $statusPembayaran = 'Open';

        $tahun = date("Y");
        $tanggalNow = date("Y-m-d");
        $sektor = SektorBantuan::all();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();
        $provinsi = Provinsi::all();
        $pengirim = Pengirim::orderBy('pengirim', 'ASC')->get();
        $data = Kelayakan::whereYear('tgl_terima', $tahun)->where('ykpp', 'Yes')->where('status_ykpp', $statusPembayaran)->orderBy('create_date', 'DESC')->get();
        $jumlahData = Kelayakan::whereYear('tgl_terima', $tahun)->where('ykpp', 'Yes')->where('status_ykpp', $statusPembayaran)->count();

        $totalPenyaluran = DB::table('tbl_kelayakan')
            ->select(DB::raw('sum(nominal_approved) as total'))
            ->whereYear('tgl_terima', $tahun)
            ->where('ykpp', 'Yes')
            ->where('status_ykpp', $statusPembayaran)
            ->first();

        $totalFee = DB::table('tbl_kelayakan')
            ->select(DB::raw('sum(nominal_fee) as total'))
            ->whereYear('tgl_terima', $tahun)
            ->where('ykpp', 'Yes')
            ->where('status_ykpp', $statusPembayaran)
            ->first();

        $totalPembayaran = DB::table('tbl_kelayakan')
            ->select(DB::raw('sum(total_ykpp) as total'))
            ->whereYear('tgl_terima', $tahun)
            ->where('ykpp', 'Yes')
            ->where('status_ykpp', $statusPembayaran)
            ->first();

        return view('report.data_pembayaran_ktt')
            ->with([
                'dataSektor' => $sektor,
                'dataPilar' => $pilar,
                'dataProvinsi' => $provinsi,
                'dataKelayakan' => $data,
                'jumlahData' => $jumlahData,
                'dataPengirim' => $pengirim,
                'tahun' => $tahun,
                'tanggal' => $tanggalNow,
                'ket' => $statusPembayaran,
                'totalPenyaluran' => $totalPenyaluran->total,
                'totalFee' => $totalFee->total,
                'totalPembayaran' => $totalPembayaran->total,
            ]);
    }

    public function printPaymentYKPPOpen()
    {
        $statusPembayaran = 'Open';
        $tahun = date("Y");

        $data = Kelayakan::whereYear('tgl_terima', $tahun)->where('ykpp', 'Yes')->where('status_ykpp', $statusPembayaran)->orderBy('create_date', 'DESC')->get();

        $totalPenyaluran = DB::table('tbl_kelayakan')
            ->select(DB::raw('sum(nominal_approved) as total'))
            ->whereYear('tgl_terima', $tahun)
            ->where('ykpp', 'Yes')
            ->where('status_ykpp', $statusPembayaran)
            ->first();

        $totalFee = DB::table('tbl_kelayakan')
            ->select(DB::raw('sum(nominal_fee) as total'))
            ->whereYear('tgl_terima', $tahun)
            ->where('ykpp', 'Yes')
            ->where('status_ykpp', $statusPembayaran)
            ->first();

        $totalPembayaran = DB::table('tbl_kelayakan')
            ->select(DB::raw('sum(total_ykpp) as total'))
            ->whereYear('tgl_terima', $tahun)
            ->where('ykpp', 'Yes')
            ->where('status_ykpp', $statusPembayaran)
            ->first();

        return view('print.list_ykpp')
            ->with([
                'dataKelayakan' => $data,
                'tahun' => $tahun,
                'totalPenyaluran' => $totalPenyaluran->total,
                'totalFee' => $totalFee->total,
                'totalPembayaran' => $totalPembayaran->total,
            ]);
    }

    public function listPaymentYKPPVerified()
    {
        $tahun = date("Y");
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();
        $provinsi = Provinsi::all();
        $pengirim = Pengirim::orderBy('pengirim', 'ASC')->get();
        $data = Kelayakan::whereYear('tgl_terima', $tahun)->where('ykpp', 'Yes')->where('status_ykpp', $statusPembayaran)->orderBy('create_date', 'DESC')->get();

        $jumlahData = Kelayakan::whereYear('tgl_terima', $tahun)->where('ykpp', 'Yes')->where('status_ykpp', $statusPembayaran)->count();

        $totalPenyaluran = DB::table('tbl_kelayakan')
            ->select(DB::raw('sum(nominal_approved) as total'))
            ->whereYear('tgl_terima', $tahun)
            ->where('ykpp', 'Yes')
            ->where('status_ykpp', $statusPembayaran)
            ->first();

        $totalFee = DB::table('tbl_kelayakan')
            ->select(DB::raw('sum(nominal_fee) as total'))
            ->whereYear('tgl_terima', $tahun)
            ->where('ykpp', 'Yes')
            ->where('status_ykpp', $statusPembayaran)
            ->first();

        $totalPembayaran = DB::table('tbl_kelayakan')
            ->select(DB::raw('sum(total_ykpp) as total'))
            ->whereYear('tgl_terima', $tahun)
            ->where('ykpp', 'Yes')
            ->where('status_ykpp', $statusPembayaran)
            ->first();

        return view('report.data_pembayaran_ykpp')
            ->with([
                'dataSektor' => $sektor,
                'dataPilar' => $pilar,
                'dataProvinsi' => $provinsi,
                'dataKelayakan' => $data,
                'jumlahData' => $jumlahData,
                'dataPengirim' => $pengirim,
                'tahun' => $tahun,
                'tanggal' => $tanggalNow,
                'ket' => $statusPembayaran,
                'totalPenyaluran' => $totalPenyaluran->total,
                'totalFee' => $totalFee->total,
                'totalPembayaran' => $totalPembayaran->total,
            ]);
    }

    public function printPaymentYKPPVerified()
    {
        $statusPembayaran = 'Verified';
        $tahun = date("Y");

        $data = Kelayakan::whereYear('tgl_terima', $tahun)->where('ykpp', 'Yes')->where('status_ykpp', $statusPembayaran)->orderBy('create_date', 'DESC')->get();

        $totalPenyaluran = DB::table('tbl_kelayakan')
            ->select(DB::raw('sum(nominal_approved) as total'))
            ->whereYear('tgl_terima', $tahun)
            ->where('ykpp', 'Yes')
            ->where('status_ykpp', $statusPembayaran)
            ->first();

        $totalFee = DB::table('tbl_kelayakan')
            ->select(DB::raw('sum(nominal_fee) as total'))
            ->whereYear('tgl_terima', $tahun)
            ->where('ykpp', 'Yes')
            ->where('status_ykpp', $statusPembayaran)
            ->first();

        $totalPembayaran = DB::table('tbl_kelayakan')
            ->select(DB::raw('sum(total_ykpp) as total'))
            ->whereYear('tgl_terima', $tahun)
            ->where('ykpp', 'Yes')
            ->where('status_ykpp', $statusPembayaran)
            ->first();

        return view('print.list_ykpp')
            ->with([
                'dataKelayakan' => $data,
                'tahun' => $tahun,
                'totalPenyaluran' => $totalPenyaluran->total,
                'totalFee' => $totalFee->total,
                'totalPembayaran' => $totalPembayaran->total,
            ]);
    }

    public function listPaymentYKPPSubmited(Request $request)
    {
        $tahun = $request->input('tahun', date("Y"));
        $penyaluran      = $request->input('penyaluran');

        $kelayakan = ViewYKPP::where('status_ykpp', 'Submited')
            // ->where('tahun_ykpp', $tahun)
            ->when($tahun, function ($q) use ($tahun) {
                return $q->where('tahun_ykpp', $tahun);
            })
            ->when($penyaluran, function ($q) use ($penyaluran) {
                return $q->where('penyaluran_ke', $penyaluran);
            })
            ->orderBy('penyaluran_ke')
            ->get()
            ->groupBy(function ($item) {
                return $item->penyaluran_ke; // gunakan properti laravel-style (snake_case)
            })
            ->map(function ($items, $penyaluranKe) {
                $first = $items->first();
                return [
                    'penyaluran_ke' => $penyaluranKe,
                    'tahun_ykpp'    => $first->tahun_ykpp,
                    'no_surat'      => $first->no_surat_ykpp,
                    'tgl_surat'     => $first->tgl_surat_ykpp,
                    'file_surat'    => $first->surat_ykpp,
                    'rows'          => $items,
                ];
            });

        $jumlahData = $kelayakan->flatMap(function ($g) {
            return $g['rows'];
        })->count();

        return view('report.data_pembayaran_ykpp_submit', [
            'penyaluran' => $kelayakan,
            'jumlahData' => $jumlahData,
            'tahun'      => $tahun,
        ]);
    }

    public function printPaymentYKPPSubmited()
    {
        $statusPembayaran = 'Submited';
        $tahun = date("Y");

        $data = Kelayakan::whereYear('tgl_terima', $tahun)->where('ykpp', 'Yes')->where('status_ykpp', $statusPembayaran)->orderBy('create_date', 'DESC')->get();

        $totalPembayaran = DB::table('tbl_kelayakan')
            ->select(DB::raw('sum(nominal_approved) as total'))
            ->whereYear('tgl_terima', $tahun)
            ->where('ykpp', 'Yes')
            ->where('status_ykpp', $statusPembayaran)
            ->first();

        return view('print.list_ykpp')
            ->with([
                'dataKelayakan' => $data,
                'tahun' => $tahun,
                'totalPembayaran' => $totalPembayaran->total,
            ]);
    }

    public function printPenyaluran($encryptedPenyaluran, $encryptedTahun)
    {
        try {
            $penyaluranKe = decrypt($encryptedPenyaluran);
            $tahun = decrypt($encryptedTahun);
        } catch (\Throwable $e) {
            abort(404);
        }

        $data = ViewYKPP::where('status_ykpp', 'Submited')
            ->where('penyaluran_ke', $penyaluranKe)
            ->where('tahun_ykpp', $tahun)
            ->get();

        if ($data->isEmpty()) {
            abort(404);
        }

        $first = $data->first();

        return view('print.daftar_penyaluran', [
            'penyaluran_ke'     => $penyaluranKe,
            'tahun'             => $tahun,
            'noSurat'          => $first->no_surat_ykpp,
            'tglSurat'         => $first->tgl_surat_ykpp,
            'dataPenyaluran'    => $data,
            
        ]);
    }
}
