<?php

namespace App\Services\Pembayaran;

use App\Models\Kelayakan;
use App\Models\Proker;
use Exception;
use Illuminate\Support\Facades\DB;

class PembayaranUpsertService
{
    public function store($kelayakanID, array $data, $username)
    {
        $kelayakan = Kelayakan::findOrFail($kelayakanID);

        $proker = Proker::where('id_proker', $kelayakan->id_proker)->first();

        if (!$proker) {
            return redirect()->back()->with('gagalDetail', 'Program kerja belum ditambahkan.');
        }

        $feeDalamRupiah = ($data['jumlahPembayaranAsli'] * $data['fee']) / 100;
        $subTotal = $data['jumlahPembayaranAsli'] + $feeDalamRupiah;

        if ($data['metode'] == 'Popay') {
            $dataPembayaran = [
                'id_kelayakan' => $kelayakanID,
                'deskripsi' => $data['deskripsi'],
                'termin' => $data['termin'],
                'metode' => $data['metode'],
                'nilai_approved' => $kelayakan->nominal_approved,
                'jumlah_pembayaran' => $data['jumlahPembayaranAsli'],
                'fee' => $feeDalamRupiah,
                'fee_persen' => $data['fee'],
                'subtotal' => $subTotal,
                'status' => 'Open',
                'create_date' => now(),
                'create_by' => $username,
            ];
        } elseif ($data['metode'] == 'YKPP') {
            $dataPembayaran = [
                'id_kelayakan' => $kelayakanID,
                'deskripsi' => $data['deskripsi'],
                'termin' => $data['termin'],
                'metode' => $data['metode'],
                'nilai_approved' => $kelayakan->nominal_approved,
                'jumlah_pembayaran' => $data['jumlahPembayaranAsli'],
                'fee' => $feeDalamRupiah,
                'fee_persen' => $data['fee'],
                'subtotal' => $subTotal,
                'status' => 'Open',
                'create_date' => now(),
                'create_by' => $username,
                'status_ykpp' => 'Open',
                'tahun_ykpp' => $proker->tahun,
            ];
        } else {
            return redirect()->back()->with('gagalDetail', 'Metode pembayaran belum ditentukan.');
        }

        $exists = DB::table('tbl_pembayaran')
            ->where('id_kelayakan', $kelayakanID)
            ->where('termin', $data['termin'])
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

    public function update($pembayaranID, array $data)
    {
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

        $statusYKPP = empty($pembayaran->status_ykpp) ? 'Open' : $pembayaran->status_ykpp;
        $feeAsli = ($data['jumlahPembayaranAsli'] * $data['fee']) / 100;
        $subTotal = $data['jumlahPembayaranAsli'] + $feeAsli;

        $dataUpdate = [
            'deskripsi' => $data['deskripsi'],
            'termin' => $data['termin'],
            'metode' => $data['metode'],
            'jumlah_pembayaran' => $data['jumlahPembayaranAsli'],
            'fee' => $feeAsli,
            'fee_persen' => $data['fee'],
            'subtotal' => $subTotal,
            'status_ykpp' => $statusYKPP,
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
}
