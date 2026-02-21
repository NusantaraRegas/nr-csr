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
];
