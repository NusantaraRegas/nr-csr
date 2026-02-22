<?php

return [
    'allow_simulation' => env('HEALTH_ALLOW_SIMULATION', false),

    'auth' => [
        'token' => env('HEALTH_CHECK_TOKEN'),
    ],

    'alerting' => [
        'enabled' => env('HEALTH_ALERTING_ENABLED', true),
        'log_channel' => env('HEALTH_ALERT_LOG_CHANNEL', env('LOG_CHANNEL', 'stack')),
    ],

    'probes' => [
        'timeout_seconds' => (float) env('HEALTH_PROBE_TIMEOUT_SECONDS', 2),
        'timeout_min_seconds' => (float) env('HEALTH_PROBE_TIMEOUT_MIN_SECONDS', 0.2),
        'timeout_max_seconds' => (float) env('HEALTH_PROBE_TIMEOUT_MAX_SECONDS', 5),
        'allow_non_production' => env('HEALTH_PROBE_ALLOW_NON_PRODUCTION', false),
        'allow_in_ci' => env('HEALTH_PROBE_ALLOW_IN_CI', false),
        'allowed_environments' => array_values(array_filter(array_map('trim', explode(
            ',',
            (string) env('HEALTH_PROBE_ALLOWED_ENVIRONMENTS', 'production')
        )))),
        'smtp' => [
            'enabled' => env('HEALTH_SMTP_TRANSPORT_PROBE', false),
        ],
        'sqs' => [
            'enabled' => env('HEALTH_SQS_TRANSPORT_PROBE', false),
        ],
        'beanstalkd' => [
            'enabled' => env('HEALTH_BEANSTALK_TRANSPORT_PROBE', false),
        ],
    ],
];
