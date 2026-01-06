<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Pengirim;
use Exception;

class PengirimController extends Controller
{
    public function index(){
        $perusahaanID = session('user')->id_perusahaan;
        $data = Pengirim::where('id_perusahaan', $perusahaanID)->orderBy('status')->orderBy('pengirim')->get();
        return view('master.data_pengirim')
            ->with([
                'dataPengirim' => $data
            ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:100|min:3',
        ], [
            'nama.required'  => 'Nama stakeholder harus diisi',
            'nama.max' => 'Maksimal 100 karakter',
            'nama.min' => 'Minimal 3 karakter',
        ]);

        $perusahaanID = session('user')->id_perusahaan;

        $nama = strtoupper($request->nama);

        $dataPengirim = [
            'pengirim' => strtoupper($request->nama),
            'id_perusahaan' => $perusahaanID,
            'status' => 'Active',
        ];

        try {
            DB::table('tbl_pengirim')->insert($dataPengirim);
            return redirect()->back()->with('berhasil', "Stakeholder dengan nama $nama berhasil disimpan");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Stakeholder gagal disimpan');
        }
    }

    public function update(Request $request)
    {
        try {
            $logID = decrypt($request->idpengirim);
        } catch (Exception $e) {
            abort(404);
        }

        $request->validate([
            'nama' => 'required|max:100|min:3',
            'status' => 'required',
        ], [
            'nama.required'  => 'Nama stakeholder harus diisi',
            'nama.max' => 'Maksimal 100 karakter',
            'nama.min' => 'Minimal 3 karakter',
            'status.required'  => 'Status stakeholder harus diisi',
        ]);

        $perusahaanID = session('user')->id_perusahaan;

        $nama = strtoupper($request->nama);

        $dataUpdate = [
            'pengirim' => strtoupper($request->nama),
            'id_perusahaan' => $perusahaanID,
            'status' => $request->status,
        ];

        try {
            Pengirim::where('id_pengirim', $logID)->update($dataUpdate);
            return redirect()->back()->with('berhasil', "Stakeholder dengan nama $nama berhasil diubah");
        } catch (Exception $e) {
            return redirect()->back()->with('peringatan', 'Stakeholder gagal diubah');
        }
    }

    public function delete($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }
        
        $pengirim = Pengirim::find($logID);

        if (!$pengirim) {
            return redirect()->back()->with('gagal', 'Stakeholder tidak ditemukan');
        }

        try {
            Pengirim::where('id_pengirim', $logID)->delete();
            return redirect()->back()->with('berhasil', "Stakeholder dengan nama $pengirim->pengirim berhasil dihapus");
        } catch (\Exception $e) {
            \Log::error('Gagal menghapus stakeholder: '.$e->getMessage());
            return redirect()->back()->with('gagal', 'Stakeholder gagal dihapus');
        }

    }
}
