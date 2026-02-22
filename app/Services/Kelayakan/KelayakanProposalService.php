<?php

namespace App\Services\Kelayakan;

use App\Http\Requests\StoreKelayakanRequest;
use App\Http\Requests\UpdateKelayakanBankRequest;
use App\Http\Requests\UpdateKelayakanPenerimaRequest;
use App\Http\Requests\UpdateKelayakanProkerRequest;
use App\Http\Requests\UpdateKelayakanProposalRequest;
use App\Http\Requests\UpdateKelayakanRequest;
use App\Models\Hirarki;
use App\Models\Kelayakan;
use App\Models\Lampiran;
use App\Models\Lembaga;
use App\Models\Proker;
use Exception;
use Illuminate\Support\Facades\DB;

class KelayakanProposalService
{
    public function store(StoreKelayakanRequest $request)
    {
        $hirarki = Hirarki::where('id_user', session('user')->id_user)
            ->where('id_level', 1)
            ->first();

        if (empty($hirarki)) {
            return redirect()->back()->with('gagal', 'Anda tidak terdaftar sebagai Maker kelayakan proposal')->withInput();
        }

        DB::beginTransaction();

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
                'tgl_surat' => date('Y-m-d', strtotime($request->tglSurat)),
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
            report($e);

            return redirect()->back()->withInput()->with('gagal', 'Gagal menyimpan data kelayakan');
        }
    }

    public function update(int $kelayakanID, UpdateKelayakanRequest $request)
    {
        DB::beginTransaction();

        try {
            $lembaga = Lembaga::findOrFail($request->dari);

            $dataKelayakan = [
                'no_agenda' => strtoupper($request->noAgenda),
                'id_pengirim' => $request->pengirim,
                'tgl_terima' => date('Y-m-d', strtotime($request->tglPenerimaan)),
                'sifat' => $request->sifat,
                'asal_surat' => $lembaga->nama_lembaga,
                'no_surat' => strtoupper($request->noSurat),
                'tgl_surat' => date('Y-m-d', strtotime($request->tglSurat)),
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

            return redirect()->back()->with('suksesDetail', 'Kelayakan proposal berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            report($e);

            return redirect()->back()->withInput()->with('gagalDetail', 'Gagal memperbarui data kelayakan proposal');
        }
    }

    public function updateProposal(int $kelayakanID, UpdateKelayakanProposalRequest $request)
    {
        DB::beginTransaction();

        try {
            $dataKelayakan = [
                'no_agenda' => strtoupper($request->noAgenda),
                'id_pengirim' => $request->pengirim,
                'tgl_terima' => date('Y-m-d', strtotime($request->tglPenerimaan)),
                'sifat' => $request->sifat,
                'no_surat' => strtoupper($request->noSurat),
                'tgl_surat' => date('Y-m-d', strtotime($request->tglSurat)),
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

    public function updatePenerima(int $kelayakanID, UpdateKelayakanPenerimaRequest $request)
    {
        DB::beginTransaction();

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

    public function updateBank(int $kelayakanID, UpdateKelayakanBankRequest $request)
    {
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

    public function updateProker(int $kelayakanID, UpdateKelayakanProkerRequest $request)
    {
        $proker = Proker::findOrFail($request->prokerID);

        if (! $proker) {
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
}
