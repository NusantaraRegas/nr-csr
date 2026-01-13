<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApproveEvaluator;
use App\Models\Kelayakan;
use App\Models\ViewEvaluasi;
use Illuminate\Http\Request;
use App\Models\Evaluasi;
use App\Models\Survei;
use App\Models\User;
use App\Http\Requests\ApproveEvaluasiKadep;
use App\Http\Requests\ApproveEvaluasiKadiv;
use DB;
use Illuminate\Support\Facades\Session;
use Mail;
use Exception;

class TasklistController extends Controller
{
    public function index()
    {
        date_default_timezone_set("Asia/Jakarta");
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

        $username = session('user')->username;

        $evaluator2 = DB::table('v_evaluasi')
            ->select('v_evaluasi.*')
            ->where([
                ['evaluator2', $username],
                ['status', 'Forward'],
            ])
            ->orderBy('id_evaluasi', 'DESC')
            ->get();

        $jumlahEvaluator2 = DB::table('v_evaluasi')
            ->select(DB::raw('count(*) as jumlah'))
            ->where([
                ['evaluator2', $username],
                ['status', 'Forward'],
            ])
            ->first();

        $kadep = DB::table('v_evaluasi')
            ->select('v_evaluasi.*')
            ->where([
                ['kadep', $username],
                ['status', 'Approved 1'],
            ])
            ->orderBy('id_evaluasi', 'DESC')
            ->get();

        $jumlahKadep = DB::table('v_evaluasi')
            ->select(DB::raw('count(*) as jumlah'))
            ->where([
                ['kadep', $username],
                ['status', 'Approved 1'],
            ])
            ->first();

        $kadiv = DB::table('v_evaluasi')
            ->select('v_evaluasi.*')
            ->where([
                ['kadiv', $username],
                ['status', 'Approved 2'],
            ])
            ->orderBy('id_evaluasi', 'DESC')
            ->get();

        $jumlahKadiv = DB::table('v_evaluasi')
            ->select(DB::raw('count(*) as jumlah'))
            ->where([
                ['kadiv', $username],
                ['status', 'Approved 2'],
            ])
            ->first();

        $jumlahTask = $jumlahEvaluator2->jumlah + $jumlahKadep->jumlah + $jumlahKadiv->jumlah;

        $surveyor2 = DB::table('v_survei')
            ->select('v_survei.*')
            ->where([
                ['survei2', $username],
                ['status', 'Forward'],
            ])
            ->orderBy('id_survei', 'DESC')
            ->get();

        $jumlahSurveyor2 = DB::table('v_survei')
            ->select(DB::raw('count(*) as jumlah'))
            ->where([
                ['survei2', $username],
                ['status', 'Forward'],
            ])
            ->first();

        $kadepSurvei = DB::table('v_survei')
            ->select('v_survei.*')
            ->where([
                ['kadiv', $username],
                ['status', 'Approved 2'],
            ])
            ->orderBy('id_survei', 'DESC')
            ->get();

        $jumlahKadepSurvei = DB::table('v_survei')
            ->select(DB::raw('count(*) as jumlah'))
            ->where([
                ['kadep', $username],
                ['status', 'Approved 1'],
            ])
            ->first();

        $kadivSurvei = DB::table('v_survei')
            ->select('v_survei.*')
            ->where([
                ['kadiv', $username],
                ['status', 'Approved 2'],
            ])
            ->orderBy('id_survei', 'DESC')
            ->get();

        $jumlahKadivSurvei = DB::table('v_survei')
            ->select(DB::raw('count(*) as jumlah'))
            ->where([
                ['kadiv', $username],
                ['status', 'Approved 2'],
            ])
            ->first();


        $jumlahTaskSurvei = $jumlahSurveyor2->jumlah + $jumlahKadepSurvei->jumlah + $jumlahKadivSurvei->jumlah;

        return view('tasklist.evaluasi')
            ->with([
                'username' => $username,
                'dataEvaluator2' => $evaluator2,
                'jumlahEvaluator2' => $jumlahEvaluator2->jumlah,
                'dataKadep' => $kadep,
                'jumlahKadep' => $jumlahKadep->jumlah,
                'dataKadiv' => $kadiv,
                'jumlahKadiv' => $jumlahKadiv->jumlah,
                'dataSurvei2' => $surveyor2,
                'jumlahSurvei2' => $jumlahSurveyor2->jumlah,
                'dataKadepSurvei' => $kadepSurvei,
                'jumlahKadepSurvei' => $jumlahKadepSurvei->jumlah,
                'dataKadivSurvei' => $kadivSurvei,
                'jumlahKadivSurvei' => $jumlahKadivSurvei->jumlah,
                'jumlahTask' => $jumlahTask,
                'jumlahTaskSurvei' => $jumlahTaskSurvei,
            ]);
    }

    public function tasklistEvaluasi()
    {
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

        $username = session('user')->username;

        if (session('user')->role == 'Manager') {
            $data = ViewEvaluasi::where('kadiv', $username)
                ->where('status', 'Approved 2')
                ->orderBy('id_evaluasi', 'DESC')
                ->get();

            $jumlahData = ViewEvaluasi::where('kadiv', $username)
                ->where('status', 'Approved 2')
                ->count();
        } elseif (session('user')->role == 'Supervisor 1') {
            $data = ViewEvaluasi::where('kadep', $username)
                ->where('status', 'Approved 1')
                ->orderBy('id_evaluasi', 'DESC')
                ->get();

            $jumlahData = ViewEvaluasi::where('kadep', $username)
                ->where('status', 'Approved 1')
                ->count();
        }else{
            $data = ViewEvaluasi::where('kadep', $username)
                ->where('status', 'Approved 1')
                ->orderBy('id_evaluasi', 'DESC')
                ->get();
            $jumlahData = 0;
        }

        return view('home.tasklist_evaluasi')
            ->with([
                'username' => $username,
                'dataEvaluasi' => $data,
                'jumlahData' => $jumlahData,
            ]);
    }

    public function todo()
    {
        date_default_timezone_set("Asia/Jakarta");
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

        $username = session('user')->username;

        $data = DB::select("SELECT * FROM V_EVALUASI WHERE (EVALUATOR1 = '$username' AND STATUS = 'Survei') OR (EVALUATOR2 = '$username' AND STATUS = 'Survei')");
        $jumlahData = DB::select("SELECT COUNT(*) AS JUMLAH FROM V_EVALUASI WHERE (EVALUATOR1 = '$username' AND STATUS = 'Survei') OR (EVALUATOR2 = '$username' AND STATUS = 'Survei')");

        return view('home.todo')
            ->with([
                'dataEvaluasi' => $data,
                'jumlahData' => $jumlahData[0]->jumlah,
            ]);
    }

    public function approveEvaluator($evaluasiID, $catatan)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("Y-m-d");

        $dataEvaluasi = DB::table('v_evaluasi')
            ->select('v_evaluasi.*')
            ->whereIn('id_evaluasi', explode(",", $evaluasiID))
            ->get();

        foreach ($dataEvaluasi as $e) {
            #SEND EMAIL
            $evaluator1 = User::where('username', $e->evaluator1)->first();
            $evaluator2 = User::where('username', $e->evaluator2)->first();
            $kadep = User::where('role', 'Supervisor 1')->first();

            $data[] = [
                [
                    $dataEmail = [
                        'no_agenda' => $e->no_agenda,
                        'pengirim' => $e->pengirim,
                        'tgl_terima' => $e->tgl_terima,
                        'dari' => $e->asal_surat,
                        'no_surat' => $e->no_surat,
                        'tgl_surat' => $e->tgl_surat,
                        'sektor' => $e->sektor_bantuan,
                        'perihal' => $e->perihal,
                        'permohonan' => $e->nilai_pengajuan,
                        'bantuan' => $e->nilai_bantuan,
                        'evaluator1' => $evaluator1->nama,
                        'evaluator2' => $evaluator2->nama,
                        'penerima' => $kadep->nama,
                    ],

                    $dataUpdate = [
                        'status' => 'Approved 1',
                        'catatan2' => $catatan,
                        'approve_date' => $tanggalMenit,
                    ],


//                    Mail::send('mail.approval_evaluator', $dataEmail, function ($message) use ($kadep) {
//                        $message->to($kadep->email, $kadep->nama)
//                            ->subject('Evaluasi Proposal')
//                            ->from('pgn.no.reply@pertamina.com', 'NR SHARE');
//                    }),

                    #UPDATE EVALUASI
                    Evaluasi::whereIn('id_evaluasi', explode(",", $evaluasiID))->update($dataUpdate),
                ]
            ];

            return redirect()->back()->with('berhasil', 'Evaluasi proposal berhasil disetujui');
        }

    }

    public function approveKadep($evaluasiID, $catatan, $status)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("Y-m-d");

        $dataEvaluasi = DB::table('v_evaluasi')
            ->select('v_evaluasi.*')
            ->whereIn('id_evaluasi', explode(",", $evaluasiID))
            ->get();

        foreach ($dataEvaluasi as $e) {

            #SEND EMAIL
            $evaluator1 = User::where('username', $e->evaluator1)->first();
            $evaluator2 = User::where('username', $e->evaluator2)->first();
            $kadiv = User::where('role', 'Manager')->first();

            $data[] = [
                [
                    $dataEmail = [
                        'no_agenda' => $e->no_agenda,
                        'pengirim' => $e->pengirim,
                        'tgl_terima' => $e->tgl_terima,
                        'dari' => $e->asal_surat,
                        'no_surat' => $e->no_surat,
                        'tgl_surat' => $e->tgl_surat,
                        'sektor' => $e->sektor_bantuan,
                        'perihal' => $e->perihal,
                        'permohonan' => $e->nilai_pengajuan,
                        'bantuan' => $e->nilai_bantuan,
                        'evaluator1' => $evaluator1->nama,
                        'evaluator2' => $evaluator2->nama,
                        'penerima' => $kadiv->nama,
                    ],

                    $dataUpdate = [
                        'status' => $status,
                        'ket_kadin1' => $catatan,
                        'approve_kadep' => $tanggalMenit,
                    ],

//                    Mail::send('mail.approval_evaluator', $dataEmail, function ($message) use ($kadiv) {
//                        $message->to($kadiv->email, $kadiv->nama)
//                            ->subject('Evaluasi Proposal')
//                            ->from('pgn.no.reply@pertamina.com', 'NR SHARE');
//                    }),

                    #UPDATE EVALUASI
                    Evaluasi::whereIn('id_evaluasi', explode(",", $evaluasiID))->update($dataUpdate),
                ]
            ];

            return redirect()->back()->with('berhasil', 'Evaluasi proposal berhasil disetujui');
        }

    }

    public function approveKadiv($evaluasiID, $catatan, $status)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("Y-m-d");

        $dataEvaluasi = DB::table('v_evaluasi')
            ->select('v_evaluasi.*')
            ->whereIn('id_evaluasi', explode(",", $evaluasiID))
            ->get();

        foreach ($dataEvaluasi as $e) {

            #SEND EMAIL
            $evaluator1 = User::where('username', $e->evaluator1)->first();
            $evaluator2 = User::where('username', $e->evaluator2)->first();

            if ($status == 'Survei') {
                $data[] = [
                    [
                        $dataEmail = [
                            'no_agenda' => $e->no_agenda,
                            'pengirim' => $e->pengirim,
                            'tgl_terima' => $e->tgl_terima,
                            'dari' => $e->asal_surat,
                            'no_surat' => $e->no_surat,
                            'tgl_surat' => $e->tgl_surat,
                            'sektor' => $e->sektor_bantuan,
                            'perihal' => $e->perihal,
                            'permohonan' => $e->nilai_pengajuan,
                            'bantuan' => $e->nilai_bantuan,
                            'evaluator1' => $evaluator1->nama,
                            'evaluator2' => $evaluator2->nama,
                            'penerima' => $evaluator1->nama,
                        ],

                        $dataUpdate = [
                            'status' => $status,
                            'ket_kadiv' => $catatan,
                            'approve_kadiv' => $tanggalMenit,
                        ],

//                        Mail::send('mail.approved_evaluator', $dataEmail, function ($message) use ($evaluator1, $evaluator2) {
//                            $message->to($evaluator1->email, $evaluator1->nama)
//                                ->cc($evaluator2->email, $evaluator2->nama)
//                                ->subject('Evaluasi Proposal')
//                                ->from('pgn.no.reply@pertamina.com', 'NR SHARE');
//                        }),

                        #UPDATE EVALUASI
                        Evaluasi::whereIn('id_evaluasi', explode(",", $evaluasiID))->update($dataUpdate),
                    ],
                ];
            } else {
                $data[] = [
                    [
                        $dataEmail = [
                            'no_agenda' => $e->no_agenda,
                            'pengirim' => $e->pengirim,
                            'tgl_terima' => $e->tgl_terima,
                            'dari' => $e->asal_surat,
                            'no_surat' => $e->no_surat,
                            'tgl_surat' => $e->tgl_surat,
                            'sektor' => $e->sektor_bantuan,
                            'perihal' => $e->perihal,
                            'permohonan' => $e->nilai_pengajuan,
                            'bantuan' => $e->nilai_bantuan,
                            'evaluator1' => $evaluator1->nama,
                            'evaluator2' => $evaluator2->nama,
                            'penerima' => $evaluator1->nama,
                        ],

                        $dataUpdate = [
                            'status' => $status,
                            'ket_kadiv' => $catatan,
                            'reject_date' => $tanggalMenit,
                            'reject_by' => session('user')->username,
                        ],

                        $dataUpdateProposal = [
                            'status' => $status,
                        ],

//                        Mail::send('mail.reject_evaluasi', $dataEmail, function ($message) use ($evaluator1, $evaluator2) {
//                            $message->to($evaluator1->email, $evaluator1->nama)
//                                ->cc($evaluator2->email, $evaluator2->nama)
//                                ->subject('Penolakan Evaluasi Proposal')
//                                ->from('pgn.no.reply@pertamina.com', 'NR SHARE');
//                        }),

                        #UPDATE EVALUASI
                        Evaluasi::whereIn('id_evaluasi', explode(",", $evaluasiID))->update($dataUpdate),
                        Kelayakan::whereIn('no_agenda', explode(",", $e->no_agenda))->update($dataUpdateProposal),
                    ],
                ];
            }

            return redirect()->back()->with('berhasil', 'Evaluasi proposal berhasil disetujui');
        }

    }
}