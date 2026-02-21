<?php

$finder = PhpCsFixer\Finder::create()
    ->append([
        __DIR__ . '/app/Exceptions/Handler.php',
        __DIR__ . '/app/Http/Controllers/LampiranController.php',
        __DIR__ . '/app/Http/Controllers/TasklistController.php',
        __DIR__ . '/app/Services/Auth/AuthContext.php',
        __DIR__ . '/tests/Feature/AuthStateConsistencyTest.php',
        __DIR__ . '/tests/Feature/PriorityTwoCriticalPathTransitionsTest.php',
    ]);

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(false)
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'binary_operator_spaces' => ['default' => 'single_space'],
        'single_quote' => true,
        'trailing_comma_in_multiline_array' => true,
    ])
    ->setFinder($finder);
