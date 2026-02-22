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
