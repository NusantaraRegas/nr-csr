<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertBASTDana;
use App\Http\Requests\InsertHeader;
use App\Http\Requests\InsertSPK;
use App\Models\BASTDana;
use App\Models\DetailSPK;
use App\Models\Kelayakan;
use App\Models\Provinsi;
use App\Models\SektorBantuan;
use App\Models\SPK;
use App\Models\Survei;
use Illuminate\Http\Request;
use DB;
use Mail;
use Exception;

class SPKController extends Controller
{
    public function inputSPK($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }

        $tanggal = date("d-M-Y");

        $dataSPK = DB::table('v_survei')
            ->select('v_survei.*')
            ->where([
                ['no_agenda', $logID]
            ])
            ->first();

        $bank = DB::table('PGN_PAYMENT.T_MASTER_DATA')
            ->select('T_MASTER_DATA.*')
            ->where('CODE', 'BANK_NAME')
            ->get();

        $approver = DB::table('v_user')
            ->select('v_user.*')
            ->where('status', 'Active')
            ->whereIn('role', [2, 3, 4])
            ->get();

        return view('transaksi.input_spk')
            ->with([
                'data' => $dataSPK,
                'dataBank' => $bank,
                'dataApprover' => $approver,
                'tanggal' => $tanggal,
            ]);
    }

    public function insertSPK(InsertSPK $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date("d-M-Y");

        $dataSPK = [
            'NO_AGENDA' => $request->noAgenda,
            'NO_SPK' => strtoupper($request->noSPK),
            'TGL_SPK' => $request->tglSPK,
            'KEGIATAN' => ucwords($request->judulKegiatan),
            'NAMA' => ucwords($request->nama),
            'JABATAN' => ucwords($request->jabatan),
            'PERUSAHAAN' => ucwords($request->perusahaan),
            'ALAMAT' => ucwords($request->alamat),
            'NO_PENAWARAN' => strtoupper($request->noPenawaran),
            'TGL_PENAWARAN' => $request->tglPenawaran,
            'NO_BERITA_ACARA' => strtoupper($request->noBAST),
            'TGL_BERITA_ACARA' => $request->tglBAST,
            'NOMINAL' => $request->nilaiPengadaan,
            'TERMIN' => $request->termin,
            'RUPIAH1' => $request->rupiah1,
            'RUPIAH2' => $request->rupiah2,
            'RUPIAH3' => $request->rupiah3,
            'RUPIAH4' => $request->rupiah4,
            'NAMA_BANK' => $request->namaBank,
            'CABANG' => $request->cabang,
            'NO_REKENING' => $request->noRekening,
            'ATAS_NAMA' => strtoupper($request->atasNama),
            'DUE_DATE' => $request->tglBatasWaktu,
            'NAMA_PENGADILAN' => ucwords($request->pengadilan),
            'NAMA_PEJABAT' => $request->namaPejabat,
            'JABATAN_PEJABAT' => ucwords($request->jabatanPejabat),
            'STATUS' => 'Draft',
            'CREATED_BY' => session('user')->username,
            'CREATED_DATE' => $tanggal,
        ];

        $dataUpdate = [
            'SPK' => 'Oke',
        ];


        try {
            SPK::create($dataSPK);
            Survei::where('no_agenda', $request->noAgenda)->update($dataUpdate);
            return redirect()->route('detail-kelayakan', encrypt($request->noAgenda))->with('sukses', 'Draft SPK berhasil disimpan');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Draft SPK gagal disimpan');
        }

    }

    public function ubahSPK($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }

        $tanggal = date("d-M-Y");

        $dataSPK = DB::table('tbl_spk')
            ->select('tbl_spk.*')
            ->where([
                ['no_agenda', $logID]
            ])
            ->first();

        $approver = DB::table('v_user')
            ->select('v_user.*')
            ->where('status', 'Active')
            ->whereIn('role', [2, 3, 4])
            ->get();

        $detailSPK = DB::table('TBL_DETAIL_SPK')
            ->select('TBL_DETAIL_SPK.*')
            ->where('no_agenda', $logID)
            ->get();

        return view('transaksi.edit_spk')
            ->with([
                'data' => $dataSPK,
                'dataApprover' => $approver,
                'dataDetailSPK' => $detailSPK,
                'tanggal' => $tanggal,
            ]);
    }

    public function editSPK(InsertSPK $request)
    {
        $dataSPK = [
            'NO_AGENDA' => $request->noAgenda,
            'NO_SPK' => strtoupper($request->noSPK),
            'TGL_SPK' => $request->tglSPK,
            'KEGIATAN' => ucwords($request->judulKegiatan),
            'NAMA' => ucwords($request->nama),
            'JABATAN' => ucwords($request->jabatan),
            'PERUSAHAAN' => ucwords($request->perusahaan),
            'ALAMAT' => ucwords($request->alamat),
            'NO_PENAWARAN' => strtoupper($request->noPenawaran),
            'TGL_PENAWARAN' => $request->tglPenawaran,
            'NO_BERITA_ACARA' => strtoupper($request->noBAST),
            'TGL_BERITA_ACARA' => $request->tglBAST,
            'NOMINAL' => $request->nilaiPengadaan,
            'TERMIN' => $request->termin,
            'RUPIAH1' => $request->rupiah1,
            'RUPIAH2' => $request->rupiah2,
            'RUPIAH3' => $request->rupiah3,
            'RUPIAH4' => $request->rupiah4,
            'NAMA_BANK' => $request->namaBank,
            'CABANG' => $request->cabang,
            'NO_REKENING' => $request->noRekening,
            'ATAS_NAMA' => strtoupper($request->atasNama),
            'DUE_DATE' => $request->tglBatasWaktu,
            'NAMA_PENGADILAN' => ucwords($request->pengadilan),
            'NAMA_PEJABAT' => $request->namaPejabat,
            'JABATAN_PEJABAT' => ucwords($request->jabatanPejabat),
        ];

        try {
            SPK::where('no_agenda', $request->noAgenda)->update($dataSPK);
            return redirect()->route('detail-kelayakan', encrypt($request->noAgenda))->with('sukses', 'Draft SPK berhasil diubah');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Draft SPK gagal diubah');
        }

    }

    public function insertHeader(InsertHeader $request)
    {
        try {
            $logID = decrypt($request->noAgenda);
        } catch (Exception $e) {
            abort(404);
        }

        $dataSPK = [
            'HEADER1' => ucwords($request->header1),
            'HEADER2' => ucwords($request->header2),
            'HEADER3' => ucwords($request->header3),
        ];

        try {
            SPK::where('no_agenda', $logID)->update($dataSPK);
            return redirect()->back()->with('sukses', 'Buat tabel rincian');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Header tabel gagal disimpan');
        }

    }

    public function insertDetailSPK(InsertHeader $request)
    {
        try {
            $logID = decrypt($request->noAgenda);
        } catch (Exception $e) {
            abort(404);
        }

        $dataDetail = [
            'NO_AGENDA' => $logID,
            'COLUMN1' => $request->header1,
            'COLUMN2' => $request->header2,
            'COLUMN3' => $request->header3,
        ];

        try {
            DetailSPK::create($dataDetail);
            return redirect()->back();
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Gagal menambahkan kolom');
        }

    }

    public function deleteSPK($loginID)
    {

        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }

        $dataUpdate = [
            'SPK' => ''
        ];

        SPK::where('no_agenda', $logID)->delete();
        Survei::where('no_agenda', $logID)->update($dataUpdate);
        return redirect()->back()->with('sukses', 'Dokumen SPK berhasil dihapus');
    }

    public function formSPK($loginID)
    {
        $data = DB::table('V_SPK')
            ->select('V_SPK.*')
            ->where('ID_KELAYAKAN', $loginID)
            ->first();

        $detailSPK = DB::table('TBL_DETAIL_SPK')
            ->select('TBL_DETAIL_SPK.*')
            ->where('no_agenda', $data->no_agenda)
            ->get();

        return view('form.spk')
            ->with([
                'data' => $data,
                'dataDetailSPK' => $detailSPK,
            ]);
    }
}