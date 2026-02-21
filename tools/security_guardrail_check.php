<?php

/**
 * Lightweight hardcoded-secret guardrail.
 *
 * Intended usage (local/CI):
 *   php tools/security_guardrail_check.php
 */

declare(strict_types=1);

$output = [];
$code = 0;
exec('git ls-files', $output, $code);

if ($code !== 0) {
    fwrite(STDERR, "Failed to enumerate tracked files with git ls-files\n");
    exit(2);
}

$excludedPrefixes = [
    'vendor/',
    'node_modules/',
    'storage/',
    'bootstrap/cache/',
    'docs/',
];

$excludedFiles = [
    'tools/security_guardrail_check.php',
];

$patterns = [
    [
        'name' => 'literal StrongPass123',
        'regex' => '/StrongPass123/i',
    ],
    [
        'name' => 'literal corp.NR',
        'regex' => '/corp\.NR/i',
    ],
    [
        'name' => 'hardcoded PASSWORD assignment',
        // Match only uppercase PASSWORD-like keys in env/yaml/shell style assignments.
        // Skip env-var references (${...}), empty values, and explicit placeholders.
        'regex' => '/^\s*(?:export\s+)?(?:DB_PASSWORD|POSTGRES_PASSWORD|DEFAULT_USER_PASSWORD|PASSWORD)\s*[:=]\s*+(?!\$\{?[A-Z0-9_]+\}?)(?!["\']?(?:change_me|your_|example|placeholder)\b)(?!["\']?\s*$).+$/',
    ],
];

$violations = [];

foreach ($output as $file) {
    $skip = false;
    foreach ($excludedPrefixes as $prefix) {
        if (strpos($file, $prefix) === 0) {
            $skip = true;
            break;
        }
    }

    if (in_array($file, $excludedFiles, true)) {
        continue;
    }

    if ($skip || !is_file($file)) {
        continue;
    }

    $content = @file($file, FILE_IGNORE_NEW_LINES);
    if ($content === false) {
        continue;
    }

    foreach ($content as $lineNumber => $line) {
        foreach ($patterns as $pattern) {
            if (preg_match($pattern['regex'], $line) === 1) {
                $violations[] = sprintf(
                    '%s:%d [%s] %s',
                    $file,
                    $lineNumber + 1,
                    $pattern['name'],
                    trim($line)
                );
            }
        }
    }
}

if (!empty($violations)) {
    fwrite(STDERR, "Hardcoded-secret guardrail failed. Potential issues found:\n");
    foreach ($violations as $violation) {
        fwrite(STDERR, ' - ' . $violation . "\n");
    }
    exit(1);
}

fwrite(STDOUT, "Hardcoded-secret guardrail passed (no obvious literals found).\n");
exit(0);
