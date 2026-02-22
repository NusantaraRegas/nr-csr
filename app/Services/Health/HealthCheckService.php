<?php

namespace App\Services\Health;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class HealthCheckService
{
    public function run(array $simulations = []): array
    {
        $checks = [
            'db' => $this->checkDatabase(),
            'queue' => $this->checkQueue(),
            'mail' => $this->checkMail(),
        ];

        $checks = $this->applySimulation($checks, $simulations);
        $status = $this->resolveStatus($checks);
        $timestamp = now()->toIso8601String();

        $this->emitAlert($status, $checks, $timestamp);

        return [
            'status' => $status,
            'checks' => $checks,
            'timestamp' => $timestamp,
            'http_status' => $status === 'unhealthy' ? 503 : 200,
        ];
    }

    private function checkDatabase(): array
    {
        try {
            DB::connection()->getPdo();
            DB::select('SELECT 1');

            return $this->healthy('Database connection reachable.');
        } catch (\Throwable $e) {
            return $this->unhealthy('Database connection failed.', ['exception' => $e->getMessage()]);
        }
    }

    private function checkQueue(): array
    {
        $driver = (string) config('queue.default', 'sync');

        if (in_array($driver, ['sync', 'null'], true)) {
            return $this->degraded("Queue driver `{$driver}` is non-async.");
        }

        if ($driver === 'database') {
            $table = (string) config('queue.connections.database.table', 'jobs');

            if (!Schema::hasTable($table)) {
                return $this->degraded("Queue driver `database` active but table `{$table}` is missing.");
            }

            return $this->healthy('Database queue table is available.');
        }

        if ($driver === 'redis') {
            try {
                app('redis')->connection()->ping();

                return $this->healthy('Redis queue connection reachable.');
            } catch (\Throwable $e) {
                return $this->unhealthy('Redis queue connection failed.', ['exception' => $e->getMessage()]);
            }
        }

        if ($driver === 'sqs') {
            return $this->checkSqsQueue();
        }

        if ($driver === 'beanstalkd') {
            return $this->checkBeanstalkQueue();
        }

        return $this->degraded("Queue driver `{$driver}` health check is not explicitly implemented.");
    }

    private function checkMail(): array
    {
        $driver = (string) config('mail.driver', 'smtp');

        if (in_array($driver, ['array', 'log'], true)) {
            return $this->degraded("Mail driver `{$driver}` is non-delivery.");
        }

        if ($driver === 'smtp') {
            return $this->checkSmtpMail();
        }

        return $this->healthy("Mail driver `{$driver}` configured.");
    }

    private function checkSqsQueue(): array
    {
        $prefix = trim((string) config('queue.connections.sqs.prefix'));
        $queue = trim((string) config('queue.connections.sqs.queue'));

        if (
            $prefix === '' ||
            $queue === '' ||
            strpos($prefix, 'your-account-id') !== false ||
            strpos($queue, 'your-queue-name') !== false
        ) {
            return $this->degraded('SQS queue is configured with placeholder/missing values.');
        }

        $queueUrl = $this->resolveSqsQueueUrl($prefix, $queue);
        if ($queueUrl === '') {
            return $this->degraded('SQS queue URL cannot be resolved from current configuration.');
        }

        if (!$this->isTransportProbeEnabled('sqs')) {
            return $this->healthy('SQS queue configuration is present. Transport probe skipped.', [
                'probe' => 'skipped',
                'queue_url' => $queueUrl,
            ]);
        }

        $probe = $this->probeHttpEndpoint('queue', 'sqs', $queueUrl, 'sqs_http');
        if (!$probe['ok']) {
            return $this->unhealthy('SQS queue reachability probe failed.', [
                'probe' => $probe['probe'],
                'queue_url' => $queueUrl,
                'timeout' => $probe['timed_out'],
                'reason' => $probe['reason'],
                'http_status' => $probe['http_status'],
            ]);
        }

        return $this->healthy('SQS queue endpoint reachable.', [
            'probe' => $probe['probe'],
            'queue_url' => $queueUrl,
            'http_status' => $probe['http_status'],
            'latency_ms' => $probe['latency_ms'],
        ]);
    }

    private function checkBeanstalkQueue(): array
    {
        $host = trim((string) config('queue.connections.beanstalkd.host'));
        $port = (int) config('queue.connections.beanstalkd.port', 11300);

        if ($host === '' || $port <= 0) {
            return $this->degraded('Beanstalkd host/port is not configured.');
        }

        if (!$this->isTransportProbeEnabled('beanstalkd')) {
            return $this->healthy('Beanstalkd queue configuration is present. Transport probe skipped.', [
                'probe' => 'skipped',
                'host' => $host,
                'port' => $port,
            ]);
        }

        $probe = $this->probeTcpEndpoint('queue', 'beanstalkd', $host, $port, 'beanstalk_tcp');
        if (!$probe['ok']) {
            return $this->unhealthy('Beanstalkd socket probe failed.', [
                'probe' => $probe['probe'],
                'host' => $host,
                'port' => $port,
                'timeout' => $probe['timed_out'],
                'reason' => $probe['reason'],
            ]);
        }

        return $this->healthy('Beanstalkd socket reachable.', [
            'probe' => $probe['probe'],
            'host' => $host,
            'port' => $port,
            'latency_ms' => $probe['latency_ms'],
        ]);
    }

    private function checkSmtpMail(): array
    {
        $host = trim((string) config('mail.host'));
        $port = (int) config('mail.port');
        $fromAddress = trim((string) data_get(config('mail.from'), 'address'));
        $username = trim((string) config('mail.username'));
        $password = (string) config('mail.password');
        $encryption = trim((string) config('mail.encryption'));

        if ($host === '' || $port <= 0) {
            return $this->degraded('SMTP mail host/port is not configured.');
        }

        if ($host === 'smtp.mailgun.org' && $fromAddress === 'hello@example.com') {
            return $this->degraded('SMTP mail configuration is still using placeholder defaults.');
        }

        if (($username === '' && $password !== '') || ($username !== '' && $password === '')) {
            return $this->degraded('SMTP auth configuration is incomplete.');
        }

        if (!$this->isTransportProbeEnabled('smtp')) {
            return $this->healthy('SMTP mail configuration is present. Transport probe skipped.', [
                'probe' => 'skipped',
                'host' => $host,
                'port' => $port,
            ]);
        }

        $connectionProbe = $this->probeTcpEndpoint('mail', 'smtp', $host, $port, 'smtp_tcp');
        if (!$connectionProbe['ok']) {
            return $this->unhealthy('SMTP connection probe failed.', [
                'probe' => $connectionProbe['probe'],
                'host' => $host,
                'port' => $port,
                'timeout' => $connectionProbe['timed_out'],
                'reason' => $connectionProbe['reason'],
            ]);
        }

        if ($username !== '') {
            $authProbe = $this->probeSmtpAuthentication($host, $port, $username, $password, $encryption);
            if (!$authProbe['ok']) {
                return $this->unhealthy('SMTP auth probe failed.', [
                    'probe' => $authProbe['probe'],
                    'host' => $host,
                    'port' => $port,
                    'timeout' => $authProbe['timed_out'],
                    'reason' => $authProbe['reason'],
                ]);
            }

            return $this->healthy('SMTP connection/auth probe succeeded.', [
                'probe' => $authProbe['probe'],
                'host' => $host,
                'port' => $port,
                'latency_ms' => $authProbe['latency_ms'],
            ]);
        }

        return $this->healthy('SMTP connection probe succeeded.', [
            'probe' => $connectionProbe['probe'],
            'host' => $host,
            'port' => $port,
            'latency_ms' => $connectionProbe['latency_ms'],
            'auth' => 'not_configured',
        ]);
    }

    private function applySimulation(array $checks, array $simulations): array
    {
        foreach ($simulations as $component => $status) {
            if (!isset($checks[$component])) {
                continue;
            }

            if ($status === 'unhealthy') {
                $checks[$component] = $this->unhealthy('Simulated unhealthy state.');
                continue;
            }

            $checks[$component] = $this->degraded('Simulated degraded state.');
        }

        return $checks;
    }

    private function resolveStatus(array $checks): string
    {
        foreach ($checks as $check) {
            if ($check['status'] === 'unhealthy') {
                return 'unhealthy';
            }
        }

        foreach ($checks as $check) {
            if ($check['status'] === 'degraded') {
                return 'degraded';
            }
        }

        return 'healthy';
    }

    private function emitAlert(string $status, array $checks, string $timestamp): void
    {
        if (!config('health.alerting.enabled', true)) {
            return;
        }

        $channel = config('health.alerting.log_channel', 'stack');
        $context = [
            'status' => $status,
            'checks' => $checks,
            'timestamp' => $timestamp,
        ];

        if ($status === 'unhealthy') {
            Log::channel($channel)->error('health.unhealthy', $context);
            return;
        }

        if ($status === 'degraded') {
            Log::channel($channel)->warning('health.degraded', $context);
        }
    }

    private function isTransportProbeEnabled(string $probe): bool
    {
        return (bool) config("health.probes.{$probe}.enabled", false);
    }

    private function probeTimeoutSeconds(): float
    {
        $timeout = (float) config('health.probes.timeout_seconds', 2.0);

        return $timeout > 0 ? $timeout : 2.0;
    }

    /**
     * @return array<string, mixed>
     */
    private function probeTcpEndpoint(string $component, string $driver, string $host, int $port, string $probe): array
    {
        $timeout = $this->probeTimeoutSeconds();
        $start = microtime(true);
        $errno = 0;
        $errstr = '';
        $socket = @stream_socket_client(
            sprintf('tcp://%s:%d', $host, $port),
            $errno,
            $errstr,
            $timeout,
            STREAM_CLIENT_CONNECT
        );
        $latencyMs = (int) round((microtime(true) - $start) * 1000);

        if ($socket === false) {
            $reason = $errstr !== '' ? $errstr : ('Socket error code ' . $errno);
            $timedOut = $this->isTimeoutMessage($reason);

            $this->emitProbeAlert($timedOut ? 'health.probe.timeout' : 'health.probe.failure', $timedOut ? 'warning' : 'error', [
                'component' => $component,
                'driver' => $driver,
                'probe' => $probe,
                'host' => $host,
                'port' => $port,
                'timeout_seconds' => $timeout,
                'latency_ms' => $latencyMs,
                'reason' => $reason,
            ]);

            return [
                'ok' => false,
                'probe' => $probe,
                'timed_out' => $timedOut,
                'latency_ms' => $latencyMs,
                'reason' => $reason,
                'http_status' => null,
            ];
        }

        fclose($socket);

        return [
            'ok' => true,
            'probe' => $probe,
            'timed_out' => false,
            'latency_ms' => $latencyMs,
            'reason' => null,
            'http_status' => null,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function probeHttpEndpoint(string $component, string $driver, string $url, string $probe): array
    {
        $timeout = $this->probeTimeoutSeconds();
        $start = microtime(true);

        try {
            $response = (new Client([
                'timeout' => $timeout,
                'connect_timeout' => $timeout,
                'http_errors' => false,
            ]))->request('HEAD', $url);

            $statusCode = (int) $response->getStatusCode();
            $latencyMs = (int) round((microtime(true) - $start) * 1000);
            $isReachable = $statusCode >= 200 && $statusCode < 500;

            if (!$isReachable) {
                $reason = 'HTTP status ' . $statusCode;
                $this->emitProbeAlert('health.probe.failure', 'error', [
                    'component' => $component,
                    'driver' => $driver,
                    'probe' => $probe,
                    'url' => $url,
                    'timeout_seconds' => $timeout,
                    'latency_ms' => $latencyMs,
                    'reason' => $reason,
                    'http_status' => $statusCode,
                ]);

                return [
                    'ok' => false,
                    'probe' => $probe,
                    'timed_out' => false,
                    'latency_ms' => $latencyMs,
                    'reason' => $reason,
                    'http_status' => $statusCode,
                ];
            }

            return [
                'ok' => true,
                'probe' => $probe,
                'timed_out' => false,
                'latency_ms' => $latencyMs,
                'reason' => null,
                'http_status' => $statusCode,
            ];
        } catch (\Throwable $e) {
            $latencyMs = (int) round((microtime(true) - $start) * 1000);
            $reason = $e->getMessage();
            $timedOut = $this->isTimeoutMessage($reason);

            $this->emitProbeAlert($timedOut ? 'health.probe.timeout' : 'health.probe.failure', $timedOut ? 'warning' : 'error', [
                'component' => $component,
                'driver' => $driver,
                'probe' => $probe,
                'url' => $url,
                'timeout_seconds' => $timeout,
                'latency_ms' => $latencyMs,
                'reason' => $reason,
            ]);

            return [
                'ok' => false,
                'probe' => $probe,
                'timed_out' => $timedOut,
                'latency_ms' => $latencyMs,
                'reason' => $reason,
                'http_status' => null,
            ];
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function probeSmtpAuthentication(
        string $host,
        int $port,
        string $username,
        string $password,
        string $encryption
    ): array {
        $timeout = $this->probeTimeoutSeconds();
        $swiftTimeout = max(1, (int) ceil($timeout));
        $start = microtime(true);

        try {
            $transport = new \Swift_SmtpTransport($host, $port, $encryption !== '' ? $encryption : null);
            $transport->setTimeout($swiftTimeout);
            $transport->setUsername($username);
            $transport->setPassword($password);
            $transport->start();
            $transport->stop();

            return [
                'ok' => true,
                'probe' => 'smtp_auth',
                'timed_out' => false,
                'latency_ms' => (int) round((microtime(true) - $start) * 1000),
                'reason' => null,
            ];
        } catch (\Throwable $e) {
            $latencyMs = (int) round((microtime(true) - $start) * 1000);
            $reason = $e->getMessage();
            $timedOut = $this->isTimeoutMessage($reason);

            $this->emitProbeAlert($timedOut ? 'health.probe.timeout' : 'health.probe.failure', $timedOut ? 'warning' : 'error', [
                'component' => 'mail',
                'driver' => 'smtp',
                'probe' => 'smtp_auth',
                'host' => $host,
                'port' => $port,
                'timeout_seconds' => $swiftTimeout,
                'latency_ms' => $latencyMs,
                'reason' => $reason,
            ]);

            return [
                'ok' => false,
                'probe' => 'smtp_auth',
                'timed_out' => $timedOut,
                'latency_ms' => $latencyMs,
                'reason' => $reason,
            ];
        }
    }

    private function resolveSqsQueueUrl(string $prefix, string $queue): string
    {
        if (preg_match('/^https?:\\/\\//i', $queue)) {
            return $queue;
        }

        if (!preg_match('/^https?:\\/\\//i', $prefix)) {
            return '';
        }

        return rtrim($prefix, '/') . '/' . ltrim($queue, '/');
    }

    private function isTimeoutMessage(string $message): bool
    {
        return stripos($message, 'timed out') !== false;
    }

    private function emitProbeAlert(string $event, string $level, array $context): void
    {
        if (!config('health.alerting.enabled', true)) {
            return;
        }

        $channel = config('health.alerting.log_channel', 'stack');

        if ($level === 'error') {
            Log::channel($channel)->error($event, $context);
            return;
        }

        Log::channel($channel)->warning($event, $context);
    }

    private function healthy(string $message, array $meta = []): array
    {
        return [
            'status' => 'healthy',
            'message' => $message,
            'meta' => (object) $meta,
        ];
    }

    private function degraded(string $message, array $meta = []): array
    {
        return [
            'status' => 'degraded',
            'message' => $message,
            'meta' => (object) $meta,
        ];
    }

    private function unhealthy(string $message, array $meta = []): array
    {
        return [
            'status' => 'unhealthy',
            'message' => $message,
            'meta' => (object) $meta,
        ];
    }
}
