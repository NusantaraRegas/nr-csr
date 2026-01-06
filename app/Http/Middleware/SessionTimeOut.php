<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Session\Store;
use Carbon\Carbon;

class SessionTimeout
{
    protected $session;
    protected $timeout;

    // Route yang dikecualikan dari middleware timeout (tanpa login penuh)
    protected $excludedRoutes = [
        'auth/login',
        'auth/otp',
        'auth/resend-otp',
        'auth/forgot-password',
        'auth/change-password/*',
    ];

    public function __construct(Store $session)
    {
        $this->session = $session;
        $this->timeout = config('session.lifetime_timeout', 1800); // default 30 menit
    }

    public function handle($request, Closure $next)
    {
        // Lewati middleware untuk route yang dikecualikan
        foreach ($this->excludedRoutes as $route) {
            if ($request->is($route)) {
                return $next($request);
            }
        }

        // Cek apakah user sudah login
        if (Auth::check()) {
            $currentTime = Carbon::now()->timestamp;
            $lastActivity = $this->session->get('lastActivityTime');

            // Timeout? Log out dan redirect ke login
            if ($lastActivity && ($currentTime - $lastActivity > $this->timeout)) {
                $this->session->forget('lastActivityTime');

                // Simpan URL terakhir sebelum logout
                $this->session->put('url.intended', $request->fullUrl());

                Auth::logout();

                return redirect()->route('login')
                    ->with('session', 'Sesi anda sudah habis, silakan login kembali.');
            }

            // Update waktu aktivitas terakhir
            $this->session->put('lastActivityTime', $currentTime);

            // Simpan URL terakhir jika bukan halaman login/logout dll
            if (!$request->is('auth/*')) {
                $this->session->put('url.intended', $request->fullUrl());
            }
        }

        return $next($request);
    }
}
