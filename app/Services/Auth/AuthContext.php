<?php

namespace App\Services\Auth;

use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;

class AuthContext
{
    const SESSION_USER_KEY = 'user';

    /**
     * @var Session
     */
    protected $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @return object|null
     */
    public function user()
    {
        $user = $this->session->get(self::SESSION_USER_KEY);

        if (is_array($user)) {
            return (object) $user;
        }

        return $user;
    }

    /**
     * @return bool
     */
    public function hasUser()
    {
        return !empty($this->user());
    }

    /**
     * @return bool
     */
    public function isAuthenticated()
    {
        return Auth::check() || $this->hasUser();
    }

    /**
     * @param mixed $user
     * @return void
     */
    public function setUser($user)
    {
        $this->session->put(self::SESSION_USER_KEY, $user);
    }

    /**
     * @return void
     */
    public function clearUser()
    {
        $this->session->forget(self::SESSION_USER_KEY);
    }

    /**
     * @return string|null
     */
    public function role()
    {
        $user = $this->user();

        return $user->role ?? null;
    }

    /**
     * @param array $roles
     * @return bool
     */
    public function hasAnyRole(array $roles)
    {
        $role = $this->role();

        if ($role === null) {
            return false;
        }

        return in_array($role, $roles, true);
    }

    /**
     * @return string|null
     */
    public function username()
    {
        $user = $this->user();

        return $user->username ?? null;
    }

    /**
     * @return mixed
     */
    public function perusahaanId()
    {
        $user = $this->user();

        return $user->id_perusahaan ?? null;
    }

    /**
     * @return string|null
     */
    public function perusahaan()
    {
        $user = $this->user();

        return $user->perusahaan ?? null;
    }

    /**
     * @return void
     */
    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }

        $this->clearUser();
    }
}
