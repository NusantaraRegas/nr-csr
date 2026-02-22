<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

    public function test_health_endpoint_reports_degraded_for_sqs_placeholder_configuration()
    {
        config()->set('queue.default', 'sqs');
        config()->set('queue.connections.sqs.prefix', 'https://sqs.us-east-1.amazonaws.com/your-account-id');
        config()->set('queue.connections.sqs.queue', 'your-queue-name');

        $response = $this->getJson('/api/health');

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('data.status', 'degraded');
        $response->assertJsonPath('data.checks.queue.status', 'degraded');
    }

    public function test_health_endpoint_reports_unhealthy_for_sqs_transport_probe_failure()
    {
        config()->set('queue.default', 'sqs');
        config()->set('queue.connections.sqs.prefix', 'http://127.0.0.1:1');
        config()->set('queue.connections.sqs.queue', 'health-probe-queue');
        config()->set('health.probes.timeout_seconds', 0.2);
        config()->set('health.probes.sqs.enabled', true);

        $response = $this->getJson('/api/health');

        $response->assertStatus(503);
        $response->assertJsonPath('success', false);
        $response->assertJsonPath('errors.health.status', 'unhealthy');
        $response->assertJsonPath('errors.health.checks.queue.status', 'unhealthy');
        $response->assertJsonPath('errors.health.checks.queue.meta.probe', 'sqs_http');
    }

    public function test_health_endpoint_reports_healthy_for_beanstalk_transport_probe_when_socket_is_reachable()
    {
        list($server, $host, $port) = $this->openTcpServer();
        config()->set('queue.default', 'beanstalkd');
        config()->set('queue.connections.beanstalkd.host', $host);
        config()->set('queue.connections.beanstalkd.port', $port);
        config()->set('health.probes.timeout_seconds', 1);
        config()->set('health.probes.beanstalkd.enabled', true);

        try {
            $response = $this->getJson('/api/health');
        } finally {
            fclose($server);
        }

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('data.checks.queue.status', 'healthy');
        $response->assertJsonPath('data.checks.queue.meta.probe', 'beanstalk_tcp');
    }

    public function test_health_endpoint_reports_unhealthy_for_beanstalk_transport_probe_failure()
    {
        config()->set('queue.default', 'beanstalkd');
        config()->set('queue.connections.beanstalkd.host', '127.0.0.1');
        config()->set('queue.connections.beanstalkd.port', 1);
        config()->set('health.probes.timeout_seconds', 0.2);
        config()->set('health.probes.beanstalkd.enabled', true);

        $response = $this->getJson('/api/health');

        $response->assertStatus(503);
        $response->assertJsonPath('success', false);
        $response->assertJsonPath('errors.health.checks.queue.status', 'unhealthy');
        $response->assertJsonPath('errors.health.checks.queue.meta.probe', 'beanstalk_tcp');
    }

    public function test_health_endpoint_reports_healthy_for_smtp_transport_probe_when_socket_is_reachable()
    {
        list($server, $host, $port) = $this->openTcpServer();
        config()->set('queue.default', 'database');
        config()->set('mail.driver', 'smtp');
        config()->set('mail.host', $host);
        config()->set('mail.port', $port);
        config()->set('mail.username', '');
        config()->set('mail.password', '');
        config()->set('health.probes.timeout_seconds', 1);
        config()->set('health.probes.smtp.enabled', true);

        try {
            $response = $this->getJson('/api/health');
        } finally {
            fclose($server);
        }

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('data.checks.mail.status', 'healthy');
        $response->assertJsonPath('data.checks.mail.meta.probe', 'smtp_tcp');
    }

    public function test_health_endpoint_reports_degraded_for_incomplete_smtp_auth_configuration()
    {
        config()->set('mail.driver', 'smtp');
        config()->set('mail.host', 'smtp.internal.test');
        config()->set('mail.port', 587);
        config()->set('mail.username', 'smtp-user');
        config()->set('mail.password', '');
        config()->set('health.probes.smtp.enabled', true);

        $response = $this->getJson('/api/health');

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('data.status', 'degraded');
        $response->assertJsonPath('data.checks.mail.status', 'degraded');
    }

    public function test_health_endpoint_reports_unhealthy_for_smtp_transport_probe_failure()
    {
        config()->set('mail.driver', 'smtp');
        config()->set('mail.host', '127.0.0.1');
        config()->set('mail.port', 1);
        config()->set('mail.username', '');
        config()->set('mail.password', '');
        config()->set('health.probes.timeout_seconds', 0.2);
        config()->set('health.probes.smtp.enabled', true);

        $response = $this->getJson('/api/health');

        $response->assertStatus(503);
        $response->assertJsonPath('success', false);
        $response->assertJsonPath('errors.health.checks.mail.status', 'unhealthy');
        $response->assertJsonPath('errors.health.checks.mail.meta.probe', 'smtp_tcp');
    }

    public function test_health_transport_probe_failure_emits_structured_alert_logs()
    {
        config()->set('health.alerting.enabled', true);
        config()->set('health.alerting.log_channel', 'stack');
        config()->set('mail.driver', 'smtp');
        config()->set('mail.host', '127.0.0.1');
        config()->set('mail.port', 1);
        config()->set('mail.username', '');
        config()->set('mail.password', '');
        config()->set('health.probes.timeout_seconds', 0.2);
        config()->set('health.probes.smtp.enabled', true);

        Log::shouldReceive('channel')->with('stack')->andReturnSelf()->atLeast()->once();
        Log::shouldReceive('error')->withArgs(function ($event, array $context) {
            return $event === 'health.probe.failure'
                && data_get($context, 'component') === 'mail'
                && data_get($context, 'driver') === 'smtp'
                && data_get($context, 'probe') === 'smtp_tcp';
        })->once();
        Log::shouldReceive('error')->withArgs(function ($event, array $context) {
            return $event === 'health.unhealthy'
                && data_get($context, 'status') === 'unhealthy'
                && data_get($context, 'checks.mail.status') === 'unhealthy';
        })->once();

        $response = $this->getJson('/api/health');

        $response->assertStatus(503);
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

    private function openTcpServer()
    {
        $errno = 0;
        $errstr = '';
        $server = stream_socket_server('tcp://127.0.0.1:0', $errno, $errstr);
        $this->assertNotFalse($server, 'Unable to start local TCP test server: ' . $errstr);

        $address = (string) stream_socket_get_name($server, false);
        $parts = explode(':', $address);
        $host = $parts[0];
        $port = (int) $parts[1];

        return [$server, $host, $port];
    }
}
