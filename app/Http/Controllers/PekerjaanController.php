<?php

namespace App\Http\Controllers;

use App\Models\BAKN;
use App\Models\LampiranPekerjaan;
use App\Models\LogPekerjaan;
use App\Models\Pekerjaan;
use App\Models\PembayaranVendor;
use App\Models\Proker;
use App\Models\SPH;
use App\Models\SPK;
use App\Models\SPPH;
use App\Models\Vendor;
use App\Models\ViewPekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use Exception;
use Mail;

class PekerjaanController extends Controller
{
    public function index()
    {
        $tahun = date("Y");
        $role = session('user')->role;

        $proker = Proker::where('tahun', $tahun)->where('perusahaan', "PT Nusantara Regas")->get();

        if ($role == "Vendor"){
            $vendor = session('user')->perusahaan;
            $dataVendor = Vendor::where('nama_perusahaan', $vendor)->first();

            $data = ViewPekerjaan::where('tahun', $tahun)->where('id_vendor', $dataVendor->vendor_id)->whereIn('status', ['In Progress', 'Done'])->orderBy('pekerjaan_id', 'ASC')->get();
        }else{
            $data = ViewPekerjaan::where('tahun', $tahun)->orderBy('pekerjaan_id', 'ASC')->get();
        }

        return view('Pekerjaan.index')
            ->with([
                'tahun' => $tahun,
                'dataProker' => $proker,
                'dataPekerjaan' => $data,
            ]);
    }

    public function view($pekerjaanID)
    {
        try {
            $logID = decrypt($pekerjaanID);
        } catch (Exception $e) {
            abort(404);
        }

        $pekerjaan = ViewPekerjaan::where('pekerjaan_id', $logID)->first();
        $proker = Proker::where('tahun', $pekerjaan->tahun)->where('perusahaan', "PT Nusantara Regas")->get();
        $lampiran = LampiranPekerjaan::where('pekerjaan_id', $logID)->orderBy('lampiran_id', 'ASC')->get();
        $jumlahLampiran = LampiranPekerjaan::where('pekerjaan_id', $logID)->count();
        $lampiranApproved = LampiranPekerjaan::where('pekerjaan_id', $logID)->where('status', 'Approved')->orderBy('lampiran_id', 'ASC')->get();
        $jumlahLampiranApproved = LampiranPekerjaan::where('pekerjaan_id', $logID)->where('status', 'Approved')->count();
        $SPPH = SPPH::where('pekerjaan_id', $logID)->orderBy('tanggal', 'ASC')->get();
        $jumlahSPPH = SPPH::where('pekerjaan_id', $logID)->count();
        $SPH = SPH::where('pekerjaan_id', $logID)->orderBy('tanggal', 'ASC')->get();
        $jumlahSPH = SPH::where('pekerjaan_id', $logID)->count();
        $BAKN = BAKN::where('pekerjaan_id', $logID)->orderBy('tanggal', 'ASC')->get();
        $jumlahBAKN = BAKN::where('pekerjaan_id', $logID)->count();
        $jumlahBAKNApproved = BAKN::where('pekerjaan_id', $logID)->where('status', 'Accepted')->count();
        $SPK = SPK::where('pekerjaan_id', $logID)->orderBy('tanggal', 'ASC')->get();
        $jumlahSPK = SPK::where('pekerjaan_id', $logID)->count();
        $pembayaran = PembayaranVendor::where('pekerjaan_id', $logID)->orderBy('termin', 'ASC')->get();
        $jumlahPembayaran = PembayaranVendor::where('pekerjaan_id', $logID)->count();
        $vendor = DB::table('TBL_VENDOR')
            ->whereNotIn('VENDOR_ID', function ($query) use ($logID) {
                $query->select('ID_VENDOR')
                    ->from('TBL_SPPH')
                    ->where('PEKERJAAN_ID', $logID);
            })
            ->get();
        $log = LogPekerjaan::where('pekerjaan_id', $logID)->orderBy('log_id', 'DESC')->get();
        $jumlahLog = LogPekerjaan::where('pekerjaan_id', $logID)->count();
        $dokumenMandatoriProyek = DB::table('TBL_DOKUMEN_MANDATORI_PROYEK')
            ->whereNotIn('NAMA_DOKUMEN', function ($query) use ($logID) {
                $query->select('NAMA_DOKUMEN')
                    ->from('TBL_LAMPIRAN_PEKERJAAN')
                    ->where('PEKERJAAN_ID', $logID);
            })
            ->get();
        $pilihanVendor = DB::table('TBL_VENDOR')
            ->whereIn('VENDOR_ID', function ($query) use ($logID) {
                $query->select('ID_VENDOR')
                    ->from('TBL_SPH')
                    ->where('PEKERJAAN_ID', $logID);
            })
            ->get();
        $SPHApproved = SPH::where('pekerjaan_id', $logID)->where('status', "Approved")->count();
        $SPKApproved = SPK::where('pekerjaan_id', $logID)->where('status', "Accepted")->count();

        return view('Pekerjaan.view')
            ->with([
                'data' => $pekerjaan,
                'dataProker' => $proker,
                'dataLampiran' => $lampiran,
                'jumlahLampiran' => $jumlahLampiran,
                'dataLampiranApproved' => $lampiranApproved,
                'jumlahLampiranApproved' => $jumlahLampiranApproved,
                'dataSPPH' => $SPPH,
                'jumlahSPPH' => $jumlahSPPH,
                'dataSPH' => $SPH,
                'jumlahSPH' => $jumlahSPH,
                'dataBAKN' => $BAKN,
                'jumlahBAKN' => $jumlahBAKN,
                'jumlahBAKNApproved' => $jumlahBAKNApproved,
                'dataSPK' => $SPK,
                'jumlahSPK' => $jumlahSPK,
                'dataPembayaran' => $pembayaran,
                'jumlahPembayaran' => $jumlahPembayaran,
                'dataVendor' => $vendor,
                'dataLog' => $log,
                'jumlahLog' => $jumlahLog,
                'dokumenMandatori' => $dokumenMandatoriProyek,
                'SPHApproved' => $SPHApproved,
                'SPKApproved' => $SPKApproved,
                'pilihanVendor' => $pilihanVendor,
            ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'namaPekerjaan' => 'required',
            'ringkasan' => 'required',
            'proker' => 'required',
            'nilaiPerkiraan' => 'required',
            'lampiran' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:10240',
        ]);

        $tanggalMenit = date("Y-m-d H:i:s");
        $proker = Proker::where('id_proker', $request->proker)->first();

        $image = $request->file('lampiran');
        $size = $image->getSize();
        $type = strtolower($image->guessExtension() ?: $image->getClientOriginalExtension() ?: 'bin');
        $name = $this->storeAttachmentFile($image, $request->namaDokumen);

        $dataPekerjaan = [
            'nama_pekerjaan' => $request->namaPekerjaan,
            'ringkasan' => $request->ringkasan,
            'tahun' => $proker->tahun,
            'proker_id' => $proker->id_proker,
            'nilai_perkiraan' => str_replace(".", "", $request->nilaiPerkiraan),
            'status' => 'Open',
            'created_by' => session('user')->id_user,
            'created_date' => $tanggalMenit,
            'kak' => $name,
        ];

        try {
            DB::table('tbl_pekerjaan')->insert($dataPekerjaan);
            $lastData = DB::table('tbl_pekerjaan')->max('pekerjaan_id');

            $dataLampiran = [
                'pekerjaan_id' => $lastData,
                'nama_file' => "$request->namaDokumen",
                'nama_dokumen' => $request->namaDokumen,
                'file' => $name,
                'size' => $size,
                'type' => $type,
                'status' => 'Approved',
                'upload_by' => session('user')->id_user,
                'upload_date' => $tanggalMenit,
            ];

            $dataLog = [
                'pekerjaan_id' => $lastData,
                'update_by' => session('user')->id_user,
                'update_date' => $tanggalMenit,
                'action' => "Create Project",
            ];

            DB::table('tbl_lampiran_pekerjaan')->insert($dataLampiran);
            DB::table('tbl_log_pekerjaan')->insert($dataLog);

            return redirect()->back()->with('sukses', "Pekerjaan berhasil disimpan");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Pekerjaan gagal disimpan');
        }
    }

    public function edit($pekerjaanID)
    {
        try {
            $logID = decrypt($pekerjaanID);
        } catch (Exception $e) {
            abort(404);
        }

        $pekerjaan = ViewPekerjaan::where('pekerjaan_id', $logID)->first();
        $proker = Proker::where('tahun', $pekerjaan->tahun)->where('perusahaan', "PT Nusantara Regas")->get();

        return view('Pekerjaan.edit')
            ->with([
                'data' => $pekerjaan,
                'dataProker' => $proker,
            ]);
    }

    public function update(Request $request)
    {
        try {
            $logID = decrypt($request->pekerjaanID);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'namaPekerjaan' => 'required',
            'ringkasan' => 'required',
            'proker' => 'required',
            'nilaiPerkiraan' => 'required',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:10240',
        ]);

        $tanggalMenit = date("Y-m-d H:i:s");
        $proker = Proker::where('id_proker', $request->proker)->first();

        if ($request->hasFile('lampiran')) {
            $image = $request->file('lampiran');
            $size = $image->getSize();
            $type = strtolower($image->guessExtension() ?: $image->getClientOriginalExtension() ?: 'bin');
            $name = $this->storeAttachmentFile($image, $request->namaDokumen);

            $dataPekerjaan = [
                'nama_pekerjaan' => $request->namaPekerjaan,
                'ringkasan' => $request->ringkasan,
                'tahun' => $proker->tahun,
                'proker_id' => $proker->id_proker,
                'nilai_perkiraan' => str_replace(".", "", $request->nilaiPerkiraan),
                'kak' => $name,
            ];

            $dataLampiran = [
                'pekerjaan_id' => $logID,
                'nama_file' => "$request->namaDokumen",
                'nama_dokumen' => $request->namaDokumen,
                'file' => $name,
                'size' => $size,
                'type' => $type,
                'status' => 'Open',
                'upload_by' => session('user')->id_user,
                'upload_date' => $tanggalMenit,
            ];

            LampiranPekerjaan::where('pekerjaan_id', $logID)->where('nama_dokumen', 'KAK')->update($dataLampiran);
        } else {
            $dataPekerjaan = [
                'nama_pekerjaan' => $request->namaPekerjaan,
                'ringkasan' => $request->ringkasan,
                'tahun' => $proker->tahun,
                'proker_id' => $proker->id_proker,
                'nilai_perkiraan' => str_replace(".", "", $request->nilaiPerkiraan),
            ];
        }

        $dataLog = [
            'pekerjaan_id' => $logID,
            'update_by' => session('user')->id_user,
            'update_date' => $tanggalMenit,
            'action' => "Edit Project",
        ];

        try {
            Pekerjaan::where('pekerjaan_id', $logID)->update($dataPekerjaan);
            DB::table('tbl_log_pekerjaan')->insert($dataLog);
            return redirect()->route('indexPekerjaan')->with('sukses', "Pekerjaan berhasil diubah");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Pekerjaan gagal diubah');
        }
    }

    public function delete($pekerjaanID)
    {
        try {
            $logID = decrypt($pekerjaanID);
        } catch (Exception $e) {
            abort(404);
        }

        Pekerjaan::where('pekerjaan_id', $logID)->delete();
        SPPH::where('pekerjaan_id', $logID)->delete();
        SPH::where('pekerjaan_id', $logID)->delete();
        BAKN::where('pekerjaan_id', $logID)->delete();
        SPK::where('pekerjaan_id', $logID)->delete();
        LogPekerjaan::where('pekerjaan_id', $logID)->delete();
        LampiranPekerjaan::where('pekerjaan_id', $logID)->delete();
        return redirect()->back()->with('sukses', "Pekerjaan berhasil dihapus");
    }

    public function storeSPPH(Request $request)
    {
        try {
            $pekerjaanID = decrypt($request->pekerjaanID);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'nomor' => 'required',
            'tanggal' => 'required',
            'namaVendor' => 'required',
            'lampiran' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:10240',
        ]);

        $tanggalMenit = date("Y-m-d H:i:s");
        $proyek = Pekerjaan::where('pekerjaan_id', $pekerjaanID)->first();
        $jumlahSPPH = SPPH::where('nomor', $request->nomor)->count();

        if ($jumlahSPPH > 0){
            return redirect()->back()->with('gagal', "SPPH dengan Nomor $request->nomor sudah digunakan");
        }

        if ($proyek->status == "Open"){
            $status = "Procurement";
        }else{
            $status = $proyek->status;
        }

        $vendor = Vendor::where('vendor_id', $request->namaVendor)->first();

        $image = $request->file('lampiran');
        $size = $image->getSize();
        $type = strtolower($image->guessExtension() ?: $image->getClientOriginalExtension() ?: 'bin');
        $name = $this->storeAttachmentFile($image, $request->namaDokumen);

        $dataSPPH = [
            'nomor' => strtoupper($request->nomor),
            'tanggal' => date('Y-m-d', strtotime($request->tanggal)),
            'pekerjaan_id' => $pekerjaanID,
            'id_vendor' => $vendor->vendor_id,
            'status' => 'DRAFT',
            'file_spph' => $name,
            'created_by' => session('user')->id_user,
            'created_date' => $tanggalMenit,
        ];

        $dataLampiran = [
            'id_vendor' => $vendor->vendor_id,
            'pekerjaan_id' => $pekerjaanID,
            'nomor' => $request->nomor,
            'nama_file' => "$request->namaDokumen $vendor->nama_perusahaan",
            'nama_dokumen' => $request->namaDokumen,
            'file' => $name,
            'size' => $size,
            'type' => $type,
            'status' => 'Open',
            'upload_by' => session('user')->id_user,
            'upload_date' => $tanggalMenit,
        ];

        $dataLog = [
            'pekerjaan_id' => $pekerjaanID,
            'update_by' => session('user')->id_user,
            'update_date' => $tanggalMenit,
            'action' => "Create SPPH $vendor->nama_perusahaan",
        ];

        $dataPekerjaan = [
            'status' => $status,
        ];

        try {
            DB::table('tbl_spph')->insert($dataSPPH);
            DB::table('tbl_lampiran_pekerjaan')->insert($dataLampiran);
            DB::table('tbl_log_pekerjaan')->insert($dataLog);
            Pekerjaan::where('pekerjaan_id', $pekerjaanID)->update($dataPekerjaan);
            return redirect()->back()->with('sukses', "Permintaan Penawaran Harga berhasil disimpan");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Permintaan Penawaran Harga gagal disimpan');
        }
    }

    public function storeBAKN(Request $request)
    {
        try {
            $pekerjaanID = decrypt($request->pekerjaanID);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'nomor' => 'required',
            'tanggal' => 'required',
            'nilaiKesepakatan' => 'required',
            'lampiran' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:10240',
        ]);

        $tanggalMenit = date("Y-m-d H:i:s");
        $project = Pekerjaan::where('pekerjaan_id', $pekerjaanID)->first();
        $sph = SPH::where('pekerjaan_id', $pekerjaanID)->where('status', 'Approved')->first();
        $vendor = Vendor::where('vendor_id', $sph->id_vendor)->first();

        $image = $request->file('lampiran');
        $size = $image->getSize();
        $type = strtolower($image->guessExtension() ?: $image->getClientOriginalExtension() ?: 'bin');
        $name = $this->storeAttachmentFile($image, $request->namaDokumen);

        $dataBAKN = [
            'nomor' => strtoupper($request->nomor),
            'tanggal' => date('Y-m-d', strtotime($request->tanggal)),
            'pekerjaan_id' => $pekerjaanID,
            'id_vendor' => $vendor->vendor_id,
            'status' => 'DRAFT',
            'file_bakn' => $name,
            'created_by' => session('user')->id_user,
            'created_date' => $tanggalMenit,
            'nilai_kesepakatan' => str_replace(".", "", $request->nilaiKesepakatan),
            'sph_id' => $sph->sph_id,
        ];

        $dataLampiran = [
            'id_vendor' => $vendor->vendor_id,
            'pekerjaan_id' => $pekerjaanID,
            'nomor' => strtoupper($request->nomor),
            'nama_file' => "$request->namaDokumen $vendor->nama_perusahaan",
            'nama_dokumen' => $request->namaDokumen,
            'file' => $name,
            'size' => $size,
            'type' => $type,
            'status' => 'Open',
            'upload_by' => session('user')->id_user,
            'upload_date' => $tanggalMenit,
        ];

        $dataLog = [
            'pekerjaan_id' => $pekerjaanID,
            'update_by' => session('user')->id_user,
            'update_date' => $tanggalMenit,
            'action' => "Create BAKN $vendor->nama_perusahaan",
        ];

        $dataPekerjaan = [
            'nilai_kesepakatan' => str_replace(".", "", $request->nilaiKesepakatan),
        ];

        $dataEmail = [
            'penerima' => $vendor->nama_perusahaan,
            'no_bakn' => strtoupper($request->nomor),
            'tanggal' => date('Y-m-d', strtotime($request->tanggal)),
            'namaProyek' => $project->nama_pekerjaan,
            'nilaiKesepakatan' => str_replace(".", "", $request->nilaiKesepakatan),
            'no_sph' => $sph->nomor,
        ];

        try {
            Mail::send('mail.submit_bakn', $dataEmail, function ($message) use ($vendor, $project) {
                $message->to($vendor->email, $vendor->nama_perusahaan)
                    ->subject("Berita Acara Klarifikasi dan Negosiasi $project->nama_pekerjaan")
                    ->from('pgn.no.reply@pertamina.com', 'NR SHARE');
            });

            DB::table('tbl_bakn')->insert($dataBAKN);
            DB::table('tbl_lampiran_pekerjaan')->insert($dataLampiran);
            DB::table('tbl_log_pekerjaan')->insert($dataLog);
            Pekerjaan::where('pekerjaan_id', $pekerjaanID)->update($dataPekerjaan);
            return redirect()->back()->with('sukses', "Berita Acara Klarifikasi dan Negosiasi berhasil disimpan");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Berita Acara Klarifikasi dan Negosiasi gagal disimpan');
        }
    }

    public function storePaymentMethod(Request $request)
    {
        try {
            $pekerjaanID = decrypt($request->pekerjaanID);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'termin' => 'required',
        ]);

        $tanggalMenit = date("Y-m-d H:i:s");

        $proyek = Pekerjaan::where('pekerjaan_id', $pekerjaanID)->first();
        $nilaiProyek = $proyek->nilai_kesepakatan;

        if ($request->termin == 1) {
            if ($request->termin1 == '') {
                return redirect()->back()->with('gagal', 'Persentase termin pembayaran harus diisi');
            } else {
                if ($request->termin1 != 100) {
                    return redirect()->back()->with('gagal', 'Persentase termin belum mencapai 100%');
                } else {
                    $rupiah1 = $nilaiProyek * $request->termin1 / 100;

                    $dataPembayaran1 = [
                        'pekerjaan_id' => $proyek->pekerjaan_id,
                        'id_vendor' => $proyek->id_vendor,
                        'termin' => 1,
                        'persen' => $request->termin1,
                        'nilai_kesepakatan' => $nilaiProyek,
                        'jumlah_pembayaran' => $rupiah1,
                        'status' => 'Open',
                        'create_date' => $tanggalMenit,
                        'create_by' => session('user')->username,
                    ];

                    DB::table('tbl_pembayaran_vendor')->insert($dataPembayaran1);
                }
            }
        } elseif ($request->termin == 2) {
            if ($request->termin1 == '' and $request->termin2 == '') {
                return redirect()->back()->with('gagal', 'Persentase termin pembayaran harus diisi');
            } else {
                if ($request->termin1 + $request->termin2 != 100) {
                    return redirect()->back()->with('gagal', 'Persentase termin belum mencapai 100%');
                } else {
                    $rupiah1 = $nilaiProyek * $request->termin1 / 100;
                    $rupiah2 = $nilaiProyek * $request->termin2 / 100;

                    $dataPembayaran1 = [
                        'pekerjaan_id' => $proyek->pekerjaan_id,
                        'id_vendor' => $proyek->id_vendor,
                        'termin' => 1,
                        'persen' => $request->termin1,
                        'nilai_kesepakatan' => $nilaiProyek,
                        'jumlah_pembayaran' => $rupiah1,
                        'status' => 'Open',
                        'create_date' => $tanggalMenit,
                        'create_by' => session('user')->username,
                    ];

                    $dataPembayaran2 = [
                        'pekerjaan_id' => $proyek->pekerjaan_id,
                        'id_vendor' => $proyek->id_vendor,
                        'termin' => 2,
                        'persen' => $request->termin2,
                        'nilai_kesepakatan' => $nilaiProyek,
                        'jumlah_pembayaran' => $rupiah2,
                        'status' => 'Open',
                        'create_date' => $tanggalMenit,
                        'create_by' => session('user')->username,
                    ];

                    DB::table('tbl_pembayaran_vendor')->insert($dataPembayaran1);
                    DB::table('tbl_pembayaran_vendor')->insert($dataPembayaran2);
                }
            }
        } elseif ($request->termin == 3) {
            if ($request->termin1 == '' and $request->termin2 == '' and $request->termin3 == '') {
                return redirect()->back()->with('gagal', 'Persentase termin pembayaran harus diisi');
            } else {
                if ($request->termin1 + $request->termin2 + $request->termin3 != 100) {
                    return redirect()->back()->with('gagal', 'Persentase termin belum mencapai 100%');
                } else {
                    $rupiah1 = $nilaiProyek * $request->termin1 / 100;
                    $rupiah2 = $nilaiProyek * $request->termin2 / 100;
                    $rupiah3 = $nilaiProyek * $request->termin3 / 100;

                    $dataPembayaran1 = [
                        'pekerjaan_id' => $proyek->pekerjaan_id,
                        'id_vendor' => $proyek->id_vendor,
                        'termin' => 1,
                        'persen' => $request->termin1,
                        'nilai_kesepakatan' => $nilaiProyek,
                        'jumlah_pembayaran' => $rupiah1,
                        'status' => 'Open',
                        'create_date' => $tanggalMenit,
                        'create_by' => session('user')->username,
                    ];

                    $dataPembayaran2 = [
                        'pekerjaan_id' => $proyek->pekerjaan_id,
                        'id_vendor' => $proyek->id_vendor,
                        'termin' => 2,
                        'persen' => $request->termin2,
                        'nilai_kesepakatan' => $nilaiProyek,
                        'jumlah_pembayaran' => $rupiah2,
                        'status' => 'Open',
                        'create_date' => $tanggalMenit,
                        'create_by' => session('user')->username,
                    ];

                    $dataPembayaran3 = [
                        'pekerjaan_id' => $proyek->pekerjaan_id,
                        'id_vendor' => $proyek->id_vendor,
                        'termin' => 3,
                        'persen' => $request->termin3,
                        'nilai_kesepakatan' => $nilaiProyek,
                        'jumlah_pembayaran' => $rupiah3,
                        'status' => 'Open',
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
                    $rupiah1 = $nilaiProyek * $request->termin1 / 100;
                    $rupiah2 = $nilaiProyek * $request->termin2 / 100;
                    $rupiah3 = $nilaiProyek * $request->termin3 / 100;
                    $rupiah4 = $nilaiProyek * $request->termin4 / 100;

                    $dataPembayaran1 = [
                        'pekerjaan_id' => $proyek->pekerjaan_id,
                        'id_vendor' => $proyek->id_vendor,
                        'termin' => 1,
                        'persen' => $request->termin1,
                        'nilai_kesepakatan' => $nilaiProyek,
                        'jumlah_pembayaran' => $rupiah1,
                        'status' => 'Open',
                        'create_date' => $tanggalMenit,
                        'create_by' => session('user')->username,
                    ];

                    $dataPembayaran2 = [
                        'pekerjaan_id' => $proyek->pekerjaan_id,
                        'id_vendor' => $proyek->id_vendor,
                        'termin' => 2,
                        'persen' => $request->termin2,
                        'nilai_kesepakatan' => $nilaiProyek,
                        'jumlah_pembayaran' => $rupiah2,
                        'status' => 'Open',
                        'create_date' => $tanggalMenit,
                        'create_by' => session('user')->username,
                    ];

                    $dataPembayaran3 = [
                        'pekerjaan_id' => $proyek->pekerjaan_id,
                        'id_vendor' => $proyek->id_vendor,
                        'termin' => 3,
                        'persen' => $request->termin3,
                        'nilai_kesepakatan' => $nilaiProyek,
                        'jumlah_pembayaran' => $rupiah3,
                        'status' => 'Open',
                        'create_date' => $tanggalMenit,
                        'create_by' => session('user')->username,
                    ];

                    $dataPembayaran4 = [
                        'pekerjaan_id' => $proyek->pekerjaan_id,
                        'id_vendor' => $proyek->id_vendor,
                        'termin' => 4,
                        'persen' => $request->termin4,
                        'nilai_kesepakatan' => $nilaiProyek,
                        'jumlah_pembayaran' => $rupiah4,
                        'status' => 'Open',
                        'create_date' => $tanggalMenit,
                        'create_by' => session('user')->username,
                    ];

                    DB::table('tbl_pembayaran_vendor')->insert($dataPembayaran1);
                    DB::table('tbl_pembayaran_vendor')->insert($dataPembayaran2);
                    DB::table('tbl_pembayaran_vendor')->insert($dataPembayaran3);
                    DB::table('tbl_pembayaran_vendor')->insert($dataPembayaran4);
                }
            }
        }

        $dataLog = [
            'pekerjaan_id' => $pekerjaanID,
            'update_by' => session('user')->id_user,
            'update_date' => $tanggalMenit,
            'action' => "Create Payment Methode",
        ];

        try {
            DB::table('tbl_log_pekerjaan')->insert($dataLog);
            return redirect()->back()->with('sukses', "Metode pembayaran berhasil disimpan");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Metode pembayaran gagal disimpan');
            return redirect()->back()->with('gagal', 'Metode pembayaran gagal disimpan');
        }
    }

    public function submitBAKN($baknID)
    {
        try {
            $logID = decrypt($baknID);
        } catch (Exception $e) {
            abort(404);
        }

        $tanggalMenit = date("Y-m-d H:i:s");
        $bakn = BAKN::where('bakn_id', $logID)->first();
        $sph = SPH::where('sph_id', $bakn->sph_id)->first();
        $project = Pekerjaan::where('pekerjaan_id', $bakn->pekerjaan_id)->first();
        $vendor = Vendor::where('vendor_id', $bakn->id_vendor)->first();

        $dataBAKN = [
            'status' => "Submitted",
        ];

        $dataLog = [
            'pekerjaan_id' => $bakn->pekerjaan_id,
            'update_by' => session('user')->id_user,
            'update_date' => $tanggalMenit,
            'action' => "Submit BAKN $vendor->nama_perusahaan",
        ];

        $dataEmail = [
            'penerima' => $vendor->nama_perusahaan,
            'no_bakn' => $bakn->nomor,
            'tanggal' => $bakn->tanggal,
            'namaProyek' => $project->nama_pekerjaan,
            'nilaiKesepakatan' => $bakn->nilai_kesepakatan,
            'no_sph' => $sph->nomor,
        ];

        try {
            Mail::send('mail.submit_bakn', $dataEmail, function ($message) use ($vendor, $project) {
                $message->to($vendor->email, $vendor->nama_perusahaan)
                    ->subject("Berita Acara Klarifikasi dan Negosiasi $project->nama_pekerjaan")
                    ->from('pgn.no.reply@pertamina.com', 'NR SHARE');
            });

            BAKN::where('bakn_id', $logID)->update($dataBAKN);
            DB::table('tbl_log_pekerjaan')->insert($dataLog);

            return redirect()->back()->with('sukses', "Berita Acara Klarifikasi dan Negosiasi untuk $vendor->nama_perusahaan berhasil disubmit");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', "Berita Acara Klarifikasi dan Negosiasi untuk $vendor->nama_perusahaan gagal disubmit");
        }
    }

    public function storeSPK(Request $request)
    {
        try {
            $pekerjaanID = decrypt($request->pekerjaanID);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'nomor' => 'required',
            'tanggal' => 'required',
            'durasi' => 'required',
            'lampiran' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:10240',
        ]);

        $tanggalMenit = date("Y-m-d H:i:s");
        $startDate = date('Y-m-d', strtotime($request->tanggal));
        $durasi = $request->durasi;
        $dueDate = date('Y-m-d',strtotime("$durasi day",strtotime($startDate)));

        $project = Pekerjaan::where('pekerjaan_id', $pekerjaanID)->first();
        $sph = SPH::where('pekerjaan_id', $pekerjaanID)->first();
        $bakn = BAKN::where('pekerjaan_id', $pekerjaanID)->first();
        $vendor = Vendor::where('vendor_id', $bakn->id_vendor)->first();

        $image = $request->file('lampiran');
        $size = $image->getSize();
        $type = strtolower($image->guessExtension() ?: $image->getClientOriginalExtension() ?: 'bin');
        $name = $this->storeAttachmentFile($image, $request->namaDokumen);

        $dataSPK = [
            'nomor' => strtoupper($request->nomor),
            'tanggal' => date('Y-m-d', strtotime($request->tanggal)),
            'pekerjaan_id' => $pekerjaanID,
            'status' => 'DRAFT',
            'created_by' => session('user')->id_user,
            'created_date' => $tanggalMenit,
            'id_vendor' => $bakn->id_vendor,
            'file_spk' => $name,
            'nilai_kesepakatan' => $bakn->nilai_kesepakatan,
            'sph_id' => $bakn->sph_id,
            'bakn_id' => $bakn->bakn_id,
            'start_date' => date('Y-m-d', strtotime($request->tanggal)),
            'due_date' => date('Y-m-d', strtotime($dueDate)),
            'durasi' => $durasi,
        ];

        $dataPekerjaan = [
            'status' => "In Progress",
        ];

        $dataLampiran = [
            'id_vendor' => $vendor->vendor_id,
            'pekerjaan_id' => $pekerjaanID,
            'nomor' => strtoupper($request->nomor),
            'nama_file' => "$request->namaDokumen $vendor->nama_perusahaan",
            'nama_dokumen' => $request->namaDokumen,
            'file' => $name,
            'size' => $size,
            'type' => $type,
            'status' => 'Open',
            'upload_by' => session('user')->id_user,
            'upload_date' => $tanggalMenit,
        ];

        $dataLog = [
            'pekerjaan_id' => $pekerjaanID,
            'update_by' => session('user')->id_user,
            'update_date' => $tanggalMenit,
            'action' => "Create SPK $vendor->nama_perusahaan",
        ];

        $dataEmail = [
            'penerima' => $vendor->nama_perusahaan,
            'no_spk' => strtoupper($request->nomor),
            'tanggal' => date('Y-m-d', strtotime($request->tanggal)),
            'namaProyek' => $project->nama_pekerjaan,
            'nilaiKesepakatan' => $project->nilai_kesepakatan,
            'durasi' => $durasi,
            'dueDate' => date('Y-m-d', strtotime($dueDate)),
            'no_sph' => $sph->nomor,
            'no_bakn' => $bakn->nomor,
        ];

        try {
            Mail::send('mail.submit_spk', $dataEmail, function ($message) use ($vendor, $project) {
                $message->to($vendor->email, $vendor->nama_perusahaan)
                    ->subject("Surat Perintah Kerja $project->nama_pekerjaan")
                    ->from('pgn.no.reply@pertamina.com', 'NR SHARE');
            });

            DB::table('tbl_spk')->insert($dataSPK);
            DB::table('tbl_lampiran_pekerjaan')->insert($dataLampiran);
            DB::table('tbl_log_pekerjaan')->insert($dataLog);
            Pekerjaan::where('pekerjaan_id', $pekerjaanID)->update($dataPekerjaan);
            return redirect()->back()->with('sukses', "Surat Perintah Kerja berhasil disimpan");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Surat Perintah Kerja gagal disimpan');
        }
    }

    public function submitSPK($spkID)
    {
        try {
            $logID = decrypt($spkID);
        } catch (Exception $e) {
            abort(404);
        }

        $tanggalMenit = date("Y-m-d H:i:s");
        $spk = SPK::where('spk_id', $logID)->first();
        $bakn = BAKN::where('bakn_id', $spk->bakn_id)->first();
        $sph = SPH::where('sph_id', $spk->sph_id)->first();
        $project = Pekerjaan::where('pekerjaan_id', $spk->pekerjaan_id)->first();
        $vendor = Vendor::where('vendor_id', $spk->id_vendor)->first();

        $dataSPK = [
            'status' => "Submitted",
        ];

        $dataLog = [
            'pekerjaan_id' => $bakn->pekerjaan_id,
            'update_by' => session('user')->id_user,
            'update_date' => $tanggalMenit,
            'action' => "Submit SPK $vendor->nama_perusahaan",
        ];

        $dataEmail = [
            'penerima' => $vendor->nama_perusahaan,
            'no_spk' => strtoupper($spk->nomor),
            'tanggal' => $spk->tanggal,
            'namaProyek' => $project->nama_pekerjaan,
            'nilaiKesepakatan' => $project->nilai_kesepakatan,
            'durasi' => $spk->durasi,
            'dueDate' => $spk->due_date,
            'no_sph' => $sph->nomor,
            'no_bakn' => $bakn->nomor,
        ];

        try {
            Mail::send('mail.submit_spk', $dataEmail, function ($message) use ($vendor, $project) {
                $message->to($vendor->email, $vendor->nama_perusahaan)
                    ->subject("Surat Perintah Kerja $project->nama_pekerjaan")
                    ->from('pgn.no.reply@pertamina.com', 'NR SHARE');
            });

            SPK::where('spk_id', $logID)->update($dataSPK);
            DB::table('tbl_log_pekerjaan')->insert($dataLog);

            return redirect()->back()->with('sukses', "Surat Perintah Kerja untuk $vendor->nama_perusahaan berhasil disubmit");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', "Surat Perintah Kerja untuk $vendor->nama_perusahaan gagal disubmit");
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $logID = decrypt($request->pekerjaanID);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'status' => 'required',
        ]);

        $tanggalMenit = date("Y-m-d H:i:s");

        $dataPekerjaan = [
            'status' => $request->status,
        ];

        $dataLog = [
            'pekerjaan_id' => $logID,
            'update_by' => session('user')->id_user,
            'update_date' => $tanggalMenit,
            'action' => "Update status $request->status",
        ];

        try {
            Pekerjaan::where('pekerjaan_id', $logID)->update($dataPekerjaan);
            DB::table('tbl_log_pekerjaan')->insert($dataLog);
            return redirect()->back()->with('sukses', "Status pekerjaan berhasil diubah");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Status pekerjaan gagal diubah');
        }
    }

    public function storeLampiran(Request $request)
    {
        try {
            $pekerjaanID = decrypt($request->pekerjaanID);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'namaDokumen' => 'required',
            'lampiran' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:10240',
        ]);

        $tanggalMenit = date("Y-m-d H:i:s");

        $image = $request->file('lampiran');
        $size = $image->getSize();
        $type = strtolower($image->guessExtension() ?: $image->getClientOriginalExtension() ?: 'bin');
        $name = $this->storeAttachmentFile($image, $request->namaDokumen);

        $dataLampiran = [
            'pekerjaan_id' => $pekerjaanID,
            'nama_file' => $request->namaDokumen,
            'nama_dokumen' => $request->namaDokumen,
            'file' => $name,
            'size' => $size,
            'type' => $type,
            'status' => 'Open',
            'upload_by' => session('user')->id_user,
            'upload_date' => $tanggalMenit,
        ];

        $dataLog = [
            'pekerjaan_id' => $pekerjaanID,
            'update_by' => session('user')->id_user,
            'update_date' => $tanggalMenit,
            'action' => "Attach Document $request->namaDokumen",
        ];

        try {
            DB::transaction(function () use ($dataLampiran, $dataLog, $request, $name, $pekerjaanID) {
                DB::table('tbl_lampiran_pekerjaan')->insert($dataLampiran);
                DB::table('tbl_log_pekerjaan')->insert($dataLog);

                if ($request->namaDokumen == "KAK") {
                    $updateKAK = [
                        'kak' => $name,
                    ];

                    Pekerjaan::where('pekerjaan_id', $pekerjaanID)->update($updateKAK);
                }
            });

            return redirect()->back()->with('sukses', "Dokumen $request->namaDokumen berhasil disimpan");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', "Dokumen $request->namaDokumen gagal disimpan");
        }
    }

    private function storeAttachmentFile($file, $context = 'lampiran')
    {
        $extension = strtolower($file->guessExtension() ?: $file->getClientOriginalExtension() ?: 'bin');
        $safeContext = preg_replace('/[^a-z0-9]+/i', '-', (string) $context);
        $safeContext = trim(strtolower($safeContext), '-');
        if ($safeContext === '') {
            $safeContext = 'lampiran';
        }

        $fileName = sprintf('%s-%s-%s.%s', $safeContext, date('YmdHis'), bin2hex(random_bytes(4)), $extension);
        Storage::disk('attachment')->putFileAs('', $file, $fileName);

        return $fileName;
    }

    public function deleteSPPH($spphID)
    {
        try {
            $logID = decrypt($spphID);
        } catch (Exception $e) {
            abort(404);
        }

        $tanggalMenit = date("Y-m-d H:i:s");
        $spph = SPPH::where('spph_id', $logID)->first();
        $vendor = Vendor::where('vendor_id', $spph->id_vendor)->first();

        $dataLog = [
            'pekerjaan_id' => $spph->pekerjaan_id,
            'update_by' => session('user')->id_user,
            'update_date' => $tanggalMenit,
            'action' => "Delete SPPH $vendor->nama_perusahaan",
        ];

        SPPH::where('spph_id', $logID)->delete();
        LampiranPekerjaan::where('nama_dokumen', 'SPPH')->where('nomor', $spph->nomor)->delete();
        DB::table('tbl_log_pekerjaan')->insert($dataLog);
        return redirect()->back()->with('sukses', "Permintaan Penawaran Harga untuk $vendor->nama_perusahaan berhasil dihapus");
    }

    public function deleteBAKN($baknID)
    {
        try {
            $logID = decrypt($baknID);
        } catch (Exception $e) {
            abort(404);
        }

        $tanggalMenit = date("Y-m-d H:i:s");
        $bakn = BAKN::where('bakn_id', $logID)->first();
        $vendor = Vendor::where('vendor_id', $bakn->id_vendor)->first();

        $dataLog = [
            'pekerjaan_id' => $bakn->pekerjaan_id,
            'update_by' => session('user')->id_user,
            'update_date' => $tanggalMenit,
            'action' => "Delete BAKN $vendor->nama_perusahaan",
        ];

        BAKN::where('bakn_id', $logID)->delete();
        LampiranPekerjaan::where('nama_dokumen', 'BAKN')->where('nomor', $bakn->nomor)->delete();
        DB::table('tbl_log_pekerjaan')->insert($dataLog);
        return redirect()->back()->with('sukses', "Berita Acara Klarifikasi dan Negosiasi untuk $vendor->nama_perusahaan berhasil dihapus");
    }

    public function submitSPPH($spphID)
    {
        try {
            $logID = decrypt($spphID);
        } catch (Exception $e) {
            abort(404);
        }

        $tanggalMenit = date("Y-m-d H:i:s");
        $spph = SPPH::where('spph_id', $logID)->first();
        $project = Pekerjaan::where('pekerjaan_id', $spph->pekerjaan_id)->first();
        $vendor = Vendor::where('vendor_id', $spph->id_vendor)->first();

        $dataSPPH = [
            'status' => "Submitted",
        ];

        $dataLog = [
            'pekerjaan_id' => $spph->pekerjaan_id,
            'update_by' => session('user')->id_user,
            'update_date' => $tanggalMenit,
            'action' => "Submit SPPH $vendor->nama_perusahaan",
        ];

        $dataEmail = [
            'penerima' => $vendor->nama_perusahaan,
            'no_spph' => $spph->nomor,
            'tanggal' => $spph->tanggal,
            'namaProyek' => $project->nama_pekerjaan,
        ];

        try {
            Mail::send('mail.permintaan_spph', $dataEmail, function ($message) use ($vendor, $project) {
                $message->to($vendor->email, $vendor->nama_perusahaan)
                    ->subject("Permintaan Penawaran Harga $project->nama_pekerjaan")
                    ->from('pgn.no.reply@pertamina.com', 'NR SHARE');
            });

            SPPH::where('spph_id', $logID)->update($dataSPPH);
            DB::table('tbl_log_pekerjaan')->insert($dataLog);

            return redirect()->back()->with('sukses', "Permintaan Penawaran Harga untuk $vendor->nama_perusahaan berhasil disubmit");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', "Permintaan Penawaran Harga untuk $vendor->nama_perusahaan gagal disubmit");
        }
    }

    public function approveSPH(Request $request)
    {
        try {
            $logID = decrypt($request->pekerjaanID);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'namaVendor' => 'required',
        ]);

        $tanggalMenit = date("Y-m-d H:i:s");
        $vendor = Vendor::where('vendor_id', $request->namaVendor)->first();
        $sph = SPH::where('pekerjaan_id', $logID)->where('id_vendor', $vendor->vendor_id)->first();

        $dataApproved = [
            'status' => 'Approved',
        ];

        $dataRejected = [
            'status' => 'Rejected',
        ];

        $dataPekerjaan = [
            'id_vendor' => $vendor->vendor_id,
            'nilai_penawaran' => $sph->nilai_penawaran,
        ];

        $dataLog = [
            'pekerjaan_id' => $logID,
            'update_by' => session('user')->id_user,
            'update_date' => $tanggalMenit,
            'action' => "Memilih $vendor->nama_perusahaan sebagai vendor",
        ];

        try {
            SPH::where('pekerjaan_id', $logID)->where('id_vendor', $request->namaVendor)->update($dataApproved);
            SPH::where('pekerjaan_id', $logID)->whereNotIn('id_vendor', [$request->namaVendor])->update($dataRejected);
            LampiranPekerjaan::where('pekerjaan_id', $logID)->where('id_vendor', $request->namaVendor)->update($dataApproved);
            Pekerjaan::where('pekerjaan_id', $logID)->update($dataPekerjaan);
            DB::table('tbl_log_pekerjaan')->insert($dataLog);
            return redirect()->back()->with('sukses', "$vendor->nama_perusahaan berhasil dipilih sebagai vendor");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Pemilihan vendor gagal');
        }
    }

    public function resetExecutor($pekerjaanID)
    {
        try {
            $logID = decrypt($pekerjaanID);
        } catch (Exception $e) {
            abort(404);
        }

        $tanggalMenit = date("Y-m-d H:i:s");
        $proyek = Pekerjaan::where('pekerjaan_id', $logID)->first();
        $vendor = Vendor::where('vendor_id', $proyek->id_vendor)->first();

        $dataSubmit = [
            'status' => 'Submitted',
        ];

        $dataOpen = [
            'status' => 'Open',
        ];

        $dataPekerjaan = [
            'id_vendor' => NULL,
            'nilai_penawaran' => NULL,
        ];

        $dataLog = [
            'pekerjaan_id' => $logID,
            'update_by' => session('user')->id_user,
            'update_date' => $tanggalMenit,
            'action' => "Reset vendor",
        ];

        try {
            SPH::where('pekerjaan_id', $logID)->update($dataSubmit);
            LampiranPekerjaan::where('pekerjaan_id', $logID)->where('id_vendor', $vendor->vendor_id)->update($dataOpen);
            Pekerjaan::where('pekerjaan_id', $logID)->update($dataPekerjaan);
            DB::table('tbl_log_pekerjaan')->insert($dataLog);
            return redirect()->back()->with('sukses', "Pelaksana proyek berhasil direset");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Pelaksana proyek gagal direset');
        }
    }

}
