<?php

namespace App\Http\Controllers;

use App\Services\Auth\AuthContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\User;
use Mail;
use Exception;

class LoginController extends Controller
{
    /**
     * @var AuthContext
     */
    protected $authContext;

    public function __construct(AuthContext $authContext)
    {
        $this->authContext = $authContext;
    }

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
        if ($this->authContext->hasUser()) {
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

            $this->authContext->setUser($data);

            if ($this->authContext->role() == 'Subsidiary') {
                return redirect()->intended(route('dashboardSubsidiary'));
            } else {
                return redirect()->intended(route('dashboard'));
            }

        }

        // 4. Coba login via LDAP (optional fallback)
        if (!config('auth.ldap.enabled', false)) {
            return redirect()->back()->with('credential', 'Username atau password salah.');
        }

        // Guard: PHP LDAP extension might not be installed in local Docker.
        // Without it, calling ldap_connect() would fatal with "Call to undefined function".
        if (!function_exists('ldap_connect')) {
            return redirect()->back()->with(
                'gagal',
                'LDAP login tidak tersedia (PHP LDAP extension belum terpasang di environment ini).'
            );
        }

        $domain   = config('auth.ldap.domain', 'pertamina\\');
        $ldapHost = config('auth.ldap.host', '10.129.1.4');
        $ldapPort = (int) config('auth.ldap.port', 389);
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
            $this->authContext->setUser($user);
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

    public function forgot()
    {
        return view('auth.forgot');
    }

    public function logout()
    {
        $this->authContext->logout();
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
