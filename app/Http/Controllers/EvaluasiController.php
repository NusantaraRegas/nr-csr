<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertTanggal;
use App\Models\Evaluasi;
use App\Models\Kelayakan;
use App\Models\Lampiran;
use App\Models\Survei;
use App\Models\DetailKriteria;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\InsertEvaluasi;
use DB;
use Mail;
use Exception;

class EvaluasiController extends Controller
{
    public function index()
    {
        $data = DB::table('v_evaluasi')
            ->select('v_evaluasi.*')
            ->orderBy('id_evaluasi', 'DESC')
            ->get();
        return view('report.data_evaluasi')
            ->with([
                'dataEvaluasi' => $data,
            ]);
    }

    public function inputEvaluasi($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }

        $kelayakan = Kelayakan::where('no_agenda', $logID)->first();
        $user = User::where([
            ['username', '!=', session('user')->username],
            ['status', '=', 'Active'],
        ])
            ->orderBy('nama', 'ASC')->get();
        return view('transaksi.input_evaluasi')
            ->with([
                'data' => $kelayakan,
                'dataUser' => $user,
            ]);
    }

    public function insertEvaluasi(Request $request)
    {
        $this->validate($request, [
            'rencanaAnggaran' => 'required',
            'dokumen' => 'required',
            'denah' => 'required',
            'perkiraanDana' => 'required',
            'syarat' => 'required',
            'catatan' => 'required',
            'evaluator1' => 'required',
            'evaluator2' => 'required',
        ]);

        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date("Y-m-d");

        $kadiv = User::where('role', 'Manager')->where('status', 'Active')->first();
        $kadep = User::where('role', 'Supervisor 1')->where('status', 'Active')->first();

        $dataEvaluasi = [
            'no_agenda' => strtoupper($request->noAgenda),
            'rencana_anggaran' => $request->rencanaAnggaran,
            'dokumen' => $request->dokumen,
            'denah' => $request->denah,
            'syarat' => $request->syarat,
            'evaluator1' => session('user')->username,
            'evaluator2' => $request->evaluator2,
            'catatan1' => $request->catatan,
            'kadep' => $kadep->username,
            'kadiv' => $kadiv->username,
            'status' => 'Approved 1',
            'create_by' => session('user')->username,
            'approve_date' => $tanggal,
        ];

        $dataUpdate = [
            'nilai_bantuan' => str_replace(".", "", $request->perkiraanDana),
            'status' => 'Evaluasi',
        ];

        if ($request->wilayahOperasi != null) {
            $dataWilayah = [
                'no_agenda' => $request->noAgenda,
                'kriteria' => $request->wilayahOperasi,
            ];
            DB::table('tbl_detail_kriteria')->insert($dataWilayah);
        }

        if ($request->kelancaranOperasional != null) {
            $dataKelancaran = [
                'no_agenda' => $request->noAgenda,
                'kriteria' => $request->kelancaranOperasional,
            ];
            DB::table('tbl_detail_kriteria')->insert($dataKelancaran);
        }

        if ($request->hubunganBaik != null) {
            $dataHubungan = [
                'no_agenda' => $request->noAgenda,
                'kriteria' => $request->hubunganBaik,
            ];
            DB::table('tbl_detail_kriteria')->insert($dataHubungan);
        }

        if ($request->brandImage != null) {
            $dataBrand = [
                'no_agenda' => $request->noAgenda,
                'kriteria' => $request->brandImage,
            ];
            DB::table('tbl_detail_kriteria')->insert($dataBrand);
        }

        if ($request->pengembanganWilayah != null) {
            $dataPengembangan = [
                'no_agenda' => $request->noAgenda,
                'kriteria' => $request->pengembanganWilayah,
            ];

            DB::table('tbl_detail_kriteria')->insert($dataPengembangan);
        }

        DB::table('tbl_evaluasi')->insert($dataEvaluasi);
        DB::table('tbl_kelayakan')
            ->where('no_agenda', $request->noAgenda)
            ->update($dataUpdate);
        return redirect()->route('dataKelayakan')->with('sukses', 'Evaluasi proposal berhasil disimpan');

//        try {
//
//        } catch (Exception $e) {
//            return redirect()->back()->with('gagal', 'Evaluasi proposal gagal disimpan');
//        }

    }

    public function formEvaluasi($loginID)
    {

        $data = DB::table('v_evaluasi')
            ->select('v_evaluasi.*')
            ->where('id_kelayakan', $loginID)
            ->first();
        return view('form.evaluasi')
            ->with([
                'data' => $data,
            ]);
    }

    public function ubahEvaluasi($loginID)
    {

        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }

        $kelayakan = Kelayakan::where('no_agenda', $logID)->first();
        $evaluasi = DB::table('v_evaluasi')
            ->select('v_evaluasi.*')
            ->where('no_agenda', $logID)
            ->first();
        $user = User::where([
            ['username', '!=', session('user')->username],
            ['status', '=', 'Active'],
        ])
            ->orderBy('nama', 'ASC')->get();

        $evaluator1 = User::where('username', $evaluasi->evaluator1)->first();
        $evaluator2 = User::where('username', $evaluasi->evaluator2)->first();
        return view('transaksi.edit_evaluasi')
            ->with([
                'data' => $evaluasi,
                'dataKelayakan' => $kelayakan,
                'dataUser' => $user,
                'evaluator1' => $evaluator1,
                'evaluator2' => $evaluator2,
            ]);
    }

    public function editEvaluasi(InsertEvaluasi $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalMenit = date("Y-m-d");

        if ($request->perkiraanDana == 'NaN') {
            $perkiraanDana = 0;
        } else {
            $perkiraanDana = $request->perkiraanDana;
        }

        if ($request->syarat == 'Tidak Memenuhi Syarat') {
            if ($request->status == 'Revisi') {
                $dataUpdate = [
                    'rencana_anggaran' => $request->rencanaAnggaran,
                    'dokumen' => $request->dokumen,
                    'denah' => $request->denah,
                    'syarat' => $request->syarat,
                    'evaluator2' => $request->evaluator2,
                    'catatan1' => $request->catatan,
                    'status' => 'Approved 1',
                ];

                $dataKelayakan = [
                    'nilai_bantuan' => 0,
                ];

                DetailKriteria::where('no_agenda', $request->noAgenda)->delete();
                try {
                    if ($request->wilayahOperasi != null) {
                        $dataWilayah = [
                            'no_agenda' => $request->noAgenda,
                            'kriteria' => $request->wilayahOperasi,
                        ];
                        DB::table('TBL_DETAIL_KRITERIA')->insert($dataWilayah);
                        //$insert = DetailKriteria::create($dataWilayah);
                    }

                    if ($request->kelancaranOperasional != null) {
                        $dataKelancaran = [
                            'no_agenda' => $request->noAgenda,
                            'kriteria' => $request->kelancaranOperasional,
                        ];
                        DB::table('TBL_DETAIL_KRITERIA')->insert($dataKelancaran);
                        //$insert = DetailKriteria::create($dataKelancaran);
                    }

                    if ($request->hubunganBaik != null) {
                        $dataHubungan = [
                            'no_agenda' => $request->noAgenda,
                            'kriteria' => $request->hubunganBaik,
                        ];
                        DB::table('TBL_DETAIL_KRITERIA')->insert($dataHubungan);
                        //$insert = DetailKriteria::create($dataHubungan);
                    }

                    if ($request->brandImage != null) {
                        $dataBrand = [
                            'no_agenda' => $request->noAgenda,
                            'kriteria' => $request->brandImage,
                        ];
                        DB::table('TBL_DETAIL_KRITERIA')->insert($dataBrand);
                        //$insert = DetailKriteria::create($dataBrand);
                    }

                    if ($request->pengembanganWilayah != null) {
                        $dataPengembangan = [
                            'no_agenda' => $request->noAgenda,
                            'kriteria' => $request->pengembanganWilayah,
                        ];
                        DB::table('TBL_DETAIL_KRITERIA')->insert($dataPengembangan);
                        //$insert = DetailKriteria::create($dataPengembangan);
                    }

                    Evaluasi::where('no_agenda', $request->noAgenda)->update($dataUpdate);
                    Kelayakan::where('no_agenda', $request->noAgenda)->update($dataKelayakan);

                    //SEND EMAIL
                    $dataEvaluasi = DB::table('v_evaluasi')
                        ->select('v_evaluasi.*')
                        ->where('no_agenda', $request->noAgenda)
                        ->first();
                    $evaluator1 = User::where('username', $dataEvaluasi->evaluator1)->first();
                    $evaluator2 = User::where('username', $dataEvaluasi->evaluator2)->first();
                    $kadep = User::where('role', 3)->first();
                    $dataEmail = [
                        'no_agenda' => $dataEvaluasi->no_agenda,
                        'pengirim' => $dataEvaluasi->pengirim,
                        'tgl_terima' => $dataEvaluasi->tgl_terima,
                        'dari' => $dataEvaluasi->asal_surat,
                        'no_surat' => $dataEvaluasi->no_surat,
                        'tgl_surat' => $dataEvaluasi->tgl_surat,
                        'sektor' => $dataEvaluasi->sektor_bantuan,
                        'perihal' => $dataEvaluasi->perihal,
                        'permohonan' => $dataEvaluasi->nilai_pengajuan,
                        'bantuan' => $dataEvaluasi->nilai_bantuan,
                        'evaluator1' => $evaluator1->nama,
                        'evaluator2' => $evaluator2->nama,
                        'penerima' => $kadep->nama,
                    ];

//                    Mail::send('mail.approval_evaluator', $dataEmail, function ($message) use ($kadep) {
//                        $message->to($kadep->email, $kadep->nama)
//                            ->subject('Evaluasi Proposal')
//                            ->from('pgn.no.reply@pertamina.com', 'PGN SHARE');
//                    });

                    return redirect()->route('detail-kelayakan', encrypt($request->noAgenda))->with('sukses', 'Evaluasi proposal berhasil diubah');
                } catch (Exception $e) {
                    return redirect()->back()->with('gagal', 'Evaluasi proposal gagal diubah');
                }
            } else {
                $dataUpdate = [
                    'rencana_anggaran' => $request->rencanaAnggaran,
                    'dokumen' => $request->dokumen,
                    'denah' => $request->denah,
                    'syarat' => $request->syarat,
                    'evaluator2' => $request->evaluator2,
                    'catatan1' => $request->catatan,
                ];

                $dataKelayakan = [
                    'nilai_bantuan' => 0,
                ];

                DetailKriteria::where('no_agenda', $request->noAgenda)->delete();

                try {
                    if ($request->wilayahOperasi != null) {
                        $dataWilayah = [
                            'no_agenda' => $request->noAgenda,
                            'kriteria' => $request->wilayahOperasi,
                        ];
                        DB::table('TBL_DETAIL_KRITERIA')->insert($dataWilayah);
                        //$insert = DetailKriteria::create($dataWilayah);
                    }

                    if ($request->kelancaranOperasional != null) {
                        $dataKelancaran = [
                            'no_agenda' => $request->noAgenda,
                            'kriteria' => $request->kelancaranOperasional,
                        ];
                        DB::table('TBL_DETAIL_KRITERIA')->insert($dataKelancaran);
                        //$insert = DetailKriteria::create($dataKelancaran);
                    }

                    if ($request->hubunganBaik != null) {
                        $dataHubungan = [
                            'no_agenda' => $request->noAgenda,
                            'kriteria' => $request->hubunganBaik,
                        ];

                        DB::table('TBL_DETAIL_KRITERIA')->insert($dataBrand);
                        //$insert = DetailKriteria::create($dataBrand);
                    }

                    if ($request->brandImage != null) {
                        $dataBrand = [
                            'no_agenda' => $request->noAgenda,
                            'kriteria' => $request->brandImage,
                        ];
                        $insert = DetailKriteria::create($dataBrand);
                    }

                    if ($request->pengembanganWilayah != null) {
                        $dataPengembangan = [
                            'no_agenda' => $request->noAgenda,
                            'kriteria' => $request->pengembanganWilayah,
                        ];
                        DB::table('TBL_DETAIL_KRITERIA')->insert($dataPengembangan);
                        //$insert = DetailKriteria::create($dataPengembangan);
                    }

                    Evaluasi::where('no_agenda', $request->noAgenda)->update($dataUpdate);
                    Kelayakan::where('no_agenda', $request->noAgenda)->update($dataKelayakan);
                    return redirect()->route('detail-kelayakan', encrypt($request->noAgenda))->with('sukses', 'Evaluasi proposal berhasil diubah');
                } catch (Exception $e) {
                    return redirect()->back()->with('gagal', 'Evaluasi proposal gagal diubah');
                }
            }
        } else {
            if ($request->status == 'Revisi') {
                if ($perkiraanDana == 0) {
                    return redirect()->back()->with('gagal', 'Perkiraan Dana tidak boleh 0');
                } else {
                    $dataUpdate = [
                        'rencana_anggaran' => $request->rencanaAnggaran,
                        'dokumen' => $request->dokumen,
                        'denah' => $request->denah,
                        'syarat' => $request->syarat,
                        'evaluator2' => $request->evaluator2,
                        'catatan1' => $request->catatan,
                        'status' => 'Approved 1',
                    ];

                    $dataKelayakan = [
                        'nilai_bantuan' => $perkiraanDana,
                    ];

                    DetailKriteria::where('no_agenda', $request->noAgenda)->delete();

                    try {
                        if ($request->wilayahOperasi != null) {
                            $dataWilayah = [
                                'no_agenda' => $request->noAgenda,
                                'kriteria' => $request->wilayahOperasi,
                            ];
                            DB::table('TBL_DETAIL_KRITERIA')->insert($dataWilayah);
                            //$insert = DetailKriteria::create($dataWilayah);
                        }

                        if ($request->kelancaranOperasional != null) {
                            $dataKelancaran = [
                                'no_agenda' => $request->noAgenda,
                                'kriteria' => $request->kelancaranOperasional,
                            ];
                            $insert = DetailKriteria::create($dataKelancaran);
                        }

                        if ($request->hubunganBaik != null) {
                            $dataHubungan = [
                                'no_agenda' => $request->noAgenda,
                                'kriteria' => $request->hubunganBaik,
                            ];
                            DB::table('TBL_DETAIL_KRITERIA')->insert($dataHubungan);
                            //$insert = DetailKriteria::create($dataHubungan);
                        }

                        if ($request->brandImage != null) {
                            $dataBrand = [
                                'no_agenda' => $request->noAgenda,
                                'kriteria' => $request->brandImage,
                            ];
                            DB::table('TBL_DETAIL_KRITERIA')->insert($dataBrand);
                            //$insert = DetailKriteria::create($dataBrand);
                        }

                        if ($request->pengembanganWilayah != null) {
                            $dataPengembangan = [
                                'no_agenda' => $request->noAgenda,
                                'kriteria' => $request->pengembanganWilayah,
                            ];
                            DB::table('TBL_DETAIL_KRITERIA')->insert($dataPengembangan);
                            //$insert = DetailKriteria::create($dataPengembangan);
                        }

                        Evaluasi::where('no_agenda', $request->noAgenda)->update($dataUpdate);
                        Kelayakan::where('no_agenda', $request->noAgenda)->update($dataKelayakan);

                        //SEND EMAIL
                        $dataEvaluasi = DB::table('v_evaluasi')
                            ->select('v_evaluasi.*')
                            ->where('no_agenda', $request->noAgenda)
                            ->first();
                        $evaluator1 = User::where('username', $dataEvaluasi->evaluator1)->first();
                        $evaluator2 = User::where('username', $dataEvaluasi->evaluator2)->first();
                        $kadep = User::where('role', 3)->first();
                        $dataEmail = [
                            'no_agenda' => $dataEvaluasi->no_agenda,
                            'pengirim' => $dataEvaluasi->pengirim,
                            'tgl_terima' => $dataEvaluasi->tgl_terima,
                            'dari' => $dataEvaluasi->asal_surat,
                            'no_surat' => $dataEvaluasi->no_surat,
                            'tgl_surat' => $dataEvaluasi->tgl_surat,
                            'sektor' => $dataEvaluasi->sektor_bantuan,
                            'perihal' => $dataEvaluasi->perihal,
                            'permohonan' => $dataEvaluasi->nilai_pengajuan,
                            'bantuan' => $dataEvaluasi->nilai_bantuan,
                            'evaluator1' => $evaluator1->nama,
                            'evaluator2' => $evaluator2->nama,
                            'penerima' => $kadep->nama,
                        ];

//                        Mail::send('mail.approval_evaluator', $dataEmail, function ($message) use ($kadep) {
//                            $message->to($kadep->email, $kadep->nama)
//                                ->subject('Evaluasi Proposal')
//                                ->from('pgn.no.reply@pertamina.com', 'PGN SHARE');
//                        });

                        return redirect()->route('detail-kelayakan', encrypt($request->noAgenda))->with('sukses', 'Evaluasi proposal berhasil diubah');
                    } catch (Exception $e) {
                        return redirect()->back()->with('gagal', 'Evaluasi proposal gagal diubah');
                    }
                }
            } else {
                if ($perkiraanDana == 0) {
                    return redirect()->back()->with('gagal', 'Perkiraan Dana tidak boleh 0');
                } else {
                    $dataUpdate = [
                        'rencana_anggaran' => $request->rencanaAnggaran,
                        'dokumen' => $request->dokumen,
                        'denah' => $request->denah,
                        'syarat' => $request->syarat,
                        'evaluator2' => $request->evaluator2,
                        'catatan1' => $request->catatan,
                    ];

                    $dataKelayakan = [
                        'nilai_bantuan' => $perkiraanDana,
                    ];

                    DetailKriteria::where('no_agenda', $request->noAgenda)->delete();

                    try {
                        if ($request->wilayahOperasi != null) {
                            $dataWilayah = [
                                'no_agenda' => $request->noAgenda,
                                'kriteria' => $request->wilayahOperasi,
                            ];
                            DB::table('TBL_DETAIL_KRITERIA')->insert($dataWilayah);
                            //$insert = DetailKriteria::create($dataWilayah);
                        }

                        if ($request->kelancaranOperasional != null) {
                            $dataKelancaran = [
                                'no_agenda' => $request->noAgenda,
                                'kriteria' => $request->kelancaranOperasional,
                            ];
                            DB::table('TBL_DETAIL_KRITERIA')->insert($dataKelancaran);
                            //$insert = DetailKriteria::create($dataKelancaran);
                        }

                        if ($request->hubunganBaik != null) {
                            $dataHubungan = [
                                'no_agenda' => $request->noAgenda,
                                'kriteria' => $request->hubunganBaik,
                            ];
                            DB::table('TBL_DETAIL_KRITERIA')->insert($dataHubungan);
                            //$insert = DetailKriteria::create($dataHubungan);
                        }

                        if ($request->brandImage != null) {
                            $dataBrand = [
                                'no_agenda' => $request->noAgenda,
                                'kriteria' => $request->brandImage,
                            ];
                            DB::table('TBL_DETAIL_KRITERIA')->insert($dataBrand);
                            //$insert = DetailKriteria::create($dataBrand);
                        }

                        if ($request->pengembanganWilayah != null) {
                            $dataPengembangan = [
                                'no_agenda' => $request->noAgenda,
                                'kriteria' => $request->pengembanganWilayah,
                            ];
                            DB::table('TBL_DETAIL_KRITERIA')->insert($dataPengembangan);
                            //$insert = DetailKriteria::create($dataPengembangan);
                        }

                        Evaluasi::where('no_agenda', $request->noAgenda)->update($dataUpdate);
                        Kelayakan::where('no_agenda', $request->noAgenda)->update($dataKelayakan);
                        return redirect()->route('detail-kelayakan', encrypt($request->noAgenda))->with('sukses', 'Evaluasi proposal berhasil diubah');
                    } catch (Exception $e) {
                        return redirect()->back()->with('gagal', 'Evaluasi proposal gagal diubah');
                    }
                }
            }

        }
    }

    public function editkadepEvaluasi(Request $request)
    {
        try {
            $logID = decrypt($request->noAgenda);
        } catch (Exception $e) {
            abort(404);
        }

        $dataUpdate = [
            'kadep' => $request->namaKadep,
        ];

        try {
            Evaluasi::where('no_agenda', $logID)->update($dataUpdate);
            return redirect()->back()->with('sukses', 'Depertment Head Operation berhasil diubah');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Depertment Head Operation gagal diubah');
        }
    }

    public function forwardEvaluasi($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }

        $dataUpdate = [
            'status' => 'Forward',
        ];

        //SEND EMAIL
        $dataEvaluasi = DB::table('v_evaluasi')
            ->select('v_evaluasi.*')
            ->where('no_agenda', $logID)
            ->first();

        $evaluator1 = User::where('username', $dataEvaluasi->evaluator1)->first();
        $evaluator2 = User::where('username', $dataEvaluasi->evaluator2)->first();
        $dataEmail = [
            'no_agenda' => $dataEvaluasi->no_agenda,
            'pengirim' => $dataEvaluasi->pengirim,
            'tgl_terima' => $dataEvaluasi->tgl_terima,
            'dari' => $dataEvaluasi->asal_surat,
            'no_surat' => $dataEvaluasi->no_surat,
            'tgl_surat' => $dataEvaluasi->tgl_surat,
            'sektor' => $dataEvaluasi->sektor_bantuan,
            'perihal' => $dataEvaluasi->perihal,
            'permohonan' => $dataEvaluasi->nilai_pengajuan,
            'bantuan' => $dataEvaluasi->nilai_bantuan,
            'evaluator1' => $evaluator1->nama,
            'evaluator2' => $evaluator2->nama,
            'penerima' => $evaluator2->nama,
        ];

        try {
            Mail::send('mail.approval_evaluator', $dataEmail, function ($message) use ($evaluator2) {
                $message->to($evaluator2->email, $evaluator2->nama)
                    ->subject('Evaluasi Proposal')
                    ->from('pgn.no.reply@pertamina.com', 'PGN SHARE');
            });

            Evaluasi::where('no_agenda', $logID)->update($dataUpdate);
            return redirect()->back()->with('sukses', 'Evaluasi proposal berhasil diteruskan');

        } catch (Exception $e) {
            Evaluasi::where('no_agenda', $logID)->update($dataUpdate);
            return redirect()->back()->with('sukses', 'Evaluasi proposal berhasil diteruskan');
        }

    }

    public function deleteEvaluasi($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }

        $dataUpdate = [
            'status' => 'Draft',
        ];

        Evaluasi::where('no_agenda', $logID)->delete();
        Survei::where('no_agenda', $logID)->delete();
        Kelayakan::where('no_agenda', $logID)->update($dataUpdate);
        DetailKriteria::where('no_agenda', $logID)->delete();
        return redirect()->back()->with('sukses', 'Evaluasi proposal berhasil dihapus');
    }

    public function editTanggal1(Request $request)
    {
        try {
            $logID = decrypt($request->noAgenda);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'tanggalEvaluator1' => 'required',
            'komentarEvaluator' => 'required',
        ]);

        $dataUpdate = [
            'create_date' => date('Y-m-d', strtotime($request->tanggalEvaluator1)),
            'catatan1' => $request->komentarEvaluator,
        ];

        try {
            Evaluasi::where('no_agenda', $logID)->update($dataUpdate);
            return redirect()->back()->with('sukses', "Komentar berhasil diubah");
        } catch (Exception $e) {
            return redirect()->back()->with('peringatan', 'Komentar gagal diubah');
        }
    }

    public function editTanggal2(Request $request)
    {
        try {
            $logID = decrypt($request->noAgenda);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'tanggalEvaluator2' => 'required',
        ]);

        $dataUpdate = [
            'approve_date' => date('Y-m-d', strtotime($request->tanggalEvaluator2)),
        ];

        try {
            Evaluasi::where('no_agenda', $logID)->update($dataUpdate);
            return redirect()->back()->with('sukses', "Tanggal berhasil diubah");
        } catch (Exception $e) {
            return redirect()->back()->with('peringatan', 'Tanggal gagal diubah');
        }
    }

    public function editTanggal3(Request $request)
    {
        try {
            $logID = decrypt($request->noAgenda);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'tanggalKadepEvaluasi' => 'required',
            'komentarKadepEvaluasi' => 'required',
        ]);

        $dataUpdate = [
            'approve_kadep' => date('Y-m-d', strtotime($request->tanggalKadepEvaluasi)),
            'ket_kadin1' => $request->komentarKadepEvaluasi,
        ];

        try {
            Evaluasi::where('no_agenda', $logID)->update($dataUpdate);
            return redirect()->back()->with('sukses', "Komentar berhasil diubah");
        } catch (Exception $e) {
            return redirect()->back()->with('peringatan', 'Komentar gagal diubah');
        }
    }

    public function editTanggal4(Request $request)
    {
        try {
            $logID = decrypt($request->noAgenda);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'tanggalKadivEvaluasi' => 'required',
            'komentarKadivEvaluasi' => 'required',
        ]);

        $dataUpdate = [
            'approve_kadiv' => date('Y-m-d', strtotime($request->tanggalKadivEvaluasi)),
            'ket_kadiv' => $request->komentarKadivEvaluasi,
        ];

        try {
            Evaluasi::where('no_agenda', $logID)->update($dataUpdate);
            return redirect()->back()->with('sukses', "Komentar berhasil diubah");
        } catch (Exception $e) {
            return redirect()->back()->with('peringatan', 'Komentar gagal diubah');
        }
    }
}