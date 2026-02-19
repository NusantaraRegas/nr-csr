<?php

namespace App\Http\Controllers;

use App\Exports\ProkerExport;
use App\Exports\RealisasiProker;
use App\Helper\APIHelper;
use App\Models\Anggaran;
use App\Models\Kelayakan;
use App\Models\Perusahaan;
use App\Models\Pilar;
use App\Models\Relokasi;
use App\Models\SDG;
use App\Models\SektorBantuan;
use App\Models\SubPilar;
use App\Models\ViewProker;
use Illuminate\Http\Request;
use App\Http\Requests\InsertProker;
use App\Models\Proker;
use DB;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class ProkerController extends Controller
{
    public function dataGols($pilar)
    {
        $data = SDG::where('pilar', $pilar)->get();

        foreach ($data as $row) {
            echo $output = '<option>' . $row->nama . '</option>';
        }
    }

    public function dataGolsPencarian($pilar)
    {
        $data = SDG::where('pilar', $pilar)->get();

        echo $output = '<option>All Goals</option>';
        foreach ($data as $row) {
            echo $output = '<option>' . $row->nama . '</option>';
        }
    }

    public function sisaAnggaran($prokerID)
    {
        $tahun = date("Y");
        $proker = Proker::where('id_proker', $prokerID)->first();

        // pastikan $prokerID berupa array
        $realisasi = DB::table('v_pembayaran')
            ->whereIn('id_proker', (array) $prokerID)
            ->sum('subtotal');                 // numeric; bisa null di DB tertentu

        $realisasi = (float) ($realisasi ?? 0);
        $totalAnggaran = (float) ($proker->anggaran ?? 0);

        // ini sebenarnya "sisa anggaran"
        $sisa = $totalAnggaran - $realisasi;   // pakai max(0, ...) kalau tak mau minus

        $html = '<option value="'. $sisa .'">'.
                number_format($sisa, 0, ',', '.') .
                '</option>';

        return response($html);
    }

    public function index(Request $request)
    {
        // Ambil filter dari request, atau fallback ke session/tahun saat ini
        $perusahaanID = $request->input('perusahaan', session('user')->id_perusahaan);
        $tahun = $request->input('tahun', date("Y"));

        // Ambil data perusahaan yang dipilih
        $company = Perusahaan::findOrFail($perusahaanID);

        // Ambil data anggaran tahun yang dipilih
        $anggaranQuery = Anggaran::where('id_perusahaan', $perusahaanID);
        if ($tahun) {
            $anggaranQuery->where('tahun', $tahun);
        }
        $anggaran = $anggaranQuery->first();

        $nominal = $anggaran->nominal ?? 0;

        // Query data proker sesuai filter
        $dataQuery = Proker::where('id_perusahaan', $perusahaanID);
        if ($tahun) {
            $dataQuery->where('tahun', $tahun);
        }
        $data = $dataQuery->orderByDesc('id_proker')->get();

        $total = $data->sum('anggaran');
        $sisa = $nominal - $total;

        // Query alokasi pilar dan prioritas sesuai filter
        $alokasiPilar = DB::table('tbl_proker')
            ->select('pilar', DB::raw('SUM(anggaran) as total'))
            ->where('id_perusahaan', $perusahaanID)
            ->when($tahun, function ($q) use ($tahun) {
                return $q->where('tahun', $tahun);
            })
            ->groupBy('pilar')
            ->get();

        $alokasiPrioritas = DB::table('tbl_proker')
            ->select('prioritas', DB::raw('SUM(anggaran) as total'))
            ->where('id_perusahaan', $perusahaanID)
            ->when($tahun, function ($q) use ($tahun) {
                return $q->where('tahun', $tahun);
            })
            ->groupBy('prioritas')
            ->get();

        // Dropdowns
        $perusahaan = Perusahaan::orderBy('id_perusahaan')->get();
        $pilar = Pilar::orderBy('kode')->get();
        $dataAnggaran = Anggaran::where('id_perusahaan', $perusahaanID)
            ->orderByDesc('tahun')
            ->get();

        return view('master.data_proker', [
            'dataProker'       => $data,
            'alokasiPilar'     => $alokasiPilar,
            'alokasiPrioritas' => $alokasiPrioritas,
            'dataPerusahaan'   => $perusahaan,
            'dataPilar'        => $pilar,
            'dataAnggaran'     => $dataAnggaran,
            'tahun'            => $tahun,
            'perusahaan'       => $company,
            'anggaran'         => $nominal,
            'totalAlokasi'     => $total,
            'sisa'             => $sisa,
        ]);
    }

    public function cariPerusahaan(Request $request)
    {
        $this->validate($request, [
            'perusahaan' => 'required',
            'tahun' => 'required',
        ]);

        return redirect()->route('indexProkerPerusahaan', ['year' => $request->tahun, 'company' => encrypt($request->perusahaan)]);
    }

    public function indexPerusahaan($year, $company)
    {
        try {
            $logID = decrypt($company);
        } catch (Exception $e) {
            abort(404);
        }

        $tahun = $year;
        $anggaran = Anggaran::where('tahun', $tahun)->where('perusahaan', $logID)->first();

        if (empty($anggaran->nominal)) {
            $nominal = 0;
        } else {
            $nominal = $anggaran->nominal;
        }

        $data = Proker::where('tahun', $tahun)->where('perusahaan', $logID)->orderBy('id_proker', 'ASC')->orderBy('tahun', 'ASC')->get();
        $jumlahData = Proker::where('tahun', $tahun)->where('perusahaan', $logID)->count();

        $perusahaan = Perusahaan::orderBy('id_perusahaan', 'ASC')->get();

        $totalAlokasi = DB::table('tbl_proker')
            ->select(DB::raw('SUM(anggaran) as total'))
            ->where('tahun', $tahun)
            ->where('perusahaan', $logID)
            ->first();

        $pilar = Pilar::orderBy('kode', 'ASC')->get();
        $gols = SDG::orderBy('id_sdg', 'ASC')->get();
        return view('master.data_proker')
            ->with([
                'dataProker' => $data,
                'jumlahData' => $jumlahData,
                'dataPerusahaan' => $perusahaan,
                'dataPilar' => $pilar,
                'dataGols' => $gols,
                'tahun' => $tahun,
                'comp' => $logID,
                'anggaran' => $nominal,
                'totalAlokasi' => $totalAlokasi->total,
            ]);
    }

    public function create()
    {
        $indikator = SubPilar::orderBy('pilar', 'ASC')->get();
        return view('master.input_proker')
            ->with([
                'dataIndikator' => $indikator
            ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'proker' => 'required|string|max:300',
            'pilar'   => 'required',
            'tpb'   => 'required',
            'tahun'   => 'required|integer',
            'nominalAsli' => 'required|numeric',
            'prioritas'   => 'required',
        ], [
            'proker.required'   => 'Program kerja harus diisi',
            'proker.max'   => 'Program kerja maksimal 200 karakter',
            'pilar.required'   => 'Pilar harus dipilih',
            'tpb.required'   => 'TPB harus dipilih',
            'tahun.required'   => 'Tahun anggaran harus dipilih',
            'nominalAsli.required' => 'Nominal anggaran harus diisi',
            'nominalAsli.numeric'  => 'Nominal harus berupa angka',
        ]);

        $dataProker = [
            'proker' => strtoupper($request->proker),
            'pilar' => $request->pilar,
            'gols' => $request->tpb,
            'anggaran' => $request->nominalAsli,
            'tahun' => $request->tahun,
            'prioritas' => $request->prioritas,
            'id_perusahaan' => session('user')->id_perusahaan,
        ];

        try {
            DB::table('tbl_proker')->insert($dataProker);
            return redirect()->back()->with('berhasil', "Program kerja tahun {$request->tahun} berhasil disimpan");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', "Program kerja tahun {$request->tahun} gagal disimpan");
        }
    }

    public function update(Request $request)
    {
        try {
            $prokerID = decrypt($request->prokerID);
        } catch (Exception $e) {
            abort(404);
        }

        $request->validate([
            'proker' => 'required|string|max:300',
            'pilar' => 'required|string',
            'tpb' => 'required|string',
            'tahun' => 'required|numeric',
            'nominalAsli' => 'required|numeric',
            'prioritas' => 'required|string',
        ], [
            'proker.required'   => 'Program kerja harus diisi',
            'proker.max'   => 'Program kerja maksimal 200 karakter',
            'pilar.required'   => 'Pilar harus dipilih',
            'tpb.required'   => 'TPB harus dipilih',
            'tahun.required'   => 'Tahun anggaran harus dipilih',
            'nominalAsli.required' => 'Nominal anggaran harus diisi',
            'nominalAsli.numeric'  => 'Nominal harus berupa angka',
        ]);

        $dataProker = [
            'proker' => strtoupper($request->proker),
            'pilar' => $request->pilar,
            'gols' => $request->tpb,
            'anggaran' => $request->nominalAsli,
            'tahun' => $request->tahun,
            'prioritas' => $request->prioritas,
        ];

        try {
            Proker::where('id_proker', $prokerID)->update($dataProker);
            return redirect()->back()->with('berhasil', "Program kerja tahun {$request->tahun} berhasil diubah");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Program kerja tahun {$request->tahun} gagal diubah');
        }
    }

    public function delete($id)
    {
        try {
            $prokerID = decrypt($id);
        } catch (Exception $e) {
            abort(404);
        }

        $proker = Proker::find($prokerID);

        if (!$proker) {
            return redirect()->back()->with('gagalDetail', 'Program kerja tidak ditemukan.');
        }

        // Cek relasi satu per satu
        $relatedData = [];

        if ($proker->kelayakan()->exists()) {
            $relatedData[] = 'Kelayakan Proposal';
        }

        if (!empty($relatedData)) {
            $message = 'Tidak dapat menghapus karena masih memiliki data relasi pada ' . implode(', ', $relatedData) . '.';
            return redirect()->back()->with('gagalHapus', $message);
        }

        try {
            Proker::where('id_proker', $prokerID)->delete();
            return redirect()->back()->with('sukses', "Program kerja berhasil dihapus");
        } catch (Exception $e) {
            return redirect()->back()->with('gagalHapus', 'Program kerja gagal dihapus');
        }

        
    }

    public function printProker($year)
    {
        $tahun = $year;
        $anggaran = Anggaran::where('tahun', $tahun)->first();

        $data = Proker::where('tahun', $tahun)->orderBy('id_proker', 'ASC')->orderBy('tahun', 'ASC')->get();
        $jumlahData = Proker::where('tahun', $tahun)->count();

        $totalAlokasi = DB::table('tbl_proker')
            ->select(DB::raw('SUM(anggaran) as total'))
            ->where('tahun', $tahun)
            ->first();

        $pilar = Pilar::orderBy('kode', 'ASC')->get();
        $gols = SDG::orderBy('id_sdg', 'ASC')->get();
        return view('print.proker')
            ->with([
                'dataProker' => $data,
                'jumlahData' => $jumlahData,
                'dataPilar' => $pilar,
                'dataGols' => $gols,
                'tahun' => $tahun,
                'anggaran' => $anggaran->nominal,
                'totalAlokasi' => $totalAlokasi->total,
            ]);
    }

    public function exportProker(Request $request)
    {
        // Ambil filter dari request, atau fallback ke session/tahun saat ini
        $perusahaanID = $request->input('perusahaan', session('user')->id_perusahaan);
        $tahun = $request->input('tahun', date("Y"));

        // Ambil data perusahaan yang dipilih
        $company = Perusahaan::findOrFail($perusahaanID);
        $perusahaan = $company->nama_perusahaan;

        // Ambil data anggaran tahun yang dipilih
        $anggaranQuery = Anggaran::where('id_perusahaan', $perusahaanID);
        if ($tahun) {
            $anggaranQuery->where('tahun', $tahun);
        }
        $anggaran = $anggaranQuery->first();

        $nominal = $anggaran->nominal ?? 0;

        // Query data proker sesuai filter
        $dataQuery = Proker::where('id_perusahaan', $perusahaanID);
        if ($tahun) {
            $dataQuery->where('tahun', $tahun);
        }
        $data = $dataQuery->orderByDesc('id_proker')->get();

        return Excel::download(new ProkerExport($data, $perusahaan, $tahun), 'program-kerja-' . $tahun . '.xlsx');
    }

}
