<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = Anggota::orderBy('status')->orderBy('nama_anggota')->get();
        return view('master.data_anggota')
            ->with([
                'dataAnggota' => $anggota,
            ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|min:3',
            'fraksi' => 'required|string',
            'komisi' => 'required|string',
            'jabatan' => 'required|string',
            'tenagaAhli' => 'required|string|max:100|min:3',
            'noTelp' => [
                'required',
                'regex:/^[0-9]{10,15}$/'
            ],
        ], [
            'nama.required'        => 'Nama harus diisi',
            'nama.max'             => 'Nama maksimal 100 karakter',
            'nama.min'             => 'Nama minimal 3 karakter',

            'fraksi.required'      => 'Fraksi harus diisi',
            'komisi.required'      => 'Komisi harus diisi',

            'jabatan.required'     => 'Jabatan harus diisi',

            'tenagaAhli.required'  => 'Tenaga Ahli harus diisi',
            'tenagaAhli.max'       => 'Tenaga Ahli maksimal 100 karakter',
            'tenagaAhli.min'       => 'Tenaga Ahli minimal 3 karakter',

            'noTelp.required'      => 'No HP harus diisi',
            'noTelp.regex'         => 'No HP harus terdiri dari 10 sampai 15 angka',
        ]);

        $dataAnggota = [
            'nama_anggota' => $request->nama,
            'fraksi'       => $request->fraksi,
            'komisi'       => $request->komisi,
            'jabatan'      => $request->jabatan,
            'staf_ahli'    => $request->tenagaAhli,
            'no_telp'      => $request->noTelp,
            'status'      => 'Active',
        ];

        try {
            DB::table('tbl_anggota')->insert($dataAnggota);
            return redirect()->back()->with('sukses', "Anggota dengan nama $request->nama berhasil disimpan");
        } catch (\Exception $e) {
            \Log::error('Gagal simpan anggota', ['error' => $e->getMessage()]);
            return redirect()->back()->with('gagal', 'Terjadi kesalahan, anggota gagal disimpan');
        }
    }

    public function update(Request $request)
    {

        try {
            $logID = decrypt($request->anggotaID);
        } catch (Exception $e) {
            abort(404, 'ID tidak valid');
        }

        $request->validate([
            'nama' => 'required|string|max:100|min:3',
            'fraksi' => 'required|string',
            'komisi' => 'required|string',
            'jabatan' => 'required|string',
            'tenagaAhli' => 'required|string|max:100|min:3',
            'noTelp' => [
                'required',
                'regex:/^[0-9]{10,15}$/'
            ],
            'status' => 'required|in:Active,Non Active',
        ], [
            'nama.required'        => 'Nama harus diisi',
            'nama.max'             => 'Nama maksimal 100 karakter',
            'nama.min'             => 'Nama minimal 3 karakter',

            'fraksi.required'      => 'Fraksi harus diisi',
            'komisi.required'      => 'Komisi harus diisi',

            'jabatan.required'     => 'Jabatan harus diisi',

            'tenagaAhli.required'  => 'Tenaga Ahli harus diisi',
            'tenagaAhli.max'       => 'Tenaga Ahli maksimal 100 karakter',
            'tenagaAhli.min'       => 'Tenaga Ahli minimal 3 karakter',

            'noTelp.required'      => 'No HP harus diisi',
            'noTelp.regex'         => 'No HP harus terdiri dari 10 sampai 15 angka',
            'status.required' => 'Status harus diisi',
            'status.in' => 'Status harus bernilai Active atau Non Active',
        ]);

        $dataAnggota = [
            'nama_anggota' => $request->nama,
            'fraksi' => $request->fraksi,
            'komisi' => $request->komisi,
            'jabatan' => $request->jabatan,
            'staf_ahli' => $request->tenagaAhli,
            'no_telp' => $request->noTelp,
            'status' => $request->status,
        ];

        try {
            Anggota::where('id_anggota', $logID)->update($dataAnggota);
            return redirect()->back()->with('sukses', "Anggota dengan nama {$request->nama} berhasil diubah");
        } catch (Exception $e) {
            return redirect()->back()->with('gagal', 'Anggota gagal diubah: ' . $e->getMessage());
        }
    }

    public function delete($anggotaID)
    {
        try {
            $logID = decrypt($anggotaID);
        } catch (Exception $e) {
            abort(404);
        }

        $anggota = Anggota::findOrFail($logID);

         if (!$anggota) {
            return redirect()->back()->with('gagalDetail', 'Data anggota tidak ditemukan.');
        }

        Anggota::where('id_anggota', $anggota->id_anggota)->delete();
        return redirect()->back()->with('sukses', "Anggota dengan nama $anggota->nama_anggota berhasil disimpan");
    }

    public function profile($id)
    {
        try {
            $anggotaID = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'ID anggota tidak valid');
        }

        $anggota = Anggota::findOrFail($anggotaID);
        return view('master.profile_anggota')
            ->with([
                'data' => $anggota,
            ]);
    }

    public function updateFoto(Request $request)
    {
        try {
            $anggotaID = decrypt($request->anggotaID);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Data tidak valid.'], 422);
        }

        // Validasi
        $request->validate([
            'foto_profile' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $anggota = Anggota::findOrFail($anggotaID);

            // Simpan foto baru
            $file = $request->file('foto_profile');
            $fileName = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('foto_anggota', $fileName, 'public');

            // Update DB
            DB::table('tbl_anggota')->where('id_anggota', $anggotaID)->update([
                'foto_profile' => $filePath
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Foto profile berhasil diperbarui.',
                'foto_profile' => asset('storage/' . $filePath)
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal upload foto profile', ['error' => $e->getMessage()]);

            // Return JSON error untuk JS (fetch)
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan server.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
