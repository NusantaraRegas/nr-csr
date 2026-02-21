<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class HealthCheckEndpointsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->useSqliteInMemory();
        $this->prepareHealthTables();

        config()->set('health.allow_simulation', true);
        config()->set('health.alerting.enabled', false);
        config()->set('queue.default', 'database');
        config()->set('mail.driver', 'smtp');
        config()->set('mail.host', 'smtp.internal.test');
        config()->set('mail.port', 587);
        config()->set('mail.from.address', 'noreply@example.test');
    }

    public function test_health_endpoint_reports_healthy_when_dependencies_are_available()
    {
        $response = $this->getJson('/api/health');

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('data.status', 'healthy');
        $response->assertJsonPath('data.checks.db.status', 'healthy');
        $response->assertJsonPath('data.checks.queue.status', 'healthy');
    }

    public function test_health_endpoint_supports_degraded_simulation()
    {
        $response = $this->getJson('/api/health?simulate=queue');

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('data.status', 'degraded');
        $response->assertJsonPath('data.checks.queue.status', 'degraded');
    }

    public function test_health_endpoint_supports_unhealthy_simulation()
    {
        $response = $this->getJson('/api/health?simulate=db:unhealthy');

        $response->assertStatus(503);
        $response->assertJsonPath('success', false);
        $response->assertJsonPath('meta.code', 'HEALTH_UNHEALTHY');
        $response->assertJsonPath('errors.health.status', 'unhealthy');
        $response->assertJsonPath('errors.health.checks.db.status', 'unhealthy');
    }

    private function useSqliteInMemory()
    {
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', ':memory:');

        DB::purge('sqlite');
        DB::reconnect('sqlite');
    }

    private function prepareHealthTables()
    {
        Schema::dropIfExists('jobs');

        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue')->nullable();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });
    }
}
