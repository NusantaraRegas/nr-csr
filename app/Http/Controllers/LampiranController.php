<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\EditLampiran;
use App\Models\Kelayakan;
use App\Models\Lampiran;
use Illuminate\Http\Request;
use App\Http\Requests\InsertLampiran;
use DB;
use Mail;
use Exception;

class LampiranController extends Controller
{
    public function index($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }
        $jumlahData = DB::table('tbl_lampiran')
            ->select(DB::raw('count(*) as jumlah'))
            ->where('no_agenda', $logID)
            ->first();
        $data = Lampiran::where('no_agenda', $logID)->get();
        return view('report.data_lampiran')
            ->with([
                'jumlahData' => $jumlahData,
                'dataLampiran' => $data,
                'noAgenda' => $logID,
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
            'nama' => 'required',
            'lampiran' => 'required|file|mimes:pdf|mimetypes:application/pdf,application/x-pdf|max:5120',
        ], [
            'nama.required' => 'Jenis dokumen wajib diisi',
            'lampiran.required' => 'Lampiran wajib diunggah',
            'lampiran.mimes' => 'Lampiran harus berformat PDF',
            'lampiran.mimetypes' => 'Lampiran harus berupa file PDF yang valid',
            'lampiran.max' => 'Ukuran file lampiran maksimal 5MB',
        ]);

        $kelayakan = Kelayakan::findOrFail($kelayakanID);

        if (empty($kelayakan)) {
            return redirect()->back()->with('gagal', 'Kelayakan proposal tidak ditemukan')->withInput();
        }

        $image = $request->file('lampiran');
        $size = $image->getSize();
        $type = strtolower($image->guessExtension() ?: $image->getClientOriginalExtension() ?: 'bin');
        $featured_new_name = $this->storeAttachmentFile($image, $request->nama);

        $dataLampiran = [
            'ID_KELAYAKAN' => $kelayakan->id_kelayakan,
            'NO_AGENDA' => $kelayakan->no_agenda,
            'NAMA' => $request->nama,
            'LAMPIRAN' => $featured_new_name,
            'UPLOAD_BY' => session('user')->username,
            'CREATED_BY' => session('user')->id_user,
            'UPLOAD_DATE' => now(),
        ];

        try {
            Lampiran::create($dataLampiran);
            Log::info('upload.event', [
                'action' => 'lampiran_store',
                'actor_username' => session('user')->username ?? null,
                'actor_role' => session('user')->role ?? null,
                'kelayakan_id' => $kelayakan->id_kelayakan,
                'agenda' => $kelayakan->no_agenda,
                'file_name' => $featured_new_name,
                'file_type' => $type,
                'file_size' => $size,
            ]);
            return redirect()->back()->with('suksesDetail', 'Dokumen pendukung berhasil disimpan');
        } catch (Exception $e) {
            Log::error('upload.event_failed', [
                'action' => 'lampiran_store',
                'actor_username' => session('user')->username ?? null,
                'actor_role' => session('user')->role ?? null,
                'kelayakan_id' => $kelayakanID,
                'file_type' => $type,
                'file_size' => $size,
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->with('gagalDetail', 'Dokumen pendukung gagal disimpan');
        }
    }

    public function update(Request $request)
    {
        try {
            $lampiranID = decrypt($request->lampiranID);
        } catch (Exception $e) {
            abort(404, 'ID Lampiran tidak valid');
        }

        $request->validate([
            'nama' => 'required',
            'lampiran' => 'nullable|file|mimes:pdf|mimetypes:application/pdf,application/x-pdf|max:5120',
        ], [
            'nama.required' => 'Jenis dokumen wajib diisi',
            'lampiran.mimes' => 'Lampiran harus berformat PDF',
            'lampiran.mimetypes' => 'Lampiran harus berupa file PDF yang valid',
            'lampiran.max' => 'Ukuran file lampiran maksimal 5MB',
        ]);

        $lampiran = Lampiran::findOrFail($lampiranID);

        if (!$lampiran) {
            return redirect()->back()->with('gagal', 'Data lampiran tidak ditemukan');
        }

        $lampiran->nama = $request->nama;

        // Jika user mengupload file baru
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $fileName = $this->storeAttachmentFile($file, $request->nama);
            $size = $file->getSize();
            $type = strtolower($file->guessExtension() ?: $file->getClientOriginalExtension() ?: 'bin');

            // Hapus file lama jika ada
            if (!empty($lampiran->lampiran) && Storage::disk('attachment')->exists($lampiran->lampiran)) {
                Storage::disk('attachment')->delete($lampiran->lampiran);
            }

            $lampiran->lampiran = $fileName;
            $lampiran->upload_date = now();

            Log::info('upload.event', [
                'action' => 'lampiran_update_with_file',
                'actor_username' => session('user')->username ?? null,
                'actor_role' => session('user')->role ?? null,
                'lampiran_id' => $lampiran->id_lampiran,
                'agenda' => $lampiran->no_agenda,
                'file_name' => $fileName,
                'file_type' => $type,
                'file_size' => $size,
            ]);
        }

        $lampiran->created_by = session('user')->id_user;
        $lampiran->save();

        return redirect()->back()->with('sukses', 'Dokumen berhasil diperbarui');
    }
    
    public function delete($id)
    {
        try {
            $lampiranID = decrypt($id);
        } catch (Exception $e) {
            abort(404);
        }

        $lampiran = Lampiran::findOrFail($lampiranID);

        // if(in_array($lampiran->nama, ['Surat Pengantar dan Proposal', 'Disposisi'])){
        //     return redirect()->back()->with('gagal', "Dokumen ini hanya bisa diedit dan tidak bisa dihapus")->withInput();
        // }

        $lampiran->delete();
        //Lampiran::where('id_lampiran', $lampiranID)->delete();
        return redirect()->back()->with('berhasil', 'Dokumen pendukung berhasil dihapus');
    }

    public function storeDokumentasi(Request $request)
    {
        try {
            $kelayakanID = decrypt($request->kelayakanID);
        } catch (\Exception $e) {
            abort(404);
        }

        $request->validate([
            'dokumentasi' => 'required|file|mimes:jpeg,png,jpg,gif,svg,mp4,avi,mov,webm|max:10240',
        ], [
            'dokumentasi.required' => 'Dokumentasi wajib diunggah.',
            'dokumentasi.file' => 'Dokumentasi harus berupa file.',
            'dokumentasi.mimes' => 'Format file tidak didukung. Gunakan jpeg, png, jpg, gif, svg, mp4, avi, mov, atau webm.',
            'dokumentasi.max' => 'Ukuran maksimal file adalah 10MB.',
        ]);

        $kelayakan = Kelayakan::findOrFail($kelayakanID);

        $file = $request->file('dokumentasi');

        // Simpan file ke storage/app/public/dokumentasi
        $path = $file->store('dokumentasi', 'public'); // hasil: dokumentasi/nama-file.ext

        $dataLampiran = [
            'ID_KELAYAKAN' => $kelayakan->id_kelayakan,
            'NO_AGENDA' => $kelayakan->no_agenda,
            'NAMA' => 'Dokumentasi',
            'LAMPIRAN' => $path, // Simpan path relatif untuk nanti ditampilkan
            'UPLOAD_BY' => session('user')->username ?? 'unknown',
            'CREATED_BY' => session('user')->id_user ?? null,
            'UPLOAD_DATE' => now(),
        ];

        try {
            Lampiran::create($dataLampiran);
            Log::info('upload.event', [
                'action' => 'dokumentasi_store',
                'actor_username' => session('user')->username ?? null,
                'actor_role' => session('user')->role ?? null,
                'kelayakan_id' => $kelayakan->id_kelayakan,
                'agenda' => $kelayakan->no_agenda,
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'file_type' => strtolower($file->guessExtension() ?: $file->getClientOriginalExtension() ?: 'bin'),
            ]);
            return redirect()->back()->with('suksesDetail', 'Dokumentasi bantuan berhasil disimpan');
        } catch (\Exception $e) {
            Log::error('upload.event_failed', [
                'action' => 'dokumentasi_store',
                'actor_username' => session('user')->username ?? null,
                'actor_role' => session('user')->role ?? null,
                'kelayakan_id' => $kelayakanID,
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->with('gagalDetail', 'Dokumentasi bantuan gagal disimpan');
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
}
