<?php

namespace App\Http\Controllers;

use App\Helper\APIHelper;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PembayaranExport;
use App\Exports\RealisasiProkerExport;
use App\Exports\RealisasiPilarExport;
use App\Exports\RealisasiPrioritasExport;
use App\Http\Requests\ExportPopay;
use App\Models\Kelayakan;
use App\Models\Lampiran;
use App\Models\Pembayaran;
use App\Models\Pilar;
use App\Models\Anggaran;
use App\Models\Lembaga;
use App\Models\Pengirim;
use App\Models\User;
use App\Models\Proker;
use App\Models\Provinsi;
use App\Models\SektorBantuan;
use App\Models\SubProposal;
use App\Models\Survei;
use App\Models\ViewPembayaran;
use App\Models\ViewProker;
use Illuminate\Http\Request;
use DB;
use Mail;
use Exception;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $perusahaanID = session('user')->id_perusahaan;
        $tahun = $request->input('tahun', date("Y"));
        $proker      = $request->input('proker');
        $jenis      = $request->input('jenis');
        $pilar      = $request->input('pilar');
        $tpb        = $request->input('tpb');
        $prioritas  = $request->input('prioritas');
        $status     = $request->input('status');
        $provinsi   = $request->input('provinsi');
        $kabupaten  = $request->input('kabupaten');
        $kecamatan  = $request->input('kecamatan');
        $kelurahan  = $request->input('kelurahan');

        $data = ViewPembayaran::when($tahun, function ($q) use ($tahun) {
                return $q->where('tahun', $tahun);
            })
            ->when($jenis, function ($q) use ($jenis) {
                return $q->where('jenis', $jenis);
            })
            ->when($status, function ($q) use ($status) {
                return $q->where('status', $status);
            })
            ->when($pilar, function ($q) use ($pilar) {
                return $q->where('pilar', $pilar);
            })
            ->when($tpb, function ($q) use ($tpb) {
                return $q->where('gols', $tpb);
            })
            ->when($prioritas, function ($q) use ($prioritas) {
                return $q->where('prioritas', $prioritas);
            })
            ->when($proker, function ($q) use ($proker) {
                return $q->where('id_proker', $proker);
            })
            ->when($provinsi, function ($q) use ($provinsi) {
                return $q->where('provinsi', $provinsi);
            })
            ->when($kabupaten, function ($q) use ($kabupaten) {
                return $q->where('kabupaten', $kabupaten);
            })
            ->when($kecamatan, function ($q) use ($kecamatan) {
                return $q->where('kecamatan', $kecamatan);
            })
            ->when($kelurahan, function ($q) use ($kelurahan) {
                return $q->where('kelurahan', $kelurahan);
            })
            ->orderByDesc('id_pembayaran')
            ->get();

        $total = $data->sum('subtotal');

        return view('report.data_pembayaran')
            ->with([
                'tahun'           => $tahun,
                'dataPembayaran'  => $data,
                'totalRealisasi'  => $total,
                'dataProvinsi'    => Provinsi::orderBy('provinsi')->get(),
                'dataPilar'       => Pilar::orderBy('id_pilar', 'ASC')->get(),
            ]);
    }

    public function exportPembayaran(Request $request)
    {
        $perusahaanID = session('user')->id_perusahaan;

        $tahun      = $request->input('tahun', date("Y"));
        $jenis      = $request->input('jenis');
        $pilar      = $request->input('pilar');
        $tpb        = $request->input('tpb');
        $prioritas  = $request->input('prioritas');
        $status     = $request->input('status');
        $provinsi   = $request->input('provinsi');
        $kabupaten  = $request->input('kabupaten');
        $kecamatan  = $request->input('kecamatan');
        $kelurahan  = $request->input('kelurahan');

        $data = ViewPembayaran::when($tahun, function ($q) use ($tahun) {
                return $q->where('tahun', $tahun);
            })
            ->when($jenis, function ($q) use ($jenis) {
                return $q->where('jenis', $jenis);
            })
            ->when($pilar, function ($q) use ($pilar) {
                return $q->where('pilar', $pilar);
            })
            ->when($tpb, function ($q) use ($tpb) {
                return $q->where('gols', $tpb);
            })
            ->when($prioritas, function ($q) use ($prioritas) {
                return $q->where('prioritas', $prioritas);
            })
            ->when($status, function ($q) use ($status) {
                return $q->where('status', $status);
            })
            ->when($provinsi, function ($q) use ($provinsi) {
                return $q->where('provinsi', $provinsi);
            })
            ->when($kabupaten, function ($q) use ($kabupaten) {
                return $q->where('kabupaten', $kabupaten);
            })
            ->when($kecamatan, function ($q) use ($kecamatan) {
                return $q->where('kecamatan', $kecamatan);
            })
            ->when($kelurahan, function ($q) use ($kelurahan) {
                return $q->where('kelurahan', $kelurahan);
            })
            ->orderByDesc('id_pembayaran')
            ->get();

        return Excel::download(new PembayaranExport($data, $tahun), 'rekap-pembayaran-' . $tahun . '.xlsx');
    }

    public function indexPilar(Request $request)
    {
        $perusahaanID = session('user')->id_perusahaan;
        $tahun = $request->input('tahun', date("Y"));

        $dataAnggaran = Anggaran::where('id_perusahaan', $perusahaanID)
            ->orderByDesc('tahun')
            ->get();

        $totalRealisasi = DB::table('v_pembayaran')
            ->select(DB::raw('SUM(subtotal) as total'))
            ->where('tahun', $tahun)
            ->first();
        
        $prokerPilar = DB::table('tbl_proker')
            ->select('pilar', DB::raw('SUM(anggaran) as total'))
            ->where('id_perusahaan', $perusahaanID)
            ->where('tahun', $tahun)
            ->groupBy('pilar')
            ->orderByRaw("
                CASE 
                    WHEN pilar = 'Sosial' THEN 1
                    WHEN pilar = 'Ekonomi' THEN 2
                    WHEN pilar = 'Lingkungan' THEN 3
                    ELSE 4
                END
            ")
            ->get();

        $realisasiPilar = DB::table('v_pembayaran')
            ->select('pilar', DB::raw('SUM(subtotal) as total'))
            ->where('tahun', $tahun)
            ->groupBy('pilar')
            ->get();
            
        //Plan vs Actual Pilar
        $reportPilar = [];

        foreach ($prokerPilar as $proker) {
            $pilar = $proker->pilar;
            $reportPilar[$pilar] = [
                'pilar' => $pilar,
                'anggaran' => $proker->total,
                'realisasi' => 0,
                'selisih' => 0,
                'persentase' => 0,
            ];
        }

        foreach ($realisasiPilar as $realisasi) {
            $pilar = $realisasi->pilar;
            $realisasiTotal = $realisasi->total;

            if (isset($reportPilar[$pilar])) {
                $anggaran = $reportPilar[$pilar]['anggaran'];
                $selisih = $anggaran - $realisasiTotal;
                $persen = $anggaran > 0 ? round(($realisasiTotal / $anggaran) * 100, 2) : 0;

                $reportPilar[$pilar]['realisasi'] = $realisasiTotal;
                $reportPilar[$pilar]['selisih'] = $selisih;
                $reportPilar[$pilar]['persentase'] = $persen;
            } else {
                // Realisasi tanpa anggaran
                $reportPilar[$pilar] = [
                    'pilar' => $pilar,
                    'anggaran' => 0,
                    'realisasi' => $realisasiTotal,
                    'selisih' => -$realisasiTotal,
                    'persentase' => 0,
                ];
            }
        }

        // Konversi ke collection
        $reportPilar = collect($reportPilar)->values();  

        return view('report.data_realisasi_pilar')
            ->with([
                'tahun'           => $tahun,
                'dataAnggaran'           => $dataAnggaran,
                'totalRealisasi'  => $totalRealisasi->total,
                'dataPilar' => $reportPilar,
            ]);    
    }

    public function exportRealisasiPilar(Request $request)
    {
        $perusahaanID = session('user')->id_perusahaan;
        $tahun = $request->input('tahun', date("Y"));

        $dataAnggaran = Anggaran::where('id_perusahaan', $perusahaanID)
            ->orderByDesc('tahun')
            ->get();

        $totalRealisasi = DB::table('v_pembayaran')
            ->select(DB::raw('SUM(subtotal) as total'))
            ->where('tahun', $tahun)
            ->first();
        
        $prokerPilar = DB::table('tbl_proker')
            ->select('pilar', DB::raw('SUM(anggaran) as total'))
            ->where('id_perusahaan', $perusahaanID)
            ->where('tahun', $tahun)
            ->groupBy('pilar')
            ->orderByRaw("
                CASE 
                    WHEN pilar = 'Sosial' THEN 1
                    WHEN pilar = 'Ekonomi' THEN 2
                    WHEN pilar = 'Lingkungan' THEN 3
                    ELSE 4
                END
            ")
            ->get();

        $realisasiPilar = DB::table('v_pembayaran')
            ->select('pilar', DB::raw('SUM(subtotal) as total'))
            ->where('tahun', $tahun)
            ->groupBy('pilar')
            ->get();
            
        //Plan vs Actual Pilar
        $reportPilar = [];

        foreach ($prokerPilar as $proker) {
            $pilar = $proker->pilar;
            $reportPilar[$pilar] = [
                'pilar' => $pilar,
                'anggaran' => $proker->total,
                'realisasi' => 0,
                'selisih' => 0,
                'persentase' => 0,
            ];
        }

        foreach ($realisasiPilar as $realisasi) {
            $pilar = $realisasi->pilar;
            $realisasiTotal = $realisasi->total;

            if (isset($reportPilar[$pilar])) {
                $anggaran = $reportPilar[$pilar]['anggaran'];
                $selisih = $anggaran - $realisasiTotal;
                $persen = $anggaran > 0 ? round(($realisasiTotal / $anggaran) * 100, 2) : 0;

                $reportPilar[$pilar]['realisasi'] = $realisasiTotal;
                $reportPilar[$pilar]['selisih'] = $selisih;
                $reportPilar[$pilar]['persentase'] = $persen;
            } else {
                // Realisasi tanpa anggaran
                $reportPilar[$pilar] = [
                    'pilar' => $pilar,
                    'anggaran' => 0,
                    'realisasi' => $realisasiTotal,
                    'selisih' => -$realisasiTotal,
                    'persentase' => 0,
                ];
            }
        }

        // Konversi ke collection
        $data = collect($reportPilar)->values();  

        return Excel::download(new RealisasiPilarExport($data, $tahun), 'rekap-realisasi-pilar-' . $tahun . '.xlsx');
    }

    public function indexPrioritas(Request $request)
    {
        $perusahaanID = session('user')->id_perusahaan;
        $tahun = $request->input('tahun', date("Y"));

        $dataAnggaran = Anggaran::where('id_perusahaan', $perusahaanID)
            ->orderByDesc('tahun')
            ->get();

        $totalRealisasi = DB::table('v_pembayaran')
            ->select(DB::raw('SUM(subtotal) as total'))
            ->where('tahun', $tahun)
            ->first();
        
        $prokerPrioritas = DB::table('tbl_proker')
            ->select('prioritas', DB::raw('SUM(anggaran) as total'))
            ->where('id_perusahaan', $perusahaanID)
            ->where('tahun', $tahun)
            ->groupBy('prioritas')
            ->orderByRaw("
                CASE 
                    WHEN prioritas = 'Pendidikan' THEN 1
                    WHEN prioritas = 'UMK' THEN 2
                    WHEN prioritas = 'Lingkungan' THEN 3
                    ELSE 4
                END
            ")
            ->get();

        $realisasiPrioritas = DB::table('v_pembayaran')
            ->select('prioritas', DB::raw('SUM(subtotal) as total'))
            ->where('tahun', $tahun)
            ->groupBy('prioritas')
            ->get();
            
        //Plan vs Actual Prioritas
        $reportPrioritas = [];

        foreach ($prokerPrioritas as $proker) {
            $prioritas = $proker->prioritas;
            $reportPrioritas[$prioritas] = [
                'prioritas' => $prioritas,
                'anggaran' => $proker->total,
                'realisasi' => 0,
                'selisih' => 0,
                'persentase' => 0,
            ];
        }

        foreach ($realisasiPrioritas as $realisasi) {
            $prioritas = $realisasi->prioritas;
            $realisasiTotal = $realisasi->total;

            if (isset($reportPrioritas[$prioritas])) {
                $anggaran = $reportPrioritas[$prioritas]['anggaran'];
                $selisih = $anggaran - $realisasiTotal;
                $persen = $anggaran > 0 ? round(($realisasiTotal / $anggaran) * 100, 2) : 0;

                $reportPrioritas[$prioritas]['realisasi'] = $realisasiTotal;
                $reportPrioritas[$prioritas]['selisih'] = $selisih;
                $reportPrioritas[$prioritas]['persentase'] = $persen;
            } else {
                // Realisasi tanpa anggaran
                $reportPrioritas[$prioritas] = [
                    'prioritas' => $prioritas,
                    'anggaran' => 0,
                    'realisasi' => $realisasiTotal,
                    'selisih' => -$realisasiTotal,
                    'persentase' => 0,
                ];
            }
        }

        // Konversi ke collection
        $reportPrioritas = collect($reportPrioritas)->values();  

        return view('report.data_realisasi_prioritas')
            ->with([
                'tahun'           => $tahun,
                'dataAnggaran'    => $dataAnggaran,
                'totalRealisasi'  => $totalRealisasi->total,
                'dataPrioritas'   => $reportPrioritas,
            ]);    
    }

    public function exportRealisasiPrioritas(Request $request)
    {
        $perusahaanID = session('user')->id_perusahaan;
        $tahun = $request->input('tahun', date("Y"));

        $dataAnggaran = Anggaran::where('id_perusahaan', $perusahaanID)
            ->orderByDesc('tahun')
            ->get();

        $totalRealisasi = DB::table('v_pembayaran')
            ->select(DB::raw('SUM(subtotal) as total'))
            ->where('tahun', $tahun)
            ->first();
        
        $prokerPrioritas = DB::table('tbl_proker')
            ->select('prioritas', DB::raw('SUM(anggaran) as total'))
            ->where('id_perusahaan', $perusahaanID)
            ->where('tahun', $tahun)
            ->groupBy('prioritas')
            ->orderByRaw("
                CASE 
                    WHEN prioritas = 'Pendidikan' THEN 1
                    WHEN prioritas = 'UMK' THEN 2
                    WHEN prioritas = 'Lingkungan' THEN 3
                    ELSE 4
                END
            ")
            ->get();

        $realisasiPrioritas = DB::table('v_pembayaran')
            ->select('prioritas', DB::raw('SUM(subtotal) as total'))
            ->where('tahun', $tahun)
            ->groupBy('prioritas')
            ->get();
            
        //Plan vs Actual Prioritas
        $reportPrioritas = [];

        foreach ($prokerPrioritas as $proker) {
            $prioritas = $proker->prioritas;
            $reportPrioritas[$prioritas] = [
                'prioritas' => $prioritas,
                'anggaran' => $proker->total,
                'realisasi' => 0,
                'selisih' => 0,
                'persentase' => 0,
            ];
        }

        foreach ($realisasiPrioritas as $realisasi) {
            $prioritas = $realisasi->prioritas;
            $realisasiTotal = $realisasi->total;

            if (isset($reportPrioritas[$prioritas])) {
                $anggaran = $reportPrioritas[$prioritas]['anggaran'];
                $selisih = $anggaran - $realisasiTotal;
                $persen = $anggaran > 0 ? round(($realisasiTotal / $anggaran) * 100, 2) : 0;

                $reportPrioritas[$prioritas]['realisasi'] = $realisasiTotal;
                $reportPrioritas[$prioritas]['selisih'] = $selisih;
                $reportPrioritas[$prioritas]['persentase'] = $persen;
            } else {
                // Realisasi tanpa anggaran
                $reportPrioritas[$prioritas] = [
                    'prioritas' => $prioritas,
                    'anggaran' => 0,
                    'realisasi' => $realisasiTotal,
                    'selisih' => -$realisasiTotal,
                    'persentase' => 0,
                ];
            }
        }

        // Konversi ke collection
        $data = collect($reportPrioritas)->values();   

        return Excel::download(new RealisasiPrioritasExport($data, $tahun), 'rekap-realisasi-prioritas-' . $tahun . '.xlsx');
    }

    public function indexRealisasiProker(Request $request)
    {
        $tahun    = $request->input('tahun', date("Y"));
        $pilarFilter = $request->input('pilar');
        $tpbFilter = $request->input('tpb');

        $perusahaanID = session('user')->id_perusahaan;

        $anggaran = Anggaran::where('id_perusahaan', $perusahaanID)
            ->where('tahun', $tahun)
            ->first();

        $queryProker = Proker::where('id_perusahaan', $perusahaanID)
            ->where('tahun', $tahun);

        if ($pilarFilter) {
            $queryProker->where('pilar', $pilarFilter);
        }

        if ($tpbFilter) {
            $queryProker->where('gols', 'like', "%$tpbFilter%");
        }

        $prokers = $queryProker->get();

        // Ambil realisasi untuk semua proker sekaligus
        $prokerIDs = $prokers->pluck('id_proker');

        $realisasiData = DB::table('v_pembayaran')
            ->select('id_proker', DB::raw('SUM(subtotal) as total'))
            ->whereIn('id_proker', $prokerIDs)
            ->where('tahun', $tahun)
            ->groupBy('id_proker')
            ->pluck('total', 'id_proker'); // hasil: [id_proker => total]

        $totalRealisasi = $realisasiData->sum();

        $sisa = $anggaran->nominal - $totalRealisasi;

        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();
        $dataAnggaran = Anggaran::where('id_perusahaan', $perusahaanID)
            ->orderByDesc('tahun')
            ->get();


        return view('report.data_realisasi_proker', [
            'tahun' => $tahun,
            'anggaran' => $anggaran->nominal,
            'realisasi' => $totalRealisasi,
            'sisa' => $sisa,
            'dataPilar' => $pilar,
            'dataAnggaran' => $dataAnggaran,
            'dataProker' => $prokers,
            'realisasiProker' => $realisasiData,
        ]);
    }

    public function exportRealisasiProker(Request $request)
    {
        $tahun = $request->input('tahun', date("Y"));
        $pilarFilter = $request->input('pilar');
        $tpbFilter = $request->input('tpb');
        $perusahaanID = session('user')->id_perusahaan;

        $anggaran = Anggaran::where('id_perusahaan', $perusahaanID)
            ->where('tahun', $tahun)
            ->first();

        $queryProker = Proker::where('id_perusahaan', $perusahaanID)
            ->where('tahun', $tahun);

        if ($pilarFilter) {
            $queryProker->where('pilar', $pilarFilter);
        }

        if ($tpbFilter) {
            $queryProker->where('gols', 'like', "%$tpbFilter%");
        }

        $prokers = $queryProker->get();

        // Guard clause jika kosong
        if ($prokers->isEmpty()) {
            return back()->with('gagalDetail', 'Data program kerja tidak ditemukan.');
        }

        $prokerIDs = $prokers->pluck('id_proker');

        $realisasiData = DB::table('v_pembayaran')
            ->select('id_proker', DB::raw('SUM(subtotal) as total'))
            ->whereIn('id_proker', $prokerIDs)
            ->where('tahun', $tahun)
            ->groupBy('id_proker')
            ->pluck('total', 'id_proker'); // hasil: [id_proker => total]

        return Excel::download(
            new RealisasiProkerExport($prokers, $tahun, $realisasiData),
            'realisasi-proker-' . $tahun . '.xlsx'
        );
    }

    public function taskMapping(Request $request)
    {
        $tahun = date("Y");

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
        );

        if ($tahun > '2022'){
            $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestNonProkerPopayV4', $param, '');
            $return = json_decode(strstr($release, '{'), true);
            $data = $return['data'];
        }else{
            $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestNonProker', $param, '');
            $return = json_decode(strstr($release, '{'), true);
            $data = $return['data'];
        }

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::select("SELECT CITY_NAME FROM TBL_WILAYAH GROUP BY CITY_NAME");
        $proker = Proker::where('tahun', $tahun)->orderBy('id_proker', 'ASC')->orderBy('tahun', 'ASC')->get();
        $sektor = SektorBantuan::orderBy('kode_sektor', 'ASC')->get();
        return view('report.task_mapping')
            ->with([
                'dataPayment' => $data,
                'tahun' => $tahun,
                'dataSektor' => $sektor,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataProker' => $proker,
            ]);
    }

    public function postTaskMappingAnnual(Request $request)
    {
        $this->validate($request, [
            'tahun' => 'required',
        ]);

        return redirect()->route('taskMappingAnnual', ['year' => encrypt($request->tahun)]);
    }

    public function taskMappingAnnual($year)
    {
        try {
            $tahun = decrypt($year);
        } catch (Exception $e) {
            abort(404);
        }

        $param = array(
            "user_id" => "1211",
            "budget_year" => $tahun,
        );

        if ($tahun > '2022'){
            $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestNonProkerPopayV4', $param, '');
            $return = json_decode(strstr($release, '{'), true);
            $data = $return['data'];
        }else{
            $release = APIHelper::instance()->httpCall('POST', env('BASEURL_PAYMENT') . '/api/listPaymentRequestNonProker', $param, '');
            $return = json_decode(strstr($release, '{'), true);
            $data = $return['data'];
        }

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::select("SELECT CITY_NAME FROM TBL_WILAYAH GROUP BY CITY_NAME");
        $proker = Proker::where('tahun', $tahun)->orderBy('id_proker', 'ASC')->orderBy('tahun', 'ASC')->get();
        $sektor = SektorBantuan::orderBy('kode_sektor', 'ASC')->get();
        return view('report.task_mapping')
            ->with([
                'dataPayment' => $data,
                'tahun' => $tahun,
                'dataSektor' => $sektor,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataProker' => $proker,
            ]);
    }

    public function store(Request $request)
    {
        try {
            $kelayakanID = decrypt($request->kelayakanID);
        } catch (Exception $e) {
            abort(404);
        }

        // Validasi
        $request->validate([
            'deskripsi' => 'required|string|max:500',
            'termin' => 'required',
            'metode' => 'required',
            'jumlahPembayaranAsli' => 'required|numeric',
            'fee' => 'required|numeric|min:0|max:100',
        ], [
            'deskripsi.required' => 'Deskripsi pembayaran harus diisi',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter',
            'termin.required' => 'Termin pembayaran harus dipilih',
            'metode.required' => 'Metode harus dipilih',
            'jumlahPembayaranAsli.required' => 'Jumlah pembayaran harus diisi',
            'fee.required' => 'Fee pembayaran harus diisi',
            'fee.max' => 'Fee tidak boleh lebih dari 100%',
        ]);

        $kelayakan = Kelayakan::findOrFail($kelayakanID);

        if (!$kelayakan) {
            return redirect()->back()->with('gagalDetail', 'Data kelayakan tidak ditemukan.');
        }

        $proker = Proker::where('id_proker', $kelayakan->id_proker)->first();

        if (!$proker) {
            return redirect()->back()->with('gagalDetail', 'Program kerja belum ditambahkan.');
        }

        // Hitung fee dalam rupiah
        $feeDalamRupiah = ($request->jumlahPembayaranAsli * $request->fee) / 100;
        $subTotal = $request->jumlahPembayaranAsli + $feeDalamRupiah;

        $metode = $request->metode;

        if($metode == 'Popay'){
            $dataPembayaran = [
                'id_kelayakan' => $kelayakanID,
                'deskripsi' => $request->deskripsi,
                'termin' => $request->termin,
                'metode' => $request->metode,
                'nilai_approved' => $kelayakan->nominal_approved,
                'jumlah_pembayaran' => $request->jumlahPembayaranAsli,
                'fee' => $feeDalamRupiah,
                'fee_persen' => $request->fee,
                'subtotal' => $subTotal,
                'status' => 'Open',
                'create_date' => now(),
                'create_by' => session('user')->username,
            ];
        }elseif($metode == 'YKPP'){
            $dataPembayaran = [
                'id_kelayakan' => $kelayakanID,
                'deskripsi' => $request->deskripsi,
                'termin' => $request->termin,
                'metode' => $request->metode,
                'nilai_approved' => $kelayakan->nominal_approved,
                'jumlah_pembayaran' => $request->jumlahPembayaranAsli,
                'fee' => $feeDalamRupiah,
                'fee_persen' => $request->fee,
                'subtotal' => $subTotal,
                'status' => 'Open',
                'create_date' => now(),
                'create_by' => session('user')->username,
                'status_ykpp' => "Open",
                'tahun_ykpp' => $proker->tahun,
            ];
        }else{
            return redirect()->back()->with('gagalDetail', 'Metode pembayaran belum ditentukan.');
        }

        // Cek termin duplikat
        $exists = DB::table('tbl_pembayaran')
            ->where('id_kelayakan', $kelayakanID)
            ->where('termin', $request->termin)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('gagalDetail', 'Termin tersebut sudah pernah dibuat.');
        }

        try {
            DB::table('tbl_pembayaran')->insert($dataPembayaran);
            return redirect()->back()->with('suksesDetail', 'Pembayaran berhasil disimpan');
        } catch (Exception $e) {
            return redirect()->back()->with('gagalDetail', 'Pembayaran gagal disimpan');
        }
    }

    public function update(Request $request)
    {
        try {
            $pembayaranID = decrypt($request->pembayaranID);
        } catch (Exception $e) {
            abort(404);
        }

        $request->validate([
            'deskripsi' => 'required|string|max:500',
            'termin' => 'required',
            'metode' => 'required',
            'jumlahPembayaranAsli' => 'required|numeric',
            'fee' => 'required|numeric|min:0|max:100',
        ], [
            'deskripsi.required' => 'Deskripsi pembayaran harus diisi',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter',
            'termin.required' => 'Termin pembayaran harus dipilih',
            'metode.required' => 'Metode harus dipilih',
            'jumlahPembayaranAsli.required' => 'Jumlah pembayaran harus diisi',
            'fee.required' => 'Fee pembayaran harus diisi',
        ]);

        $pembayaran = DB::table('tbl_pembayaran')->where('id_pembayaran', $pembayaranID)->first();

        if (!$pembayaran) {
            return redirect()->back()->with('gagalDetail', 'Data pembayaran tidak ditemukan.');
        }

        $kelayakan = Kelayakan::where('id_kelayakan', $pembayaran->id_kelayakan)->first();

        if (!$kelayakan) {
            return redirect()->back()->with('gagalDetail', 'Data kelayakan tidak ditemukan.');
        }

        $proker = Proker::where('id_proker', $kelayakan->id_proker)->first();

        if (!$proker) {
            return redirect()->back()->with('gagalDetail', 'Program kerja belum ditambahkan.');
        }

        $status_ykpp = empty($pembayaran->status_ykpp) ? 'Open' : $pembayaran->status_ykpp;

        // Hitung nilai fee dalam rupiah
        $feeAsli = ($request->jumlahPembayaranAsli * $request->fee) / 100;

        // Hitung subtotal
        $subTotal = $request->jumlahPembayaranAsli + $feeAsli;

        $dataUpdate = [
            'deskripsi' => $request->deskripsi,
            'termin' => $request->termin,
            'metode' => $request->metode,
            'jumlah_pembayaran' => $request->jumlahPembayaranAsli,
            'fee' => $feeAsli,
            'fee_persen' => $request->fee, // disimpan sebagai persen (misalnya 5)
            'subtotal' => $subTotal,
            'status_ykpp' => $status_ykpp,
            'tahun_ykpp' => $proker->tahun,
        ];

        try {
            DB::table('tbl_pembayaran')
                ->where('id_pembayaran', $pembayaranID)
                ->update($dataUpdate);

            return redirect()->back()->with('suksesDetail', 'Data pembayaran berhasil diperbarui');
        } catch (Exception $e) {
            return redirect()->back()->with('gagalDetail', 'Data pembayaran gagal diperbarui');
        }
    }

    public function delete($id)
    {
        try {
            $pembayaranID = decrypt($id);
        } catch (Exception $e) {
            abort(404);
        }
        
        $pembayaran = Pembayaran::find($pembayaranID);

        if (!$pembayaran) {
            return redirect()->back()->with('gagalDetail', 'Data pembayaran tidak ditemukan.');
        }

        try {
            Pembayaran::where('id_pembayaran', $pembayaranID)->delete();
            return redirect()->back()->with('suksesDetail', 'Daftar pembayaran berhasil dihapus');
        } catch (Exception $e) {
            return redirect()->back()->with('gagalDetail', 'Daftar pembayaran gagal dihapus');
        }
    }

    public function subProposal($id)
    {

        try {
            $logID = decrypt($id);
        } catch (Exception $e) {
            abort(404);
        }

        $pembayaran = Pembayaran::where('pr_id', $logID)->first();

        $kelayakan = Kelayakan::where('no_agenda', $pembayaran->no_agenda)->first();
        $survei = Survei::where('no_agenda', $pembayaran->no_agenda)->first();
        $subProposal = SubProposal::where('no_agenda', $kelayakan->no_agenda)->orderBy('id_sub_proposal', 'ASC')->get();

        $total = DB::table('TBL_SUB_PROPOSAL')
            ->select(DB::raw('sum(SUBTOTAL) as jumlah'))
            ->where([
                ['no_agenda', $pembayaran->no_agenda],
            ])
            ->first();

        return view('report.export_sub_proposal')
            ->with([
                'dataPembayaran' => $pembayaran,
                'dataKelayakan' => $kelayakan,
                'dataSubProposal' => $subProposal,
                'nilaiApproved' => $survei->nilai_approved,
                'noAgenda' => $kelayakan->no_agenda,
                'total' => $total->jumlah,
                'PRNumber' => $logID,
            ]);
    }

    public function exportPembayaranIdulAdha($pembayaranID)
    {
        try {
            $logID = decrypt($pembayaranID);
        } catch (Exception $e) {
            abort(404);
        }

        $dataPembayaran = ViewPembayaran::where('id_pembayaran', $logID)->first();

        $param = array(
            "user_id" => "1211",
        );

        //DATA RECEIVER
        $release = APIHelper::instance()->httpCallJson('POST', env('BASEURL') . '/api/APIPaymentRequest/CreatePaymentRequest', $param, '');
        $return = json_decode(strstr($release, '{'), true);
        $data = $return['data'];
        $sup = $data['dataSupplier'];
        $supplier = $sup['Collection'];
        $budget = $data['dataBudget'];

        //DATA BANK
        $releaseBank = APIHelper::instance()->apiCall('GET', env('BASEURL') . '/api/APIPaymentRequest/form/bank/2312', '');
        $returnBank = json_decode(strstr($releaseBank, '{'), true);
        $bank = $returnBank['dataBank'];
        $city = $returnBank['dataCity'];
        $receiverType = $returnBank['receiverType'];
        $nationality = $returnBank['dataNationality'];

        return view('report.export_popay_idul_adha')
            ->with([
                'dataPembayaran' => $dataPembayaran,
                'dataSupplier' => $supplier,
                'dataBudget' => $budget,
                'dataBank' => $bank,
                'dataCity' => $city,
                'dataReceiver' => $receiverType,
                'dataNationality' => $nationality,
            ]);
    }

    public function exportPopay(ExportPopay $request)
    {
        try {
            $idPembayaran = decrypt($request->idPembayaran);
        } catch (Exception $e) {
            abort(404);
        }

        date_default_timezone_set('Asia/Jakarta');

        $tahun = date("Y");
        $tanggal = date("d-M-Y");
        $tanggalTambah = date('Y-m-d', strtotime('+14 days', strtotime($tanggal)));
        $dueDate = date('d-M-Y', strtotime($tanggalTambah));

        $tanggalBerangkat = date('d-M-Y', strtotime($tanggalTambah));
        $tanggalKembali = date('d-M-Y', strtotime($tanggalTambah));

        $payment = DB::table('PGN_PAYMENT.T_PAYMENT_REQUEST')
            ->select(DB::raw('max(ID) as id'))
            ->where('ID_USER', '!=', 0)
            ->first();

        $paymentID = $payment->id + 1;

        function kekata($x)
        {
            $x = abs($x);
            $angka = array("", "satu", "dua", "tiga", "empat", "lima",
                "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
            $temp = "";
            if ($x < 12) {
                $temp = " " . $angka[$x];
            } else if ($x < 20) {
                $temp = kekata($x - 10) . " belas";
            } else if ($x < 100) {
                $temp = kekata($x / 10) . " puluh" . kekata($x % 10);
            } else if ($x < 200) {
                $temp = " seratus" . kekata($x - 100);
            } else if ($x < 1000) {
                $temp = kekata($x / 100) . " ratus" . kekata($x % 100);
            } else if ($x < 2000) {
                $temp = " seribu" . kekata($x - 1000);
            } else if ($x < 1000000) {
                $temp = kekata($x / 1000) . " ribu" . kekata($x % 1000);
            } else if ($x < 1000000000) {
                $temp = kekata($x / 1000000) . " juta" . kekata($x % 1000000);
            } else if ($x < 1000000000000) {
                $temp = kekata($x / 1000000000) . " milyar" . kekata(fmod($x, 1000000000));
            } else if ($x < 1000000000000000) {
                $temp = kekata($x / 1000000000000) . " trilyun" . kekata(fmod($x, 1000000000000));
            }
            return $temp;
        }


        function terbilang($x, $style = 4)
        {
            if ($x < 0) {
                $hasil = "minus " . trim(kekata($x));
            } else {
                $hasil = trim(kekata($x));
            }
            switch ($style) {
                case 1:
                    $hasil = strtoupper($hasil);
                    break;
                case 2:
                    $hasil = strtolower($hasil);
                    break;
                case 3:
                    $hasil = ucwords($hasil);
                    break;
                default:
                    $hasil = ucfirst($hasil);
                    break;
            }
            return $hasil;
        }

        $domain = 'corp\\';
        $maker = session('user')->username;

        $data = ViewPembayaran::where('id_pembayaran', $idPembayaran)->first();

        $makerPopay = DB::table('PGN_PAYMENT.T_USER')
            ->select('T_USER.*')
            ->where([
                ['username', $domain . $maker],
            ])
            ->first();

        $bank = DB::table('PGN_PAYMENT.T_MASTER_DATA')
            ->select('T_MASTER_DATA.*')
            ->where([
                ['CODE', 'BANK_NAME'],
                ['DESCRIPTION', $request->namaBank],
            ])
            ->first();

        $namaBank = $bank->nama;

        if ($data->jumlah_pembayaran == 0) {
            $terbilang = 'Nol Rupiah';
        } elseif ($data->jumlah_pembayaran > 0) {
            $terbilang = terbilang($data->jumlah_pembayaran, $style = 1) . ' RUPIAH';
        }

        if ($data->provinsi == 'Nanggroe Aceh Darussalam (NAD)') {
            $kodeProvinsi = '801';
        } elseif ($data->provinsi == 'Bali') {
            $kodeProvinsi = '802';
        } elseif ($data->provinsi == 'Banten') {
            $kodeProvinsi = '803';
        } elseif ($data->provinsi == 'Bengkulu') {
            $kodeProvinsi = '804';
        } elseif ($data->provinsi == 'Gorontalo') {
            $kodeProvinsi = '805';
        } elseif ($data->provinsi == 'DKI Jakarta') {
            $kodeProvinsi = '806';
        } elseif ($data->provinsi == 'Jambi') {
            $kodeProvinsi = '807';
        } elseif ($data->provinsi == 'Jawa Barat') {
            $kodeProvinsi = '808';
        } elseif ($data->provinsi == 'Jawa Tengah') {
            $kodeProvinsi = '809';
        } elseif ($data->provinsi == 'Jawa Timur') {
            $kodeProvinsi = '810';
        } elseif ($data->provinsi == 'Kalimantan Barat') {
            $kodeProvinsi = '811';
        } elseif ($data->provinsi == 'Kalimantan Selatan') {
            $kodeProvinsi = '812';
        } elseif ($data->provinsi == 'Kalimantan Tengah') {
            $kodeProvinsi = '813';
        } elseif ($data->provinsi == 'Kalimantan Utara') {
            $kodeProvinsi = '814';
        } elseif ($data->provinsi == 'Kalimantan Utara') {
            $kodeProvinsi = '815';
        } elseif ($data->provinsi == 'Bangka Belitung') {
            $kodeProvinsi = '816';
        } elseif ($data->provinsi == 'Kepulauan Riau') {
            $kodeProvinsi = '817';
        } elseif ($data->provinsi == 'Lampung') {
            $kodeProvinsi = '818';
        } elseif ($data->provinsi == 'Maluku') {
            $kodeProvinsi = '819';
        } elseif ($data->provinsi == 'Maluku Utara') {
            $kodeProvinsi = '820';
        } elseif ($data->provinsi == 'Nusa Tenggara Barat(NTB)') {
            $kodeProvinsi = '821';
        } elseif ($data->provinsi == 'Nusa Tenggara Timur(NTT)') {
            $kodeProvinsi = '822';
        } elseif ($data->provinsi == 'Papua') {
            $kodeProvinsi = '823';
        } elseif ($data->provinsi == 'Papua Barat') {
            $kodeProvinsi = '824';
        } elseif ($data->provinsi == 'Riau') {
            $kodeProvinsi = '825';
        } elseif ($data->provinsi == 'Barat') {
            $kodeProvinsi = '826';
        } elseif ($data->provinsi == 'Sulawesi Selatan') {
            $kodeProvinsi = '827';
        } elseif ($data->provinsi == 'Sulawesi Tengah') {
            $kodeProvinsi = '828';
        } elseif ($data->provinsi == 'Sulawesi Tenggara') {
            $kodeProvinsi = '829';
        } elseif ($data->provinsi == 'Sulawesi Utara') {
            $kodeProvinsi = '830';
        } elseif ($data->provinsi == 'Sumatera Barat') {
            $kodeProvinsi = '831';
        } elseif ($data->provinsi == 'Sumatera Selatan') {
            $kodeProvinsi = '832';
        } elseif ($data->provinsi == 'Sumatera Utara') {
            $kodeProvinsi = '833';
        } elseif ($data->provinsi == 'DI Yogyakarta') {
            $kodeProvinsi = '834';
        } else {
            $kodeProvinsi = '806';
        }

        if ($data->komisi == null) {
            $supID = '47946';
            $supName = 'PROPOSAL EKSTERNAL';
            $supAddress = 'JAKARTA, JAKARTA';
            $supSide = '79110';
            $emailReceiver = $data->email_pengaju;
        } else {
            $supID = '47945';
            $supName = 'PROPOSAL DPR';
            $supAddress = 'JAKARTA, JAKARTA';
            $supSide = '79109';
            $emailReceiver = 'csr.payment@pgn.co.id';
        }

        $dataPaymentRequest = [
            'id' => $paymentID,
            'id_user' => $makerPopay->id,
            'type' => 'CSR 517/518',
            'divisi' => $makerPopay->divisi,
            'status' => 'DRAFT',
            'curr_po_contract' => 'IDR',
            'invoice_curr' => 'IDR',
            'no_po_contract' => strtoupper($request->noPO),
            'description' => strtoupper($data->asal_surat),
            'long_description' => strtoupper($data->kabupaten . ' - ' . $data->asal_surat . ' : ' . $data->perihal),
            'payment_termin' => $data->termin,
            'date_po_contract' => strtoupper($request->tglPO),
            'amount_po_contract' => $data->nilai_approved,
            'supplier_id' => $supID,
            'supplier_name' => $supName,
            'supplier_address' => $supAddress,
            'invoice_number' => strtoupper($request->noPO),
            'invoice_date' => strtoupper($request->tglPO),
            'invoice_amount' => $data->jumlah_pembayaran,
            'witheild_amount' => $data->jumlah_pembayaran,
            'created_by' => $makerPopay->id,
            'hierarchy_code' => 'HIRARKI_CSR',
            'attribute3' => '1',
            'attribute1' => '0',
            'attribute2' => 'Setting Payment',
            'invoice_due_date' => $dueDate,
            'name_po_contract' => 'BAST BANTUAN DANA ' . strtoupper($data->sektor) . ' DALAM RANGKA KEGIATAN ' . strtoupper($data->deskripsi),
            'import_flag' => 'N',
            'receiver_type' => 'EXTERNAL',
            'supplier_site_id' => $supSide,
            'site' => $makerPopay->site,
            'budget_year' => $tahun,
            'created_by_name' => $domain . $maker,
            'terbilang' => $terbilang
        ];

        $dataUpdate = [
            'PR_ID' => $paymentID,
            'STATUS' => 'exported',
            'EXPORT_BY' => session('user')->username,
            'EXPORT_DATE' => $tanggal,
        ];

        $dataUpdateBank = [
            'NAMA_BANK' => $request->namaBank,
            'ATAS_NAMA' => $request->atasNama,
            'NO_REKENING' => $request->noRekening,
            'CABANG_BANK' => $request->cabangBank,
        ];

        $dataPaymentReceiver = [
            'id_payment_request' => $paymentID,
            'name' => '',
            'address' => '',
            'bank_account' => $data->no_rekening,
            'bank_name' => $namaBank,
            'bank_address' => $request->cabangBank,
            'bank_account_name' => strtoupper($data->atas_nama),
            'email' => $emailReceiver,
            'amount' => $data->jumlah_pembayaran,
            'attribute1' => 'N',
            'receiver_type' => '1',
            'receiver_nationality' => '1',
        ];

        $dataInvoice = [
            'id_payment_request' => $paymentID,
            'type_account' => 'Item',
            'amount' => $data->jumlah_pembayaran,
            'description' => strtoupper($data->kabupaten . ' - ' . $data->asal_surat . ' : ' . $data->perihal),
            'account_org' => '000',
            'account_no' => '90600',
            'account_pb' => '22',
            'account_eb' => '518',
            'account_cad1' => $data->kode_sektor,
            'account_cad2' => $kodeProvinsi,
            'import_flag' => 'N',
        ];

        $fileEvaluasi = [
            'ID_PAYMENT_REQUEST' => $paymentID,
            'DOC_NAME' => 'FORM EVALUASI',
            'ATTRIBUTE3' => config('app.url') . '/Form/Evaluasi/' . $data->id_kelayakan,
            'DESCRIPTION' => 'FORM EVALUASI',
        ];

        $fileSurvei = [
            'ID_PAYMENT_REQUEST' => $paymentID,
            'DOC_NAME' => 'LEMBAR SURVEY',
            'ATTRIBUTE3' => config('app.url') . '/Form/Survei/' . $data->id_kelayakan,
            'DESCRIPTION' => 'LEMBAR SURVEY',
        ];

        $insertRequest = DB::table('PGN_PAYMENT.T_PAYMENT_REQUEST')->insert($dataPaymentRequest);
        Pembayaran::where('id_pembayaran', $idPembayaran)->update($dataUpdate);
        Kelayakan::where('no_agenda', $data->no_agenda)->update($dataUpdateBank);
        $insertReceiver = DB::table('PGN_PAYMENT.T_PAYMENT_RECEIVER')->insert($dataPaymentReceiver);
        $insertInvoice = DB::table('PGN_PAYMENT.T_INVOICE_LINE')->insert($dataInvoice);
        $insertEvaluasi = DB::table('PGN_PAYMENT.T_DOCUMENT')->insert($fileEvaluasi);
        $insertSurvei = DB::table('PGN_PAYMENT.T_DOCUMENT')->insert($fileSurvei);

        $dataLampiran = Lampiran::where('no_agenda', $data->no_agenda)->get();
        foreach ($dataLampiran as $lampiran) {
            $fileProposal[] = [
                DB::table('PGN_PAYMENT.T_DOCUMENT')->insert([
                    'ID_PAYMENT_REQUEST' => $paymentID,
                    'DOC_NAME' => $lampiran->nama,
                    'ATTRIBUTE3' => config('app.url') . '/attachment/' . $lampiran->lampiran,
                    'DESCRIPTION' => $lampiran->nama,
                ])
            ];
        }

        return redirect()->back()->with('sukses', 'Data berhasil diexport ke popay');
//        try {
//
//        } catch (Exception $e) {
//            return redirect()->back()->with('gagal', 'Data gagal diexport ke popay');
//        }

    }

    public function deletePopay($loginID)
    {

        try {
            $prID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }

        $dataUpdate = [
            'PR_ID' => '',
            'STATUS' => '',
            'EXPORT_BY' => '',
            'EXPORT_DATE' => '',
        ];

        try {
            Pembayaran::where('id_pembayaran', $prID)->update($dataUpdate);
            return redirect()->back()->with('sukses', 'Data berhasil direset');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Data gagal direset');
        }

    }

    public function dataTaxPut($loginID)
    {
        if ($loginID == 'include') {
            echo $output = '<option value="" disabled selected>Select PPN Put</option>';
            echo $output = '<option value="Yes">Yes</option>';
            echo $output = '<option value="No">No</option>';

        } else {
            echo $output = '<option value="" disabled selected>Select PPN Put</option>';
            echo $output = '<option value="No">No</option>';
        }
    }

    public function dataTaxCode($loginID)
    {
        if ($loginID == 'include') {
            $release = APIHelper::instance()->apiCall('GET', env('BASEURL_PAYMENT') . '/api/getTaxCode', '');
            $return = json_decode(strstr($release, '{'), true);
            $dataPPN = $return['data'];

            echo $output = '<option value="" taxRate="" disabled selected>Select PPN Code</option>';
            foreach ($dataPPN as $row) {
                echo $output = '<option value="' . $row['name'] . '" taxRate="' . $row['rate'] . '">' . $row['name'] . '</option>';
            }

        } else {
            echo $output = '<option value="" taxRate="">N/A</option>';
        }
    }


    public
    function dataTaxGroup($loginID)
    {
        $param = array(
            "description" => $loginID,
        );

        $store = APIHelper::instance()->httpCallJson('POST', env('BASEURL_PAYMENT') . '/api/getTaxGroup', $param, '');
        $return = json_decode(strstr($store, '{'), true);
        $dataTaxGroup = $return['data'];

        echo $output = '<option value="" disabled selected>Select Tax Code</option>';
        foreach ($dataTaxGroup as $row) {
            echo $output = '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
        }
    }

}
