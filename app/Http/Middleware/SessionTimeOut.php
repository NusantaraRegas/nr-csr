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

        // This application uses a custom session-based login (session('user'))
        // instead of Laravel's Auth facade.
        // In local/dev, Auth::check() will typically be false, so we also treat
        // session('user') as a logged-in indicator.
        if (Auth::check() || session()->has('user')) {
            $currentTime = Carbon::now()->timestamp;
            $lastActivity = $this->session->get('lastActivityTime');

            // Timeout? Log out dan redirect ke login
            if ($lastActivity && ($currentTime - $lastActivity > $this->timeout)) {
                $this->session->forget('lastActivityTime');

                // Simpan URL terakhir sebelum logout
                $this->session->put('url.intended', $request->fullUrl());

                // Clear both auth and the custom session user.
                Auth::logout();
                $this->session->forget('user');

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
