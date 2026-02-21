<?php

namespace App\Services\Health;

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
            $prefix = (string) config('queue.connections.sqs.prefix');
            $queue = (string) config('queue.connections.sqs.queue');

            if (
                $prefix === '' ||
                $queue === '' ||
                strpos($prefix, 'your-account-id') !== false ||
                strpos($queue, 'your-queue-name') !== false
            ) {
                return $this->degraded('SQS queue is configured with placeholder/missing values.');
            }

            return $this->healthy('SQS queue configuration is present.');
        }

        if ($driver === 'beanstalkd') {
            $host = (string) config('queue.connections.beanstalkd.host');

            if ($host === '') {
                return $this->degraded('Beanstalkd host is not configured.');
            }

            return $this->healthy('Beanstalkd queue configuration is present.');
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
            $host = (string) config('mail.host');
            $port = (string) config('mail.port');
            $fromAddress = (string) data_get(config('mail.from'), 'address');

            if ($host === '' || $port === '') {
                return $this->degraded('SMTP mail host/port is not configured.');
            }

            if ($host === 'smtp.mailgun.org' && $fromAddress === 'hello@example.com') {
                return $this->degraded('SMTP mail configuration is still using placeholder defaults.');
            }

            return $this->healthy('SMTP mail configuration is present.');
        }

        return $this->healthy("Mail driver `{$driver}` configured.");
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
