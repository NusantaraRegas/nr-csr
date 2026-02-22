<?php

namespace App\Services\Dashboard;

use App\Models\Anggaran;
use App\Models\Perusahaan;
use Illuminate\Support\Facades\DB;

class DashboardOverviewService
{
    public function build(int $perusahaanID, $tahun): array
    {
        $company = Perusahaan::findOrFail($perusahaanID);

        $budget = Anggaran::where('id_perusahaan', $perusahaanID)
            ->where('tahun', $tahun)
            ->first();

        $realisasi = DB::table('v_pembayaran')
            ->select(DB::raw('SUM(subtotal) as total'))
            ->where('tahun', $tahun)
            ->first();

        $totalRealisasi = $realisasi->total ?? 0;
        $sisa = $budget->nominal - $totalRealisasi;

        $realisasiPilar = DB::table('v_pembayaran')
            ->select('pilar', DB::raw('SUM(subtotal) as total'))
            ->where('tahun', $tahun)
            ->groupBy('pilar')
            ->get();

        $realisasiPrioritas = DB::table('v_pembayaran')
            ->select('prioritas', DB::raw('SUM(subtotal) as total'))
            ->where('tahun', $tahun)
            ->groupBy('prioritas')
            ->get();

        $dataRealisasi = DB::table('v_pembayaran')
            ->selectRaw("TO_CHAR(approve_date, 'MM') as bulan, SUM(subtotal) as total")
            ->whereRaw("EXTRACT(YEAR FROM approve_date) = ?", [$tahun])
            ->groupBy(DB::raw("TO_CHAR(approve_date, 'MM')"))
            ->get();

        $dataTotalPilar = $realisasiPilar->map(function ($row) use ($tahun) {
            return [
                'name' => $row->pilar ?: 'Tanpa Pilar',
                'y' => (float) $row->total,
                'url' => route('indexPembayaran', ['tahun' => $tahun, 'pilar' => $row->pilar]),
            ];
        })->toArray();

        $dataTotalPrioritas = $realisasiPrioritas->map(function ($row) use ($tahun) {
            return [
                'name' => $row->prioritas ?: 'Tanpa Prioritas',
                'y' => (float) $row->total,
                'url' => route('indexPembayaran', ['tahun' => $tahun, 'prioritas' => $row->prioritas]),
            ];
        })->toArray();

        $bulanIndo = [
            '01' => 'Jan',
            '02' => 'Feb',
            '03' => 'Mar',
            '04' => 'Apr',
            '05' => 'Mei',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Agu',
            '09' => 'Sep',
            '10' => 'Okt',
            '11' => 'Nov',
            '12' => 'Des',
        ];

        $realisasiDefault = collect($bulanIndo)->map(function ($label, $kode) {
            return [
                'code' => $kode,
                'name' => $label,
                'total' => 0,
            ];
        });

        $realisasiPerBulan = $realisasiDefault->map(function ($item) use ($dataRealisasi) {
            $found = $dataRealisasi->firstWhere('bulan', $item['code']);

            return [
                'name' => $item['name'],
                'y' => $found ? (float) $found->total : 0,
            ];
        })->values();

        $dataAnggaran = Anggaran::where('id_perusahaan', $perusahaanID)
            ->orderByDesc('tahun')
            ->get();

        $anggaranAP = DB::table('tbl_anggaran as a')
            ->join('tbl_perusahaan as p', 'a.id_perusahaan', '=', 'p.id_perusahaan')
            ->select('a.id_perusahaan', 'p.nama_perusahaan', 'a.nominal')
            ->where('a.tahun', $tahun)
            ->whereNotIn('a.id_perusahaan', [1])
            ->get();

        $realisasiAP = DB::table('tbl_realisasi_ap as r')
            ->select('r.id_perusahaan', DB::raw('SUM(r.nilai_bantuan) as nilai_realisasi'))
            ->where('r.tahun', $tahun)
            ->groupBy('r.id_perusahaan')
            ->get()
            ->keyBy('id_perusahaan');

        $categories = [];
        $anggaranData = [];
        $realisasiData = [];

        foreach ($anggaranAP as $row) {
            $categories[] = $row->nama_perusahaan;
            $anggaranData[] = (int) $row->nominal;
            $realisasiData[] = isset($realisasiAP[$row->id_perusahaan])
                ? (int) $realisasiAP[$row->id_perusahaan]->nilai_realisasi
                : 0;
        }

        return [
            'tahun' => $tahun,
            'anggaran' => $budget->nominal,
            'perusahaan' => $company,
            'realisasi' => $totalRealisasi,
            'sisa' => $sisa,
            'dataAnggaran' => $dataAnggaran,
            'dataTotalPilar' => $dataTotalPilar,
            'dataTotalPrioritas' => $dataTotalPrioritas,
            'realisasiPerBulan' => $realisasiPerBulan,
            'categories' => $categories,
            'anggaranData' => $anggaranData,
            'realisasiData' => $realisasiData,
        ];
    }
}
