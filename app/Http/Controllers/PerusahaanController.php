<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Perusahaan;
use App\Models\User;
use Exception;

class PerusahaanController extends Controller
{
    public function index(){
        $data = Perusahaan::with('picUser')->orderBy('id_perusahaan', 'ASC')->get();
        $pic = User::where('status', 'Active')->orderBy('nama', 'ASC')->get();
        return view('master.data_perusahaan')
            ->with([
                'dataPerusahaan' => $data,
                'dataPIC' => $pic
            ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'inisial' => 'required|max:10|min:2',
            'nama' => 'required|max:100|min:10',
            'alamat' => 'required|max:500|min:10',
            'kategori' => 'required',
        ], [
            'inisial.required'  => 'Inisial harus diisi',
            'inisial.max' => 'Maksimal 10 karakter',
            'inisial.min' => 'Minimal 2 karakter',
            'nama.required'  => 'Nama perusahaan harus diisi',
            'nama.max' => 'Maksimal 100 karakter',
            'nama.min' => 'Minimal 10 karakter',
            'alamat.required'  => 'Alamat harus diisi',
            'alamat.max' => 'Maksimal 100 karakter',
            'alamat.min' => 'Minimal 10 karakter',
            'kategori.required'  => 'Kategori harus diisi',
        ]);

        $data = [
            'kode' => strtoupper($request->inisial),
            'nama_perusahaan' => $request->nama,
            'alamat' => $request->alamat,
            'kategori' => $request->kategori,
        ];

        try {
            DB::table('tbl_perusahaan')->insert($data);
            return redirect()->back()->with('sukses', "Entitas dengan nama $request->nama berhasil disimpan");
        } catch (\Exception $e) {
            \Log::error('Gagal menyimpan perusahaan: '.$e->getMessage());
            return redirect()->back()->with('gagal', 'Entitas gagal disimpan');
        }
    }

    public function update(Request $request)
    {
        try {
            $logID = decrypt($request->perusahaanID);
        } catch (\Exception $e) {
            abort(404, 'ID perusahaan tidak valid');
        }

        $request->validate([
            'inisial' => 'required|max:10|min:2',
            'nama' => 'required|max:100|min:10',
            'alamat' => 'required|max:500|min:10',
            'kategori' => 'required',
        ], [
            'inisial.required'  => 'Inisial harus diisi',
            'inisial.max' => 'Maksimal 10 karakter',
            'inisial.min' => 'Minimal 2 karakter',
            'nama.required'  => 'Nama perusahaan harus diisi',
            'nama.max' => 'Maksimal 100 karakter',
            'nama.min' => 'Minimal 10 karakter',
            'alamat.required'  => 'Alamat harus diisi',
            'alamat.max' => 'Maksimal 100 karakter',
            'alamat.min' => 'Minimal 10 karakter',
            'kategori.required'  => 'Kategori harus diisi',
        ]);

        $data = [
            'kode' => strtoupper($request->inisial),
            'nama_perusahaan' => $request->nama,
            'alamat' => $request->alamat,
            'kategori' => $request->kategori,
        ];

        try {
            Perusahaan::where('id_perusahaan', $logID)->update($data);
            return redirect()->back()->with('sukses', "Entitas dengan nama $request->nama berhasil diubah");
        } catch (\Exception $e) {
            \Log::error('Gagal merubah perusahaan: '.$e->getMessage());
            return redirect()->back()->with('gagal', 'Perusahaan gagal diubah');
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $logID = decrypt($request->perusahaanID);
        } catch (\Exception $e) {
            abort(404, 'ID perusahaan tidak valid');
        }

        $request->validate([
            'inisial' => 'required|max:10|min:2',
            'nama' => 'required|max:100|min:10',
            'alamat' => 'required|max:500|min:10',
            'noTelp' => 'nullable|numeric|regex:/^[0-9]{10,15}$/|digits_between:10,15',
            'kategori' => 'required',
        ], [
            'inisial.required'  => 'Inisial harus diisi',
            'inisial.max' => 'Inisial maksimal 10 karakter',
            'inisial.min' => 'Inisial minimal 2 karakter',
            'nama.required'  => 'Nama perusahaan harus diisi',
            'nama.max' => 'Maksimal 100 karakter',
            'nama.min' => 'Minimal 10 karakter',
            'alamat.required'  => 'Alamat harus diisi',
            'alamat.max' => 'Maksimal 100 karakter',
            'alamat.min' => 'Minimal 10 karakter',
            'noTelp.numeric'  => 'No HP harus angka',
            'noTelp.digits_between' => 'No HP harus 10 sampai 15 digit angka',
            'pic.max' => 'Maksimal 100 karakter',
            'kategori.required'  => 'Kategori harus diisi',
        ]);

        $data = [
            'kode' => strtoupper($request->inisial),
            'nama_perusahaan' => $request->nama,
            'alamat' => $request->alamat,
            'PIC' => $request->pic,
            'NO_TELP' => $request->noTelp,
            'kategori' => $request->kategori,
        ];

        try {
            Perusahaan::where('id_perusahaan', $logID)->update($data);
            return redirect()->back()->with('sukses', "Profile entitas dengan nama $request->nama berhasil diupdate");
        } catch (\Exception $e) {
            \Log::error('Gagal merubah perusahaan: '.$e->getMessage());
            return redirect()->back()->with('gagal', 'Entitas gagal diubah');
        }
    }

    public function profile($id){
        try {
            $logID = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'ID perusahaan tidak valid');
        }

        $perusahaan = Perusahaan::findOrFail($logID);
        $user = User::where('status', 'Active')->where('id_perusahaan', $perusahaan->id_perusahaan)->get();

        $pic = User::where('status', 'Active')->where('id_perusahaan', $perusahaan->id_perusahaan)->orderBy('nama', 'ASC')->get();
        return view('master.profile_perusahaan')
            ->with([
                'data' => $perusahaan,
                'dataUser' => $user,
                'dataPIC' => $pic
            ]);
    }

    public function updateLogo(Request $request)
    {
        try {
            $logID = decrypt($request->perusahaanID);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Data tidak valid.'], 422);
        }

        // Validasi
        $request->validate([
            'foto_profile' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $perusahaan = Perusahaan::findOrFail($logID);

            // Simpan foto baru
            $file = $request->file('foto_profile');
            $fileName = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('logo_perusahaan', $fileName, 'public');

            // Update DB
            DB::table('tbl_perusahaan')->where('id_perusahaan', $logID)->update([
                'foto_profile' => $filePath
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Foto profile berhasil diperbarui.',
                'foto_profile' => asset('storage/' . $filePath)
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal upload logo perusahaan', ['error' => $e->getMessage()]);

            // Return JSON error untuk JS (fetch)
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan server.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete($perusahaanID)
    {
        try {
            $logID = decrypt($perusahaanID);
        } catch (\Exception $e) {
            abort(404, 'ID perusahaan tidak valid');
        }

        $perusahaan = Perusahaan::find($logID);

        if (!$perusahaan) {
            return redirect()->back()->with('gagalDetail', 'Data entitas tidak ditemukan.');
        }

        // Cek relasi satu per satu
        $relatedData = [];

        if ($perusahaan->pengirim()->exists()) {
            $relatedData[] = 'Data Stakeholder';
        }

        if ($perusahaan->user()->exists()) {
            $relatedData[] = 'Data User';
        }

        if (!empty($relatedData)) {
            $message = 'Tidak dapat menghapus karena masih memiliki data relasi pada ' . implode(', ', $relatedData) . '.';
            return redirect()->back()->with('gagal', $message);
        }

        try {
            $perusahaan->delete();
            return redirect()->back()->with('sukses', "Entitas dengan nama $perusahaan->nama_perusahaan berhasil dihapus");
        } catch (\Exception $e) {
            \Log::error('Gagal menghapus entitas: '.$e->getMessage());
            return redirect()->back()->with('gagal', 'Entitas gagal dihapus');
        }
    }


}
