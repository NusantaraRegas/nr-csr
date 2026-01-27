<?php

namespace App\Http\Controllers;

use App\Models\LevelHirarki;
use App\Models\Hirarki;
use App\Models\ViewHirarki;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;


class HirarkiController extends Controller
{
    public function index()
    {
        $perusahaanID = session('user')->id_perusahaan;

        $level = LevelHirarki::orderBy('id')->get();
        $hirarki = ViewHirarki::orderBy('id_level')->get();
        $approver = User::where('status', 'Active')->where('id_perusahaan', $perusahaanID)->orderBy('nama', 'ASC')->get();
        return view('master.data_hirarki')
            ->with([
                'dataLevel' => $level,
                'dataHirarki' => $hirarki,
                'dataApprover' => $approver,
            ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'level' => 'required',
            'nama' => 'required',
        ], [
            'level.required' => 'Level harus diisi',
            'nama.required' => 'Nama Approver harus diisi',
        ]);

        $dataHirarki = [
            'id_user' => $request->nama,
            'id_level' => $request->level,
            'status' => 'Active',
        ];

        try {
            DB::table('tbl_hirarki')->insert($dataHirarki);
            return redirect()->back()->with('sukses', "Hirarki persetujuan berhasil disimpan");
        } catch (\Exception $e) {
            Log::error('Gagal simpan hirarki persetujuan', ['error' => $e->getMessage()]);
            return redirect()->back()->with('gagal', 'Terjadi kesalahan, hirarki persetujuan disimpan');
        }
    }

    public function update(Request $request)
    {

        try {
            $logID = decrypt($request->hirarkiID);
        } catch (Exception $e) {
            abort(404, 'ID tidak valid');
        }

        $request->validate([
            'level' => 'required',
            'nama' => 'required',
        ], [
            'level.required' => 'Level harus diisi',
            'nama.required' => 'Nama Approver harus diisi',
        ]);

        $dataHirarki = [
            'id_user' => $request->nama,
            'id_level' => $request->level,
            'status' => $request->status,
        ];

        try {
            Hirarki::where('id', $logID)->update($dataHirarki);
            return redirect()->back()->with('sukses', "Hirarki persetujuan berhasil diubah");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Hirarki persetujuan gagal diubah: ' . $e->getMessage());
        }
    }

    public function delete($hirarkiID)
    {
        try {
            $logID = decrypt($hirarkiID);
        } catch (Exception $e) {
            abort(404);
        }

        $hirarki = Hirarki::findOrFail($logID);

         if (!$hirarki) {
            return redirect()->back()->with('gagalDetail', 'Data hirarki tidak ditemukan.');
        }

        Hirarki::where('id', $hirarki->id)->delete();
        return redirect()->back()->with('sukses', "Hirarki persetujuan berhasil disimpan");
    }
}
