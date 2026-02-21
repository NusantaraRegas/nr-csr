<?php

namespace App\Http\Controllers;

use App\Helper\APIHelper;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ViewProposalExport;
use App\Exports\PenyaluranExport;
use App\Helper\formatTanggal;;
use App\Models\Hirarki;
use App\Models\DetailApproval;
use App\Models\Anggota;
use App\Models\Dokumen;
use App\Models\BASTDana;
use App\Models\DetailKriteria;
use App\Models\Lembaga;
use App\Models\Pembayaran;
use App\Models\Anggaran;
use App\Models\Pengirim;
use App\Models\Pilar;
use App\Models\Proker;
use App\Models\Provinsi;
use App\Models\SDG;
use App\Models\SektorBantuan;
use App\Models\User;
use App\Models\Bank;
use App\Models\Log;
use App\Models\ViewPembayaran;
use App\Models\ViewUser;
use App\Models\ViewProposal;
use App\Models\ViewHirarki;
use App\Models\ViewYKPP;
use App\Models\ViewDetailApproval;
use App\Http\Requests\CariKelayakanBulanRequest;
use App\Http\Requests\CariKelayakanPeriodeRequest;
use App\Http\Requests\CariKelayakanTahunRequest;
use App\Actions\Kelayakan\CariKelayakanBulanAction;
use App\Actions\Kelayakan\CariKelayakanPeriodeAction;
use App\Actions\Kelayakan\CariKelayakanTahunAction;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Kelayakan;
use App\Models\Evaluasi;
use App\Models\Survei;
use App\Models\Lampiran;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Mail;
use Exception;

class KelayakanController extends Controller
{
    public function index(Request $request)
    {
        $perusahaanID = session('user')->id_perusahaan;

        $tahun    = $request->input('tahun', date("Y"));
        $jenis    = $request->input('jenis');
        $status   = $request->input('status');
        $provinsi = $request->input('provinsi');
        $pengirim = $request->input('pengirim');
        $maker    = $request->input('maker');

        $data = ViewProposal::when($tahun, function ($q) use ($tahun) {
                return $q->whereYear('tgl_terima', $tahun);
            })
            ->when($jenis, function ($q) use ($jenis) {
                return $q->where('jenis', $jenis);
            })
            ->when($status, function ($q) use ($status) {
                return $q->where('status', $status);
            })
            ->when($provinsi, function ($q) use ($provinsi) {
                return $q->where('provinsi', $provinsi);
            })
            ->when($pengirim, function ($q) use ($pengirim) {
                return $q->where('pengirim', $pengirim);
            })
            ->when($maker, function ($q) use ($maker) {
                return $q->where('created_by', $maker);
            })
            ->orderByDesc('id_kelayakan')
            ->get();

        return view('report.data_kelayakan')->with([
            'tahun'          => $tahun,
            'dataKelayakan'  => $data,
            'dataProvinsi'   => Provinsi::orderBy('provinsi')->get(),
            'dataLembaga'    => Lembaga::orderBy('nama_lembaga')->get(),
            'dataPengirim'   => Pengirim::where('id_perusahaan', $perusahaanID)
                                        ->where('status', 'Active')
                                        ->orderBy('pengirim')->get(),
            'dataMaker'      => User::where('id_perusahaan', $perusahaanID)
                                    ->orderBy('nama')->get(),
        ]);
    }

   public function exportKelayakan(Request $request)
    {
        $tahun    = $request->input('tahun', date("Y"));
        $jenis    = $request->input('jenis');
        $status   = $request->input('status');
        $provinsi = $request->input('provinsi');
        $pengirim = $request->input('pengirim');
        $maker    = $request->input('maker');

        $data = ViewProposal::whereYear('tgl_terima', $tahun)
            ->when($jenis, function ($q) use ($jenis) {
                return $q->where('jenis', $jenis);
            })
            ->when($status, function ($q) use ($status) {
                return $q->where('status', $status);
            })
            ->when($provinsi, function ($q) use ($provinsi) {
                return $q->where('provinsi', $provinsi);
            })
            ->when($pengirim, function ($q) use ($pengirim) {
                return $q->where('pengirim', $pengirim);
            })
            ->when($maker, function ($q) use ($maker) {
                return $q->where('created_by', $maker);
            })
            ->orderByDesc('id_kelayakan')
            ->get();

        return Excel::download(new ViewProposalExport($data), 'rekap-proposal.xlsx');
    }

    public function exportPenyaluran(Request $request)
    {
        $tahun      = $request->input('tahun', date('Y'));
        $status     = $request->input('status');
        $pilar      = $request->input('pilar');
        $tpb        = $request->input('tpb');
        $prioritas  = $request->input('prioritas');

        $data = ViewYKPP::where('tahun_ykpp', $tahun)
            ->when($status, function ($q) use ($status) {
                return $q->where('status_ykpp', $status);
            })
            ->when($pilar, function ($q) use ($pilar) {
                return $q->where('pilar', $pilar);
            })
            ->when($tpb, function ($q) use ($tpb) {
                return $q->where('gols', $tpb);
            })
            ->when($prioritas, function ($q) use ($prioritas) {
                return $q->where('prioritas', $prioritas);
            })
            ->with('proker')
            ->orderBy('penyaluran_ke')
            ->get();

        return Excel::download(new PenyaluranExport($data, $tahun), 'rekap-penyaluran-' . $tahun . '.xlsx');
    }

    public function createOperasional()
    {
        $perusahaanID = session('user')->id_perusahaan;

        $lembaga = Lembaga::where('id_perusahaan', $perusahaanID)->orderBy('nama_lembaga', 'ASC')->get();
        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $pengirim = Pengirim::where('id_perusahaan', $perusahaanID)->where('status', 'Active')->orderBy('pengirim', 'ASC')->get();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();

        return view('transaksi.input_kelayakan')
            ->with([
                'dataLembaga' => $lembaga,
                'dataProvinsi' => $provinsi,
                'dataPengirim' => $pengirim,
                'dataPilar' => $pilar,
            ]);
    }

    public function create()
    {
        $perusahaanID = session('user')->id_perusahaan;

        $lembaga = Lembaga::where('id_perusahaan', $perusahaanID)->orderBy('nama_lembaga', 'ASC')->get();
        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $pengirim = Pengirim::where('id_perusahaan', $perusahaanID)->where('status', 'Active')->orderBy('pengirim', 'ASC')->get();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();

        return view('proposal.create')
            ->with([
                'dataLembaga' => $lembaga,
                'dataProvinsi' => $provinsi,
                'dataPengirim' => $pengirim,
                'dataPilar' => $pilar,
            ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'noAgenda' => 'required|unique:tbl_kelayakan,no_agenda|max:100',
            'tglPenerimaan' => 'required|date',
            'pengirim' => 'required',
            'noSurat' => 'required|max:100',
            'tglSurat' => 'required|date',
            'sifat' => 'required',
            'digunakanUntuk' => 'required|string|max:200',
            'jenis' => 'required',
            'dari' => 'required|string|max:150',
            'alamat' => 'required|string|max:255',
            'besarPermohonanAsli' => 'required|numeric',
            'perihal' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kabupaten' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kelurahan' => 'required|string|max:100',
            'deskripsiBantuan' => 'required|string|max:500',
            'disposisi' => 'required|file|mimes:pdf',
            'lampiran' => 'required|file|mimes:pdf',
        ], [
            'noAgenda.required' => 'No Agenda harus diisi',
            'noAgenda.max' => 'No Agenda maksimal 100 karakter',
            'tglPenerimaan.required' => 'Tanggal penerimaan harus diisi',
            'tglPenerimaan.date' => 'Format tanggal penerimaan tidak valid',
            'pengirim.required' => 'Pengirim harus diisi',
            'noSurat.required' => 'Nomor surat harus diisi',
            'noSurat.max' => 'Nomor surat maksimal 100 karakter',
            'tglSurat.required' => 'Tanggal surat harus diisi',
            'tglSurat.date' => 'Format tanggal surat tidak valid',
            'sifat.required' => 'Sifat surat harus diisi',
            'digunakanUntuk.required' => 'Perihal harus diisi',
            'digunakanUntuk.max' => 'Perihal maksimal 200 karakter',
            'jenis.required' => 'Jenis proposal harus dipilih',
            'dari.required' => 'Nama lembaga harus dipilih',
            'besarPermohonan.required' => 'Besar permohonan harus diisi',
            'besarPermohonan.regex' => 'Format besar permohonan hanya angka, koma, dan titik',
            'perihal.required' => 'Kategori bantuan harus diisi',
            'provinsi.required' => 'Provinsi harus diisi',
            'kabupaten.required' => 'Kabupaten/Kota harus diisi',
            'kecamatan.required' => 'Kecamatan harus diisi',
            'kelurahan.required' => 'Kelurahan harus diisi',
            'deskripsiBantuan.required' => 'Deskripsi bantuan harus diisi',
            'deskripsiBantuan.max' => 'Deskripsi maksimal 500 karakter',
            'disposisi.required' => 'Disposisi wajib diunggah',
            'disposisi.mimes' => 'Disposisi harus berformat PDF',
            //'disposisi.max' => 'Ukuran file disposisi maksimal 2MB',
            'lampiran.required' => 'Proposal/Surat wajib diunggah',
            'lampiran.mimes' => 'Proposal/Surat harus berformat PDF',
            //'lampiran.max' => 'Ukuran file Proposal/Surat maksimal 2MB',
        ]);

        $hirarki = Hirarki::where('id_user', session('user')->id_user)->where('id_level', 1)->first();

        if(empty($hirarki)){
            return redirect()->back()->with('gagal', "Anda tidak terdaftar sebagai Maker kelayakan proposal")->withInput();
        }

        try {
            $lembaga = Lembaga::findOrFail($request->dari);

            $idKelayakan = DB::selectOne("SELECT TBL_KELAYAKAN_ID_KELAYAKAN_SEQ.NEXTVAL AS ID FROM DUAL")->id;

            $dataKelayakan = [
                'id_kelayakan' => $idKelayakan,
                'no_agenda' => strtoupper($request->noAgenda),
                'id_pengirim' => $request->pengirim,
                'tgl_terima' => date('Y-m-d', strtotime($request->tglPenerimaan)),
                'sifat' => $request->sifat,
                'asal_surat' => $lembaga->nama_lembaga,
                'no_surat' => strtoupper($request->noSurat),
                'tgl_surat' => date("Y-m-d", strtotime($request->tglSurat)),
                'perihal' => $request->perihal,
                'alamat' => $lembaga->alamat,
                'provinsi' => $request->provinsi,
                'kabupaten' => $request->kabupaten,
                'kecamatan' => $request->kecamatan,
                'kelurahan' => $request->kelurahan,
                'id_lembaga' => $lembaga->id_lembaga,
                'pengaju_proposal' => $lembaga->nama_pic,
                'sebagai' => $lembaga->jabatan,
                'contact_person' => $lembaga->no_telp,
                'email_pengaju' => session('user')->email,
                'nilai_pengajuan' => $request->besarPermohonanAsli,
                'bantuan_untuk' => $request->digunakanUntuk,
                'deskripsi' => $request->deskripsiBantuan,
                'jenis' => $request->jenis,
                'status' => 'Draft',
                'create_by' => session('user')->username,
                'created_date' => now(),
                'created_by' => session('user')->id_user,
                'no_rekening' => $lembaga->no_rekening,
                'atas_nama' => $lembaga->atas_nama,
                'nama_bank' => $lembaga->nama_bank,
            ];

            $dataLog = [
                'id_kelayakan' => $idKelayakan,
                'keterangan' => 'Input kelayakan proposal',
                'created_by' => session('user')->id_user,
                'created_date' => now(),
            ];

            DB::table('tbl_kelayakan')->insert($dataKelayakan);
            DB::table('tbl_log')->insert($dataLog);

            // Upload Lampiran
            if ($request->hasFile('lampiran')) {
                $lampiran = $request->file('lampiran');
                $lampiranName = time() . '-' . str_replace(' ', '-', $lampiran->getClientOriginalName());
                $lampiran->move('attachment', $lampiranName);

                Lampiran::create([
                    'ID_KELAYAKAN' => $idKelayakan,
                    'NO_AGENDA' => $request->noAgenda,
                    'NAMA' => 'Surat Pengantar dan Proposal',
                    'LAMPIRAN' => $lampiranName,
                    'UPLOAD_BY' => session('user')->username,
                    'UPLOAD_DATE' => now(),
                    'CREATED_BY' => session('user')->id_user,
                ]);
            }

            // Upload Disposisi
            if ($request->hasFile('disposisi')) {
                $disposisi = $request->file('disposisi');
                $disposisiName = time() . '-' . str_replace(' ', '-', $disposisi->getClientOriginalName());
                $disposisi->move('attachment', $disposisiName);

                Lampiran::create([
                    'ID_KELAYAKAN' => $idKelayakan,
                    'NO_AGENDA' => $request->noAgenda,
                    'NAMA' => 'Disposisi',
                    'LAMPIRAN' => $disposisiName,
                    'UPLOAD_BY' => session('user')->username,
                    'UPLOAD_DATE' => now(),
                    'CREATED_BY' => session('user')->id_user,
                ]);
            }

            DB::commit();
            return redirect()->route('dataKelayakan')->with('sukses', 'Kelayakan proposal berhasil disimpan');

        } catch (Exception $e) {
            DB::rollBack();
            report($e); // Log error
            return redirect()->back()->withInput()->with('gagal', 'Gagal menyimpan data kelayakan');
        }
    }

    public function edit($id)
    {
        try {
            $kelayakanID = decrypt($id);
        } catch (Exception $e) {
            abort(404);
        }

        $perusahaanID = session('user')->id_perusahaan;
        $kelayakan = ViewProposal::where('id_kelayakan', $kelayakanID)->first();

        $lembaga = Lembaga::where('id_perusahaan', $perusahaanID)->orderBy('nama_lembaga', 'ASC')->get();
        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $pengirim = Pengirim::where('id_perusahaan', $perusahaanID)->where('status', 'Active')->orderBy('pengirim', 'ASC')->get();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();
        return view('proposal.edit')
            ->with([
                'data' => $kelayakan,
                'dataLembaga' => $lembaga,
                'dataProvinsi' => $provinsi,
                'dataPengirim' => $pengirim,
                'dataPilar' => $pilar,
            ]);
    }

    public function update(Request $request)
    {

        try {
            $kelayakanID = decrypt($request->kelayakanID);
        } catch (Exception $e) {
            abort(404);
        }

        $request->validate([
            'noAgenda' => 'required|max:100',
            'tglPenerimaan' => 'required|date',
            'pengirim' => 'required',
            'noSurat' => 'required|max:100',
            'tglSurat' => 'required|date',
            'sifat' => 'required',
            'jenis' => 'required',
            'digunakanUntuk' => 'required|string|max:200',
            'dari' => 'required|string|max:150',
            'alamat' => 'required|string|max:255',
            'besarPermohonanAsli' => 'required|numeric',
            'perihal' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kabupaten' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kelurahan' => 'required|string|max:100',
            'deskripsiBantuan' => 'required|string|max:500',
        ], [
            'noAgenda.required' => 'No Agenda harus diisi',
            'noAgenda.max' => 'No Agenda maksimal 100 karakter',
            'tglPenerimaan.required' => 'Tanggal penerimaan harus diisi',
            'tglPenerimaan.date' => 'Format tanggal penerimaan tidak valid',
            'pengirim.required' => 'Pengirim harus diisi',
            'noSurat.required' => 'Nomor surat harus diisi',
            'noSurat.max' => 'Nomor surat maksimal 100 karakter',
            'tglSurat.required' => 'Tanggal surat harus diisi',
            'tglSurat.date' => 'Format tanggal surat tidak valid',
            'sifat.required' => 'Sifat surat harus diisi',
            'digunakanUntuk.required' => 'Perihal harus diisi',
            'digunakanUntuk.max' => 'Perihal maksimal 200 karakter',
            'jenis.required' => 'Jenis proposal harus dipilih',
            'dari.required' => 'Nama lembaga harus dipilih',
            'besarPermohonan.required' => 'Besar permohonan harus diisi',
            'besarPermohonan.regex' => 'Format besar permohonan hanya angka, koma, dan titik',
            'perihal.required' => 'Kategori bantuan harus diisi',
            'provinsi.required' => 'Provinsi harus diisi',
            'kabupaten.required' => 'Kabupaten/Kota harus diisi',
            'kecamatan.required' => 'Kecamatan harus diisi',
            'kelurahan.required' => 'Kelurahan harus diisi',
            'deskripsiBantuan.required' => 'Deskripsi bantuan harus diisi',
            'deskripsiBantuan.max' => 'Deskripsi maksimal 500 karakter',
        ]);

        try {
            $lembaga = Lembaga::findOrFail($request->dari);

            $dataKelayakan = [
                'no_agenda' => strtoupper($request->noAgenda),
                'id_pengirim' => $request->pengirim,
                'tgl_terima' => date('Y-m-d', strtotime($request->tglPenerimaan)),
                'sifat' => $request->sifat,
                'asal_surat' => $lembaga->nama_lembaga,
                'no_surat' => strtoupper($request->noSurat),
                'tgl_surat' => date("Y-m-d", strtotime($request->tglSurat)),
                'perihal' => $request->perihal,
                'alamat' => $lembaga->alamat,
                'provinsi' => $request->provinsi,
                'kabupaten' => $request->kabupaten,
                'kecamatan' => $request->kecamatan,
                'kelurahan' => $request->kelurahan,
                'id_lembaga' => $lembaga->id_lembaga,
                'pengaju_proposal' => $lembaga->nama_pic,
                'sebagai' => $lembaga->jabatan,
                'contact_person' => $lembaga->no_telp,
                'email_pengaju' => session('user')->email,
                'nilai_pengajuan' => $request->besarPermohonanAsli,
                'bantuan_untuk' => $request->digunakanUntuk,
                'deskripsi' => $request->deskripsiBantuan,
                'jenis' => $request->jenis,
                'no_rekening' => $lembaga->no_rekening,
                'atas_nama' => $lembaga->atas_nama,
                'nama_bank' => $lembaga->nama_bank,
            ];

            $dataLog = [
                'id_kelayakan' => $kelayakanID,
                'keterangan' => 'Edit kelayakan proposal',
                'created_by' => session('user')->id_user,
                'created_date' => now(),
            ];

            DB::table('tbl_kelayakan')->where('id_kelayakan', $kelayakanID)->update($dataKelayakan);
            DB::table('tbl_log')->insert($dataLog);
            DB::commit();
            return redirect()->route('dataKelayakan')->with('sukses', 'Kelayakan proposal berhasil diubah');

        } catch (Exception $e) {
            DB::rollBack();
            report($e);
            return redirect()->back()->withInput()->with('gagal', 'Gagal merubah data kelayakan');
        }
    }

    private function romanMonth(int $n): string {
        static $r = ["","I","II","III","IV","V","VI","VII","VIII","IX","X","XI","XII"];
        return $r[$n] ?? "";
    }

    /**
     * Ambil nomor urut (5 digit) khusus tahun berjalan, aman dari race condition.
     * Pola:
     *  - Kunci baris tahun sekarang dengan FOR UPDATE.
     *  - Jika belum ada, buat baris awal (0), lalu kunci lagi.
     *  - Naikkan LAST_NO, kembalikan nilai barunya.
     */
    private function nextRunningNumberPerYear(): string {
        return DB::transaction(function () {
            $tahun = (int) date('Y');

            // Coba kunci baris tahun sekarang
            $row = DB::selectOne(
                "SELECT LAST_NO FROM NO_AGENDA WHERE TAHUN = ? FOR UPDATE",
                [$tahun]
            );

            if (!$row) {
                // Belum ada baris untuk tahun ini → buat dulu
                DB::insert("INSERT INTO NO_AGENDA (TAHUN, LAST_NO) VALUES (?, ?)", [$tahun, 0]);

                // Kunci lagi supaya pasti ter-lock pada baris yang baru
                $row = DB::selectOne(
                    "SELECT LAST_NO FROM NO_AGENDA WHERE TAHUN = ? FOR UPDATE",
                    [$tahun]
                );
            }

            $last  = (int) $row->last_no;
            $next  = $last + 1;

            DB::update(
                "UPDATE NO_AGENDA SET LAST_NO = ? WHERE TAHUN = ?",
                [$next, $tahun]
            );

            // 5 digit, mis. 00001
            return str_pad((string) $next, 5, '0', STR_PAD_LEFT);
        });
    }

    private function generateNoAgendaWithCounter(): string {
        $nomor = $this->nextRunningNumberPerYear();     // contoh: 00042
        $roman = $this->romanMonth((int) date('n'));    // contoh: VIII
        $tahun = date('Y');                              // contoh: 2025
        return "{$nomor}/CSR-OPS/{$roman}/{$tahun}";
    }

    public function storeOperasional(Request $request)
    {
        $request->validate([
            'noSurat' => 'required|max:100',
            'tglSurat' => 'required|date',
            'sifat' => 'required',
            'dari' => 'required|string|max:150',
            'alamat' => 'required|string|max:255',
            'besarPermohonanAsli' => 'required|numeric',
            'provinsi' => 'required|string|max:100',
            'kabupaten' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kelurahan' => 'required|string|max:100',
            'deskripsiBantuan' => 'required|string|max:500',
        ], [
            'noSurat.required' => 'Nomor surat harus diisi',
            'noSurat.max' => 'Nomor surat maksimal 100 karakter',
            'tglSurat.required' => 'Tanggal surat harus diisi',
            'tglSurat.date' => 'Format tanggal surat tidak valid',
            'sifat.required' => 'Sifat surat harus diisi',
            'dari.required' => 'Nama lembaga harus dipilih',
            'besarPermohonanAsli.required' => 'Besar permohonan harus diisi',
            'besarPermohonanAsli.regex' => 'Format besar permohonan hanya angka, koma, dan titik',
            'provinsi.required' => 'Provinsi harus diisi',
            'kabupaten.required' => 'Kabupaten/Kota harus diisi',
            'kecamatan.required' => 'Kecamatan harus diisi',
            'kelurahan.required' => 'Kelurahan harus diisi',
            'deskripsiBantuan.required' => 'Deskripsi bantuan harus diisi',
            'deskripsiBantuan.max' => 'Deskripsi maksimal 500 karakter',
        ]);

        $noagenda  = $this->generateNoAgendaWithCounter();

        // $hirarki = User::where('id_user', session('user')->id_user)->where('role', 'Payment')->first();

        // if(empty($hirarki)){
        //     return redirect()->back()->with('gagal', "Anda tidak memiliki akses untuk input biaya operasional")->withInput();
        // }
            
        try {
            $lembaga = Lembaga::findOrFail($request->dari);
            $idKelayakan = DB::selectOne("SELECT TBL_KELAYAKAN_ID_KELAYAKAN_SEQ.NEXTVAL AS ID FROM DUAL")->id;

            $dataKelayakan = [
                'id_kelayakan' => $idKelayakan,
                'no_agenda' => strtoupper($noagenda),
                'id_pengirim' => 2,
                'tgl_terima' => date('Y-m-d', strtotime($request->tglSurat)),
                'sifat' => $request->sifat,
                'asal_surat' => $lembaga->nama_lembaga,
                'no_surat' => strtoupper($request->noSurat),
                'tgl_surat' => date("Y-m-d", strtotime($request->tglSurat)),
                'perihal' => 'Permohonan Bantuan Dana',
                'alamat' => $lembaga->alamat,
                'provinsi' => $request->provinsi,
                'kabupaten' => $request->kabupaten,
                'kecamatan' => $request->kecamatan,
                'kelurahan' => $request->kelurahan,
                'id_lembaga' => $lembaga->id_lembaga,
                'pengaju_proposal' => $lembaga->nama_pic,
                'sebagai' => $lembaga->jabatan,
                'contact_person' => $lembaga->no_telp,
                'email_pengaju' => session('user')->email,
                'nilai_pengajuan' => $request->besarPermohonanAsli,
                'nilai_bantuan' => $request->besarPermohonanAsli,
                'bantuan_untuk' => 'Operasional CSR',
                'deskripsi' => $request->deskripsiBantuan,
                'jenis' => 'Operasional',
                'status' => 'Approved',
                'create_by' => session('user')->username,
                'created_date' => now(),
                'created_by' => session('user')->id_user,
                'no_rekening' => $lembaga->no_rekening,
                'atas_nama' => $lembaga->atas_nama,
                'nama_bank' => $lembaga->nama_bank,
            ];

            $approver = ViewHirarki::where('level', 3)->where('status', 'Active')->first();
            $lastApprover = ViewHirarki::where('level', 4)->where('status', 'Active')->first();

            $dataEvaluasi = [
                'no_agenda' => strtoupper($noagenda),
                'id_kelayakan' => $idKelayakan,
                'rencana_anggaran' => 'ADA',
                'dokumen' => 'ADA',
                'denah' => 'TIDAK ADA',
                'syarat' => 'Survei',
                'catatan1' => 'Biaya Operasional',
                'catatan2' => 'Biaya Operasional',
                'ket_kadiv' => 'Untuk dapat diproses sesuai prosedur',
                'ket_kadin1' => 'Untuk ditindaklanjuti sesuai peraturan yang berlaku',
                'evaluator1' => session('user')->username,
                'evaluator2' => session('user')->username,
                'kadep' => $approver->username,
                'kadiv' => $lastApprover->username,
                'status' => 'Survei',
                'approve_date' => now(),
                'approve_kadep' => now(),
                'approve_kadiv' => now(),
                'create_by' => session('user')->username,
                'created_by' => session('user')->id_user,
                'create_date' => now(),
            ];

            $dataSurvei = [
                'no_agenda' => strtoupper($noagenda),
                'id_kelayakan' => $idKelayakan,
                'usulan'          => 'Disarankan',
                'bantuan_berupa'  => 'Dana',
                'hasil_konfirmasi'  => 'Biaya Operasional',
                'hasil_survei'  => 'Biaya Operasional',
                'ket_kadin1'  => 'Dilengkapi kelengkapan dokumen administrasi sesuai peraturan yang berlaku',
                'nilai_bantuan'   => $request->besarPermohonanAsli,
                'nilai_approved'   => $request->besarPermohonanAsli,
                'termin'          => 1,
                'persen1'          => 100,
                'rupiah1'          => $request->besarPermohonanAsli,
                'survei1'         => session('user')->username,
                'survei2'         => session('user')->username,
                'status'          => 'Approved 3',
                'kadep'           => $approver->username,
                'kadiv'           => $lastApprover->username,
                'created_by'      => session('user')->id_user,
                'create_date' => now(),
                'approve_date' => now(),
                'approve_kadep' => now(),
                'approve_kadiv' => now(),
            ];

            $dataKriteria = [
                'no_agenda' => strtoupper($request->noAgenda),
                'id_kelayakan' => $idKelayakan,
                'kriteria' => 'Kelancaran Operasional/asset NR',
            ];

            $dataPembayaran = [
                'id_kelayakan' => $idKelayakan,
                'deskripsi' => $request->deskripsiBantuan,
                'termin' => 1,
                'metode' => 'Popay',
                'nilai_approved' => $request->besarPermohonanAsli,
                'jumlah_pembayaran' => $request->besarPermohonanAsli,
                'fee' => 0,
                'fee_persen' => 0,
                'subtotal' => $request->besarPermohonanAsli,
                'status' => 'Open',
                'create_date' => now(),
                'create_by' => session('user')->username,
            ];            

            DB::table('tbl_kelayakan')->insert($dataKelayakan);
            DB::table('tbl_evaluasi')->insert($dataEvaluasi);
            DB::table('tbl_survei')->insert($dataSurvei);
            DB::table('tbl_detail_kriteria')->insert($dataKriteria);
            DB::table('tbl_pembayaran')->insert($dataPembayaran);

            DB::commit();
            return redirect()->route('dataKelayakan')->with('sukses', 'Operasional berhasil disimpan');    

        } catch (Exception $e) {
            DB::rollBack();
            report($e); // Log error
            return redirect()->back()->withInput()->with('gagal', 'Gagal menyimpan data operasional');
        }
    }

    public function detail($id)
    {

        try {
            $kelayakanID = decrypt($id);
        } catch (Exception $e) {
            abort(404);
        }

        //dd($kelayakanID);

        $perusahaanID = session('user')->id_perusahaan;
        $tahun = date("Y");

        $kelayakan = ViewProposal::where('id_kelayakan', $kelayakanID)->with('proker')->first();
        
        $evaluasi = Evaluasi::where('id_kelayakan', $kelayakanID)->with('user')->first();
        $survei = Survei::where('id_kelayakan', $kelayakanID)->with('user')->first();
        $bast = BASTDana::where('id_kelayakan', $kelayakanID)->with('approver')->first();
        $pembayaran = Pembayaran::where('id_kelayakan', $kelayakanID)->with('kelayakan')->get();

        $lembaga = Lembaga::where('id_perusahaan', $perusahaanID)->orderBy('nama_lembaga', 'ASC')->get();
        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $pengirim = Pengirim::where('id_perusahaan', $perusahaanID)->where('status', 'Active')->orderBy('pengirim', 'ASC')->get(); 
        $anggaran = Anggaran::where('id_perusahaan', $perusahaanID)
            ->orderBy('tahun', 'DESC')
            ->take(2)
            ->get(); 

        $proker = Proker::where('id_perusahaan', $perusahaanID)->where('tahun', $tahun)->orderBy('id_proker', 'ASC')->get();

        $logs = Log::where('id_kelayakan', $kelayakanID)
            ->with('user')
            ->latest('created_date')
            ->get();

        $groupedLogs = $logs->groupBy(function ($item) {
            $date = \Carbon\Carbon::parse($item->created_date)->startOfDay();

            if ($date->isToday()) {
                return 'Hari Ini';
            } elseif ($date->isYesterday()) {
                return 'Kemarin';
            } else {
                return $date->translatedFormat('d F Y');
            }
        });

        $dokumen = Dokumen::orderBy('id')->get();        
        $lampiran = Lampiran::where('id_kelayakan', $kelayakanID)->with('user')->orderBy('id_lampiran')->get();
        $dokumentasi = Lampiran::where('id_kelayakan', $kelayakanID)->where('nama', 'Dokumentasi')->with('user')->orderBy('id_lampiran')->get();
        $kepentingan = DetailKriteria::where('id_kelayakan', $kelayakanID)->get();
        $kepentinganDipilih = DetailKriteria::where('id_kelayakan', $kelayakanID)->pluck('kriteria')->toArray();
        
        $jumlahApproval = DetailApproval::where('id_kelayakan', $kelayakanID)->count();
        $logApprovalEvaluasi = DetailApproval::where('id_kelayakan', $kelayakanID)->where('phase', 'Evaluasi')->with('hirarki')->with('user')->orderBy('id')->get();
        $logApprovalSurvei = DetailApproval::where('id_kelayakan', $kelayakanID)->where('phase', 'Survei')->with('hirarki')->with('user')->orderBy('id')->get();

        $bank = Bank::orderBy('nama_bank')->get();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();
        
        $reviewer = ViewHirarki::where('level', 2)->where('status', 'Active')->orderBy('nama')->get();
        $nextApprover = ViewDetailApproval::where('id_kelayakan', $kelayakanID)->where('status', 'In Progress')->with('user')->first();
        $approver = User::whereIn('role', ['Supervisor 1', 'Manager', 'Corporate Secretary', 'Direktur'])->where('status', 'Active')->orderBy('id_user', 'ASC')->get();
        return view('proposal.view')
            ->with([
                'data' => $kelayakan,
                'evaluasi' => $evaluasi,
                'survei' => $survei,
                'bast' => $bast,
                'pembayaran' => $pembayaran,
                'dataLembaga' => $lembaga,
                'dataProvinsi' => $provinsi,
                'dataPengirim' => $pengirim,
                'dataAnggaran' => $anggaran,
                'dataProker' => $proker,
                'dataLogs' => $logs,
                'groupedLogs' => $groupedLogs,
                'jumlahApproval' => $jumlahApproval,
                'dataApproverEvaluasi' => $logApprovalEvaluasi,
                'dataApproverSurvei' => $logApprovalSurvei,
                'dataDokumen' => $dokumen,
                'dataBank' => $bank,
                'dataPilar' => $pilar,
                'nextApprover' => $nextApprover,
                'dataReviewer' => $reviewer,
                'dataApprover' => $approver,
                'dataLampiran' => $lampiran,
                'dataDokumentasi' => $dokumentasi,
                'dataKepentingan' => $kepentingan,
                'kepentinganDipilih' => $kepentinganDipilih,
            ]);
    }

    public function updateProposal(Request $request)
    {

        try {
            $kelayakanID = decrypt($request->kelayakanID);
        } catch (Exception $e) {
            abort(404);
        }

        $request->validate([
            'noAgenda' => 'required|max:100',
            'tglPenerimaan' => 'required|date',
            'pengirim' => 'required',
            'noSurat' => 'required|max:100',
            'tglSurat' => 'required|date',
            'sifat' => 'required',
            'digunakanUntuk' => 'required|string|max:200',
            'jenis' => 'required',
        ], [
            'noAgenda.required' => 'No Agenda harus diisi',
            'noAgenda.max' => 'No Agenda maksimal 100 karakter',
            'tglPenerimaan.required' => 'Tanggal penerimaan harus diisi',
            'tglPenerimaan.date' => 'Format tanggal penerimaan tidak valid',
            'pengirim.required' => 'Pengirim harus diisi',
            'noSurat.required' => 'Nomor surat harus diisi',
            'noSurat.max' => 'Nomor surat maksimal 100 karakter',
            'tglSurat.required' => 'Tanggal surat harus diisi',
            'tglSurat.date' => 'Format tanggal surat tidak valid',
            'sifat.required' => 'Sifat surat harus diisi',
            'digunakanUntuk.required' => 'Perihal harus diisi',
            'digunakanUntuk.max' => 'Perihal maksimal 200 karakter',
            'jenis.required' => 'Jenis proposal harus dipilih',
        ]);

        try {
            $dataKelayakan = [
                'no_agenda' => strtoupper($request->noAgenda),
                'id_pengirim' => $request->pengirim,
                'tgl_terima' => date('Y-m-d', strtotime($request->tglPenerimaan)),
                'sifat' => $request->sifat,
                'no_surat' => strtoupper($request->noSurat),
                'tgl_surat' => date("Y-m-d", strtotime($request->tglSurat)),
                'bantuan_untuk' => $request->digunakanUntuk,
                'jenis' => $request->jenis,
            ];

            $dataLog = [
                'id_kelayakan' => $kelayakanID,
                'keterangan' => 'Edit surat/proposal',
                'created_by' => session('user')->id_user,
                'created_date' => now(),
            ];

            DB::table('tbl_kelayakan')->where('id_kelayakan', $kelayakanID)->update($dataKelayakan);
            DB::table('tbl_log')->insert($dataLog);
            DB::commit();
            return redirect()->back()->with('suksesDetail', 'Surat/proposal berhasil diperbarui');

        } catch (Exception $e) {
            DB::rollBack();
            report($e);
            return redirect()->back()->withInput()->with('gagalDetail', 'Gagal memperbarui data surat/proposal');
        }
    }

    public function updatePenerima(Request $request)
    {

        try {
            $kelayakanID = decrypt($request->kelayakanID);
        } catch (Exception $e) {
            abort(404);
        }

        $request->validate([
            'dari' => 'required|string|max:150',
            'alamat' => 'required|string|max:255',
            'besarPermohonanAsli' => 'required|numeric',
            'perihal' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kabupaten' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kelurahan' => 'required|string|max:100',
            'deskripsiBantuan' => 'required|string|max:500',
        ], [
            'dari.required' => 'Nama lembaga harus dipilih',
            'besarPermohonanAsli.required' => 'Besar permohonan harus diisi',
            'besarPermohonanAsli.regex' => 'Format besar permohonan hanya angka, koma, dan titik',
            'perihal.required' => 'Kategori bantuan harus diisi',
            'provinsi.required' => 'Provinsi harus diisi',
            'kabupaten.required' => 'Kabupaten/Kota harus diisi',
            'kecamatan.required' => 'Kecamatan harus diisi',
            'kelurahan.required' => 'Kelurahan harus diisi',
            'deskripsiBantuan.required' => 'Deskripsi bantuan harus diisi',
            'deskripsiBantuan.max' => 'Deskripsi maksimal 500 karakter',
        ]);

        try {
            $lembaga = Lembaga::findOrFail($request->dari);

            $dataKelayakan = [
                'perihal' => $request->perihal,
                'alamat' => $lembaga->alamat,
                'provinsi' => $request->provinsi,
                'kabupaten' => $request->kabupaten,
                'kecamatan' => $request->kecamatan,
                'kelurahan' => $request->kelurahan,
                'id_lembaga' => $lembaga->id_lembaga,
                'pengaju_proposal' => $lembaga->nama_pic,
                'sebagai' => $lembaga->jabatan,
                'contact_person' => $lembaga->no_telp,
                'email_pengaju' => session('user')->email,
                'nilai_pengajuan' => $request->besarPermohonanAsli,
                'deskripsi' => $request->deskripsiBantuan,
            ];

            $dataLog = [
                'id_kelayakan' => $kelayakanID,
                'keterangan' => 'Edit penerima manfaat',
                'created_by' => session('user')->id_user,
                'created_date' => now(),
            ];

            DB::table('tbl_kelayakan')->where('id_kelayakan', $kelayakanID)->update($dataKelayakan);
            DB::table('tbl_log')->insert($dataLog);

            DB::commit();
            return redirect()->back()->with('suksesDetail', 'Penerima manfaat berhasil diperbarui');

        } catch (Exception $e) {
            DB::rollBack();
            report($e);
            return redirect()->back()->withInput()->with('gagalDetail', 'Gagal memperbarui data penerima manfaat');
        }
    }

    public function updateBank(Request $request)
    {
        try {
            $kelayakanID = decrypt($request->kelayakanID);
        } catch (Exception $e) {
            abort(404);
        }

        $request->validate([
            'namaBank' => 'required',
            'noRekening' => 'required|numeric',
            'atasNama' => 'required|max:100|min:3',
        ], [
            'namaBank.required'  => 'Nama bank harus diisi',
            'noRekening.required' => 'No rekening harus diisi',
            'atasNama.required'  => 'Atas nama harus diisi',
            'atasNama.max' => 'Atas nama maksimal 100 karakter',
            'atasNama.min' => 'Atas nama minimal 3 karakter',
        ]);

        $dataBank = [
            'nama_bank' => $request->namaBank,
            'atas_nama' => $request->atasNama,
            'no_rekening' => $request->noRekening,
        ];

        $dataLog = [
            'id_kelayakan' => $kelayakanID,
            'keterangan' => 'Edit informasi bank',
            'created_by' => session('user')->id_user,
            'created_date' => now(),
        ];

       try {
            Kelayakan::where('id_kelayakan', $kelayakanID)->update($dataBank);
            DB::table('tbl_log')->insert($dataLog);
            return redirect()->back()->with('suksesDetail', 'Informasi bank berhasil diperbarui');
       } catch (Exception $e) {
            return redirect()->back()->with('gagalDetail', 'Gagal memperbarui data informasi bank');
       }
    }

    public function updateProker(Request $request)
    {
        try {
            $kelayakanID = decrypt($request->kelayakanID);
        } catch (Exception $e) {
            abort(404);
        }

        $request->validate([
            'prokerID' => 'required',
            'pilar' => 'required|max:100',
            'tpb' => 'required|max:200',
        ], [
            'prokerID.required'  => 'Program kerja harus dipilih',
            'pilar.required' => 'Pilar harus diisi',
            'tpb.required'  => 'TPB harus diisi',
        ]);

        $proker = Proker::findOrFail($request->prokerID);

        if (!$proker) {
            return redirect()->back()->with('gagalDetail', 'Data Program kerja tidak ditemukan.');
        }

        $dataProker = [
            'id_proker' => $request->prokerID,
            'pilar' => $request->pilar,
            'tpb' => $request->tpb,
        ];

        $dataLog = [
            'id_kelayakan' => $kelayakanID,
            'keterangan' => 'Edit Program Kerja',
            'created_by' => session('user')->id_user,
            'created_date' => now(),
        ];

       try {
            Kelayakan::where('id_kelayakan', $kelayakanID)->update($dataProker);
            DB::table('tbl_log')->insert($dataLog);
            return redirect()->back()->with('suksesDetail', 'Program kerja berhasil diperbarui');
       } catch (Exception $e) {
            return redirect()->back()->with('gagalDetail', 'Gagal memperbarui data program kerja');
       }
    }
    public function submit(Request $request)
    {
        try {
            $hirarkiID = decrypt($request->hirarkiID);
            $kelayakanID = decrypt($request->kelayakanID);
        } catch (DecryptException $e) {
            abort(404);
        }

        $request->validate([
            'catatan' => 'required|min:10',
        ], [
            'catatan.required' => 'Catatan harus diisi',
            'catatan.min' => 'Catatan minimal 10 karakter',
        ]);

        $kelayakan = ViewProposal::where('id_kelayakan', $kelayakanID)->first();
        $evaluasi = Evaluasi::where('id_kelayakan', $kelayakanID)->first();
        $survei = Survei::where('id_kelayakan', $kelayakanID)->first();
        $detailApproval = ViewDetailApproval::where('id', $hirarkiID)->first();

        $currentLevel = $detailApproval->level;
        $nextLevel = $currentLevel + 1;
        $finalLevel = $this->getFinalApprovalLevel($kelayakan->nilai_bantuan);
        $isFinal = $currentLevel >= $finalLevel;
        $phase = $kelayakan->status;
        $catatan = $request->catatan;
        $statusApproval = $currentLevel == 1 ? 'Submitted' : 'Approved';

        $nextApprover = null;
        if (!$isFinal) {
            if ($phase === 'Evaluasi') {
                if ($currentLevel == 1) {
                    $nextApprover = ViewHirarki::where('username', $evaluasi->evaluator2)
                        ->where('level', $nextLevel)
                        ->where('status', 'Active')
                        ->first();
                } else {
                    $nextApprover = ViewHirarki::where('level', $nextLevel)
                        ->where('status', 'Active')
                        ->first();
                }
            } else {
                if ($currentLevel == 1) {
                    $nextApprover = ViewHirarki::where('username', $survei->survei2)
                        ->where('level', $nextLevel)
                        ->where('status', 'Active')
                        ->first();
                } else {
                    $nextApprover = ViewHirarki::where('level', $nextLevel)
                        ->where('status', 'Active')
                        ->first();
                }
            }
        }

        try {
            DB::beginTransaction();

            if ($phase === 'Evaluasi') {
                if ($isFinal || !$nextApprover) {
                    $update = $this->getEvaluasiUpdate($currentLevel, $catatan);
                    $statusKelayakan = 'Survei';
                    $this->sendEmailNotif($kelayakan, $kelayakan->created_by, 'notifikasi_persetujuan');
                } else {
                    DB::table('tbl_detail_approval')->insert([
                        'id_kelayakan' => $kelayakanID,
                        'id_hirarki' => $nextApprover->id,
                        'id_user' => $nextApprover->id_user,
                        'status' => 'In Progress',
                        'phase' => 'Evaluasi',
                        'status_date' => now(),
                        'task_date' => now(),
                        'created_by' => session('user')->id_user,
                        'pesan' => $catatan,
                    ]);
                    $update = $this->getEvaluasiUpdate($currentLevel, $catatan);
                    $statusKelayakan = 'Evaluasi';
                    $this->sendEmailNotif($kelayakan, $nextApprover->id_user, 'notifikasi_permohonan_persetujuan');
                }

                DB::table('tbl_evaluasi')->where('id_kelayakan', $kelayakanID)->update($update);
            } else {
                if ($isFinal || !$nextApprover) {
                    $update = $this->getSurveiUpdate($currentLevel, $catatan, $survei->nilai_bantuan);
                    $statusKelayakan = 'Approved';

                    $jumlahTermin = (int) $survei->termin;

                    for ($i = 1; $i <= $jumlahTermin; $i++) {
                        $persen = (float) $survei->{'persen' . $i};
                        $rupiah = (float) $survei->{'rupiah' . $i};

                        if ($jumlahTermin > 1) {
                            $deskripsi = "Pembayaran termin ke $i atas $kelayakan->bantuan_untuk $kelayakan->nama_lembaga $kelayakan->kabupaten $kelayakan->provinsi";
                        } else {
                            $deskripsi = "Pembayaran atas $kelayakan->bantuan_untuk $kelayakan->nama_lembaga $kelayakan->kabupaten $kelayakan->provinsi";
                        }

                        // Validasi: hanya simpan jika rupiah dan persen lebih dari 0
                        if ($rupiah > 0 && $persen > 0) {
                            $dataPembayaran = [
                                'id_kelayakan' => $kelayakan->id_kelayakan,
                                'deskripsi' => $deskripsi,
                                'termin' => $i,
                                'metode' => 'Popay',
                                'nilai_approved' => $survei->nilai_approved,
                                'jumlah_pembayaran' => $rupiah,
                                'fee' => 0,
                                'fee_persen' => 0,
                                'subtotal' => $rupiah,
                                'status' => 'Open',
                                'create_date' => now(),
                                'create_by' => session('user')->username,
                            ];

                            DB::table('tbl_pembayaran')->insert($dataPembayaran);
                        }
                    }

                    $this->sendEmailNotif($kelayakan, $kelayakan->created_by, 'notifikasi_persetujuan');
                } else {
                    DB::table('tbl_detail_approval')->insert([
                        'id_kelayakan' => $kelayakanID,
                        'id_hirarki' => $nextApprover->id,
                        'id_user' => $nextApprover->id_user,
                        'status' => 'In Progress',
                        'phase' => 'Survei',
                        'status_date' => now(),
                        'task_date' => now(),
                        'created_by' => session('user')->id_user,
                        'pesan' => $catatan,
                    ]);
                    $update = $this->getSurveiUpdate($currentLevel, $catatan, $survei->nilai_bantuan);
                    $statusKelayakan = 'Survei';
                    $this->sendEmailNotif($kelayakan, $nextApprover->id_user, 'notifikasi_permohonan_persetujuan');
                }

                DB::table('tbl_survei')->where('id_kelayakan', $kelayakanID)->update($update);
            }

            DB::table('tbl_kelayakan')->where('id_kelayakan', $kelayakanID)->update(['status' => $statusKelayakan]);

            DB::table('tbl_log')->insert([
                'id_kelayakan' => $kelayakanID,
                'keterangan' => 'Submit persetujuan ' . strtolower($phase) . ' proposal',
                'created_by' => session('user')->id_user,
                'created_date' => now(),
            ]);

            DB::table('tbl_detail_approval')->where('id', $detailApproval->id)->update([
                'catatan' => $catatan,
                'status' => $statusApproval,
                'action_date' => now(),
            ]);

            DB::commit();
            return redirect()->back()->with('suksesDetail', "Persetujuan berhasil disubmit");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('gagalDetail', 'Persetujuan gagal disubmit');
        }
    }

    private function getFinalApprovalLevel($nilai)
    {
        if ($nilai <= 500000000) return 4;
        if ($nilai <= 2000000000) return 5;
        return 6;
    }

    private function getEvaluasiUpdate($level, $catatan)
    {
        switch ($level) {
            case 1:
                return ['status' => 'Approved 1', 'catatan1' => $catatan, 'create_date' => now()];
            case 2:
                return ['status' => 'Approved 2', 'catatan2' => $catatan, 'approve_date' => now()];
            case 3:
                return ['status' => 'Approved 3', 'ket_kadin1' => $catatan, 'approve_kadep' => now()];
            case 4:
                return ['status' => 'Survei', 'ket_kadiv' => $catatan, 'approve_kadiv' => now()];
            case 5:
                return ['status' => 'Approved Sekper', 'ket_sekper' => $catatan, 'approve_sekper' => now()];
            case 6:
                return ['status' => 'Approved Dirut', 'ket_dirut' => $catatan, 'approve_dirut' => now()];        
            default:
                return [];
        }
    }

    private function getSurveiUpdate($level, $catatan, $nilai)
    {
        switch ($level) {
            case 1:
                return ['status' => 'Forward', 'hasil_survei' => $catatan, 'nilai_approved' => $nilai, 'create_date' => now()];
            case 2:
                return ['status' => 'Approved 1', 'hasil_konfirmasi' => $catatan, 'nilai_approved' => $nilai, 'approve_date' => now()];
            case 3:
                return ['status' => 'Approved 2', 'ket_kadin1' => $catatan, 'nilai_approved' => $nilai, 'approve_kadep' => now()];
            case 4:
                return ['status' => 'Approved 3', 'ket_kadiv' => $catatan, 'nilai_approved' => $nilai, 'approve_kadiv' => now()];
            case 5:
                return ['status' => 'Approved Sekper', 'ket_sekper' => $catatan, 'nilai_approved' => $nilai, 'approve_sekper' => now()];
            case 6:
                return ['status' => 'Approved Dirut', 'ket_dirut' => $catatan, 'nilai_approved' => $nilai, 'approve_dirut' => now()];    
            default:
                return [];
        }
    }

    private function sendEmailNotif($kelayakan, $receiverId, $template)
    {
        $receiver = User::find($receiverId);

        $dataEmail = [
            'nama_penerima' => $receiver->nama,
            'phase' => $kelayakan->status,
            'id' => $kelayakan->id_kelayakan,
            'no_agenda' => $kelayakan->no_agenda,
            'tanggal_terima' => formatTanggal::tanggal_indo(date('Y-m-d', strtotime($kelayakan->tgl_terima))),
            'pengirim' => $kelayakan->pengirim,
            'nama_lembaga' => $kelayakan->nama_lembaga,
            'perihal' => $kelayakan->bantuan_untuk,
            'besar_permohonan' => 'Rp. ' . number_format($kelayakan->nilai_pengajuan, 0, ',', '.'),
            'perkiraan_bantuan' => 'Rp. ' . number_format($kelayakan->nilai_bantuan, 0, ',', '.'),
        ];

        Mail::send("mail.$template", $dataEmail, function ($message) use ($receiver, $kelayakan) {
            $message->to($receiver->email, $receiver->nama)
                ->subject("Persetujuan $kelayakan->status Proposal")
                ->from('pgn.no.reply@pertamina.com', 'NR SHARE');
        });
    }

    public function cariKelayakan()
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

        $tahun = date("Y");
        $sektor = SektorBantuan::all();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();
        $provinsi = Provinsi::all();
        $pengirim = Pengirim::orderBy('pengirim', 'ASC')->get();
        $data = Kelayakan::where('status', '!=', 'Approved')->whereYear('tgl_terima', $tahun)->orderBy('create_date', 'DESC')->get();
        $jumlahData = Kelayakan::where('status', '!=', 'Approved')->whereYear('tgl_terima', $tahun)->count();
        return view('report.data_kelayakan')
            ->with([
                'dataSektor' => $sektor,
                'dataPilar' => $pilar,
                'dataProvinsi' => $provinsi,
                'dataKelayakan' => $data,
                'jumlahData' => $jumlahData,
                'dataPengirim' => $pengirim,
                'keterangan' => "Proposal Ongoing Tahun $tahun",
            ]);
    }

    public function cariKelayakanCompleted()
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

        $tahun = date("Y");
        $sektor = SektorBantuan::all();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();
        $provinsi = Provinsi::all();
        $pengirim = Pengirim::orderBy('pengirim', 'ASC')->get();
        $data = Kelayakan::where('status', '=', 'Approved')->whereYear('tgl_terima', $tahun)->orderBy('create_date', 'DESC')->get();
        $jumlahData = Kelayakan::where('status', '=', 'Approved')->whereYear('tgl_terima', $tahun)->count();
        return view('report.data_kelayakan')
            ->with([
                'dataSektor' => $sektor,
                'dataPilar' => $pilar,
                'dataProvinsi' => $provinsi,
                'dataKelayakan' => $data,
                'jumlahData' => $jumlahData,
                'dataPengirim' => $pengirim,
                'keterangan' => "Proposal Completed Tahun $tahun",
            ]);
    }

    public function dataToday()
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

        $tanggalNow = date("Y-m-d");
        $sektor = SektorBantuan::all();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();
        $provinsi = Provinsi::all();
        $pengirim = Pengirim::orderBy('pengirim', 'ASC')->get();
        $data = Kelayakan::whereDate('create_date', $tanggalNow)->orderBy('create_date', 'DESC')->get();
        $jumlahData = Kelayakan::whereDate('create_date', $tanggalNow)->count();

        return view('report.data_kelayakan')
            ->with([
                'dataSektor' => $sektor,
                'dataPilar' => $pilar,
                'dataProvinsi' => $provinsi,
                'dataKelayakan' => $data,
                'jumlahData' => $jumlahData,
                'dataPengirim' => $pengirim,
                'keterangan' => "Tanggal Input ". tanggal_indo($tanggalNow),
            ]);
    }

    public function cariBulan(CariKelayakanBulanRequest $request, CariKelayakanBulanAction $action)
    {
        return $action->execute($request);
    }

    public function dataBulan($bulan, $tahun)
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

        if ($bulan == 1){
            $bln = 'Januari';
        }elseif ($bulan == 2){
            $bln = 'Februari';
        }elseif ($bulan == 3){
            $bln = 'Maret';
        }elseif ($bulan == 4){
            $bln = 'April';
        }elseif ($bulan == 5){
            $bln = 'Mei';
        }elseif ($bulan == 6){
            $bln = 'Juni';
        }elseif ($bulan == 7){
            $bln = 'Juli';
        }elseif ($bulan == 8){
            $bln = 'Agustus';
        }elseif ($bulan == 9){
            $bln = 'September';
        }elseif ($bulan == 10){
            $bln = 'Oktober';
        }elseif ($bulan == 11){
            $bln = 'November';
        }elseif ($bulan == 12){
            $bln = 'Desember';
        }

        $sektor = SektorBantuan::all();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();
        $provinsi = Provinsi::all();
        $pengirim = Pengirim::orderBy('pengirim', 'ASC')->get();
        $data = Kelayakan::whereMonth('tgl_terima', $bulan)->whereYear('tgl_terima', $tahun)->orderBy('create_date', 'DESC')->get();
        $jumlahData = Kelayakan::whereMonth('tgl_terima', $bulan)->whereYear('tgl_terima', $tahun)->count();

        return view('report.data_kelayakan')
            ->with([
                'dataSektor' => $sektor,
                'dataPilar' => $pilar,
                'dataProvinsi' => $provinsi,
                'dataKelayakan' => $data,
                'jumlahData' => $jumlahData,
                'dataPengirim' => $pengirim,
                'tahun' => $tahun,
                'keterangan' => "Periode $bln $tahun",
            ]);
    }

    public function cariTahun(CariKelayakanTahunRequest $request, CariKelayakanTahunAction $action)
    {
        return $action->execute($request);
    }

    public function dataTahun($tahun)
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

        $sektor = SektorBantuan::all();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();
        $provinsi = Provinsi::all();
        $pengirim = Pengirim::orderBy('pengirim', 'ASC')->get();
        $data = Kelayakan::whereYear('tgl_terima', $tahun)->orderBy('create_date', 'DESC')->get();
        $jumlahData = Kelayakan::whereYear('tgl_terima', $tahun)->count();
        return view('report.data_kelayakan')
            ->with([
                'dataSektor' => $sektor,
                'dataPilar' => $pilar,
                'dataProvinsi' => $provinsi,
                'dataKelayakan' => $data,
                'jumlahData' => $jumlahData,
                'dataPengirim' => $pengirim,
                'keterangan' => "All Data Tahun $tahun",
            ]);
    }

    public function cariPeriode(CariKelayakanPeriodeRequest $request, CariKelayakanPeriodeAction $action)
    {
        return $action->execute($request);
    }

    public function dataPeriode($tanggal1, $tanggal2)
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

        $data = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->orderBy('create_date', 'DESC')->get();
        $jumlahData = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->count();
        $pengirim = Pengirim::orderBy('pengirim', 'ASC')->get();
        $sektor = SektorBantuan::all();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();
        $provinsi = Provinsi::all();
        return view('report.data_kelayakan')
            ->with([
                'dataKelayakan' => $data,
                'jumlahData' => $jumlahData,
                'dataSektor' => $sektor,
                'dataPilar' => $pilar,
                'dataProvinsi' => $provinsi,
                'dataPengirim' => $pengirim,
                'keterangan' => "Periode ". tanggal_indo($tanggal1)." S.d ". tanggal_indo($tanggal2),
            ]);
    }

    public function dataProvinsi($tanggal1, $tanggal2, $provinsi, $kabupaten)
    {
        try {
            $kab = decrypt($kabupaten);
        } catch (Exception $e) {
            abort(404);
        }

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

        if ($kab == 'Semua Kabupaten/Kota'){
            $data = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('provinsi', $provinsi)->orderBy('create_date', 'DESC')->get();
            $jumlahData = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('provinsi', $provinsi)->count();
        }else{
            $data = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('provinsi', $provinsi)->where('kabupaten', $kab)->orderBy('create_date', 'DESC')->get();
            $jumlahData = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('provinsi', $provinsi)->where('kabupaten', $kab)->count();
        }

        $sektor = SektorBantuan::all();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();
        $prov = Provinsi::all();
        return view('report.data_kelayakan')
            ->with([
                'dataKelayakan' => $data,
                'jumlahData' => $jumlahData,
                'dataSektor' => $sektor,
                'dataPilar' => $pilar,
                'dataProvinsi' => $prov,
                'keterangan' => "Provinsi $provinsi Periode ". tanggal_indo($tanggal1)." S.d ". tanggal_indo($tanggal2),
            ]);
    }

    public function dataProvinsiSDGs($tanggal1, $tanggal2, $provinsi, $kabupaten, $pilar, $gols)
    {
        try {
            $kab = decrypt($kabupaten);
        } catch (Exception $e) {
            abort(404);
        }

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

        if ($kab == 'Semua Kabupaten/Kota' and $gols == 'Semua Gols') {
            $data = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('provinsi', $provinsi)->where('pilar', $pilar)->orderBy('create_date', 'DESC')->get();
            $jumlahData = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('provinsi', $provinsi)->where('pilar', $pilar)->count();
        }elseif($gols == 'Semua Gols'){
            $data = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('provinsi', $provinsi)->where('kabupaten', $kab)->where('pilar', $pilar)->orderBy('create_date', 'DESC')->get();
            $jumlahData = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('provinsi', $provinsi)->where('kabupaten', $kab)->where('pilar', $pilar)->count();
        }elseif ($kab == 'Semua Kabupaten/Kota'){
            $data = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('provinsi', $provinsi)->where('tpb', $gols)->where('pilar', $pilar)->orderBy('create_date', 'DESC')->get();
            $jumlahData = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('provinsi', $provinsi)->where('tpb', $gols)->where('pilar', $pilar)->count();
        }else{
            $data = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('provinsi', $provinsi)->where('kabupaten', $kab)->where('tpb', $gols)->where('pilar', $pilar)->orderBy('create_date', 'DESC')->get();
            $jumlahData = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('provinsi', $provinsi)->where('kabupaten', $kab)->where('tpb', $gols)->where('pilar', $pilar)->count();
        }

        $sektor = SektorBantuan::all();
        $dataPilar = Pilar::orderBy('id_pilar', 'ASC')->get();
        $prov = Provinsi::all();
        return view('report.data_kelayakan')
            ->with([
                'dataKelayakan' => $data,
                'jumlahData' => $jumlahData,
                'dataSektor' => $sektor,
                'dataPilar' => $dataPilar,
                'dataProvinsi' => $prov,
                'keterangan' => "Provinsi $provinsi Pilar $pilar Periode ". tanggal_indo($tanggal1)." S.d ". tanggal_indo($tanggal2),
            ]);
    }

    public function dataProvinsiJenis($tanggal1, $tanggal2, $provinsi, $kabupaten, $jenis)
    {
        try {
            $kab = decrypt($kabupaten);
        } catch (Exception $e) {
            abort(404);
        }

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

        if ($kab == 'Semua Kabupaten/Kota'){
            $data = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('provinsi', $provinsi)->where('jenis', $jenis)->orderBy('tgl_terima', 'ASC')->get();
            $jumlahData = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('provinsi', $provinsi)->where('jenis', $jenis)->count();
        }else{
            $data = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('provinsi', $provinsi)->where('kabupaten', $kab)->where('jenis', $jenis)->orderBy('tgl_terima', 'ASC')->get();
            $jumlahData = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('provinsi', $provinsi)->where('kabupaten', $kab)->where('jenis', $jenis)->count();
        }

        $sektor = SektorBantuan::all();
        $dataPilar = Pilar::orderBy('id_pilar', 'ASC')->get();
        $prov = Provinsi::all();
        return view('report.data_kelayakan')
            ->with([
                'dataKelayakan' => $data,
                'jumlahData' => $jumlahData,
                'dataSektor' => $sektor,
                'dataPilar' => $dataPilar,
                'dataProvinsi' => $prov,
                'keterangan' => "Proposal $jenis Provinsi $provinsi Periode ". tanggal_indo($tanggal1)." S.d ". tanggal_indo($tanggal2),
            ]);
    }

    public function dataProvinsiSDGsJenis($tanggal1, $tanggal2, $provinsi, $kabupaten, $pilar, $gols, $jenis)
    {
        try {
            $kab = decrypt($kabupaten);
        } catch (Exception $e) {
            abort(404);
        }

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

        if ($kab == 'Semua Kabupaten/Kota' and $gols == 'Semua Gols') {
            $data = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('provinsi', $provinsi)->where('pilar', $pilar)->where('jenis', $jenis)->orderBy('tgl_terima', 'ASC')->get();
            $jumlahData = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('provinsi', $provinsi)->where('pilar', $pilar)->where('jenis', $jenis)->count();
        }elseif($gols == 'Semua Gols'){
            $data = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('provinsi', $provinsi)->where('kabupaten', $kab)->where('pilar', $pilar)->where('jenis', $jenis)->orderBy('tgl_terima', 'ASC')->get();
            $jumlahData = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('provinsi', $provinsi)->where('kabupaten', $kab)->where('pilar', $pilar)->where('jenis', $jenis)->count();
        }elseif ($kab == 'Semua Kabupaten/Kota'){
            $data = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('provinsi', $provinsi)->where('tpb', $gols)->where('pilar', $pilar)->where('jenis', $jenis)->orderBy('tgl_terima', 'ASC')->get();
            $jumlahData = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('provinsi', $provinsi)->where('tpb', $gols)->where('pilar', $pilar)->where('jenis', $jenis)->count();
        }else{
            $data = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('provinsi', $provinsi)->where('kabupaten', $kab)->where('tpb', $gols)->where('pilar', $pilar)->where('jenis', $jenis)->orderBy('tgl_terima', 'ASC')->get();
            $jumlahData = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('provinsi', $provinsi)->where('kabupaten', $kab)->where('tpb', $gols)->where('pilar', $pilar)->where('jenis', $jenis)->count();
        }

        $sektor = SektorBantuan::all();
        $dataPilar = Pilar::orderBy('id_pilar', 'ASC')->get();
        $prov = Provinsi::all();
        return view('report.data_kelayakan')
            ->with([
                'dataKelayakan' => $data,
                'jumlahData' => $jumlahData,
                'dataSektor' => $sektor,
                'dataPilar' => $dataPilar,
                'dataProvinsi' => $prov,
                'keterangan' => "Proposal $jenis Provinsi $provinsi Pilar $pilar Periode ". tanggal_indo($tanggal1)." S.d ". tanggal_indo($tanggal2),
            ]);
    }

    public function dataSDGs($tanggal1, $tanggal2, $pilar, $gols)
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

        if($gols == 'Semua Gols'){
            $data = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('pilar', $pilar)->orderBy('tgl_terima', 'ASC')->get();
            $jumlahData = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('pilar', $pilar)->count();
        }else{
            $data = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('tpb', $gols)->where('pilar', $pilar)->orderBy('tgl_terima', 'ASC')->get();
            $jumlahData = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('tpb', $gols)->where('pilar', $pilar)->count();
        }

        $sektor = SektorBantuan::all();
        $dataPilar = Pilar::orderBy('id_pilar', 'ASC')->get();
        $prov = Provinsi::all();
        return view('report.data_kelayakan')
            ->with([
                'dataKelayakan' => $data,
                'jumlahData' => $jumlahData,
                'dataSektor' => $sektor,
                'dataPilar' => $dataPilar,
                'dataProvinsi' => $prov,
                'keterangan' => "Pilar $pilar Periode ". tanggal_indo($tanggal1)." S.d ". tanggal_indo($tanggal2),
            ]);
    }

    public function dataSDGsJenis($tanggal1, $tanggal2, $pilar, $gols, $jenis)
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

        if($gols == 'Semua Gols'){
            $data = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('pilar', $pilar)->where('jenis', $jenis)->orderBy('tgl_terima', 'ASC')->get();
            $jumlahData = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('pilar', $pilar)->where('jenis', $jenis)->count();
        }else{
            $data = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('tpb', $gols)->where('pilar', $pilar)->where('jenis', $jenis)->orderBy('tgl_terima', 'ASC')->get();
            $jumlahData = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('tpb', $gols)->where('pilar', $pilar)->where('jenis', $jenis)->count();
        }

        $sektor = SektorBantuan::all();
        $dataPilar = Pilar::orderBy('id_pilar', 'ASC')->get();
        $prov = Provinsi::all();
        return view('report.data_kelayakan')
            ->with([
                'dataKelayakan' => $data,
                'jumlahData' => $jumlahData,
                'dataSektor' => $sektor,
                'dataPilar' => $dataPilar,
                'dataProvinsi' => $prov,
                'keterangan' => "Proposal $jenis Pilar $pilar Periode ". tanggal_indo($tanggal1)." S.d ". tanggal_indo($tanggal2),
            ]);
    }

    public function dataJenis($tanggal1, $tanggal2, $jenis)
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

        $data = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('jenis', $jenis)->orderBy('tgl_terima', 'ASC')->get();
        $jumlahData = Kelayakan::whereBetween('tgl_terima', [$tanggal1, $tanggal2])->where('jenis', $jenis)->count();
        $pengirim = Pengirim::orderBy('pengirim', 'ASC')->get();
        $sektor = SektorBantuan::all();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();
        $provinsi = Provinsi::all();
        return view('report.data_kelayakan')
            ->with([
                'dataKelayakan' => $data,
                'jumlahData' => $jumlahData,
                'dataSektor' => $sektor,
                'dataPilar' => $pilar,
                'dataProvinsi' => $provinsi,
                'dataPengirim' => $pengirim,
                'keterangan' => "Proposal $jenis Periode ". tanggal_indo($tanggal1)." S.d ". tanggal_indo($tanggal2),
            ]);
    }

    public function inputKelayakan()
    {
        $company = session('user')->perusahaan;

        $lembaga = Lembaga::orderBy('nama_lembaga', 'ASC')->get();
        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::table('TBL_WILAYAH')->select('city_name')->groupBy('city_name')->get();
        $pengirim = Pengirim::where('perusahaan', $company)->orderBy('pengirim', 'ASC')->get();
        $sektor = SektorBantuan::orderBy('kode_sektor', 'ASC')->get();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();
        $proker = Proker::orderBy('id_proker', 'ASC')->get();

        $user = User::where([
            ['username', '!=', session('user')->username],
            ['status', '=', 'Active'],
        ])->orderBy('nama', 'ASC')->get();
        return view('proposal.bulanan')
            ->with([
                'dataLembaga' => $lembaga,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataPengirim' => $pengirim,
                'dataSektor' => $sektor,
                'dataPilar' => $pilar,
                'dataProker' => $proker,
                'dataUser' => $user,
            ]);
    }

    public function proposalSantunan()
    {
        $company = session('user')->perusahaan;

        $lembaga = Lembaga::orderBy('nama_lembaga', 'ASC')->get();
        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::table('TBL_WILAYAH')->select('city_name')->groupBy('city_name')->get();
        $pengirim = Pengirim::where('perusahaan', $company)->orderBy('pengirim', 'ASC')->get();
        $sektor = SektorBantuan::orderBy('kode_sektor', 'ASC')->get();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();
        $proker = Proker::orderBy('id_proker', 'ASC')->get();

        $user = User::where([
            ['username', '!=', session('user')->username],
            ['status', '=', 'Active'],
        ])->orderBy('nama', 'ASC')->get();
        return view('proposal.santunan')
            ->with([
                'dataLembaga' => $lembaga,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataPengirim' => $pengirim,
                'dataSektor' => $sektor,
                'dataPilar' => $pilar,
                'dataProker' => $proker,
                'dataUser' => $user,
            ]);
    }

    public function proposalIdulAdha()
    {
        $company = session('user')->perusahaan;

        $lembaga = Lembaga::orderBy('nama_lembaga', 'ASC')->get();
        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::table('TBL_WILAYAH')->select('city_name')->groupBy('city_name')->get();
        $pengirim = Pengirim::where('perusahaan', $company)->orderBy('pengirim', 'ASC')->get();
        $sektor = SektorBantuan::orderBy('kode_sektor', 'ASC')->get();

        $release = APIHelper::instance()->apiCall('GET', env('BASEURL_POPAYV3') . '/api/APIPaymentRequest/form/bank/2312', '');
        $return = json_decode(strstr($release, '{'), true);
        $bank = $return['dataBank'];
        $city = $return['dataCity'];
        return view('proposal.idul_adha')
            ->with([
                'dataLembaga' => $lembaga,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataPengirim' => $pengirim,
                'dataSektor' => $sektor,
                'dataBank' => $bank,
                'dataCity' => $city,
            ]);
    }

    public function proposalNatal()
    {
        $company = session('user')->perusahaan;

        $lembaga = Lembaga::orderBy('nama_lembaga', 'ASC')->get();
        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::table('TBL_WILAYAH')->select('city_name')->groupBy('city_name')->get();
        $pengirim = Pengirim::where('perusahaan', $company)->orderBy('pengirim', 'ASC')->get();
        $sektor = SektorBantuan::orderBy('kode_sektor', 'ASC')->get();
        $pilar = Pilar::orderBy('id_pilar', 'ASC')->get();
        $proker = Proker::orderBy('id_proker', 'ASC')->get();

        $user = User::where([
            ['username', '!=', session('user')->username],
            ['status', '=', 'Active'],
        ])->orderBy('nama', 'ASC')->get();
        return view('proposal.natal')
            ->with([
                'dataLembaga' => $lembaga,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataPengirim' => $pengirim,
                'dataSektor' => $sektor,
                'dataPilar' => $pilar,
                'dataProker' => $proker,
                'dataUser' => $user,
            ]);
    }

    public function proposalAspirasi()
    {
        $company = session('user')->perusahaan;

        $lembaga = Lembaga::orderBy('nama_lembaga', 'ASC')->get();
        $anggota = Anggota::orderBy('nama_anggota', 'ASC')->get();
        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::table('TBL_WILAYAH')->select('city_name')->groupBy('city_name')->get();
        $pengirim = Pengirim::where('perusahaan', $company)->orderBy('pengirim', 'ASC')->get();

        $user = User::where([
            ['username', '!=', session('user')->username],
            ['status', '=', 'Active'],
        ])->orderBy('nama', 'ASC')->get();
        return view('proposal.aspirasi')
            ->with([
                'dataLembaga' => $lembaga,
                'dataAnggota' => $anggota,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataPengirim' => $pengirim,
                'dataUser' => $user,
            ]);
    }

    public function dataKabupaten($provinsi)
    {
        $data = DB::table('TBL_WILAYAH')
        ->select('city', 'city_name')
        ->where('province', $provinsi)
        ->groupBy('city', 'city_name')
        ->orderBy('city_name', 'ASC')
        ->get();

        $output = [];

        foreach ($data as $row) {
            $output[] = [
                'label' => $row->city . ' ' . $row->city_name, // Tampil di select
                'value' => $row->city_name                     // Dikirim saat submit
           ];
        }

        return response()->json($output);
    }

    public function dataKecamatan($provinsi, $kabupaten)
    {
        $data = DB::table('TBL_WILAYAH')
        ->select('sub_district')
        ->where('province', $provinsi)
        ->where('city_name', $kabupaten)
        ->groupBy('sub_district')
        ->orderBy('sub_district', 'ASC')
        ->get();

        $output = [];

        foreach ($data as $row) {
            $output[] = [
                'label' => $row->sub_district,
                'value' => $row->sub_district
           ];
        }

        return response()->json($output);
    }

    public function dataKelurahan($provinsi, $kabupaten, $kecamatan)
    {
        $data = DB::table('TBL_WILAYAH')
        ->select('village')
        ->where('province', $provinsi)
        ->where('city_name', $kabupaten)
        ->where('sub_district', $kecamatan)
        ->groupBy('village')
        ->orderBy('village', 'ASC')
        ->get();

        $output = [];

        foreach ($data as $row) {
            $output[] = [
                'label' => $row->village,
                'value' => $row->village
           ];
        }

        return response()->json($output);
    }

    public function dataProker($tahun)
    {
        $perusahaanID = session('user')->id_perusahaan;

        $data = Proker::where('id_perusahaan', $perusahaanID)->where('tahun', $tahun)->orderBy('id_proker', 'ASC')->get();

        $output = [];

        foreach ($data as $row) {
            $output[] = [
                'label' => $row->city . ' ' . $row->city_name, // Tampil di select
                'value' => $row->city_name                     // Dikirim saat submit
           ];
        }

        return response()->json($output);
    }

    public function dataKabupatenPencarian($loginID)
    {
        $data = DB::table('TBL_WILAYAH')->select('city_name')
            ->where('province', $loginID)
            ->groupBy('city_name')
            ->orderBy('city_name', 'ASC')
            ->get();

        echo $output = '<option value="Semua Kabupaten/Kota">Semua Kabupaten/Kota</option>';
        foreach ($data as $row) {
            echo $output = '<option value="' . $row->city_name . '">' . $row->city_name . '</option>';
        }
    }

    public function dataGols($pilar)
    {
        $data = SDG::where('pilar', $pilar)->get();

        echo $output = '<option value="Semua Gols">Semua Gols</option>';
        foreach ($data as $row) {
            echo $output = '<option value="' . $row->nama . '">' . $row->nama . '</option>';
        }
    }

    public function insertKelayakan(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date("Y-m-d");

        if ($request->jenis == 'Aspirasi') {
            $this->validate($request, [
                'pengirim' => 'required',
                'noAgenda' => 'required',
                'tglPenerimaan' => 'required',
                'sifat' => 'required',
                'dari' => 'required',
                'noSurat' => 'required',
                'tglSurat' => 'required',
                'perihal' => 'required',
                'deskripsiBantuan' => 'required',
                'alamat' => 'required',
                'provinsi' => 'required',
                'kabupaten' => 'required',
                'pengajuProposal' => 'required',
                'bertindakSebagai' => 'required',
                'noTelp' => 'required|numeric',
                'email' => 'required|email',
                'besarPermohonan' => 'required',
                'digunakanUntuk' => 'required',
                'lampiran' => 'required|nullable|max:100000',
                'rencanaAnggaran' => 'required',
                'dokumen' => 'required',
                'denah' => 'required',
                'perkiraanDana' => 'required',
                'syarat' => 'required',
                'catatan' => 'required',
                'evaluator1' => 'required',
                'evaluator2' => 'required',
                'namaAnggota' => 'required',
                'fraksi' => 'required',
                'jabatan' => 'required',
                'pic' => 'required',
                //'lastApproval' => 'required',
            ]);
        } else {
            $this->validate($request, [
                'pengirim' => 'required',
                'noAgenda' => 'required',
                'tglPenerimaan' => 'required',
                'sifat' => 'required',
                'dari' => 'required',
                'noSurat' => 'required',
                'tglSurat' => 'required',
                'perihal' => 'required',
                'deskripsiBantuan' => 'required',
                'alamat' => 'required',
                'provinsi' => 'required',
                'kabupaten' => 'required',
                'pengajuProposal' => 'required',
                'bertindakSebagai' => 'required',
                'noTelp' => 'required|numeric',
                'email' => 'required|email',
                'besarPermohonan' => 'required',
                'digunakanUntuk' => 'required',
                'lampiran' => 'required|nullable|max:100000',
                'rencanaAnggaran' => 'required',
                'dokumen' => 'required',
                'denah' => 'required',
                'perkiraanDana' => 'required',
                'syarat' => 'required',
                'catatan' => 'required',
                'evaluator1' => 'required',
                'evaluator2' => 'required',
                'smap' => 'required',
                //'lastApproval' => 'required',
            ]);
        }

        $dataKelayakan = [
            'no_agenda' => strtoupper($request->noAgenda),
            'pengirim' => ucwords($request->pengirim),
            'tgl_terima' => date('Y-m-d', strtotime($request->tglPenerimaan)),
            'sifat' => $request->sifat,
            'asal_surat' => $request->dari,
            'no_surat' => strtoupper($request->noSurat),
            'tgl_surat' => date("Y-m-d", strtotime($request->tglSurat)),
            'perihal' => ucwords($request->perihal),
            'alamat' => ucwords($request->alamat),
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'pengaju_proposal' => ucwords($request->pengajuProposal),
            'sebagai' => ucwords($request->bertindakSebagai),
            'contact_person' => $request->noTelp,
            'email_pengaju' => strtolower($request->email),
            'nilai_pengajuan' => str_replace(".", "", $request->besarPermohonan),
            'nilai_bantuan' => str_replace(".", "", $request->perkiraanDana),
            'bantuan_untuk' => ucwords($request->digunakanUntuk),
            'deskripsi' => ucwords($request->deskripsiBantuan),
            'nama_anggota' => ucwords($request->namaAnggota),
            'fraksi' => ucwords($request->fraksi),
            'jabatan' => ucwords($request->jabatan),
            'pic' => ucwords($request->pic),
            'komisi' => $request->komisi,
            'jenis' => $request->jenis,
            'status' => 'Evaluasi',
            'mata_uang_pengajuan' => 'IDR',
            'mata_uang_bantuan' => 'IDR',
            'create_by' => session('user')->username,
            'no_rekening' => $request->noRekening,
            'atas_nama' => $request->atasNama,
            'nama_bank' => $request->namaBank,
            'kode_bank' => $request->kodeBank,
            'kota_bank' => $request->kota,
            'kode_kota' => $request->kodeKota,
            'cabang_bank' => $request->cabang,
        ];

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

        DB::table('tbl_kelayakan')->insert($dataKelayakan);
        DB::table('tbl_evaluasi')->insert($dataEvaluasi);

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

        if ($request->hasFile('lampiran')) {
            $image = $request->file('lampiran');
            $name = $image->getClientOriginalName();
            $type = $image->getClientOriginalExtension();
            $featured_new_name = time() . $name ."." . $type;
            $image->move('attachment', $featured_new_name);

            $dataLampiran = [
                'NO_AGENDA' => $request->noAgenda,
                'NAMA' => 'Surat Pengantar dan Proposal',
                'LAMPIRAN' => $featured_new_name,
                'UPLOAD_BY' => session('user')->username,
                'UPLOAD_DATE' => $tanggal,
            ];

            $updateDataKelayakan = [
                'proposal' => $featured_new_name,
            ];

            Lampiran::create($dataLampiran);
            Kelayakan::where('no_agenda', $request->noAgenda)->update($updateDataKelayakan);
        }

        if ($request->hasFile('disposisi')) {
            $image = $request->file('disposisi');
            $name = str_replace(' ', '-', $image->getClientOriginalName());
            $type = $image->getClientOriginalExtension();
            $featured_new_name = time() . $name ."." . $type;
            $image->move('attachment', $featured_new_name);

            $dataLampiran = [
                'NO_AGENDA' => $request->noAgenda,
                'NAMA' => 'Disposisi',
                'LAMPIRAN' => $featured_new_name,
                'UPLOAD_BY' => session('user')->username,
                'UPLOAD_DATE' => $tanggal,
            ];
            Lampiran::create($dataLampiran);
        }

        if ($request->hasFile('memo')) {
            $image = $request->file('memo');
            $name = str_replace(' ', '-', $image->getClientOriginalName());
            $type = $image->getClientOriginalExtension();
            $featured_new_name = time() . $name ."." . $type;
            $image->move('attachment', $featured_new_name);

            $dataLampiran = [
                'NO_AGENDA' => $request->noAgenda,
                'NAMA' => 'Memo/Nota Dinas',
                'LAMPIRAN' => $featured_new_name,
                'UPLOAD_BY' => session('user')->username,
                'UPLOAD_DATE' => $tanggal,
            ];
            Lampiran::create($dataLampiran);
        }

        return redirect()->route('cari-kelayakan')->with('sukses', 'Data proposal bantuan berhasil disimpan');

//        try {
//
//        } catch (Exception $e) {
//            return redirect()->back()->with('gagal', 'Data proposal bantuan gagal disimpan');
//        }
    }

    public function storeEvaluasi(Request $request)
    {
        try {
            $kelayakanID = decrypt($request->kelayakanID);
        } catch (Exception $e) {
            abort(404);
        }

        $validated = $request->validate([
            'rencanaAnggaran'    => 'required|in:ADA,TIDAK ADA',
            'dokumen'            => 'required|in:ADA,TIDAK ADA',
            'denah'              => 'required|in:ADA,TIDAK ADA',
            'kepentingan'        => 'required|array|min:1',
            'kepentingan.*'      => 'string|max:100',
            'perkiraanDana'      => 'required|string',
            'perkiraanDanaAsli'  => 'required|numeric|min:1',
            'syarat'             => 'required|in:Survei,Tidak Memenuhi Syarat',
            'reviewer'           => 'required|string|max:200',
        ], [
            'rencanaAnggaran.required'    => 'Rencana anggaran wajib dipilih.',
            'dokumen.required'            => 'Dokumentasi wajib dipilih.',
            'denah.required'              => 'Denah lokasi wajib dipilih.',
            'kepentingan.required'        => 'Minimal satu kepentingan harus dipilih.',
            'perkiraanDana.required'      => 'Perkiraan bantuan harus diisi.',
            'perkiraanDanaAsli.required'  => 'Perkiraan bantuan (angka) wajib diisi.',
            'perkiraanDanaAsli.numeric'   => 'Perkiraan bantuan harus berupa angka.',
            'syarat.required'             => 'Status kelayakan wajib dipilih.',
            'reviewer.required'         => 'Reviewer wajib dipilih.',
            'reviewer.max'              => 'Nama reviewer terlalu panjang.',
        ]);

        $kelayakan = Kelayakan::findOrFail($kelayakanID);

        if (!$kelayakan) {
            return redirect()->back()->with('gagalDetail', 'Data kelayakan tidak ditemukan.');
        }

        $maker = ViewHirarki::where('id_user', session('user')->id_user)->where('level', 1)->where('status', 'Active')->first();
        
        if(empty($maker)){
            return redirect()->back()->with('gagal', "Anda tidak terdaftar sebagai Maker kelayakan proposal")->withInput();
        }

        $approver = ViewHirarki::where('level', 3)->where('status', 'Active')->first();
        $lastApprover = ViewHirarki::where('level', 4)->where('status', 'Active')->first();
        $sekper = ViewHirarki::where('level', 5)->first();
        $dirut = ViewHirarki::where('level', 6)->first();

        $dataEvaluasi = [
            'no_agenda' => $kelayakan->no_agenda,
            'id_kelayakan' => $kelayakan->id_kelayakan,
            'rencana_anggaran' => $request->rencanaAnggaran,
            'dokumen' => $request->dokumen,
            'denah' => $request->denah,
            'syarat' => $request->syarat,
            'evaluator1' => session('user')->username,
            'evaluator2' => $request->reviewer,
            'kadep' => $approver->username,
            'kadiv' => $lastApprover->username,
            'sekper' => $sekper->username,
            'dirut' => $dirut->username,
            'status' => 'Approved 1',
            'create_by' => session('user')->username,
            'created_by' => session('user')->id_user,
        ];

        $dataKelayakan = [
            'nilai_bantuan' => $request->perkiraanDanaAsli,
            'status' => 'Evaluasi',
        ];

        $dataLog = [
            'id_kelayakan' => $kelayakanID,
            'keterangan' => 'Input evaluasi proposal',
            'created_by' => session('user')->id_user,
            'created_date' => now(),
        ];

        $dataApproval = [
            'id_kelayakan' => $kelayakanID,
            'id_hirarki' => $maker->id,
            'id_user' => $maker->id_user,
            'status' => 'In Progress',
            'phase' => 'Evaluasi',
            'status_date' => now(),
            'task_date' => now(),
            'action_date' => NULL,
            'created_by' => session('user')->id_user,
        ];

        // Simpan kepentingan (kriteria)
        if (!empty($request->kepentingan)) {
            foreach ($request->kepentingan as $kriteria) {
                DB::table('tbl_detail_kriteria')->insert([
                    'no_agenda'    => $kelayakan->no_agenda,
                    'id_kelayakan' => $kelayakan->id_kelayakan,
                    'kriteria'     => $kriteria,
                ]);
            }
        }
            
        try {
            DB::table('tbl_evaluasi')->insert($dataEvaluasi);
            DB::table('tbl_kelayakan')->where('id_kelayakan', $kelayakanID)->update($dataKelayakan);
            DB::table('tbl_log')->insert($dataLog);
            DB::table('tbl_detail_approval')->insert($dataApproval);
            return redirect()->back()->with('suksesDetail', "Evaluasi proposal berhasil disimpan");            
        } catch (Exception $e) {
            return redirect()->back()->with('gagalDetail', "Gagal menyimpan evaluasi proposal");
        }
    }

    public function updateEvaluasi(Request $request)
    {
        try {
            $evaluasiID = decrypt($request->evaluasiID);
        } catch (Exception $e) {
            abort(404);
        }

        $validated = $request->validate([
            'rencana_anggaran'    => 'required|in:ADA,TIDAK ADA',
            'dokumen'             => 'required|in:ADA,TIDAK ADA',
            'denah'               => 'required|in:ADA,TIDAK ADA',
            'kepentingan'         => 'required|array|min:1',
            'kepentingan.*'       => 'string|max:100',
            'perkiraanDana'       => 'required|string',
            'perkiraanDanaAsli'   => 'required|numeric|min:1',
            'syarat'              => 'required|in:Survei,Tidak Memenuhi Syarat',
            'reviewer'            => 'required|string|max:200',
        ]);

        $evaluasi = Evaluasi::findOrFail($evaluasiID);

        $kelayakanID = $evaluasi->id_kelayakan;
        $kelayakan = Kelayakan::findOrFail($kelayakanID);

        $dataEvaluasi = [
            'rencana_anggaran' => $request->rencana_anggaran,
            'dokumen' => $request->dokumen,
            'denah' => $request->denah,
            'syarat' => $request->syarat,
            'evaluator2' => $request->reviewer,
        ];

        $dataKelayakan = [
            'nilai_bantuan' => $request->perkiraanDanaAsli,
        ];

        $dataLog = [
            'id_kelayakan' => $kelayakanID,
            'keterangan' => 'Edit evaluasi proposal',
            'created_by' => session('user')->id_user,
            'created_date' => now(),
        ];

        DB::beginTransaction();
        try {
            DB::table('tbl_evaluasi')->where('id_evaluasi', $evaluasiID)->update($dataEvaluasi);
            DB::table('tbl_kelayakan')->where('id_kelayakan', $kelayakanID)->update($dataKelayakan);

            // Bersihkan kepentingan lama dan masukkan yang baru
            DB::table('tbl_detail_kriteria')->where('id_kelayakan', $kelayakanID)->delete();

            foreach ($request->kepentingan as $kriteria) {
                DB::table('tbl_detail_kriteria')->insert([
                    'no_agenda'    => $kelayakan->no_agenda,
                    'id_kelayakan' => $kelayakan->id_kelayakan,
                    'kriteria'     => $kriteria,
                ]);
            }

            DB::table('tbl_log')->insert($dataLog);

            DB::commit();
            return redirect()->back()->with('suksesDetail', "Evaluasi proposal berhasil diperbarui");
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('gagalDetail', "Gagal memperbarui evaluasi proposal");
        }
    }

    public function insertSantunan(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date("Y-m-d");

        $this->validate($request, [
            'pengirim' => 'required',
            'noAgenda' => 'required',
            'tglPenerimaan' => 'required',
            'sifat' => 'required',
            'dari' => 'required',
            'noSurat' => 'required',
            'tglSurat' => 'required',
            'perihal' => 'required',
            'deskripsiBantuan' => 'required',
            'alamat' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'pengajuProposal' => 'required',
            'bertindakSebagai' => 'required',
            'noTelp' => 'required|numeric',
            'email' => 'required|email',
            'besarPermohonan' => 'required',
            'digunakanUntuk' => 'required',
            'lampiran' => 'required|nullable|max:100000',
            'rencanaAnggaran' => 'required',
            'dokumen' => 'required',
            'denah' => 'required',
            'perkiraanDana' => 'required',
            'syarat' => 'required',
            'catatan' => 'required',
            'evaluator1' => 'required',
            'evaluator2' => 'required',
            //'lastApproval' => 'required',
        ]);

        $dataKelayakan = [
            'no_agenda' => strtoupper($request->noAgenda),
            'pengirim' => ucwords($request->pengirim),
            'tgl_terima' => date('Y-m-d', strtotime($request->tglPenerimaan)),
            'sifat' => $request->sifat,
            'asal_surat' => $request->dari,
            'no_surat' => strtoupper($request->noSurat),
            'tgl_surat' => date("Y-m-d", strtotime($request->tglSurat)),
            'perihal' => ucwords($request->perihal),
            'alamat' => ucwords($request->alamat),
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'pengaju_proposal' => ucwords($request->pengajuProposal),
            'sebagai' => ucwords($request->bertindakSebagai),
            'contact_person' => $request->noTelp,
            'email_pengaju' => strtolower($request->email),
            'nilai_pengajuan' => str_replace(".", "", $request->besarPermohonan),
            'nilai_bantuan' => str_replace(".", "", $request->perkiraanDana),
            'bantuan_untuk' => ucwords($request->digunakanUntuk),
            'deskripsi' => ucwords($request->deskripsiBantuan),
            'nama_anggota' => ucwords($request->namaAnggota),
            'fraksi' => ucwords($request->fraksi),
            'jabatan' => ucwords($request->jabatan),
            'pic' => ucwords($request->pic),
            'komisi' => $request->komisi,
            'jenis' => $request->jenis,
            'status' => 'Evaluasi',
            'mata_uang_pengajuan' => 'IDR',
            'mata_uang_bantuan' => 'IDR',
            'create_by' => session('user')->username,
            'create_date' => $tanggal,
            'no_rekening' => $request->noRekening,
            'atas_nama' => $request->atasNama,
            'nama_bank' => $request->namaBank,
            'kode_bank' => $request->kodeBank,
            'kota_bank' => $request->kota,
            'kode_kota' => $request->kodeKota,
            'cabang_bank' => $request->cabang,
            'smap' => $request->smap,
        ];


        $kadiv = User::where('role', 'Manager')->where('status', 'Active')->first();
        $kadep = User::where('role', 'Supervisor 1')->where('status', 'Active')->first();

        if (in_array($request->jenis, ['Santunan', 'Natal'])){
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
                'status' => 'Survei',
                'ket_kadin1' => 'Untuk ditindaklanjuti sesuai peraturan yang berlaku',
                'approve_kadep' => $tanggal,
                'ket_kadiv' => 'Untuk dapat diproses sesuai prosedur',
                'approve_kadiv' => $tanggal,
                'create_by' => session('user')->username,
                'create_date' => $tanggal,
                'approve_date' => $tanggal,
            ];
        }else{
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
                'create_date' => $tanggal,
                'approve_date' => $tanggal,
            ];
        }

        $evaluator1 = User::where('username', session('user')->username)->first();
        $evaluator2 = User::where('username', $request->evaluator2)->first();

        $dataEmail = [
            'no_agenda' => strtoupper($request->noAgenda),
            'pengirim' => ucwords($request->pengirim),
            'tgl_terima' => date('Y-m-d', strtotime($request->tglPenerimaan)),
            'dari' => $request->dari,
            'no_surat' => strtoupper($request->noSurat),
            'tgl_surat' => date("Y-m-d", strtotime($request->tglSurat)),
            'perihal' => ucwords($request->perihal),
            'permohonan' => str_replace(".", "", $request->besarRupiah),
            'bantuan' => str_replace(".", "", $request->perkiraanDana),
            'evaluator1' => $evaluator1->nama,
            'evaluator2' => $evaluator2->nama,
            'penerima' => $evaluator2->nama,
        ];

        try {
//            Mail::send('mail.approval_evaluator', $dataEmail, function ($message) use ($evaluator2) {
//                $message->to($evaluator2->email, $evaluator2->nama)
//                    ->subject('Review Evaluasi Proposal')
//                    ->from('pgn.no.reply@pertamina.com', 'NR SHARE');
//            });

            DB::table('tbl_kelayakan')->insert($dataKelayakan);
            DB::table('tbl_evaluasi')->insert($dataEvaluasi);

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

            if ($request->hasFile('lampiran')) {
                $image = $request->file('lampiran');
                $name = $image->getClientOriginalName();
                $type = $image->getClientOriginalExtension();
                $featured_new_name = time() . $name ."." . $type;
                $image->move('attachment', $featured_new_name);

                $dataLampiran = [
                    'NO_AGENDA' => $request->noAgenda,
                    'NAMA' => 'Surat Pengantar dan Proposal',
                    'LAMPIRAN' => $featured_new_name,
                    'UPLOAD_BY' => session('user')->username,
                    'UPLOAD_DATE' => $tanggal,
                ];

                $updateDataKelayakan = [
                    'proposal' => $featured_new_name,
                ];

                Lampiran::create($dataLampiran);
                Kelayakan::where('no_agenda', $request->noAgenda)->update($updateDataKelayakan);
            }

            if ($request->hasFile('disposisi')) {
                $image = $request->file('disposisi');
                $name = str_replace(' ', '-', $image->getClientOriginalName());
                $type = $image->getClientOriginalExtension();
                $featured_new_name = time() . $name ."." . $type;
                $image->move('attachment', $featured_new_name);

                $dataLampiran = [
                    'NO_AGENDA' => $request->noAgenda,
                    'NAMA' => 'Disposisi',
                    'LAMPIRAN' => $featured_new_name,
                    'UPLOAD_BY' => session('user')->username,
                    'UPLOAD_DATE' => $tanggal,
                ];
                Lampiran::create($dataLampiran);
            }

            if ($request->hasFile('memo')) {
                $image = $request->file('memo');
                $name = str_replace(' ', '-', $image->getClientOriginalName());
                $type = $image->getClientOriginalExtension();
                $featured_new_name = time() . $name ."." . $type;
                $image->move('attachment', $featured_new_name);

                $dataLampiran = [
                    'NO_AGENDA' => $request->noAgenda,
                    'NAMA' => 'Memo/Nota Dinas',
                    'LAMPIRAN' => $featured_new_name,
                    'UPLOAD_BY' => session('user')->username,
                    'UPLOAD_DATE' => $tanggal,
                ];
                Lampiran::create($dataLampiran);
            }
            return redirect()->route('cari-kelayakan')->with('sukses', 'Data proposal bantuan berhasil disimpan');

        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Data proposal bantuan gagal disimpan');
        }
    }

    public function detailKelayakan($loginID)
    {

        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }

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

        $kelayakan = Kelayakan::where('no_agenda', $logID)->first();
        $tahun = date('Y', strtotime($kelayakan->create_date));
        $company = session('user')->perusahaan;

        $id = $kelayakan->id_kelayakan;
        $noAgenda = $kelayakan->no_agenda;
        $noRekening = $kelayakan->no_rekening;
        $atasNama = $kelayakan->atas_nama;
        $namaBank = $kelayakan->nama_bank;
        $kodeBank = $kelayakan->kode_bank;
        $namaKota = $kelayakan->kota_bank;
        $kodeKota = $kelayakan->kode_kota;
        $cabang = $kelayakan->cabang_bank;
        $jenis = $kelayakan->jenis;
        $nilaiBantuan = $kelayakan->nilai_bantuan;

        $maker = User::where('username', $kelayakan->create_by)->first();

        //List Pembayaran
        $pembayaran = ViewPembayaran::where('no_agenda', $logID)->get();
        $jumlahPembayaran = ViewPembayaran::where('no_agenda', $logID)->count();

        $evaluasi = Evaluasi::where('no_agenda', $logID)->first();
        $jumlahEvaluasi = Evaluasi::where('no_agenda', $logID)->count();

        $survei = Survei::where('no_agenda', $logID)->first();

        $jumlahSurvei = Survei::where('no_agenda', $logID)->count();

        $jumlahSurveiApproved = DB::table('tbl_survei')
            ->select(DB::raw('count(*) as jumlah'))
            ->where([
                ['no_agenda', $logID],
                ['status', '=', 'Approved 3']
            ])
            ->first();
        $kriteria = DetailKriteria::where('no_agenda', $logID)->get();
        $lampiran = Lampiran::where('no_agenda', $logID)->orderBy('nama', 'ASC')->get();
        $jumlahLampiran = DB::table('tbl_lampiran')
            ->select(DB::raw('count(*) as jumlah'))
            ->where('no_agenda', $logID)
            ->first();
        $user = User::where([
            ['username', '!=', session('user')->username],
            ['status', '=', 'Active'],
        ])->orderBy('nama', 'ASC')->get();

        $jumlahTermin = Pembayaran::where('no_agenda', $logID)->count();
        $proker = Proker::where('tahun', $tahun)->where('perusahaan', $company)->orderBy('id_proker', 'ASC')->orderBy('tahun', 'ASC')->get();

        return view('transaksi.detail_kelayakan')
            ->with([
                'ID' => $id,
                'noAgenda' => $noAgenda,
                'noRekening' => $noRekening,
                'atasNama' => $atasNama,
                'namaBank' => $namaBank,
                'kodeBank' => $kodeBank,
                'namaKota' => $namaKota,
                'kodeKota' => $kodeKota,
                'cabang' => $cabang,
                'jenis' => $jenis,
                'data' => $kelayakan,
                'maker' => $maker,
                'dataEvaluasi' => $evaluasi,
                'dataSurvei' => $survei,
                'dataKriteria' => $kriteria,
                'dataLampiran' => $lampiran,
                'jumlahLampiran' => $jumlahLampiran,
                'jumlahEvaluasi' => $jumlahEvaluasi,
                'jumlahSurvei' => $jumlahSurvei,
                'jumlahSurveiApproved' => $jumlahSurveiApproved,
                'dataPembayaran' => $pembayaran,
                'jumlahPembayaran' => $jumlahPembayaran,
                'nilaiBantuan' => $nilaiBantuan,
                'dataUser' => $user,
                'jumlahTermin' => $jumlahTermin,
                'dataProker' => $proker,
            ]);
    }

    public function ubahProposal($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }

        $dataKelayakan = Kelayakan::where('id_kelayakan', $logID)->first();

        $lembaga = Lembaga::orderBy('nama_lembaga', 'ASC')->get();
        $provinsi = Provinsi::orderBy('provinsi', 'ASC')->get();
        $kabupaten = DB::table('TBL_WILAYAH')->select('city_name')->groupBy('city_name')->get();
        $pengirim = Pengirim::orderBy('pengirim', 'ASC')->get();
        $sektor = SektorBantuan::orderBy('kode_sektor', 'ASC')->get();

        return view('proposal.ubah_bulanan')
            ->with([
                'data' => $dataKelayakan,
                'dataLembaga' => $lembaga,
                'dataProvinsi' => $provinsi,
                'dataKabupaten' => $kabupaten,
                'dataPengirim' => $pengirim,
                'dataSektor' => $sektor,
            ]);
    }

    public function ubahProposalSantunan($noAgenda)
    {
        try {
            $logID = decrypt($noAgenda);
        } catch (Exception $e) {
            abort(404);
        }

        $dataKelayakan = Kelayakan::where('no_agenda', $logID)->first();

        $pengirim = Pengirim::orderBy('pengirim', 'ASC')->get();
        $sektor = SektorBantuan::all();
        $provinsi = Provinsi::all();
        $anggota = Anggota::orderBy('nama_anggota', 'ASC')->get();
        return view('proposal.ubah_bulanan')
            ->with([
                'data' => $dataKelayakan,
                'dataSektor' => $sektor,
                'dataProvinsi' => $provinsi,
                'dataPengirim' => $pengirim,
                'dataAnggota' => $anggota
            ]);
    }

    public function delete($id)
    {
        try {
            $kelayakanID = decrypt($id);
        } catch (Exception $e) {
            abort(404);
        }
        
        $kelayakan = Kelayakan::find($kelayakanID);

        if (!$kelayakan) {
            return redirect()->back()->with('gagalDetail', 'Kelayakan proposal tidak ditemukan.');
        }

        // Cek relasi satu per satu
        $relatedData = [];

        if ($kelayakan->lampiran()->exists()) {
            $relatedData[] = 'Dokumen Pendukung';
        }

        if (!empty($relatedData)) {
            $message = 'Tidak dapat menghapus karena masih memiliki data relasi pada ' . implode(', ', $relatedData) . '.';
            return redirect()->back()->with('gagalHapus', $message);
        }

        try {
            $kelayakan->delete();
            Log::where('id_kelayakan', $kelayakanID)->delete();
            return redirect()->back()->with('sukses', 'Kelayakan proposal berhasil dihapus');
        } catch (Exception $e) {
            return redirect()->back()->with('gagalHapus', 'Kelayakan proposal gagal dihapus');
        }
    }

    public function deleteKelayakan($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }
        Kelayakan::where('no_agenda', $logID)->delete();
        Evaluasi::where('no_agenda', $logID)->delete();
        Survei::where('no_agenda', $logID)->delete();
        Lampiran::where('no_agenda', $logID)->delete();
        BASTDana::where('no_agenda', $logID)->delete();
        return redirect()->back()->with('sukses', 'Proposal berhasil dihapus');
    }

    public function updateStatusYKPP(Request $request)
    {
        try {
            $logID = decrypt($request->kelayakanID);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'status' => 'required',
        ]);

        $data = [
            'status_ykpp' => $request->status,
        ];

        try {
            Kelayakan::where('id_kelayakan', $logID)->update($data);
            return redirect()->back()->with('berhasil', 'Status Pembayaran YKPP berhasil diupdate');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Status Pembayaran YKPP gagal diupdate');
        }
    }

    public function checklistYKPP(Request $request)
    {
        try {
            $kelayakanID = decrypt($request->kelayakanID);
        } catch (Exception $e) {
            abort(404);
        }

        $request->validate([
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ], [
            'tahun.required' => 'Tahun anggaran wajib dipilih.',
            'tahun.integer'  => 'Tahun anggaran harus berupa angka.',
        ]);

        $kelayakan = Kelayakan::findOrFail($kelayakanID);
        $survei = Survei::where('id_kelayakan', $kelayakanID)->first();

        if (empty($survei)) {
            return redirect()->back()->with('gagal', "Data survei untuk proposal ini belum tersedia.")->withInput();
        }

        $fee = 5; // fee 5%
        $nominalDisetujui = $survei->nilai_approved ?? 0;
        $nominalFee = round(($nominalDisetujui * $fee) / 100, 2);
        $totalYKPP = $nominalDisetujui + $nominalFee;

        $dataYKPP = [
            'ykpp'            => "Yes",
            'checklist_by'    => session('user')->username,
            'checklist_date'  => now(),
            'nominal_approved'=> $nominalDisetujui,
            'nominal_fee'     => $nominalFee,
            'total_ykpp'      => $totalYKPP,
            'status_ykpp'     => "Open",
            'tahun_ykpp'      => $request->tahun,
        ];

        $dataLog = [
            'id_kelayakan' => $kelayakanID,
            'keterangan' => 'Checklist YKPP',
            'created_by' => session('user')->id_user,
            'created_date' => now(),
        ];

        if ($kelayakan->ykpp === 'Yes') {
            return back()->with('gagal', 'Proposal ini sudah ditandai untuk YKPP sebelumnya.');
        }

        try {
            Kelayakan::where('id_kelayakan', $kelayakanID)->update($dataYKPP);
            DB::table('tbl_log')->insert($dataLog);
            return redirect()->back()->with('sukses', "Penyaluran TJSL berhasil ditambahkan ke daftar YKPP Tahun Anggaran $request->tahun");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Penyaluran TJSL gagal ditambahkan ke daftar YKPP');
        }
    }

    public function unchecklistYKPP($id)
    {
        try {
            $pembayaranID = decrypt($id);
            $pembayaran = Pembayaran::findOrFail($pembayaranID);

            $dataKelayakan = [
                'approved_ykpp_by'   => null,
                'approved_ykpp_date' => null,
                'submited_ykpp_by'   => null,
                'submited_ykpp_date' => null,
                'no_surat_ykpp'      => null,
                'tgl_surat_ykpp'     => null,
                'surat_ykpp'         => null,
                'tahun_ykpp'         => null,
                'penyaluran_ke'      => null,
            ];

            DB::table('tbl_pembayaran')->where('id_pembayaran', $pembayaranID)->update($dataKelayakan);
            return back()->with('suksesDetail', 'Penyaluran TJSL berhasil dihapus dari daftar YKPP');
        } catch (Exception $e) {
            return back()->with('gagal', 'Penyaluran TJSL gagal dihapus dari daftar YKPP');
        }
    }

    public function unsubmittedYKPP($id)
    {
        try {
            $pembayaranID = decrypt($id);
            $pembayaran = Pembayaran::findOrFail($pembayaranID);

            $dataKelayakan = [
                'submited_ykpp_by'   => null,
                'submited_ykpp_date' => null,
                'no_surat_ykpp'      => null,
                'tgl_surat_ykpp'     => null,
                'surat_ykpp'         => null,
                'penyaluran_ke'      => null,
                'status_ykpp'      => 'Verified',
            ];

            DB::table('tbl_pembayaran')->where('id_pembayaran', $pembayaranID)->update($dataKelayakan);
            return back()->with('suksesDetail', 'Penyaluran TJSL berhasil di-unsubmit');
        } catch (Exception $e) {
            return back()->with('gagal', 'Penyaluran TJSL gagal di-unsubmit');
        }
    }

    public function approveYKPP($id)
    {
        try {
            $pembayaranID = decrypt($id);
        } catch (Exception $e) {
            abort(404);
        }

        $data = [
            'status_ykpp' => "Verified",
            'approved_ykpp_by' => session('user')->username,
            'approved_ykpp_date' => now(),
        ];

        try {
            Pembayaran::where('id_pembayaran', $pembayaranID)->update($data);
            return redirect()->route('listPaymentYKPP')->with('suksesDetail', 'Verifikasi penyaluran TJSL ke YKPP berhasil');
        } catch (Exception $e) {
            return redirect()->back()->with('gagalDetail', 'Verifikasi enyaluran TJSL ke YKPP gagal');
        }
    }

    public function submitYKPP(Request $request)
    {
        $request->validate([
            'id_pembayaran' => 'required|array',
            'penyaluran' => 'required',
            'tahun' => 'required|digits:4',
        ]);

        $tanggalNow = now()->toDateString();
        $user = session('user')->username;

        try {
            DB::beginTransaction();

            Pembayaran::whereIn('id_pembayaran', $request->id_pembayaran)->update([
                'status_ykpp' => 'Submited',
                'submited_ykpp_by' => $user,
                'submited_ykpp_date' => $tanggalNow,
                'penyaluran_ke' => $request->penyaluran,
                'tahun_ykpp' => $request->tahun,
            ]);

            DB::commit();
            return redirect()->back()->with('suksesDetail', 'Penyaluran TJSL ke YKPP berhasil disubmit');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('gagalDetail', 'Penyaluran TJSL ke YKPP gagal disubmit');
        }
    }

    public function uploadSuratYKPP(Request $request)
    {
        try {
            $penyaluranKe = decrypt($request->penyaluran);
            $tahun = decrypt($request->tahun);
        } catch (\Throwable $e) {
            abort(404);
        }

        $request->validate([
            'tanggal' => 'required|date',
            'noSurat' => 'required|string|max:255',
            'lampiran' => 'required|file|mimes:pdf|max:10000',
        ], [
            'tanggal.required' => 'Tanggal surat wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'noSurat.required' => 'Nomor surat wajib diisi.',
            'noSurat.string' => 'Nomor surat harus berupa teks.',
            'noSurat.max' => 'Nomor surat maksimal 255 karakter.',
            'lampiran.required' => 'Lampiran surat wajib diunggah.',
            'lampiran.file' => 'Lampiran harus berupa file.',
            'lampiran.mimes' => 'Lampiran harus berupa file PDF.',
            'lampiran.max' => 'Ukuran lampiran maksimal 10MB.',
        ]);

        try {
            $file = $request->file('lampiran');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.pdf';
            $file->move(public_path('attachment'), $filename);

            $dataPembayaran = [
                'no_surat_ykpp'  => strtoupper($request->noSurat),
                'tgl_surat_ykpp' => $request->tanggal,
                'surat_ykpp'     => $filename,
            ];

            DB::table('tbl_pembayaran')->where('penyaluran_ke', $penyaluranKe)->where('tahun_ykpp', $tahun)
            ->update($dataPembayaran);
            return back()->with('berhasil', 'Surat perintah penyaluran TJSL berhasil diupload');
        } catch (\Throwable $e) {
            return back()->with('gagal', 'Surat perintah penyaluran TJSL gagal diupload');
        }
    }

    public function updateSuratYKPP(Request $request)
    {
        try {
            $penyaluranKe = decrypt($request->penyaluran);
            $tahun = decrypt($request->tahun);
        } catch (\Throwable $e) {
            abort(404);
        }

        $request->validate([
            'tanggal' => 'required|date',
            'noSurat' => 'required|string|max:255',
            'lampiran' => 'nullable|file|mimes:pdf|max:2048',
        ], [
            'tanggal.required' => 'Tanggal surat wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'noSurat.required' => 'Nomor surat wajib diisi.',
            'noSurat.string' => 'Nomor surat harus berupa teks.',
            'noSurat.max' => 'Nomor surat maksimal 255 karakter.',
            'lampiran.file' => 'Lampiran harus berupa file.',
            'lampiran.mimes' => 'Lampiran harus berupa file PDF.',
            'lampiran.max' => 'Ukuran lampiran maksimal 2MB.',
        ]);

        try {
            $updateData = [
                'tgl_surat_ykpp' => $request->tanggal,
                'no_surat_ykpp'  => strtoupper($request->noSurat),
            ];

            if ($request->hasFile('lampiran')) {
                $file = $request->file('lampiran');
                $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.pdf';
                $file->move(public_path('attachment'), $filename);
                $updateData['surat_ykpp'] = $filename;
            }

            Pembayaran::where('penyaluran_ke', $penyaluranKe)
                ->where('tahun_ykpp', $tahun)
                ->update($updateData);

            return back()->with('berhasil', 'Surat perintah penyaluran TJSL berhasil diperbarui');
        } catch (\Throwable $e) {
            return back()->with('gagal', 'Gagal memperbarui surat perintah penyaluran TJSL');
        }
    }

    public function ubahBank($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }

        $kelayakan = Kelayakan::where('no_agenda', $logID)->first();
        $release = APIHelper::instance()->apiCall('GET', env('BASEURL_POPAYV3') . '/api/APIPaymentRequest/form/bank/2312', '');
        $return = json_decode(strstr($release, '{'), true);
        $bank = $return['dataBank'];
        $city = $return['dataCity'];

        return view('transaksi.edit_bank')
            ->with([
                'data' => $kelayakan,
                'dataBank' => $bank,
                'dataCity' => $city,
            ]);
    }

    public function editBank(Request $request)
    {

        try {
            $logID = decrypt($request->nomor);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'noRekening' => 'required',
            'atasNama' => 'required',
            'namaBank' => 'required',
            //'kodeBank' => 'required',
            'kota' => 'required',
            //'kodeKota' => 'required',
            'cabang' => 'required',
        ]);

        $dataUpdateRekening = [
            'no_rekening' => $request->noRekening,
            'atas_nama' => $request->atasNama,
            'nama_bank' => $request->namaBank,
            'kode_bank' => $request->kodeBank,
            'kota_bank' => $request->kota,
            'kode_kota' => $request->kodeKota,
            'cabang_bank' => $request->cabang,
        ];

        try {
            Kelayakan::where('no_agenda', $logID)->update($dataUpdateRekening);
            return redirect()->route('detail-kelayakan', encrypt($logID))->with('sukses', 'Info bank berhasil diubah');
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Info bank gagal diubah');
        }
    }

    public function dataTPB($pilar)
    {
        $data = DB::table('TBL_SDG')
            ->where('pilar', $pilar)
            ->orderBy('id_sdg', 'ASC')
            ->get();

        $output = [];

        foreach ($data as $row) {
            $output[] = [
                'label' => $row->kode . '. ' . $row->nama, 
                'value' => $row->nama,
            ];
        }

        return response()->json($output);
    }

    public function dataIndikator($tpb)
    {
        $data = DB::table('TBL_SUB_PILAR')->select('kode_indikator', 'keterangan')
            ->where('tpb', $tpb)
//            ->groupBy('kode_indikator')
            ->orderBy('kode_indikator', 'ASC')
            ->get();

        echo $output = '<option></option>';
        foreach ($data as $row) {
            echo $output = '<option kodeIndikator="' . $row->kode_indikator . '">' . $row->keterangan . '</option>';
        }
    }

}

