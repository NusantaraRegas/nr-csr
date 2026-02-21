<?php

namespace App\Http\Controllers;

use App\Services\Health\HealthCheckService;
use App\Support\ApiResponse;
use Illuminate\Http\Request;

class HealthController extends Controller
{
    public function show(Request $request, HealthCheckService $service)
    {
        $result = $service->run($this->simulationMap($request));

        return $this->toResponse($result);
    }

    public function dependencies(Request $request, HealthCheckService $service)
    {
        $result = $service->run($this->simulationMap($request));

        return $this->toResponse($result);
    }

    private function toResponse(array $result)
    {
        $data = [
            'status' => $result['status'],
            'checks' => $result['checks'],
            'timestamp' => $result['timestamp'],
        ];

        if ($result['status'] === 'unhealthy') {
            return ApiResponse::error(
                'Health check menemukan dependency tidak sehat.',
                503,
                'HEALTH_UNHEALTHY',
                ['health' => $data]
            );
        }

        return ApiResponse::success(
            $data,
            'Health check selesai.',
            $result['http_status'],
            ['overall_status' => $result['status']]
        );
    }

    private function simulationMap(Request $request): array
    {
        if (!config('health.allow_simulation', false)) {
            return [];
        }

        $raw = (string) $request->query('simulate', '');
        if ($raw === '') {
            return [];
        }

        $simulations = [];
        $tokens = array_filter(array_map('trim', explode(',', $raw)));

        foreach ($tokens as $token) {
            $parts = array_map('trim', explode(':', $token, 2));
            $component = strtolower($parts[0]);
            $status = strtolower($parts[1] ?? 'degraded');

            if (!in_array($component, ['db', 'queue', 'mail'], true)) {
                continue;
            }

            if (!in_array($status, ['degraded', 'unhealthy', 'down'], true)) {
                $status = 'degraded';
            }

            if ($status === 'down') {
                $status = 'unhealthy';
            }

            $simulations[$component] = $status;
        }

        return $simulations;
    }
}
