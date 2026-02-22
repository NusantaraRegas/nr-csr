<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestCommand extends Command
{
    protected $signature = 'test {--filter=}';
    protected $description = 'Run the PHPUnit test suite';

    public function handle()
    {
        $binary = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'
            ? 'php -d extension=pdo_sqlite -d extension=sqlite3 vendor/bin/phpunit'
            : 'vendor/bin/phpunit';

        $command = $binary;
        if ($this->option('filter')) {
            $command .= ' --filter=' . escapeshellarg($this->option('filter'));
        }

        passthru($command, $exitCode);

        return $exitCode;
    }
}
