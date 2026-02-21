<?php

namespace Tests\Feature;

use Tests\TestCase;

class DeleteRouteProtectionTest extends TestCase
{
    public function test_delete_user_route_does_not_allow_get_method()
    {
        $encryptedId = encrypt(1);

        $response = $this
            ->withSession([
                'user' => (object) ['role' => 'Admin'],
            ])
            ->get('/master/deleteUser/' . $encryptedId);

        $response->assertStatus(405);
    }

    public function test_delete_user_without_csrf_token_is_blocked()
    {
        // Force CSRF middleware to run as in non-testing env.
        $this->app['env'] = 'local';

        $encryptedId = encrypt(1);

        $response = $this
            ->withSession([
                'user' => (object) ['role' => 'Admin'],
            ])
            ->delete('/master/deleteUser/' . $encryptedId);

        $response->assertStatus(419);
    }

    public function test_delete_user_is_blocked_for_unauthorized_role()
    {
        $encryptedId = encrypt(1);
        $token = 'test-csrf-token';

        $response = $this
            ->withSession([
                '_token' => $token,
                'user' => (object) ['role' => 'Inputer'],
            ])
            ->delete('/master/deleteUser/' . $encryptedId, [
                '_token' => $token,
            ]);

        $response->assertStatus(403);
    }
}
