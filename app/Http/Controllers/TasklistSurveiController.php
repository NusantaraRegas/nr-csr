<?php

namespace App\Http\Controllers;

use App\Models\Kelayakan;
use App\Models\Pembayaran;
use App\Models\ViewSurvei;
use Illuminate\Http\Request;
use App\Models\Evaluasi;
use App\Models\Survei;
use App\Models\User;
use App\Http\Requests\ApproveSurveiKadep;
use App\Http\Requests\ApproveSurveiKadiv;
use DB;
use Mail;
use Exception;

class TasklistSurveiController extends Controller
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
                ['kadep', $username],
                ['status', 'Approved 1'],
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

        return view('tasklist.survei')
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

    public function reviewSurvei()
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

        $data = ViewSurvei::where('survei2', $username)
            ->where('status', 'Forward')
            ->orderBy('id_survei', 'DESC')
            ->get();

        $jumlahData = ViewSurvei::where('survei2', $username)
            ->where('status', 'Forward')
            ->orderBy('id_survei', 'DESC')
            ->count();

        return view('home.review_survei')
            ->with([
                'username' => $username,
                'dataSurvei' => $data,
                'jumlahData' => $jumlahData,
            ]);
    }

    public function tasklistSurvei()
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
            $data = ViewSurvei::where('kadiv', $username)
                ->where('status', 'Approved 2')
                ->orderBy('id_survei', 'DESC')
                ->get();

            $jumlahData = ViewSurvei::where('kadiv', $username)
                ->where('status', 'Approved 2')
                ->count();
        } elseif (session('user')->role == 'Supervisor 1') {
            $data = ViewSurvei::where('kadep', $username)
                ->where('status', 'Approved 1')
                ->orderBy('id_survei', 'DESC')
                ->get();

            $jumlahData = ViewSurvei::where('kadep', $username)
                ->where('status', 'Approved 1')
                ->count();
        }else{
            $data = ViewSurvei::where('kadep', $username)
                ->where('status', 'Approved 1')
                ->orderBy('id_survei', 'DESC')
                ->get();

            $jumlahData = 0;
        }

        return view('home.tasklist_survei')
            ->with([
                'username' => $username,
                'dataSurvei' => $data,
                'jumlahData' => $jumlahData,
            ]);
    }

    public function review(Request $request)
    {
        try {
            $logID = decrypt($request->surveiID);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'hasilSurvei' => 'required',
        ]);

        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("Y-m-d");

        $kadep = User::where('role', 'Supervisor 1')->where('status', 'Active')->first();
        $survei = ViewSurvei::where('id_survei', $logID)->first();

        $dataEmail = [
            'no_agenda' => $survei->no_agenda,
            'pengirim' => $survei->pengirim,
            'tgl_terima' => $survei->tgl_terima,
            'dari' => $survei->asal_surat,
            'no_surat' => $survei->no_surat,
            'tgl_surat' => $survei->tgl_surat,
            'perihal' => $survei->bantuan_untuk,
            'permohonan' => $survei->nilai_pengajuan,
            'bantuan' => $survei->nilai_bantuan,
            'survei1' => $survei->hasil_survei,
            'survei2' => $request->hasilSurvei,
            'penerima' => $kadep->nama,
        ];

        $dataUpdate = [
            'status' => 'Approved 1',
            'hasil_konfirmasi' => $request->hasilSurvei,
            'approve_date' => $tanggalMenit,
        ];

        try {
//            Mail::send('mail.approval_surveyor', $dataEmail, function ($message) use ($kadep) {
//                $message->to($kadep->email, $kadep->nama)
//                    ->subject('Approval Survei Proposal')
//                    ->from('pgn.no.reply@pertamina.com', 'NR SHARE');
//            });

            Survei::where('id_survei', $logID)->update($dataUpdate);
            return redirect()->back()->with('berhasil', 'Survei proposal berhasil direview');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Survei proposal gagal direview');
        }
    }

    public function approveSurvei($loginID)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("Y-m-d");

        $dataSurvei = DB::table('v_survei')
            ->select('v_survei.*')
            ->whereIn('id_survei', explode(",", $loginID))
            ->get();

        foreach ($dataSurvei as $e) {
            #SEND EMAIL
            $survei1 = User::where('username', $e->survei1)->first();
            $survei2 = User::where('username', $e->survei2)->first();
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
                        'survei1' => $survei1->nama,
                        'survei2' => $survei2->nama,
                        'penerima' => $kadep->nama,
                    ],

                    $dataUpdate = [
                        'status' => 'Approved 1',
                        'approve_date' => $tanggalMenit,
                    ],

                    #UPDATE SURVEI
                    Survei::whereIn('id_survei', explode(",", $loginID))->update($dataUpdate),
                ]
            ];

            return redirect()->back()->with('berhasil', 'Survei proposal berhasil disetujui');
        }

    }

    public function approveAllKadep($surveiID)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("Y-m-d H:i:s");

        //DATA CHECKED
        $dataAll = ViewSurvei::whereIn('id_survei', explode(",", $surveiID))->get();

        foreach ($dataAll as $ds) {
            $data[] = [
                [

                    $dataUpdate = [
                        'status' => 'Approved 2',
                        'ket_kadin1' => "Dilengkapi kelengkapan dokumen administrasi sesuai peraturan yang berlaku dengan usulan nilai bantuan Rp. ".number_format($ds->nilai_bantuan,0,',','.'),
                        'nilai_approved' => $ds->nilai_bantuan,
                        'approve_kadep' => $tanggalMenit,
                    ],

                    Survei::where('id_survei', $ds->id_survei)->update($dataUpdate),

                ]
            ];

        }

        try {
            return redirect()->back()->with('berhasil', 'Survei proposal berhasil disetujui');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Survei gagal disetujui');
        }

    }

    public function approveAllKadiv($surveiID)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("Y-m-d");

        $dataSurvei = DB::table('v_survei')
            ->select('v_survei.*')
            ->whereIn('id_survei', explode(",", $surveiID))
            ->get();

        foreach ($dataSurvei as $e) {

            $data[] = [
                [
                    $dataBAST = [
                        'NO_AGENDA' => strtoupper($e->no_agenda),
                        'TGL_BAST' => $tanggalMenit,
                        'PILAR' => ucwords($e->pilar),
                        'BANTUAN_UNTUK' => ucwords($e->bantuan_untuk),
                        'PROPOSAL_DARI' => ucwords($e->asal_surat),
                        'ALAMAT' => ucwords($e->alamat),
                        'PROVINSI' => $e->provinsi,
                        'KABUPATEN' => $e->kabupaten,
                        'PENANGGUNG_JAWAB' => ucwords($e->pengaju_proposal),
                        'BERTINDAK_SEBAGAI' => ucwords($e->sebagai),
                        'NO_SURAT' => strtoupper($e->no_surat),
                        'TGL_SURAT' => date("Y-m-d", strtotime($e->tgl_surat)),
                        'PERIHAL' => ucwords($e->perihal),
                        'NAMA_BANK' => $e->nama_bank,
                        'NO_REKENING' => $e->no_rekening,
                        'DESKRIPSI' => $e->deskripsi,
                        'ATAS_NAMA' => strtoupper($e->atas_nama),
                        'NAMA_PEJABAT' => 'Anak Agung Raka Haryana',
                        'JABATAN_PEJABAT' => 'Division Head Corporate Social Responsibility',
                        'DESKRIPSI' => $e->deskripsi,
                        'CREATED_BY' => session('user')->username,
                        'CREATED_DATE' => $tanggalMenit,
                        'STATUS' => 'Submited',
                    ],

                    $dataUpdate = [
                        'status' => 'Approved 3',
                        'ket_kadiv' => "Dapat dibantu senilai Rp. ".number_format($e->nilai_bantuan,0,',','.')." dengan ".$e->termin." termin pembayaran",
                        'nilai_approved' => $e->nilai_bantuan,
                        'approve_kadiv' => $tanggalMenit,
                        'BAST' => 'Oke',
                    ],

                    $updateProposal = [
                        'status' => 'Approved',
                    ],

                    $dataPembayaran1 = [
                        'no_agenda' => $e->no_agenda,
                        'termin' => 1,
                        'persen' => $e->persen1,
                        'nilai_approved' => $e->nilai_bantuan,
                        'jumlah_pembayaran' => $e->nilai_bantuan,
                        'status' => '',
                        'create_date' => $tanggalMenit,
                        'create_by' => session('user')->username,
                    ],

                    DB::table('tbl_pembayaran')->insert($dataPembayaran1),
                    Survei::where('id_survei', $e->id_survei)->update($dataUpdate),
                    //Survei::whereIn('id_survei', explode(",", $surveiID))->update($dataUpdate),
                    Kelayakan::where('no_agenda', $e->no_agenda)->update($updateProposal),
                    DB::table('tbl_bast_dana')->insert($dataBAST),

                    $survei1 = User::where('username', $e->survei1)->first(),
                    $survei2 = User::where('username', $e->survei2)->first(),

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
                        'termin' => $e->termin,
                        'survei1' => $survei1->nama,
                        'survei2' => $survei2->nama,
                        'penerima' => $survei1->nama,
                    ],
                    
//                    Mail::send('mail.approved_surveyor', $dataEmail, function ($message) use ($survei1, $survei2) {
//                        $message->to($survei1->email, $survei1->nama)
//                                ->cc($survei2->email, $survei2->nama)
//                                //->cc('sigit.sutrisno@pgncom.co.id', 'Sigit Sutrisno')
//                                ->subject('Persetujuan Survei Proposal')
//                                ->from('pgn.no.reply@pertamina.com', 'NR SHARE');
//                    }),

            ]

            ];

            return redirect()->back()->with('berhasil', 'Survei proposal berhasil disetujui');
        }

    }

    public function approveKadep(ApproveSurveiKadep $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("Y-m-d");

        try {
            $logID = decrypt($request->noAgenda);
        } catch (Exception $e) {
            abort(404);
        }

        $dataKelayakan = Kelayakan::where('no_agenda', $logID)->first();
        $survei = ViewSurvei::where('no_agenda', $logID)->first();

        $nilaiBantuan = str_replace(".", "", $request->nilaiBantuan);

        if ($request->keterangan == 'Approved 1') {
            if ($request->status == 'Approved') {
                if ($request->termin == 1) {
                    if ($request->termin1 == '') {
                        return redirect()->back()->with('gagal', 'Persentase termin pembayaran harus diisi');
                    } else {
                        if ($request->termin1 != 100) {
                            return redirect()->back()->with('gagal', 'Persentase termin belum mencapai 100%');
                        } else {
                            $rupiah1 = $nilaiBantuan * $request->termin1 / 100;
                            $dataUpdate = [
                                'status' => 'Approved 2',
                                'ket_kadin1' => $request->komentar,
                                'nilai_approved' => $nilaiBantuan,
                                'termin' => $request->termin,
                                'persen1' => $request->termin1,
                                'persen2' => '',
                                'persen3' => '',
                                'persen4' => '',
                                'rupiah1' => $rupiah1,
                                'rupiah2' => '',
                                'rupiah3' => '',
                                'rupiah4' => '',
                                'approve_kadep' => $tanggalMenit,
                            ];
                        }
                    }
                } elseif ($request->termin == 2) {
                    if ($request->termin1 == '' and $request->termin2 == '') {
                        return redirect()->back()->with('gagal', 'Persentase termin pembayaran harus diisi');
                    } else {
                        if ($request->termin1 + $request->termin2 != 100) {
                            return redirect()->back()->with('gagal', 'Persentase termin belum mencapai 100%');
                        } else {
                            $rupiah1 = $nilaiBantuan * $request->termin1 / 100;
                            $rupiah2 = $nilaiBantuan * $request->termin2 / 100;
                            $dataUpdate = [
                                'status' => 'Approved 2',
                                'ket_kadin1' => $request->komentar,
                                'nilai_approved' => $nilaiBantuan,
                                'termin' => $request->termin,
                                'persen1' => $request->termin1,
                                'persen2' => $request->termin2,
                                'persen3' => '',
                                'persen4' => '',
                                'rupiah1' => $rupiah1,
                                'rupiah2' => $rupiah2,
                                'rupiah3' => '',
                                'rupiah4' => '',
                                'approve_kadep' => $tanggalMenit,
                            ];
                        }
                    }
                } elseif ($request->termin == 3) {
                    if ($request->termin1 == '' and $request->termin2 == '' and $request->termin3 == '') {
                        return redirect()->back()->with('gagal', 'Persentase termin pembayaran harus diisi');
                    } else {
                        if ($request->termin1 + $request->termin2 + $request->termin3 != 100) {
                            return redirect()->back()->with('gagal', 'Persentase termin belum mencapai 100%');
                        } else {
                            $rupiah1 = $nilaiBantuan * $request->termin1 / 100;
                            $rupiah2 = $nilaiBantuan * $request->termin2 / 100;
                            $rupiah3 = $nilaiBantuan * $request->termin3 / 100;
                            $dataUpdate = [
                                'status' => 'Approved 2',
                                'ket_kadin1' => $request->komentar,
                                'nilai_approved' => $nilaiBantuan,
                                'termin' => $request->termin,
                                'persen1' => $request->termin1,
                                'persen2' => $request->termin2,
                                'persen3' => $request->termin3,
                                'persen4' => '',
                                'rupiah1' => $rupiah1,
                                'rupiah2' => $rupiah2,
                                'rupiah3' => $rupiah3,
                                'rupiah4' => '',
                                'approve_kadep' => $tanggalMenit,
                            ];
                        }
                    }
                } elseif ($request->termin == 4) {
                    if ($request->termin1 == '' and $request->termin2 == '' and $request->termin3 == '' and $request->termin4 == '') {
                        return redirect()->back()->with('gagal', 'Persentase termin pembayaran harus diisi');
                    } else {
                        if ($request->termin1 + $request->termin2 + $request->termin3 + $request->termin4 != 100) {
                            return redirect()->back()->with('gagal', 'Persentase termin belum mencapai 100%');
                        } else {
                            $rupiah1 = $nilaiBantuan * $request->termin1 / 100;
                            $rupiah2 = $nilaiBantuan * $request->termin2 / 100;
                            $rupiah3 = $nilaiBantuan * $request->termin3 / 100;
                            $rupiah4 = $nilaiBantuan * $request->termin4 / 100;
                            $dataUpdate = [
                                'status' => 'Approved 2',
                                'ket_kadin1' => $request->komentar,
                                'nilai_approved' => $nilaiBantuan,
                                'termin' => $request->termin,
                                'persen1' => $request->termin1,
                                'persen2' => $request->termin2,
                                'persen3' => $request->termin3,
                                'persen4' => $request->termin4,
                                'rupiah1' => $rupiah1,
                                'rupiah2' => $rupiah2,
                                'rupiah3' => $rupiah3,
                                'rupiah4' => $rupiah4,
                                'approve_kadep' => $tanggalMenit,
                            ];
                        }
                    }
                }

                //SEND EMAIL
                $kadiv = User::where('role', 'Manager')->first();

                $dataEmail = [
                    'no_agenda' => $survei->no_agenda,
                    'pengirim' => $survei->pengirim,
                    'tgl_terima' => $survei->tgl_terima,
                    'dari' => $survei->asal_surat,
                    'no_surat' => $survei->no_surat,
                    'tgl_surat' => $survei->tgl_surat,
                    'perihal' => $survei->bantuan_untuk,
                    'permohonan' => $survei->nilai_pengajuan,
                    'bantuan' => $survei->nilai_bantuan,
                    'survei1' => $survei->hasil_survei,
                    'survei2' => $request->hasilSurvei,
                    'penerima' => $kadiv->nama,
                ];

                try {
//                    Mail::send('mail.approval_surveyor', $dataEmail, function ($message) use ($kadiv) {
//                        $message->to($kadiv->email, $kadiv->nama)
//                            ->subject('Survei Proposal')
//                            ->from('pgn.no.reply@pertamina.com', 'NR SHARE');
//                    });

                    Survei::where('no_agenda', $logID)->update($dataUpdate);
                    return redirect()->back()->with('berhasil', 'Survei proposal berhasil disetujui');

                } catch (Exception $e) {
                    Survei::where('no_agenda', $logID)->update($dataUpdate);
                    return redirect()->back()->with('berhasil', 'Survei proposal berhasil disetujui');
                }

            } elseif ($request->status == 'Revisi') {
                $dataUpdate = [
                    'status' => 'Revisi',
                    'ket_kadin1' => $request->komentar,
                    'revisi_by' => session('user')->username,
                    'revisi_date' => $tanggalMenit,
                ];

                //SEND EMAIL
                $dataSurvei = DB::table('v_survei')
                    ->select('v_survei.*')
                    ->where('no_agenda', $logID)
                    ->first();
                $survei1 = User::where('username', $dataSurvei->survei1)->first();
                $survei2 = User::where('username', $dataSurvei->survei2)->first();
                $dataEmail = [
                    'no_agenda' => $dataSurvei->no_agenda,
                    'pengirim' => $dataSurvei->pengirim,
                    'tgl_terima' => $dataSurvei->tgl_terima,
                    'dari' => $dataSurvei->asal_surat,
                    'no_surat' => $dataSurvei->no_surat,
                    'tgl_surat' => $dataSurvei->tgl_surat,
                    'sektor' => $dataSurvei->sektor_bantuan,
                    'perihal' => $dataSurvei->perihal,
                    'permohonan' => $dataSurvei->nilai_pengajuan,
                    'bantuan' => $nilaiBantuan,
                    'survei1' => $survei1->nama,
                    'survei2' => $survei2->nama,
                    'penerima' => $survei2->nama,
                    'komentar' => $request->komentar,
                ];

                try {
//                    Mail::send('mail.reject_survei', $dataEmail, function ($message) use ($survei1, $survei2) {
//                        $message->to($survei1->email, $survei1->nama)
//                            ->cc($survei2->email, $survei2->nama)
//                            ->subject('Revisi Survei Proposal')
//                            ->from('pgn.no.reply@pertamina.com', 'NR SHARE');
//                    });

                    Survei::where('no_agenda', $logID)->update($dataUpdate);
                    return redirect()->back()->with('berhasil', 'Survei proposal berhasil disetujui');

                } catch (Exception $e) {
                    Survei::where('no_agenda', $logID)->update($dataUpdate);
                    return redirect()->back()->with('berhasil', 'Survei proposal berhasil direvisi');
                }
            }
        } elseif ($request->keterangan = 'Approved 2') {
            if ($request->status == 'Approved') {
                if ($request->termin == 1) {
                    if ($request->termin1 == '') {
                        return redirect()->back()->with('gagal', 'Persentase termin pembayaran harus diisi');
                    } else {
                        if ($request->termin1 != 100) {
                            return redirect()->back()->with('gagal', 'Persentase termin belum mencapai 100%');
                        } else {
                            $rupiah1 = $nilaiBantuan * $request->termin1 / 100;

                            $dataBAST = [
                                'NO_AGENDA' => strtoupper($dataKelayakan->no_agenda),
                                'TGL_BAST' => $tanggalMenit,
                                'PILAR' => ucwords($dataKelayakan->pilar),
                                'BANTUAN_UNTUK' => ucwords($dataKelayakan->bantuan_untuk),
                                'PROPOSAL_DARI' => ucwords($dataKelayakan->asal_surat),
                                'ALAMAT' => ucwords($dataKelayakan->alamat),
                                'PROVINSI' => $dataKelayakan->provinsi,
                                'KABUPATEN' => $dataKelayakan->kabupaten,
                                'PENANGGUNG_JAWAB' => ucwords($dataKelayakan->pengaju_proposal),
                                'BERTINDAK_SEBAGAI' => ucwords($dataKelayakan->sebagai),
                                'NO_SURAT' => strtoupper($dataKelayakan->no_surat),
                                'TGL_SURAT' => date("Y-m-d", strtotime($dataKelayakan->tgl_surat)),
                                'PERIHAL' => ucwords($dataKelayakan->perihal),
                                'NAMA_BANK' => $dataKelayakan->nama_bank,
                                'NO_REKENING' => $dataKelayakan->no_rekening,
                                'DESKRIPSI' => $dataKelayakan->deskripsi,
                                'ATAS_NAMA' => strtoupper($dataKelayakan->atas_nama),
                                'NAMA_PEJABAT' => 'Anak Agung Raka Haryana',
                                'JABATAN_PEJABAT' => 'Division Head Corporate Social Responsibility',
                                'DESKRIPSI' => $dataKelayakan->deskripsi,
//                                'NAMA_BARANG' => ucwords($request->namaBarang),
//                                'JUMLAH_BARANG' => $request->jumlahBarang,
//                                'SATUAN_BARANG' => ucwords($request->satuanBarang),
                                'CREATED_BY' => session('user')->username,
                                'CREATED_DATE' => $tanggalMenit,
//                                'PIHAK_KEDUA' => $request->pihakKedua,
                                'STATUS' => 'Submited',
                            ];

                            $updateProposal = [
                                'status' => 'Approved',
                            ];

                            $dataUpdate = [
                                'status' => 'Approved 3',
                                'ket_kadiv' => $request->komentar,
                                'nilai_approved' => $nilaiBantuan,
                                'termin' => $request->termin,
                                'persen1' => $request->termin1,
                                'persen2' => '',
                                'persen3' => '',
                                'persen4' => '',
                                'rupiah1' => $rupiah1,
                                'rupiah2' => '',
                                'rupiah3' => '',
                                'rupiah4' => '',
                                'approve_kadiv' => $tanggalMenit,
                                'BAST' => 'Oke',
                            ];

                            $dataPembayaran1 = [
                                'no_agenda' => decrypt($request->noAgenda),
                                'termin' => 1,
                                'persen' => $request->termin1,
                                'nilai_approved' => $nilaiBantuan,
                                'jumlah_pembayaran' => $rupiah1,
                                'status' => '',
                                'create_date' => $tanggalMenit,
                                'create_by' => session('user')->username,
                            ];

                            DB::table('tbl_pembayaran')->insert($dataPembayaran1);
                        }
                    }
                } elseif ($request->termin == 2) {
                    if ($request->termin1 == '' and $request->termin2 == '') {
                        return redirect()->back()->with('gagal', 'Persentase termin pembayaran harus diisi');
                    } else {
                        if ($request->termin1 + $request->termin2 != 100) {
                            return redirect()->back()->with('gagal', 'Persentase termin belum mencapai 100%');
                        } else {
                            $rupiah1 = $nilaiBantuan * $request->termin1 / 100;
                            $rupiah2 = $nilaiBantuan * $request->termin2 / 100;

                            $dataBAST = [
                                'NO_AGENDA' => strtoupper($dataKelayakan->no_agenda),
                                'PILAR' => ucwords($dataKelayakan->pilar),
                                'BANTUAN_UNTUK' => ucwords($dataKelayakan->bantuan_untuk),
                                'PROPOSAL_DARI' => ucwords($dataKelayakan->asal_surat),
                                'ALAMAT' => ucwords($dataKelayakan->alamat),
                                'PROVINSI' => $dataKelayakan->provinsi,
                                'KABUPATEN' => $dataKelayakan->kabupaten,
                                'PENANGGUNG_JAWAB' => ucwords($dataKelayakan->atas_nama),
                                'BERTINDAK_SEBAGAI' => ucwords($dataKelayakan->sebagai),
                                'NO_SURAT' => strtoupper($dataKelayakan->no_surat),
                                'TGL_SURAT' => date("Y-m-d", strtotime($dataKelayakan->tgl_surat)),
                                'PERIHAL' => ucwords($dataKelayakan->perihal),
                                'NAMA_BANK' => $dataKelayakan->nama_bank,
                                'NO_REKENING' => $dataKelayakan->no_rekening,
                                'ATAS_NAMA' => strtoupper($dataKelayakan->atas_nama),
                                'NAMA_PEJABAT' => 'Anak Agung Raka Haryana',
                                'JABATAN_PEJABAT' => 'Division Head Corporate Social Responsibility',
                                'DESKRIPSI' => $dataKelayakan->deskripsi,
//                                'NAMA_BARANG' => ucwords($request->namaBarang),
//                                'JUMLAH_BARANG' => $request->jumlahBarang,
//                                'SATUAN_BARANG' => ucwords($request->satuanBarang),
                                'CREATED_BY' => session('user')->username,
                                'CREATED_DATE' => $tanggalMenit,
//                                'PIHAK_KEDUA' => $request->pihakKedua,
                                'STATUS' => 'Submited',
                            ];

                            $updateProposal = [
                                'status' => 'Approved',
                            ];

                            $dataUpdate = [
                                'status' => 'Approved 3',
                                'ket_kadiv' => $request->komentar,
                                'nilai_approved' => $nilaiBantuan,
                                'termin' => $request->termin,
                                'persen1' => $request->termin1,
                                'persen2' => $request->termin2,
                                'persen3' => '',
                                'persen4' => '',
                                'rupiah1' => $rupiah1,
                                'rupiah2' => $rupiah2,
                                'rupiah3' => '',
                                'rupiah4' => '',
                                'approve_kadiv' => $tanggalMenit,
                                'BAST' => 'Oke',
                            ];

                            $dataPembayaran1 = [
                                'no_agenda' => decrypt($request->noAgenda),
                                'termin' => 1,
                                'persen' => $request->termin1,
                                'nilai_approved' => $nilaiBantuan,
                                'jumlah_pembayaran' => $rupiah1,
                                'status' => '',
                                'create_date' => $tanggalMenit,
                                'create_by' => session('user')->username,
                            ];

                            $dataPembayaran2 = [
                                'no_agenda' => decrypt($request->noAgenda),
                                'termin' => 2,
                                'persen' => $request->termin2,
                                'nilai_approved' => $nilaiBantuan,
                                'jumlah_pembayaran' => $rupiah2,
                                'status' => '',
                                'create_date' => $tanggalMenit,
                                'create_by' => session('user')->username,
                            ];

                            DB::table('tbl_pembayaran')->insert($dataPembayaran1);
                            DB::table('tbl_pembayaran')->insert($dataPembayaran2);
                        }
                    }
                } elseif ($request->termin == 3) {
                    if ($request->termin1 == '' and $request->termin2 == '' and $request->termin3 == '') {
                        return redirect()->back()->with('gagal', 'Persentase termin pembayaran harus diisi');
                    } else {
                        if ($request->termin1 + $request->termin2 + $request->termin3 != 100) {
                            return redirect()->back()->with('gagal', 'Persentase termin belum mencapai 100%');
                        } else {
                            $rupiah1 = $nilaiBantuan * $request->termin1 / 100;
                            $rupiah2 = $nilaiBantuan * $request->termin2 / 100;
                            $rupiah3 = $nilaiBantuan * $request->termin3 / 100;

                            $dataBAST = [
                                'NO_AGENDA' => strtoupper($dataKelayakan->no_agenda),
                                'PILAR' => ucwords($dataKelayakan->pilar),
                                'BANTUAN_UNTUK' => ucwords($dataKelayakan->bantuan_untuk),
                                'PROPOSAL_DARI' => ucwords($dataKelayakan->asal_surat),
                                'ALAMAT' => ucwords($dataKelayakan->alamat),
                                'PROVINSI' => $dataKelayakan->provinsi,
                                'KABUPATEN' => $dataKelayakan->kabupaten,
                                'PENANGGUNG_JAWAB' => ucwords($dataKelayakan->atas_nama),
                                'BERTINDAK_SEBAGAI' => ucwords($dataKelayakan->sebagai),
                                'NO_SURAT' => strtoupper($dataKelayakan->no_surat),
                                'TGL_SURAT' => date("Y-m-d", strtotime($dataKelayakan->tgl_surat)),
                                'PERIHAL' => ucwords($dataKelayakan->perihal),
                                'NAMA_BANK' => $dataKelayakan->nama_bank,
                                'NO_REKENING' => $dataKelayakan->no_rekening,
                                'ATAS_NAMA' => strtoupper($dataKelayakan->atas_nama),
                                'NAMA_PEJABAT' => 'Anak Agung Raka Haryana',
                                'JABATAN_PEJABAT' => 'Division Head Corporate Social Responsibility',
                                'DESKRIPSI' => $dataKelayakan->deskripsi,
//                                'NAMA_BARANG' => ucwords($request->namaBarang),
//                                'JUMLAH_BARANG' => $request->jumlahBarang,
//                                'SATUAN_BARANG' => ucwords($request->satuanBarang),
                                'CREATED_BY' => session('user')->username,
                                'CREATED_DATE' => $tanggalMenit,
//                                'PIHAK_KEDUA' => $request->pihakKedua,
                                'STATUS' => 'Submited',
                            ];

                            $updateProposal = [
                                'status' => 'Approved',
                            ];

                            $dataUpdate = [
                                'status' => 'Approved 3',
                                'ket_kadiv' => $request->komentar,
                                'nilai_approved' => $nilaiBantuan,
                                'termin' => $request->termin,
                                'persen1' => $request->termin1,
                                'persen2' => $request->termin2,
                                'persen3' => $request->termin3,
                                'persen4' => '',
                                'rupiah1' => $rupiah1,
                                'rupiah2' => $rupiah2,
                                'rupiah3' => $rupiah3,
                                'rupiah4' => '',
                                'approve_kadiv' => $tanggalMenit,
                                'BAST' => 'Oke',
                            ];

                            $dataPembayaran1 = [
                                'no_agenda' => decrypt($request->noAgenda),
                                'termin' => 1,
                                'persen' => $request->termin1,
                                'nilai_approved' => $nilaiBantuan,
                                'jumlah_pembayaran' => $rupiah1,
                                'status' => '',
                                'create_date' => $tanggalMenit,
                                'create_by' => session('user')->username,
                            ];

                            $dataPembayaran2 = [
                                'no_agenda' => decrypt($request->noAgenda),
                                'termin' => 2,
                                'persen' => $request->termin2,
                                'nilai_approved' => $nilaiBantuan,
                                'jumlah_pembayaran' => $rupiah2,
                                'status' => '',
                                'create_date' => $tanggalMenit,
                                'create_by' => session('user')->username,
                            ];

                            $dataPembayaran3 = [
                                'no_agenda' => decrypt($request->noAgenda),
                                'termin' => 3,
                                'persen' => $request->termin3,
                                'nilai_approved' => $nilaiBantuan,
                                'jumlah_pembayaran' => $rupiah3,
                                'status' => '',
                                'create_date' => $tanggalMenit,
                                'create_by' => session('user')->username,
                            ];

                            DB::table('tbl_pembayaran')->insert($dataPembayaran1);
                            DB::table('tbl_pembayaran')->insert($dataPembayaran2);
                            DB::table('tbl_pembayaran')->insert($dataPembayaran3);
                        }
                    }
                } elseif ($request->termin == 4) {
                    if ($request->termin1 == '' and $request->termin2 == '' and $request->termin3 == '' and $request->termin4 == '') {
                        return redirect()->back()->with('gagal', 'Persentase termin pembayaran harus diisi');
                    } else {
                        if ($request->termin1 + $request->termin2 + $request->termin3 + $request->termin4 != 100) {
                            return redirect()->back()->with('gagal', 'Persentase termin belum mencapai 100%');
                        } else {
                            $rupiah1 = $nilaiBantuan * $request->termin1 / 100;
                            $rupiah2 = $nilaiBantuan * $request->termin2 / 100;
                            $rupiah3 = $nilaiBantuan * $request->termin3 / 100;
                            $rupiah4 = $nilaiBantuan * $request->termin4 / 100;

                            $dataBAST = [
                                'NO_AGENDA' => strtoupper($dataKelayakan->no_agenda),
                                'PILAR' => ucwords($dataKelayakan->pilar),
                                'BANTUAN_UNTUK' => ucwords($dataKelayakan->bantuan_untuk),
                                'PROPOSAL_DARI' => ucwords($dataKelayakan->asal_surat),
                                'ALAMAT' => ucwords($dataKelayakan->alamat),
                                'PROVINSI' => $dataKelayakan->provinsi,
                                'KABUPATEN' => $dataKelayakan->kabupaten,
                                'PENANGGUNG_JAWAB' => ucwords($dataKelayakan->atas_nama),
                                'BERTINDAK_SEBAGAI' => ucwords($dataKelayakan->sebagai),
                                'NO_SURAT' => strtoupper($dataKelayakan->no_surat),
                                'TGL_SURAT' => date("Y-m-d", strtotime($dataKelayakan->tgl_surat)),
                                'PERIHAL' => ucwords($dataKelayakan->perihal),
                                'NAMA_BANK' => $dataKelayakan->nama_bank,
                                'NO_REKENING' => $dataKelayakan->no_rekening,
                                'ATAS_NAMA' => strtoupper($dataKelayakan->atas_nama),
                                'NAMA_PEJABAT' => 'Anak Agung Raka Haryana',
                                'JABATAN_PEJABAT' => 'Division Head Corporate Social Responsibility',
                                'DESKRIPSI' => $dataKelayakan->deskripsi,
//                                'NAMA_BARANG' => ucwords($request->namaBarang),
//                                'JUMLAH_BARANG' => $request->jumlahBarang,
//                                'SATUAN_BARANG' => ucwords($request->satuanBarang),
                                'CREATED_BY' => session('user')->username,
                                'CREATED_DATE' => $tanggalMenit,
//                                'PIHAK_KEDUA' => $request->pihakKedua,
                                'STATUS' => 'Submited',
                            ];

                            $updateProposal = [
                                'status' => 'Approved',
                            ];

                            $dataUpdate = [
                                'status' => 'Approved 3',
                                'ket_kadiv' => $request->komentar,
                                'nilai_approved' => $nilaiBantuan,
                                'termin' => $request->termin,
                                'persen1' => $request->termin1,
                                'persen2' => $request->termin2,
                                'persen3' => $request->termin3,
                                'persen4' => $request->termin4,
                                'rupiah1' => $rupiah1,
                                'rupiah2' => $rupiah2,
                                'rupiah3' => $rupiah3,
                                'rupiah4' => $rupiah4,
                                'approve_kadiv' => $tanggalMenit,
                                'BAST' => 'Oke',
                            ];

                            $dataPembayaran1 = [
                                'no_agenda' => decrypt($request->noAgenda),
                                'termin' => 1,
                                'persen' => $request->termin1,
                                'nilai_approved' => $nilaiBantuan,
                                'jumlah_pembayaran' => $rupiah1,
                                'status' => '',
                                'create_date' => $tanggalMenit,
                                'create_by' => session('user')->username,
                            ];

                            $dataPembayaran2 = [
                                'no_agenda' => decrypt($request->noAgenda),
                                'termin' => 2,
                                'persen' => $request->termin2,
                                'nilai_approved' => $nilaiBantuan,
                                'jumlah_pembayaran' => $rupiah2,
                                'status' => '',
                                'create_date' => $tanggalMenit,
                                'create_by' => session('user')->username,
                            ];

                            $dataPembayaran3 = [
                                'no_agenda' => decrypt($request->noAgenda),
                                'termin' => 3,
                                'persen' => $request->termin3,
                                'nilai_approved' => $nilaiBantuan,
                                'jumlah_pembayaran' => $rupiah3,
                                'status' => '',
                                'create_date' => $tanggalMenit,
                                'create_by' => session('user')->username,
                            ];

                            $dataPembayaran4 = [
                                'no_agenda' => decrypt($request->noAgenda),
                                'termin' => 4,
                                'persen' => $request->termin4,
                                'nilai_approved' => $nilaiBantuan,
                                'jumlah_pembayaran' => $rupiah4,
                                'status' => '',
                                'create_date' => $tanggalMenit,
                                'create_by' => session('user')->username,
                            ];

                            DB::table('tbl_pembayaran')->insert($dataPembayaran1);
                            DB::table('tbl_pembayaran')->insert($dataPembayaran2);
                            DB::table('tbl_pembayaran')->insert($dataPembayaran3);
                            DB::table('tbl_pembayaran')->insert($dataPembayaran4);
                        }
                    }
                }

                //SEND EMAIL
                $dataSurvei = DB::table('v_survei')
                    ->select('v_survei.*')
                    ->where('no_agenda', $logID)
                    ->first();
                $survei1 = User::where('username', $dataSurvei->survei1)->first();
                $survei2 = User::where('username', $dataSurvei->survei2)->first();
                $kadiv = User::where('role', 'Manager')->first();
                $dataEmail = [
                    'no_agenda' => $dataSurvei->no_agenda,
                    'pengirim' => $dataSurvei->pengirim,
                    'tgl_terima' => $dataSurvei->tgl_terima,
                    'dari' => $dataSurvei->asal_surat,
                    'no_surat' => $dataSurvei->no_surat,
                    'tgl_surat' => $dataSurvei->tgl_surat,
                    'sektor' => $dataSurvei->sektor_bantuan,
                    'perihal' => $dataSurvei->perihal,
                    'permohonan' => $dataSurvei->nilai_pengajuan,
                    'bantuan' => $nilaiBantuan,
                    'termin' => $dataSurvei->termin,
                    'survei1' => $survei1->nama,
                    'survei2' => $survei2->nama,
                    'penerima' => $survei2->nama,
                ];

                try {
//                    Mail::send('mail.approved_surveyor', $dataEmail, function ($message) use ($survei1, $survei2) {
//                        $message->to($survei2->email, $survei2->nama)
//                            ->cc($survei1->email, $survei1->nama)
//                            ->subject('Survei Proposal')
//                            ->from('pgn.no.reply@pertamina.com', 'NR SHARE');
//                    });

                    Kelayakan::where('no_agenda', $logID)->update($updateProposal);
                    Survei::where('no_agenda', $logID)->update($dataUpdate);
                    DB::table('tbl_bast_dana')->insert($dataBAST);
                    return redirect()->back()->with('berhasil', 'Proposal berhasil disetujui');

                } catch (Exception $e) {
                    Kelayakan::where('no_agenda', $logID)->update($updateProposal);
                    Survei::where('no_agenda', $logID)->update($dataUpdate);
                    DB::table('tbl_bast_dana')->insert($dataBAST);
                    return redirect()->back()->with('berhasil', 'Proposal berhasil disetujui');
                }

            } elseif ($request->status == 'Revisi') {
                $updateProposal = [
                    'status' => 'Rejected',
                ];

                $dataUpdate = [
                    'status' => 'Reject',
                    'ket_kadiv' => $request->komentar,
                    'revisi_by' => session('user')->username,
                    'revisi_date' => $tanggalMenit,
                ];

                //SEND EMAIL
                $dataSurvei = DB::table('v_survei')
                    ->select('v_survei.*')
                    ->where('no_agenda', $logID)
                    ->first();
                $survei1 = User::where('username', $dataSurvei->survei1)->first();
                $survei2 = User::where('username', $dataSurvei->survei2)->first();
                $kadiv = User::where('role', 'Manager')->first();
                $dataEmail = [
                    'no_agenda' => $dataSurvei->no_agenda,
                    'pengirim' => $dataSurvei->pengirim,
                    'tgl_terima' => $dataSurvei->tgl_terima,
                    'dari' => $dataSurvei->asal_surat,
                    'no_surat' => $dataSurvei->no_surat,
                    'tgl_surat' => $dataSurvei->tgl_surat,
                    'sektor' => $dataSurvei->sektor_bantuan,
                    'perihal' => $dataSurvei->perihal,
                    'permohonan' => $dataSurvei->nilai_pengajuan,
                    'bantuan' => $dataSurvei->nilai_bantuan,
                    'survei1' => $survei1->nama,
                    'survei2' => $survei2->nama,
                    'penerima' => $survei2->nama,
                    'komentar' => $request->komentar,
                ];

                try {
//                    Mail::send('mail.reject_survei', $dataEmail, function ($message) use ($survei2) {
//                        $message->to($survei2->email, $survei2->nama)
//                            ->subject('Revisi Survei Proposal')
//                            ->from('pgn.no.reply@pertamina.com', 'NR SHARE');
//                    });

                    Survei::where('no_agenda', $logID)->update($dataUpdate);
                    Kelayakan::where('no_agenda', $logID)->update($updateProposal);
                    return redirect()->back()->with('berhasil', 'Proposal berhasil ditolak');

                } catch (Exception $e) {
                    Survei::where('no_agenda', $logID)->update($dataUpdate);
                    Kelayakan::where('no_agenda', $logID)->update($updateProposal);
                    return redirect()->back()->with('berhasil', 'Proposal berhasil ditolak');
                }
            }
        }
    }

    public function approveKadiv(ApproveSurveiKadiv $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("Y-m-d");

        try {
            $logID = decrypt($request->noAgenda);
        } catch (Exception $e) {
            abort(404);
        }

        $dataUpdate = [
            'status' => 'Approved 3',
            'ket_kadiv' => $request->komentar,
            'nilai_bantuan' => $request->nilaiBantuan,
            'termin' => $request->termin,
            'approve_kadiv' => $tanggalMenit,
        ];

        $updateProposal = [
            'status' => 'Approved',
        ];

        //SEND EMAIL
        $dataSurvei = DB::table('v_survei')
            ->select('v_survei.*')
            ->where('no_agenda', $logID)
            ->first();
        $survei1 = User::where('username', $dataSurvei->survei1)->first();
        $survei2 = User::where('username', $dataSurvei->survei2)->first();
        $dataEmail = [
            'no_agenda' => $dataSurvei->no_agenda,
            'pengirim' => $dataSurvei->pengirim,
            'tgl_terima' => $dataSurvei->tgl_terima,
            'dari' => $dataSurvei->asal_surat,
            'no_surat' => $dataSurvei->no_surat,
            'tgl_surat' => $dataSurvei->tgl_surat,
            'sektor' => $dataSurvei->sektor_bantuan,
            'perihal' => $dataSurvei->perihal,
            'permohonan' => $dataSurvei->nilai_pengajuan,
            'bantuan' => $dataSurvei->nilai_bantuan,
            'termin' => $dataSurvei->termin,
            'survei1' => $survei1->nama,
            'survei2' => $survei2->nama,
            'penerima' => $survei1->nama,
        ];

        try {
//            Mail::send('mail.approved_surveyor', $dataEmail, function ($message) use ($survei1) {
//                $message->to($survei1->email, $survei1->nama)
//                    ->subject('Survei Proposal')
//                    ->from('pgn.no.reply@pertamina.com', 'NR SHARE');
//            });

            Survei::where('no_agenda', $logID)->update($dataUpdate);
            Kelayakan::where('no_agenda', $logID)->update($updateProposal);
            return redirect()->back()->with('berhasil', 'Survei proposal berhasil disetujui');
        } catch (Exception $e) {
            Survei::where('no_agenda', $logID)->update($dataUpdate);
            return redirect()->back()->with('berhasil', 'Survei proposal berhasil disetujui');
        }
    }
}