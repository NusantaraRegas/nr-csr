<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Kelayakan;
use App\Models\Perusahaan;
use App\Models\Role;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\InsertUserValidation;
use App\Http\Requests\EditUserValidation;
use App\Http\Requests\EditPassword;
use App\Http\Requests\InsertProfileValidation;
use App\Http\Requests\UploadFoto;
use Yajra\DataTables\DataTables;
use DB;
use Mail;
use Image;
use App\Models\User;
use App\Helper\APIHelper;
use Exception;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $query = User::with('namaPerusahaan')->orderBy('status')->orderBy('id_perusahaan')->orderBy('nama');

        if ($request->filled('perusahaan')) {
            $query->where('id_perusahaan', $request->perusahaan);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $dataUser = $query->get();
        $dataPerusahaan = Perusahaan::orderBy('nama_perusahaan')->get();

        return view('master.data_user')
            ->with([
                'dataUser' => $dataUser,
                'dataPerusahaan' => $dataPerusahaan
            ]);
    }

    public function indexServerSide()
    {
        return view('master.data_user_new');
    }

    public function json()
    {
        $query = User::orderBy('nama', 'ASC')->get();
        return DataTables::of($query)->make(true);
    }

    public function indexActive()
    {
        $user = User::where('status', 'Active')->orderBy('status', 'ASC')->orderBy('nama', 'ASC')->get();
        $status = "Active";
        $perusahaan = Perusahaan::orderBy('id_perusahaan', 'ASC')->get();
        return view('master.data_user')
            ->with([
                'dataUser' => $user,
                'status' => $status,
                'dataPerusahaan' => $perusahaan
            ]);
    }

    public function indexNonActive()
    {
        $user = User::where('status', 'Non Active')->orderBy('status', 'ASC')->orderBy('nama', 'ASC')->get();
        $status = "Non Active";
        $perusahaan = Perusahaan::orderBy('id_perusahaan', 'ASC')->get();
        return view('master.data_user')
            ->with([
                'dataUser' => $user,
                'status' => $status,
                'dataPerusahaan' => $perusahaan
            ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:tbl_user,username',
            'email' => 'required|email',
            'nama' => 'required|max:100',
            'jabatan' => 'required|max:100',
            'perusahaan' => 'required',
            'role' => 'required',
        ], [
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah digunakan',
            'email.required' => 'Email harus diisi',
            'email.email'    => 'Format email tidak valid',
            'nama.required'  => 'Nama harus diisi',
            'nama.max' => 'Maksimal 100 karakter',
            'jabatan.required'  => 'Jabatan harus diisi',
            'jabatan.max' => 'Maksimal 100 karakter',
            'perusahaan.required'  => 'Entitas harus diisi',
            'role.required'  => 'Role harus diisi',
        ]);

        $defaultPassword = env('DEFAULT_USER_PASSWORD');
        if (empty($defaultPassword)) {
            return redirect()->back()
                ->withInput()
                ->with('gagal', 'DEFAULT_USER_PASSWORD belum dikonfigurasi. Hubungi administrator aplikasi.');
        }

        $data = [
            'username' => strtolower($request->username),
            'email' => strtolower($request->email),
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'id_perusahaan' => $request->perusahaan,
            'role' => $request->role,
            'password' => bcrypt($defaultPassword),
            'status' => 'Active',
            'remember_token' => Str::random(40),
        ];

        try {
            DB::table('tbl_user')->insert($data);
            return redirect()->back()->with('sukses', "User dengan nama $request->nama berhasil disimpan");
        } catch (Exception $e) {
            return redirect()->back()->with('failed', "User dengan nama $request->nama gagal disimpan");
        }
    }

    public function ubahUser($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }

        $dataUser = DB::table('v_user')
            ->select('v_user.*')
            ->where('id_user', '=', $logID)
            ->first();
        $area = Area::get();
        $role = Role::get();
        return view('master.edit_user')
            ->with([
                'data' => $dataUser,
                'dataArea' => $area,
                'dataRole' => $role,
            ]);
    }

    public function update(Request $request)
    {
        try {
            $logID = decrypt($request->userID);
        } catch (Exception $e) {
            abort(404);
        }

       $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'nama' => 'required|max:100',
            'jabatan' => 'required|max:100',
            'perusahaan' => 'required',
            'role' => 'required',
            'status' => 'required',
            'noSK' => 'nullable|max:100',
            'tglSK' => 'nullable|date',
        ], [
            'username.required' => 'Username harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email'    => 'Format email tidak valid',
            'nama.required'  => 'Nama harus diisi',
            'nama.max' => 'Maksimal 100 karakter',
            'jabatan.required'  => 'Jabatan harus diisi',
            'jabatan.max' => 'Maksimal 100 karakter',
            'perusahaan.required'  => 'Entitas harus diisi',
            'role.required'  => 'Role harus diisi',
            'status.required'  => 'Status harus diisi',
            'noSK.max' => 'Nomor SK maksimal 100 karakter',
            'tglSK.date' => 'Format tanggal SK tidak valid',
        ]);

        $data = [
            'username' => strtolower($request->username),
            'email' => strtolower($request->email),
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'id_perusahaan' => $request->perusahaan,
            'role' => $request->role,
            'status' => $request->status,
            'no_sk' => strtoupper($request->noSK),
            'tgl_sk' => date('Y-m-d', strtotime($request->tglSK)),
            'remember_token' => Str::random(40),
        ];

        try {
            User::where('id_user', $logID)->update($data);
            return redirect()->back()->with('sukses', "User dengan nama $request->nama berhasil diubah");
        } catch (Exception $e) {
            return redirect()->back()->with('failed', "User dengan nama $request->nama gagal diubah");
        }
    }

    public function profile($id){
        try {
            $userID = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'ID user tidak valid');
        }

        $user = User::findOrFail($userID);
        $perusahaan = Perusahaan::orderBy('id_perusahaan', 'ASC')->get();
        return view('master.profile_user')
            ->with([
                'data' => $user,
                'dataPerusahaan' => $perusahaan
            ]);
    }

    public function updateFoto(Request $request)
    {
        try {
            $userID = decrypt($request->userID);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Data tidak valid.'], 422);
        }

        // Validasi
        $request->validate([
            'foto_profile' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $user = User::findOrFail($userID);

            // Simpan foto baru
            $file = $request->file('foto_profile');
            $fileName = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('foto_profile', $fileName, 'public');

            // Update DB
            DB::table('tbl_user')->where('id_user', $userID)->update([
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

    public function delete($userID)
    {
        try {
            $logID = decrypt($userID);
        } catch (Exception $e) {
            abort(404);
        }

        $user = User::find($logID);

        if (!$user) {
            return redirect()->back()->with('gagalDetail', 'Data user tidak ditemukan.');
        }

        // Cek relasi satu per satu
        $relatedData = [];

        if ($user->perusahaan()->exists()) {
            $relatedData[] = 'PIC Entitas';
        }

        if ($user->hirarki()->exists()) {
            $relatedData[] = 'Hirarki Persetujuan';
        }

        if ($user->lampiran()->exists()) {
            $relatedData[] = 'Dokumen Pendukung';
        }

        if (!empty($relatedData)) {
            $message = 'Tidak dapat menghapus karena masih memiliki data relasi pada ' . implode(', ', $relatedData) . '.';
            return redirect()->back()->with('gagal', $message);
        }

        // Hapus file foto jika ada
        if ($user->foto_profile && Storage::disk('public')->exists($user->foto_profile)) {
            Storage::disk('public')->delete($user->foto_profile);
        }


        try {
            User::where('id_user', $logID)->delete();
            return redirect()->back()->with('sukses', "User dengan nama $user->nama berhasil dihapus.");
        } catch (Exception $e) {
            Log::error('Gagal menghapus User dengan ID: ' . $userID, [
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->with('gagal', "Terjadi kesalahan saat menghapus User dengan nama $user->nama.");
        }
    }

    public function editProfile(InsertProfileValidation $request)
    {
        try {
            $logID = decrypt($request->idlogin);
        } catch (Exception $e) {
            abort(404);
        }

        $dataUpdate = [
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'remember_token' => Str::random(50),
        ];

        User::where('id_user', $logID)->update($dataUpdate);
        return redirect()->back()->with('sukses', 'Profile anda telah diperbaharui');
    }

    public function editPassword(EditPassword $request)
    {

        date_default_timezone_set("Asia/Bangkok");
        $tanggalMenit = date("Y-m-d H:i:s");


        try {
            $logID = decrypt($request->idlogin);
        } catch (Exception $e) {
            abort(404);
        }

        $credentialUsername = [
            'username' => session('user')->username,
            'password' => $request->oldPassword
        ];

        if (auth()->attempt($credentialUsername)) {
            $user = DB::table('tbl_user')
                ->select('tbl_user.*')
                ->where('username', session('user')->username)
                ->first();

            if ($request->password != $request->konfirmasiPassword) {
                return redirect()->back()->with('gagal', 'Konfirmasi password baru tidak sesuai');
            } else {
                $dataUpdate = [
                    'password' => bcrypt($request->password),
                    'remember_token' => Str::random(50),
                ];

                $dataEmail = [
                    "nama" => session('user')->nama,
                    "tanggal" => $tanggalMenit,
                ];

                $data = User::where('username', session('user')->username)->first();
                Mail::send('mail.ubah-password', $dataEmail, function ($message) use ($data) {
                    $message->to($data->email, $data->nama)
                        ->subject('Perubahan Password Aplikasi SHARE')
                        ->from('no.reply@pgn.co.id', 'SHARE');
                });

                User::where('id_user', $logID)->update($dataUpdate);
                auth()->logout();
                session()->flush();
                return redirect(route('login'))->with('sukses', 'Password anda berhasil diperbaharui');
            }

        } else {
            return redirect()->back()->with('gagal', 'Password lama anda tidak sesuai');
        }

    }

    public function uploadFoto(UploadFoto $request)
    {
        try {
            $logID = decrypt($request->idlogin);
        } catch (Exception $e) {
            abort(404);
        }

        $user = User::where('id_user', $logID)->first();

        $image = $request->file('avatar');
        $type = $image->getClientOriginalExtension();
        $featured_new_name = $user->username;
        $image->move('avatar',$featured_new_name.".$type");
        //Image::make($image)->resize(200, 200)->save($path);

        $dataUpdate = [
            'foto' => $featured_new_name,
        ];

        User::where('id_user', $logID)->update($dataUpdate);
        return redirect()->back()->with('sukses', 'Avatar berhasil diubah');
    }

    public function deleteFotoProfile($loginID)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }

        $dataUpdate = [
            'foto' => '',
        ];

        User::where('id_user', $logID)->update($dataUpdate);
//        auth()->logout();
//        session()->flush();

        return redirect()->back()->with('sukses', 'Avatar berhasil dihapus');
    }

}
