<?php

namespace App\Http\Controllers;

use App\Models\BASTDana;
use App\Models\Survei;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Mail;
use Exception;

class TasklistLegalController extends Controller
{
    public function tasklistLegal()
    {
        //BAST
        $taskBAST = DB::table('V_BAST_DANA')
            ->select('V_BAST_DANA.*')
            ->where('status','Submited')
            ->orderBy('id_bast_dana', 'DESC')
        ->get();
        $JumlahTaskBAST = DB::table('V_BAST_DANA')
            ->select(DB::raw('count(*) as jumlah'))
            ->where('status','Submited')
            ->first();
        return view('home.tasklist_legal')
            ->with([
                'dataTaskBAST' => $taskBAST,
                'JumlahTaskBAST' => $JumlahTaskBAST,
            ]);
    }

    public function approveBAST($loginID)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date("d-M-Y");

        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }

        $dataUpdate = [
            'status' => 'Approved',
            'approved_by' => session('user')->username,
            'approved_date' => $tanggal,
        ];

        $dataBAST = DB::table('V_BAST_DANA')
            ->select('V_BAST_DANA.*')
            ->where('no_agenda', $logID)
            ->first();
        $surveyor = User::where('username', $dataBAST->survei1)->first();

        $dataEmail = [
            'noAgenda' => $dataBAST->no_agenda,
            'sektorBantuan' => ucwords($dataBAST->sektor_bantuan),
            'bantuanUntuk' => ucwords($dataBAST->bantuan_untuk),
            'proposalDari' => ucwords($dataBAST->proposal_dari),
            'perihal' => ucwords($dataBAST->perihal),
            'penerima' => $surveyor->nama,
        ];

        try {
            Mail::send('mail.approve_bast', $dataEmail, function ($message) use ($surveyor) {
                $message->to($surveyor->email, $surveyor->nama)
                    ->subject('Verifikasi BAST')
                    ->from('no.reply@pgn.co.id', 'PGN SHARE');
            });

            BASTDana::where('no_agenda', $logID)->update($dataUpdate);
            return redirect()->back()->with('sukses', 'Dokumen BAST berhasil diverifikasi');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Dokumen BAST gagal diverifikasi');
        }
    }
}
