<?php

namespace App\Services\SubProposal;

use App\Models\SubProposal;
use Exception;
use Illuminate\Support\Facades\DB;

class StoreSubProposalService
{
    public function handle(array $data)
    {
        $validasi = SubProposal::where('no_agenda', $data['noAgenda'])
            ->where('nama_lembaga', $data['namaLembaga'])
            ->count();

        if ($validasi > 0) {
            return redirect()->back()->with('gagal', "{$data['namaLembaga']} Sudah ada");
        }

        $nomor = SubProposal::where('no_agenda', $data['noAgenda'])->count();
        $nomorUrut = $nomor + 1;
        $nomorSubAgenda = $data['noAgenda'] . '.' . $nomorUrut;

        $hargaKambing = (int) str_replace('.', '', (string) ($data['hargaKambing'] ?? 0));
        $hargaSapi = (int) str_replace('.', '', (string) ($data['hargaSapi'] ?? 0));

        $totalKambing = (int) ($data['kambing'] ?? 0) * $hargaKambing;
        $totalSapi = (int) ($data['sapi'] ?? 0) * $hargaSapi;

        $subTotal = $totalKambing + $totalSapi;
        $fee = $subTotal * 10 / 100;
        $ppn = $fee * 10 / 100;
        $grandTotal = $subTotal + $fee + $ppn;

        $dataSubProposal = [
            'no_agenda' => $data['noAgenda'],
            'no_sub_agenda' => $nomorSubAgenda,
            'nama_ketua' => $data['namaKetua'],
            'nama_lembaga' => $data['namaLembaga'],
            'kambing' => $data['kambing'] ?? 0,
            'harga_kambing' => $hargaKambing,
            'sapi' => $data['sapi'] ?? 0,
            'harga_sapi' => $hargaSapi,
            'total' => $subTotal,
            'fee' => $fee,
            'ppn' => $ppn,
            'subtotal' => $grandTotal,
            'alamat' => $data['alamat'],
            'provinsi' => $data['provinsi'],
            'kabupaten' => $data['kabupaten'],
        ];

        try {
            DB::table('tbl_sub_proposal')->insert($dataSubProposal);

            return redirect()->route('dataSubProposal', encrypt($data['noAgenda']))
                ->with('sukses', 'Sub Proposal berhasil disimpan');
        } catch (Exception $e) {
            report($e);

            return redirect()->back()->with('gagal', 'Sub Proposal gagal disimpan');
        }
    }
}
