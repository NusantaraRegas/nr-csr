<?php

namespace App\Http\Controllers;

use App\Helper\APIHelper;
use App\Http\Requests\InsertBASTDana;
use Carbon\Carbon;
use App\Models\BASTDana;
use App\Models\Kelayakan;
use App\Models\ViewProposal;
use App\Models\Provinsi;
use App\Models\SektorBantuan;
use App\Models\Survei;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Mail;
use Exception;

class BASTController extends Controller
{
    public function inputBASTDana($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }

        $tanggal = date("d-M-Y");

        $dataBAST = DB::table('v_survei')
            ->select('v_survei.*')
            ->where([
                ['no_agenda', $logID]
            ])
            ->first();

        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();

        $release = APIHelper::instance()->apiCall('GET', env('BASEURL') . '/api/APIPaymentRequest/form/bank/2312', '');
        $return = json_decode(strstr($release, '{'), true);
        $bank = $return['dataBank'];
        $city = $return['dataCity'];

//        $bank = DB::table('PGN_PAYMENT.T_MASTER_DATA')
//            ->select('T_MASTER_DATA.*')
//            ->where('CODE', 'BANK_NAME')
//            ->get();

        $approver = DB::table('tbl_user')
            ->select('tbl_user.*')
            ->where('status', 'Active')
            ->whereIn('role', ['Manager', 'Supervisor 1'])
            ->get();

        return view('transaksi.input_bast_dana')
            ->with([
                'data' => $dataBAST,
                'dataProvinsi' => $provinsi,
                'dataBank' => $bank,
                'dataCity' => $city,
                'dataApprover' => $approver,
                'tanggal' => $tanggal,
            ]);
    }

    public function store(Request $request)
    {
        try {
            $kelayakanID = decrypt($request->kelayakanID);
        } catch (Exception $e) {
            abort(404);
        }

        $request->validate([
            'noBAST' => 'nullable|max:100',
            'tglBAST' => 'nullable|date',
            'noPihakKedua' => 'nullable|max:100',
            'approver' => 'required|max:200',
            'jabatan' => 'required|max:200',
        ], [
            'noBAST.max' => 'No BAST maksimal 100 karakter',
            'tglBAST.date' => 'Format tanggal penerimaan tidak valid',
            'noPihakKedua.max' => 'No BAST maksimal 100 karakter',
            'approver.required' => 'Pengirim harus diisi',
            'approver.max' => 'Nama approver maksimal 200 karakter',
            'jabatan.required' => 'Nomor surat harus diisi',
            'jabatan.max' => 'Jabatan approver maksimal 200 karakter',
        ]);

        $kelayakan = ViewProposal::where('id_kelayakan', $kelayakanID)->where('status', 'Approved')->first();

        if (!$kelayakan) {
            return redirect()->back()->with('gagalDetail', 'Data kelayakan belum disetujui.');
        }

        $dataBAST = [
            'ID_KELAYAKAN' => $kelayakan->id_kelayakan,
            'NO_AGENDA' => $kelayakan->no_agenda,
            'NO_BAST_DANA' => strtoupper($request->noBAST),
            'NO_BAST_PIHAK_KEDUA' => strtoupper($request->noPihakKedua),
            'TGL_BAST' => $request->filled('tglBAST') 
            ? Carbon::parse($request->tglBAST)->format('Y-m-d') 
            : null,
            'PILAR' => $kelayakan->pilar,
            'BANTUAN_UNTUK' => ucwords($kelayakan->bantuan_untuk),
            'PROPOSAL_DARI' => ucwords($kelayakan->nama_lembaga),
            'ALAMAT' => ucwords($kelayakan->alamat),
            'PROVINSI' => $kelayakan->provinsi,
            'KABUPATEN' => $kelayakan->kabupaten,
            'PENANGGUNG_JAWAB' => ucwords($kelayakan->nama_pic),
            'BERTINDAK_SEBAGAI' => ucwords($kelayakan->jabatan),
            'NO_SURAT' => strtoupper($kelayakan->no_surat),
            'TGL_SURAT' => $kelayakan->tgl_surat,
            'PERIHAL' => ucwords($kelayakan->perihal),
            'NAMA_BANK' => $kelayakan->nama_bank,
            'NO_REKENING' => $kelayakan->no_rekening,
            'ATAS_NAMA' => strtoupper($kelayakan->atas_nama),
            'APPROVER_ID' => $request->approver,
            'JABATAN_PEJABAT' => ucwords($request->jabatan),
            'CREATED_BY' => session('user')->username,
            'CREATED_DATE' => now(),
            'STATUS' => 'Submited',
        ];

        try {
            DB::table('tbl_bast_dana')->insert($dataBAST);
            return redirect()->back()->with('suksesDetail', 'Dokumen BAST berhasil disimpan');
        } catch (Exception $e) {
            return redirect()->back()->with('gagalDetail', 'Dokumen BAST gagal disimpan');
        }

    }

    public function ubahBASTDana($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }

        $tanggal = date("d-M-Y");

        $dataBAST = DB::table('v_survei')
            ->select('v_survei.*')
            ->where([
                ['no_agenda', $logID]
            ])
            ->first();

        $dataBASTDana = DB::table('v_bast_dana')
            ->select('v_bast_dana.*')
            ->where([
                ['no_agenda', $logID]
            ])
            ->first();


        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();

        $release = APIHelper::instance()->apiCall('GET', env('BASEURL') . '/api/APIPaymentRequest/form/bank/2312', '');
        $return = json_decode(strstr($release, '{'), true);
        $bank = $return['dataBank'];
        $city = $return['dataCity'];

//        $bank = DB::table('PGN_PAYMENT.T_MASTER_DATA')
//            ->select('T_MASTER_DATA.*')
//            ->where('CODE', 'BANK_NAME')
//            ->get();

        $approver = DB::table('tbl_user')
            ->select('tbl_user.*')
            ->where('status', 'Active')
            ->whereIn('role', ['Manager', 'Supervisor 1'])
            ->get();

        return view('transaksi.ubah_bast')
            ->with([
                'data' => $dataBAST,
                'dataBAST' => $dataBASTDana,
                'dataProvinsi' => $provinsi,
                'dataBank' => $bank,
                'dataCity' => $city,
                'dataApprover' => $approver,
                'tanggal' => $tanggal,
            ]);
    }

    public function update(Request $request)
    {
        try {
            $bastID = decrypt($request->bastID);
        } catch (Exception $e) {
            abort(404);
        }

        $request->validate([
            'noBAST' => 'nullable|max:100',
            'tglBAST' => 'nullable|date',
            'noPihakKedua' => 'nullable|max:100',
            'approver' => 'required|max:200',
            'jabatan' => 'required|max:200',
        ], [
            'noBAST.max' => 'No BAST maksimal 100 karakter',
            'tglBAST.date' => 'Format tanggal penerimaan tidak valid',
            'noPihakKedua.max' => 'No BAST maksimal 100 karakter',
            'approver.required' => 'Pengirim harus diisi',
            'approver.max' => 'Nama approver maksimal 200 karakter',
            'jabatan.required' => 'Nomor surat harus diisi',
            'jabatan.max' => 'Jabatan approver maksimal 200 karakter',
        ]);

        $bast = BASTDana::findOrFail($bastID);

        if (!$bast) {
            return redirect()->back()->with('gagalDetail', 'Berita acara tidak ditemukan.');
        }

        $kelayakan = ViewProposal::where('id_kelayakan', $bast->id_kelayakan)->where('status', 'Approved')->first();

        $dataBAST = [
            'ID_KELAYAKAN' => $kelayakan->id_kelayakan,
            'NO_AGENDA' => $kelayakan->no_agenda,
            'NO_BAST_DANA' => strtoupper($request->noBAST),
            'NO_BAST_PIHAK_KEDUA' => strtoupper($request->noPihakKedua),
            'TGL_BAST' => $request->filled('tglBAST') 
            ? Carbon::parse($request->tglBAST)->format('Y-m-d') 
            : null,
            'PILAR' => $kelayakan->pilar,
            'BANTUAN_UNTUK' => ucwords($kelayakan->bantuan_untuk),
            'PROPOSAL_DARI' => ucwords($kelayakan->nama_lembaga),
            'ALAMAT' => ucwords($kelayakan->alamat),
            'PROVINSI' => $kelayakan->provinsi,
            'KABUPATEN' => $kelayakan->kabupaten,
            'PENANGGUNG_JAWAB' => ucwords($kelayakan->nama_pic),
            'BERTINDAK_SEBAGAI' => ucwords($kelayakan->jabatan),
            'NO_SURAT' => strtoupper($kelayakan->no_surat),
            'TGL_SURAT' => $kelayakan->tgl_surat,
            'PERIHAL' => ucwords($kelayakan->perihal),
            'NAMA_BANK' => $kelayakan->nama_bank,
            'NO_REKENING' => $kelayakan->no_rekening,
            'ATAS_NAMA' => strtoupper($kelayakan->atas_nama),
            'APPROVER_ID' => $request->approver,
            'JABATAN_PEJABAT' => ucwords($request->jabatan),
        ];


       try {
            DB::table('tbl_bast_dana')
                ->where('id_bast_dana', $bastID)
                ->update($dataBAST);
        return redirect()->back()->with('suksesDetail', 'Dokumen BAST berhasil diperbaharui');
       } catch (Exception $e) {
           return redirect()->back()->with('gagalDetail', 'Dokumen BAST gagal diperbaharui');
       }

    }

    public function delete($id)
    {
        try {
            $bastID = decrypt($id);
        } catch (Exception $e) {
            abort(404);
        }

        BASTDana::where('id_bast_dana', $bastID)->delete();
        return redirect()->back()->with('suksesDetail', 'Dokumen BAST berhasil dihapus');
    }

    public function formBASTDana($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }

        $data = DB::table('V_BAST')
            ->select('V_BAST.*')
            ->where('ID_KELAYAKAN', $logID)
            ->first();


        return view('form.bast_dana')
            ->with([
                'data' => $data,
            ]);
    }

    public function formBASTDana2($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }

        $data = DB::table('V_BAST')
            ->select('V_BAST.*')
            ->where('ID_KELAYAKAN', $logID)
            ->first();


        return view('form.bast_dana2')
            ->with([
                'data' => $data,
            ]);
    }

    public function formBASTIdulAdha($loginID)
    {
        $data = DB::table('V_BAST_DANA')
            ->select('V_BAST_DANA.*')
            ->where('ID_KELAYAKAN', $loginID)
            ->first();
        
        $noAgenda = Kelayakan::where('id_kelayakan', $loginID)->first();

        $jumlahHewan = DB::table('tbl_sub_proposal')
            ->select(DB::raw('sum(kambing) as kambing, sum(sapi) as sapi'))
            ->where([
                ['no_agenda', '=', $noAgenda->no_agenda],
            ])
            ->first();

        return view('form.bast_idul_adha')
            ->with([
                'data' => $data,
                'jumlahKambing' => $jumlahHewan->kambing,
                'jumlahSapi' => $jumlahHewan->sapi,
            ]);
    }
}