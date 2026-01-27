<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Log;
use DB;
use Mail;
use Exception;

class LoginController extends Controller
{
    public function error()
    {
        return view('errors.404');
    }

    public function auth()
    {
        return redirect(route('login'));
    }

    public function index()
    {
        if (!empty(session('user'))) {
            $intended = session('url.intended', route('dashboard'));
            return redirect($intended);
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ], [
            'username.required' => 'Username harus diisi',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal harus 6 karakter.',
        ]);

        // 2. Cek user aktif
        $user = User::where('username', strtolower($request->username))
            ->where('status', 'Active')
            ->first();

        if (!$user) {
            return redirect()->back()->with('credential', 'Username tidak dikenal atau tidak aktif.');
        }

        // 3. Coba login lokal
        $credentialUsername = [
            'username' => strtolower($request->username),
            'password' => $request->password
        ];

        if (auth()->attempt($credentialUsername)) {
            $data = User::where('username', strtolower($request->username))->first();
            
            session(['user' => $data]);

            if (session('user')->role == 'Subsidiary') {
                return redirect()->intended(route('dashboardSubsidiary'));
            } else {
                return redirect()->intended(route('dashboard'));
            }

        }

        // 4. Coba login via LDAP
        // Guard: PHP LDAP extension might not be installed in local Docker.
        // Without it, calling ldap_connect() would fatal with "Call to undefined function".
        if (!function_exists('ldap_connect')) {
            return redirect()->back()->with(
                'gagal',
                'LDAP login tidak tersedia (PHP LDAP extension belum terpasang di environment ini).'
            );
        }

        $domain   = 'pertamina\\';
        $ldapHost = '10.129.1.4';
        $ldapPort = 389;
        $ldapUser = strtolower($request->username);
        $ldapPass = $request->password;

        $ldapConn = ldap_connect($ldapHost, $ldapPort);

        if (!$ldapConn) {
            return redirect()->back()->with('gagal', 'Tidak dapat terhubung ke server LDAP.');
        }

        ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);

        try {
            $ldapBind = @ldap_bind($ldapConn, $domain . $ldapUser, $ldapPass);
        } catch (\Exception $e) {
            ldap_close($ldapConn);
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat mengakses server LDAP.');
        }

        if (!$ldapBind) {
            ldap_close($ldapConn);
            return redirect()->back()->with('credential', 'Username atau password salah.');
        }

        ldap_close($ldapConn);

        // 5. Siapkan OTP dan simpan session
        $otp = rand(100000, 999999);

        Session::forget(['mfa_otp', 'mfa_id_user', 'mfa_otp_created_at', 'userID', 'user']);

        Session::put('userID', $user->id_user);
        Session::put('mfa_otp', $otp);
        Session::put('mfa_otp_created_at', now());
        Session::put('mfa_id_user', $user->id_user);

        // 6. Kirim OTP via email
        $receiver = User::where('id_user', $user->id_user)->first();

        if (!$receiver || !$receiver->email) {
            return redirect()->back()->with('gagal', 'Alamat email tidak ditemukan.');
        }

        $dataEmail = [
            'nama' => $receiver->nama,
            'otp' => $otp,
        ];

        try {
            Mail::send('mail.notifikasi_otp', $dataEmail, function ($message) use ($receiver) {
                $message->to($receiver->email, $receiver->nama)
                    ->subject('Kode OTP Login NR SHARE')
                    ->from('pgn.no.reply@pertamina.com', 'NR SHARE');
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Gagal mengirim OTP ke email.');
        }

        // 7. Arahkan ke halaman verifikasi OTP
        return redirect()->route('showOtp');
    }

    public function showOtp()
    {
        return view('auth.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $inputOtp = $request->input('otp');
        $storedOtp = Session::get('mfa_otp');
        $createdAt = Session::get('mfa_otp_created_at');
        $userID = Session::get('mfa_id_user');

        if (!$createdAt || \Carbon\Carbon::parse($createdAt)->diffInMinutes(now()) >= 5) {
            Session::forget(['mfa_otp', 'mfa_id_user', 'mfa_otp_created_at']);
            return redirect()->back()->with('credential', 'Kode OTP telah kedaluwarsa.');
        }

        if ($inputOtp == $storedOtp) {
            $user = User::find($userID);

            if (!$user) {
                return redirect()->route('login')->with('gagal', 'User tidak ditemukan.');
            }

            // Simpan user ke session manual
            session(['user' => $user]);
            session()->regenerate(); // aman

            Session::forget(['mfa_otp', 'mfa_id_user', 'mfa_otp_created_at']);
            return redirect()->route('dashboard');
        }

        return redirect()->back()->with('credential', 'Kode OTP salah.');
    }


    public function resendOtp(Request $request)
    {
        // Logika generate & kirim ulang OTP
        // Misal pakai session untuk user_id
        $userID = session('userID');
        $user = User::where('id_user', $userID)->first();

        if ($user) {
            $otp = rand(100000, 999999);

            // Simpan OTP dan timestamp
            Session::put('mfa_otp', $otp);
            Session::put('mfa_user_id', $userID);
            Session::put('mfa_otp_created_at', now());


            //SEND EMAIL
            $receiver = User::where('id_user', $userID)->first();
            $dataEmail = [
                'nama' => $receiver->nama,
                'otp' => $otp,
            ];

            Mail::send('mail.notifikasi_otp', $dataEmail, function ($message) use ($receiver) {
                $message->to($receiver->email, $receiver->nama)
                    ->subject('Kode OTP Login NR SHARE')
                    ->from('pgn.no.reply@pertamina.com', 'NR SHARE');
            });

            return redirect()->route('showOtp')->with('sukses', 'Kode OTP baru telah dikirim.');
        }

        return redirect()->back()->with('credential', 'User tidak ditemukan.');
    }

    public function loginOld(Request $request)
    {

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = DB::table('TBL_USER')
            ->select(DB::raw('count(*) as jumlah'))
            ->where([
                ['username', '=', strtolower($request->username)],
                ['status', '=', 'Active'],
            ])
            ->first();

        if ($user->jumlah == 0) {
            return redirect()->back()->with('credential', 'Username yang anda masukkan tidak dikenal');
        } else {

            $credentialUsername = [
                'username' => strtolower($request->username),
                'password' => $request->password
            ];

            if (auth()->attempt($credentialUsername)) {
                $data = DB::table('TBL_USER')
                    ->select('TBL_USER.*')
                    ->where([
                        ['username', strtolower($request->username)],
                    ])
                    ->first();

                session(['user' => $data]);
                if (session('user')->role == 'Subsidiary') {
                    return redirect(route('dashboardSubsidiary'));
                } elseif (session('user')->role == 'Vendor') {
                    return redirect(route('dashboardVendor'));
                } else {
                    return redirect(route('dashboard'));
                }
            } else {
                $domain = 'pertamina\\';
                $ldap['sAMAccountName'] = strtolower($request->username);
                $ldap['pass'] = $request->password;
                $ldap['host'] = '10.129.1.4';
                $ldap['port'] = 389;

                $ldap['conn'] = ldap_connect($ldap['host'], $ldap['port'])
                    or die("Could not conenct to {$ldap['host']}");

                ldap_set_option($ldap['conn'], LDAP_OPT_PROTOCOL_VERSION, 3);
                try {
                    $ldap['bind'] = ldap_bind($ldap['conn'], $domain . $ldap['sAMAccountName'], $ldap['pass']);
                } catch (Exception $e) {
                    $domain = 'corp\\';
                    $ldap['user'] = strtolower($request->username);
                    $ldap['pass'] = $request->password;
                    $ldap['host'] = '10.129.1.3';
                    $ldap['port'] = 389;

                    $ldap['conn'] = ldap_connect($ldap['host'], $ldap['port'])
                        or die("Could not conenct to {$ldap['host']}");

                    ldap_set_option($ldap['conn'], LDAP_OPT_PROTOCOL_VERSION, 3);
                    try {
                        $ldap['bind'] = ldap_bind($ldap['conn'], $domain . $ldap['user'], $ldap['pass']);
                    } catch (Exception $e) {
                        return redirect()->back()->with('credential', 'Kata sandi yang anda masukkan salah');
                    }
                    //return redirect()->back()->with('credential', 'Kata sandi yang anda masukkan salah');
                }

                if (!$ldap['bind']) {
                    return redirect()->back()->with('credential', 'Username yang anda masukkan tidak dikenal');
                } else {
                    $data = DB::table('TBL_USER')
                        ->select('TBL_USER.*')
                        ->where([
                            ['username', strtolower($request->username)],

                        ])
                        ->first();

                    session(['user' => $data]);
                    if (session('user')->role == 'Subsidiary') {
                        return redirect(route('dashboardSubsidiary'));
                    } elseif (session('user')->role == 'Vendor') {
                        return redirect(route('dashboardVendor'));
                    } else {
                        return redirect(route('dashboard'));
                    }
                }
                ldap_close($ldap['conn']);
            }
        }
    }

    public function forgot()
    {
        return view('auth.forgot');
    }

    public function logout()
    {
        auth()->logout();
        session()->flush();
        return redirect(route('login'));
    }

    public function checkEmail(Request $request)
    {

        $this->validate($request, [
            'email' => 'required',
        ]);

        $email = $request->email;
        $data = User::where('email', $email)->first();

        if (empty($data)) {
            return redirect()->back()->with('credential', 'Email yang anda masukkan tidak dikenal');
        } else {
            try {
                $dataEmail = [
                    "nama" => $data->nama,
                    "email" => $data->email,
                    "token" => $data->remember_token
                ];
                Mail::send('mail.reset-password', $dataEmail, function ($message) use ($data) {
                    $message->to($data->email, $data->nama)
                        ->subject('Reset Password Aplikasi SHARE')
                        ->from('pgn.no.reply@pertamina.com', 'NR SHARE');
                });
                return redirect()->back()->with('sukses', 'Cek email anda untuk mengatur ulang kata sandi');
            } catch (Exception $e) {
                return redirect()->back()->with('gagal', 'Ada masalah pada mail server aplikasi');
            }
        }
    }

    public function perbaruiPassword($email, $token)
    {
        try {
            $email = decrypt($email);
            $token = decrypt($token);
        } catch (Exception $e) {
            abort(404);
        }

        $data = User::where([
            'email' => $email,
            'remember_token' => $token
        ])->firstOrFail();

        return view('auth.reset')->with(['data' => $data]);
    }

    public function updatePassword(Request $request)
    {

        try {
            $logID = decrypt($request->userID);
        } catch (Exception $e) {
            abort(404);
        }

        $this->validate($request, [
            'password' => 'required',
        ]);

        $dataUpdate = [
            'password' => bcrypt($request->password),
            'remember_token' => Str::random(40),
        ];

        User::where('id_user', $logID)->update($dataUpdate);
        //        auth()->logout();
        //        session()->flush();
        return redirect()->route('login')->with('sukses', 'Password anda berhasil diperbaharui');
    }

    public function editPassword(Request $request)
    {
        // Validasi dasar (termasuk konfirmasi)
        $request->validate([
            'userID'      => ['required','string'],
            'newPassword'  => ['required','string','min:8','max:72','confirmed'],
        ], [
            'newPassword.required' => 'Password baru harus diisi.',
            'newPassword.confirmed' => 'Konfirmasi password tidak cocok.',
            'newPassword.min'       => 'Password minimal 8 karakter.',
        ]);

        // Dekripsi ID terenkripsi dari form
        try {
            $logID = decrypt($request->userID);
        } catch (\Exception $e) {
            return back()->with('gagal', 'ID tidak valid.')->withInput();
        }

        // Update password
        try {
            $dataUpdate = [
                'password' => bcrypt($request->newPassword),
            ];

            User::where('id_user', $logID)->update($dataUpdate);

            // (Opsional) kalau pakai Sanctum/Passport dan ingin logout semua device:
            // $user->tokens()->delete();

            return back()->with('sukses', 'Password berhasil direset');
        } catch (\Exception $e) {
            return back()->with('gagal', 'Password gagal direset')->withInput();
        }
    }
}
