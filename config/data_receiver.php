<?php

return [
    'legacy_options' => [
        // phase1: endpoint enabled with deprecation telemetry
        // phase2: endpoint disabled with deterministic API error response
        'phase' => env('LEGACY_DATA_RECEIVER_OPTIONS_PHASE', 'phase1'),
        'enabled' => env('LEGACY_DATA_RECEIVER_OPTIONS_ENABLED', true),
        'disabled_status' => (int) env('LEGACY_DATA_RECEIVER_OPTIONS_DISABLED_STATUS', 410),
        'log_channel' => env('LEGACY_DATA_RECEIVER_OPTIONS_LOG_CHANNEL', env('LOG_CHANNEL', 'stack')),
        'sunset_date' => env('LEGACY_DATA_RECEIVER_OPTIONS_SUNSET_DATE'),
    ],
];
