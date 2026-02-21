<?php

namespace Tests\Feature;

use App\Http\Middleware\OnlyAdmin;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class AuthStateConsistencyTest extends TestCase
{
    public function test_login_page_redirects_when_session_user_exists()
    {
        $response = $this
            ->withSession([
                'user' => $this->sessionUser('Admin'),
            ])
            ->get('/auth/login');

        $response->assertRedirect('/dashboard');
    }

    public function test_logout_clears_session_user()
    {
        $response = $this
            ->withSession([
                'user' => $this->sessionUser('Admin'),
            ])
            ->get('/auth/logout');

        $response->assertRedirect('/auth/login');
        $response->assertSessionMissing('user');
    }

    public function test_credential_login_redirects_when_no_session_user()
    {
        $response = $this->post('/dashboard/postDashboardAnnual', [
            'tahun' => '2025',
        ]);

        $response->assertRedirect('/auth/login');
        $response->assertSessionHas('credential');
    }

    public function test_credential_login_allows_when_session_user_exists()
    {
        $response = $this
            ->withSession([
                'user' => $this->sessionUser('Admin'),
            ])
            ->post('/dashboard/postDashboardAnnual', [
                'tahun' => '2025',
            ]);

        $response->assertStatus(302);
        $this->assertStringContainsString('/dashboard/dashboardAnnual/', $response->headers->get('Location'));
    }

    public function test_session_timeout_redirects_and_clears_user()
    {
        config(['session.lifetime_timeout' => 1]);

        $response = $this
            ->withSession([
                'user' => $this->sessionUser('Admin'),
                'lastActivityTime' => now()->subSeconds(120)->timestamp,
            ])
            ->post('/dashboard/postDashboardAnnual', [
                'tahun' => '2025',
            ]);

        $response->assertRedirect('/auth/login');
        $response->assertSessionMissing('user');
        $response->assertSessionHas('session');
    }

    public function test_session_timeout_keeps_active_session()
    {
        config(['session.lifetime_timeout' => 1800]);

        $response = $this
            ->withSession([
                'user' => $this->sessionUser('Admin'),
                'lastActivityTime' => now()->timestamp,
            ])
            ->post('/dashboard/postDashboardAnnual', [
                'tahun' => '2025',
            ]);

        $response->assertStatus(302);
        $this->assertStringContainsString('/dashboard/dashboardAnnual/', $response->headers->get('Location'));
    }

    public function test_only_admin_middleware_allows_admin_role()
    {
        $request = Request::create('/dummy-admin', 'GET');
        $request->setLaravelSession($this->app['session.store']);
        $this->app['session.store']->put('user', $this->sessionUser('Admin'));

        $middleware = $this->app->make(OnlyAdmin::class);

        $response = $middleware->handle($request, function () {
            return response('ok', 200);
        });

        $this->assertSame(200, $response->getStatusCode());
    }

    public function test_only_admin_middleware_blocks_non_admin_role()
    {
        $request = Request::create('/dummy-admin', 'GET');
        $request->setLaravelSession($this->app['session.store']);
        $this->app['session.store']->put('user', $this->sessionUser('Manager'));

        $middleware = $this->app->make(OnlyAdmin::class);

        try {
            $middleware->handle($request, function () {
                return response('ok', 200);
            });
            $this->fail('Expected middleware to abort with 403');
        } catch (HttpException $e) {
            $this->assertSame(403, $e->getStatusCode());
        }
    }

    private function sessionUser($role)
    {
        return (object) [
            'role' => $role,
            'username' => 'tester',
            'id_perusahaan' => 1,
            'perusahaan' => 'PT Nusantara Regas',
        ];
    }
}
