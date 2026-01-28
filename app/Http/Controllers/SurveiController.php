<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditSurvei;
use App\Http\Requests\InsertTanggal;
use App\Models\BASTDana;
use App\Models\Evaluasi;
use App\Models\Kelayakan;
use App\Models\Lampiran;
use App\Models\Proker;
use App\Models\Survei;
use App\Models\User;
use App\Models\Vendor;
use App\Models\ViewProker;
use App\Models\ViewHirarki;
use Illuminate\Http\Request;
use App\Http\Requests\InsertSurvei;
use Illuminate\Support\Facades\DB;
use Mail;
use Exception;

class SurveiController extends Controller
{
    public function index()
    {
        $data = DB::table('v_survei')
            ->select('v_survei.*')
            ->orderBy('id_survei', 'DESC')
            ->get();
        return view('report.data_survei')
            ->with([
                'dataSurvei' => $data
            ]);
    }

    public function setuju()
    {
        $data = DB::table('v_survei')
            ->select('v_survei.*')
            ->where('status', 'Approved 3')
            ->orderBy('id_survei', 'DESC')
            ->get();
        return view('report.data_disetujui')
            ->with([
                'dataSurvei' => $data
            ]);
    }

    public function inputSurvei($loginID)
    {

        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }

        $tahun = date("Y");
        $kelayakan = Kelayakan::where('no_agenda', $logID)->first();
        $evaluasi = Evaluasi::where('no_agenda', $logID)->first();
        $vendor = Vendor::all();
        $proker = Proker::where('perusahaan', 'PT Nusantara Regas')->where('tahun', $tahun)->orderBy('id_proker', 'ASC')->get();
        $user = User::where([
            ['username', '!=', session('user')->username],
            ['status', '=', 'Active'],
        ])
            ->orderBy('nama', 'ASC')->get();
        return view('transaksi.input_survei')
            ->with([
                'data' => $kelayakan,
                'dataEvaluasi' => $evaluasi,
                'dataVendor' => $vendor,
                'dataProker' => $proker,
                'dataUser' => $user,
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
            'bantuan'            => 'required|in:Dana,Barang',
            'usulan'             => 'required|in:Disarankan,Dipertimbangkan,Tidak Memenuhi Kriteria',
            'nilaiBantuanAsli'   => 'required|numeric|min:1',
            'reviewer'           => 'required|string|max:200',
        ], [
            'bantuan.required' => 'Jenis bantuan wajib dipilih.',
            'usulan.required' => 'Rekomendasi/usulan wajib dipilih.',
            'nilaiBantuanAsli.required' => 'Nilai bantuan asli wajib diisi.',
            'reviewer.required' => 'Reviewer wajib dipilih.',
        ]);

        // Ambil data kelayakan
        $kelayakan = Kelayakan::find($kelayakanID);
        if (!$kelayakan) {
            return redirect()->back()->with('gagalDetail', 'Data kelayakan tidak ditemukan.');
        }

        // Validasi hirarki pengguna
        $maker = ViewHirarki::where([
            ['id_user', session('user')->id_user],
            ['level', 1],
            ['status', 'Active']
        ])->first();

        if (!$maker) {
            return redirect()->back()->with('gagal', "Anda tidak terdaftar sebagai Maker kelayakan proposal")->withInput();
        }

        $approver = ViewHirarki::where('level', 3)->where('status', 'Active')->first();
        $lastApprover = ViewHirarki::where('level', 4)->where('status', 'Active')->first();
        $sekper = ViewHirarki::where('level', 5)->first();
        $dirut = ViewHirarki::where('level', 6)->first();

        // Hitung persentase & rupiah termin
        $jumlahTermin = $request->jumlah_termin;
        $nilaiBantuan = $request->nilaiBantuanAsli;
        $totalPersen = 0;
        $persenTermin = [];
        $rupiahTermin = [];

        // for ($i = 1; $i <= $jumlahTermin; $i++) {
        //     $persen = (int) $request->input("persen_termin_$i", 0);

        //     if ($persen < 0 || $persen > 100) {
        //         return redirect()->back()->with('gagalDetail', "Persentase termin $i tidak valid")->withInput();
        //     }

        //     $persenTermin[$i] = $persen;
        //     $rupiahTermin[$i] = round(($persen / 100) * $nilaiBantuan);
        //     $totalPersen += $persen;
        // }

        // if ($totalPersen !== 100) {
        //     return redirect()->back()->with('gagalDetail', 'Total persentase harus 100%')->withInput();
        // }

        // Siapkan data survei
        $dataSurvei = [
            'id_kelayakan'    => $kelayakan->id_kelayakan,
            'no_agenda'       => $kelayakan->no_agenda,
            'usulan'          => $request->usulan,
            'bantuan_berupa'  => $request->bantuan,
            'nilai_bantuan'   => $nilaiBantuan,
            'termin'          => 1,
            'persen1'          => 100,
            'rupiah1'          => $nilaiBantuan,
            'survei1'         => session('user')->username,
            'survei2'         => $request->reviewer,
            'status'          => 'Forward',
            'kadep'           => $approver->username,
            'kadiv'           => $lastApprover->username,
            'sekper' => $sekper->username,
            'dirut' => $dirut->username,
            'created_by'      => session('user')->id_user,
        ];

        // Tambahkan persen dan rupiah ke array
        // for ($i = 1; $i <= 4; $i++) {
        //     $dataSurvei["persen$i"] = $persenTermin[$i] ?? 0;
        //     $dataSurvei["rupiah$i"] = $rupiahTermin[$i] ?? 0;
        // }

        // Update status kelayakan
        $dataKelayakan = [
            'status'             => 'Survei',
            'nilai_bantuan'   => $nilaiBantuan,
            'nominal_approved'   => $nilaiBantuan,
        ];

        // Log dan approval
        $dataLog = [
            'id_kelayakan'  => $kelayakanID,
            'keterangan'    => 'Input survei proposal',
            'created_by'    => session('user')->id_user,
            'created_date'  => now(),
        ];

        $dataApproval = [
            'id_kelayakan'  => $kelayakanID,
            'id_hirarki'    => $maker->id,
            'id_user'       => $maker->id_user,
            'status'        => 'In Progress',
            'phase'         => 'Survei',
            'status_date'   => now(),
            'task_date'     => now(),
            'action_date'   => null,
            'created_by'    => session('user')->id_user,
        ];

        // Simpan ke DB
        try {
            DB::table('tbl_survei')->insert($dataSurvei);
            DB::table('tbl_kelayakan')->where('id_kelayakan', $kelayakanID)->update($dataKelayakan);
            DB::table('tbl_log')->insert($dataLog);
            DB::table('tbl_detail_approval')->insert($dataApproval);

            return redirect()->back()->with('suksesDetail', 'Survei proposal berhasil disimpan');
        } catch (Exception $e) {
            return redirect()->back()->with('gagalDetail', 'Survei proposal gagal disimpan');
        }
    }

    public function update(Request $request)
    {
        try {
            $surveiID = decrypt($request->surveiID);
        } catch (Exception $e) {
            abort(404);
        }

        $request->validate([
            'bantuan'            => 'required|in:Dana,Barang',
            'usulan'             => 'required|in:Disarankan,Dipertimbangkan,Tidak Memenuhi Kriteria',
            'nilaiBantuan'       => 'required|string',
            'nilaiBantuanAsli'   => 'required|numeric|min:1',
            'reviewer'           => 'required|string|max:200',
        ], [
            'bantuan.required' => 'Jenis bantuan wajib dipilih.',
            'usulan.required' => 'Rekomendasi/usulan wajib dipilih.',
            'nilaiBantuan.required' => 'Nilai bantuan wajib diisi.',
            'nilaiBantuanAsli.required' => 'Nilai bantuan asli wajib diisi.',
            'reviewer.required' => 'Reviewer wajib dipilih.',
        ]);

        $survei = DB::table('tbl_survei')->where('id_survei', $surveiID)->first();
        if (!$survei) {
            return redirect()->back()->with('gagalDetail', 'Data survei tidak ditemukan.');
        }

        $kelayakanID = $survei->id_kelayakan;
        $kelayakan = DB::table('tbl_kelayakan')->where('id_kelayakan', $kelayakanID)->first();
        if (!$kelayakan) {
            return redirect()->back()->with('gagalDetail', 'Data kelayakan tidak ditemukan.');
        }

        $nilaiBantuan = $request->nilaiBantuanAsli;
        $jumlahTermin = $survei->termin;

        $persenTermin = [];
        $rupiahTermin = [];

        for ($i = 1; $i <= $jumlahTermin; $i++) {
            $persen = $survei->{"persen$i"} ?? 0;
            $persenTermin[$i] = $persen;
            $rupiahTermin[$i] = round(($persen / 100) * $nilaiBantuan);
        }

        $dataUpdate = [
            'usulan'         => $request->usulan,
            'bantuan_berupa' => $request->bantuan,
            'nilai_bantuan'  => $nilaiBantuan,
            'survei1'        => session('user')->username,
            'survei2'        => $request->reviewer,
        ];

        for ($i = 1; $i <= 4; $i++) {
            $dataUpdate["rupiah$i"] = $rupiahTermin[$i] ?? 0;
        }

        $dataKelayakan = [
            'nilai_bantuan'   => $nilaiBantuan,
            'nominal_approved'   => $nilaiBantuan,
        ];

        $dataLog = [
            'id_kelayakan' => $kelayakanID,
            'keterangan'   => 'Edit survei proposal',
            'created_by'   => session('user')->id_user,
            'created_date' => now(),
        ];

        try {
            DB::table('tbl_survei')->where('id_survei', $surveiID)->update($dataUpdate);
            DB::table('tbl_kelayakan')->where('id_kelayakan', $kelayakanID)->update($dataKelayakan);
            DB::table('tbl_log')->insert($dataLog);

            return redirect()->back()->with('suksesDetail', 'Survei kelayakan proposal berhasil diperbarui.');
        } catch (Exception $e) {
            return redirect()->back()->with('gagalDetail', 'Gagal memperbarui survei kelayakan proposal.');
        }
    }

    public function updateTerminOld(Request $request)
    {
        try {
            $surveiID = decrypt($request->surveiID);
        } catch (Exception $e) {
            abort(404);
        }

        $request->validate([
            'jumlah_termin' => 'required|integer|min:1|max:4',
        ], [
            'jumlah_termin.required' => 'Jumlah termin wajib dipilih.',
        ]);

        $survei = DB::table('tbl_survei')->where('id_survei', $surveiID)->first();
        if (!$survei) {
            return redirect()->back()->with('gagalDetail', 'Data survei tidak ditemukan.');
        }

        $jumlahTermin = $request->jumlah_termin;
        $nilaiBantuan = $survei->nilai_bantuan;

        $totalPersen = 0;
        $persenTermin = [];
        $rupiahTermin = [];

        for ($i = 1; $i <= $jumlahTermin; $i++) {
            $fieldName = "persen_termin_{$i}";
            $persen = (int) $request->input($fieldName, 0);

            if ($persen < 0 || $persen > 100) {
                return redirect()->back()->with('gagalDetail', "Persentase termin $i tidak valid")->withInput();
            }

            $persenTermin[$i] = $persen;
            $rupiahTermin[$i] = round(($persen / 100) * $nilaiBantuan);
            $totalPersen += $persen;
        }

        if ($totalPersen !== 100) {
            return redirect()->back()->with('gagalDetail', 'Total persentase harus 100%')->withInput();
        }

        $update = [
            'termin' => $jumlahTermin,
        ];

        for ($i = 1; $i <= 4; $i++) {
            $update["persen$i"] = $persenTermin[$i] ?? 0;
            $update["rupiah$i"] = $rupiahTermin[$i] ?? 0;
        }

        $dataLog = [
            'id_kelayakan' => $survei->id_kelayakan,
            'keterangan'   => 'Edit termin pembayaran',
            'created_by'   => session('user')->id_user,
            'created_date' => now(),
        ];

        try {
            DB::table('tbl_survei')->where('id_survei', $surveiID)->update($update);
            DB::table('tbl_log')->insert($dataLog);

            return redirect()->back()->with('suksesDetail', 'Termin pembayaran berhasil diperbarui.');
        } catch (Exception $e) {
            return redirect()->back()->with('gagalDetail', 'Gagal memperbarui termin pembayaran.');
        }
    }

    public function updateTermin(Request $request)
    {
        try {
            $surveiID = decrypt($request->surveiID);
        } catch (\Exception $e) {
            abort(404);
        }

        // Validasi jumlah termin dulu
        $request->validate([
            'jumlah_termin' => 'required|integer|min:1|max:4',
        ], [
            'jumlah_termin.required' => 'Jumlah termin wajib dipilih.',
        ]);

        $survei = DB::table('tbl_survei')->where('id_survei', $surveiID)->first();
        if (! $survei) {
            return back()->with('gagalDetail', 'Data survei tidak ditemukan.')->withInput();
        }

        $jumlahTermin = (int) $request->jumlah_termin;
        $nilaiBantuan = (float) $survei->nilai_bantuan;

        // Validasi dinamis untuk setiap persen termin
        $rules = [];
        $messages = [];
        for ($i = 1; $i <= $jumlahTermin; $i++) {
            $rules["persen_termin_$i"] = ['required','numeric','min:0','max:100'];
            $messages["persen_termin_$i.required"] = "Persen termin $i wajib diisi.";
            $messages["persen_termin_$i.numeric"]  = "Persen termin $i harus berupa angka.";
            $messages["persen_termin_$i.min"]      = "Persen termin $i minimal 0.";
            $messages["persen_termin_$i.max"]      = "Persen termin $i maksimal 100.";
        }
        $request->validate($rules, $messages);

        $totalPersen   = 0.0;
        $persenTermin  = [];
        $rupiahTermin  = [];

        for ($i = 1; $i <= $jumlahTermin; $i++) {
            $fieldName = "persen_termin_{$i}";

            // Normalisasi 37,5 -> 37.5 lalu cast ke float
            $raw     = (string) $request->input($fieldName, 0);
            $raw     = str_replace(',', '.', $raw);
            $persen  = (float) $raw;

            $persenTermin[$i] = $persen;
            $rupiahTermin[$i] = round(($persen / 100) * $nilaiBantuan);
            $totalPersen     += $persen;
        }

        // Toleransi 0.01 agar 99.9999/100.0001 tidak bikin gagal
        if (abs($totalPersen - 100.0) > 0.01) {
            return back()->with('gagalDetail', 'Total persentase harus 100%')->withInput();
        }

        $update = [
            'termin' => $jumlahTermin,
        ];

        // Simpan sampai 4 termin, sisanya 0
        for ($i = 1; $i <= 4; $i++) {
            $update["persen$i"] = isset($persenTermin[$i]) ? $persenTermin[$i] : 0;
            $update["rupiah$i"] = isset($rupiahTermin[$i]) ? $rupiahTermin[$i] : 0;
        }

        $dataLog = [
            'id_kelayakan' => $survei->id_kelayakan,
            'keterangan'   => 'Edit termin pembayaran',
            'created_by'   => session('user')->id_user,
            'created_date' => now(),
        ];

        try {
            DB::table('tbl_survei')->where('id_survei', $surveiID)->update($update);
            DB::table('tbl_log')->insert($dataLog);

            return back()->with('suksesDetail', 'Termin pembayaran berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('gagalDetail', 'Gagal memperbarui termin pembayaran.');
        }
    }

    public function formSurvei($loginID)
    {
        $data = DB::table('v_survei')
            ->select('v_survei.*')
            ->where('id_kelayakan', $loginID)
            ->first();
        return view('form.survei')
            ->with([
                'data' => $data,
            ]);
    }

    public function kwitansi($loginID)
    {
        $data = DB::table('v_pembayaran')
            ->select('v_pembayaran.*')
            ->where('id_pembayaran', $loginID)
            ->first();
        $dataAgenda = Kelayakan::where('no_agenda', $data->no_agenda)->first();
        $dataSurvei = Survei::where('no_agenda', $data->no_agenda)->first();
        $dataBAST = BASTDana::where('no_agenda', $data->no_agenda)->first();
        return view('form.kwitansi')
            ->with([
                'data' => $data,
                'dataAgenda' => $dataAgenda,
                'dataSurvei' => $dataSurvei,
                'dataBAST' => $dataBAST,
            ]);
    }

    public function suratPenolakan($loginID)
    {
        $data = DB::table('TBL_KELAYAKAN')
            ->select('TBL_KELAYAKAN.*')
            ->where('ID_KELAYAKAN', $loginID)
            ->first();
        return view('form.surat_penolakan')
            ->with([
                'data' => $data,
            ]);
    }

    public function ubahSurvei($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }

        $survei = DB::table('v_survei')
            ->select('v_survei.*')
            ->where('no_agenda', $logID)
            ->first();
        $evaluasi = Evaluasi::where('no_agenda', $logID)->first();
        $user = User::where([
            ['username', '!=', session('user')->username],
            ['status', '=', 'Active'],
        ])
            ->orderBy('nama', 'ASC')->get();
        return view('transaksi.edit_survei')
            ->with([
                'data' => $survei,
                'dataUser' => $user,
                'dataEvaluasi' => $evaluasi,
            ]);
    }

    public function updateNilaiSurvei(Request $request)
    {
        try {
            $logID = decrypt($request->noAgenda);
        } catch (Exception $e) {
            abort(404);
        }

        $dataUpdate = [
            'nilai_approved' => str_replace(".", "", $request->nilaiSurvei),
            'ket_kadiv' => $request->catatanSurvei,
        ];

        try {
            Survei::where('no_agenda', $logID)->update($dataUpdate);
            return redirect()->back()->with('berhasil', 'Nominal bantuan berhasil diubah');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Nominal persetujuan gagal diubah');
        }
    }

    public function editkadepSurvei(Request $request)
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
            Survei::where('no_agenda', $logID)->update($dataUpdate);
            return redirect()->route('detail-kelayakan', encrypt($request->noAgenda))->with('berhasil', 'Depertment Head Operation berhasil diubah');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Depertment Head Operation gagal diubah');
        }
    }

    public function editSurvei(EditSurvei $request)
    {
        if ($request->termin == 1) {
            if ($request->termin1 == '') {
                return redirect()->back()->with('gagal', 'Persentase termin pembayaran harus diisi');
            } else {
                if ($request->termin1 != 100) {
                    return redirect()->back()->with('gagal', 'Persentase termin belum mencapai 100%');
                } else {
                    $rupiah1 = $request->nilaiBantuan * $request->termin1 / 100;
                    if ($request->status == 'Revisi') {
                        $dataUpdate = [
                            'hasil_konfirmasi' => $request->konfirmasi,
                            'hasil_survei' => $request->survei,
                            'usulan' => $request->usulan,
                            'bantuan_berupa' => $request->bantuan,
                            'nilai_bantuan' => $request->nilaiBantuan,
                            'termin' => $request->termin,
                            'persen1' => $request->termin1,
                            'rupiah1' => $rupiah1,
                            'survei2' => $request->survei2,
                            'status' => 'Approved 1',
                        ];
                    }else{
                        $dataUpdate = [
                            'hasil_konfirmasi' => $request->konfirmasi,
                            'hasil_survei' => $request->survei,
                            'usulan' => $request->usulan,
                            'bantuan_berupa' => $request->bantuan,
                            'nilai_bantuan' => $request->nilaiBantuan,
                            'termin' => $request->termin,
                            'persen1' => $request->termin1,
                            'rupiah1' => $rupiah1,
                            'survei2' => $request->survei2,
                        ];
                    }
                }
            }
        } elseif ($request->termin == 2) {
            if ($request->termin1 == '' and $request->termin2 == '') {
                return redirect()->back()->with('gagal', 'Persentase termin pembayaran harus diisi');
            } else {
                if ($request->termin1 + $request->termin2 != 100) {
                    return redirect()->back()->with('gagal', 'Persentase termin belum mencapai 100%');
                } else {
                    $rupiah1 = $request->nilaiBantuan * $request->termin1 / 100;
                    $rupiah2 = $request->nilaiBantuan * $request->termin2 / 100;
                    if ($request->status == 'Revisi') {
                        $dataUpdate = [
                            'hasil_konfirmasi' => $request->konfirmasi,
                            'hasil_survei' => $request->survei,
                            'usulan' => $request->usulan,
                            'bantuan_berupa' => $request->bantuan,
                            'nilai_bantuan' => $request->nilaiBantuan,
                            'termin' => $request->termin,
                            'persen1' => $request->termin1,
                            'persen2' => $request->termin2,
                            'rupiah1' => $rupiah1,
                            'rupiah2' => $rupiah2,
                            'survei2' => $request->survei2,
                            'status' => 'Approved 1',
                        ];
                    }else{
                        $dataUpdate = [
                            'hasil_konfirmasi' => $request->konfirmasi,
                            'hasil_survei' => $request->survei,
                            'usulan' => $request->usulan,
                            'bantuan_berupa' => $request->bantuan,
                            'nilai_bantuan' => $request->nilaiBantuan,
                            'termin' => $request->termin,
                            'persen1' => $request->termin1,
                            'persen2' => $request->termin2,
                            'rupiah1' => $rupiah1,
                            'rupiah2' => $rupiah2,
                            'survei2' => $request->survei2,
                        ];
                    }
                }
            }
        } elseif ($request->termin == 3) {
            if ($request->termin1 == '' and $request->termin2 == '' and $request->termin3 == '') {
                return redirect()->back()->with('gagal', 'Persentase termin pembayaran harus diisi');
            } else {
                if ($request->termin1 + $request->termin2 + $request->termin3 != 100) {
                    return redirect()->back()->with('gagal', 'Persentase termin belum mencapai 100%');
                } else {
                    $rupiah1 = $request->nilaiBantuan * $request->termin1 / 100;
                    $rupiah2 = $request->nilaiBantuan * $request->termin2 / 100;
                    $rupiah3 = $request->nilaiBantuan * $request->termin3 / 100;
                    if ($request->status == 'Revisi') {
                        $dataUpdate = [
                            'hasil_konfirmasi' => $request->konfirmasi,
                            'hasil_survei' => $request->survei,
                            'usulan' => $request->usulan,
                            'bantuan_berupa' => $request->bantuan,
                            'nilai_bantuan' => $request->nilaiBantuan,
                            'termin' => $request->termin,
                            'persen1' => $request->termin1,
                            'persen2' => $request->termin2,
                            'persen3' => $request->termin3,
                            'rupiah1' => $rupiah1,
                            'rupiah2' => $rupiah2,
                            'rupiah3' => $rupiah3,
                            'survei2' => $request->survei2,
                            'status' => 'Approved 1',
                        ];
                    }else{
                        $dataUpdate = [
                            'hasil_konfirmasi' => $request->konfirmasi,
                            'hasil_survei' => $request->survei,
                            'usulan' => $request->usulan,
                            'bantuan_berupa' => $request->bantuan,
                            'nilai_bantuan' => $request->nilaiBantuan,
                            'termin' => $request->termin,
                            'persen1' => $request->termin1,
                            'persen2' => $request->termin2,
                            'persen3' => $request->termin3,
                            'rupiah1' => $rupiah1,
                            'rupiah2' => $rupiah2,
                            'rupiah3' => $rupiah3,
                            'survei2' => $request->survei2,
                        ];
                    }
                }
            }
        } elseif ($request->termin == 4) {
            if ($request->termin1 == '' and $request->termin2 == '' and $request->termin3 == '' and $request->termin4 == '') {
                return redirect()->back()->with('gagal', 'Persentase termin pembayaran harus diisi');
            } else {
                if ($request->termin1 + $request->termin2 + $request->termin3 + $request->termin4 != 100) {
                    return redirect()->back()->with('gagal', 'Persentase termin belum mencapai 100%');
                } else {
                    $rupiah1 = $request->nilaiBantuan * $request->termin1 / 100;
                    $rupiah2 = $request->nilaiBantuan * $request->termin2 / 100;
                    $rupiah3 = $request->nilaiBantuan * $request->termin3 / 100;
                    $rupiah4 = $request->nilaiBantuan * $request->termin4 / 100;

                    if ($request->status == 'Revisi') {
                        $dataUpdate = [
                            'hasil_konfirmasi' => $request->konfirmasi,
                            'hasil_survei' => $request->survei,
                            'usulan' => $request->usulan,
                            'bantuan_berupa' => $request->bantuan,
                            'nilai_bantuan' => $request->nilaiBantuan,
                            'termin' => $request->termin,
                            'persen1' => $request->termin1,
                            'persen2' => $request->termin2,
                            'persen3' => $request->termin3,
                            'persen4' => $request->termin4,
                            'rupiah1' => $rupiah1,
                            'rupiah2' => $rupiah2,
                            'rupiah3' => $rupiah3,
                            'rupiah4' => $rupiah4,
                            'survei2' => $request->survei2,
                            'status' => 'Approved 1',
                        ];
                    }else{
                        $dataUpdate = [
                            'hasil_konfirmasi' => $request->konfirmasi,
                            'hasil_survei' => $request->survei,
                            'usulan' => $request->usulan,
                            'bantuan_berupa' => $request->bantuan,
                            'nilai_bantuan' => $request->nilaiBantuan,
                            'termin' => $request->termin,
                            'persen1' => $request->termin1,
                            'persen2' => $request->termin2,
                            'persen3' => $request->termin3,
                            'persen4' => $request->termin4,
                            'rupiah1' => $rupiah1,
                            'rupiah2' => $rupiah2,
                            'rupiah3' => $rupiah3,
                            'rupiah4' => $rupiah4,
                            'survei2' => $request->survei2,
                        ];
                    }
                }
            }
        }
        try {
            Survei::where('no_agenda', $request->noAgenda)->update($dataUpdate);
            return redirect()->route('detail-kelayakan', encrypt($request->noAgenda))->with('berhasil', 'Survei proposal berhasil diubah');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Survei proposal gagal diubah');
        }
    }

    public function forwardSurvei($loginID)
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
            'survei1' => $survei1->nama,
            'survei2' => $survei2->nama,
            'penerima' => $survei1->nama,
        ];

        try {
            Mail::send('mail.approval_surveyor', $dataEmail, function ($message) use ($survei2) {
                $message->to($survei2->email, $survei2->nama)
                    ->subject('Survei Proposal')
                    ->from('pgn.no.reply@pertamina.com', 'NR SHARE');
            });

            Survei::where('no_agenda', $logID)->update($dataUpdate);
            return redirect()->back()->with('berhasil', 'Survei proposal berhasil diteruskan');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', $e->getMessage());
        }

    }

    public function deleteSurvei($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }

        $dataUpdate = [
            'status' => 'Evaluasi',
        ];

        $UpdateEvaluasi = [
            'status' => 'Approved 3',
        ];

        Survei::where('no_agenda', $logID)->delete();
        Evaluasi::where('no_agenda', $logID)->update($UpdateEvaluasi);
        Kelayakan::where('no_agenda', $logID)->update($dataUpdate);
        return redirect()->back()->with('sukses', 'Survei proposal berhasil dihapus');
    }

    public function editTanggal1(Request $request)
    {
        try {
            $logID = decrypt($request->noAgenda);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'tanggalSurvei1' => 'required',
            'komentarSurvei1' => 'required',
        ]);

        $dataUpdate = [
            'create_date' => date('Y-m-d', strtotime($request->tanggalSurvei1)),
            'hasil_survei' => $request->komentarSurvei1,
        ];

        try {
            Survei::where('no_agenda', $logID)->update($dataUpdate);
            return redirect()->back()->with('sukses', "Tanggal berhasil diubah");
        } catch (Exception $e) {
            return redirect()->back()->with('peringatan', 'Tanggal gagal diubah');
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
            'tanggalSurvei2' => 'required',
            'komentarSurvei2' => 'required',
        ]);

        $dataUpdate = [
            'approve_date' => date('Y-m-d', strtotime($request->tanggalSurvei2)),
            'hasil_konfirmasi' => $request->komentarSurvei2,
        ];

        try {
            Survei::where('no_agenda', $logID)->update($dataUpdate);
            return redirect()->back()->with('sukses', "Komentar berhasil diubah");
        } catch (Exception $e) {
            return redirect()->back()->with('peringatan', 'Komentar gagal diubah');
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
            'tanggalKadep' => 'required',
            'komentarKadep' => 'required',
        ]);

        $dataUpdate = [
            'approve_kadep' => date('Y-m-d', strtotime($request->tanggalKadep)),
            'ket_kadin1' => $request->komentarKadep,
        ];

        try {
            Survei::where('no_agenda', $logID)->update($dataUpdate);
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
            'tanggalKadiv' => 'required',
            'komentarKadiv' => 'required',
        ]);

        $dataUpdate = [
            'approve_kadiv' => date('Y-m-d', strtotime($request->tanggalKadiv)),
            'ket_kadiv' => $request->komentarKadiv,
        ];

        try {
            Survei::where('no_agenda', $logID)->update($dataUpdate);
            return redirect()->back()->with('sukses', "Komentar berhasil diubah");
        } catch (Exception $e) {
            return redirect()->back()->with('peringatan', 'Komentar gagal diubah');
        }
    }

}