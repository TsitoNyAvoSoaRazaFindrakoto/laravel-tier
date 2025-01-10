<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ServeWithCrypto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serve:with-crypto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Serve the application and run the crypto:run command simultaneously';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Starting the Laravel development server...');
        $serveProcess = new Process(['php', 'artisan', 'serve']);
        $serveProcess->start();

        $this->info('Starting the crypto:run command...');
        $cryptoProcess = new Process(['php', 'artisan', 'crypto:run']);
        $cryptoProcess->start();

        // Monitor both processes
        while ($serveProcess->isRunning() && $cryptoProcess->isRunning()) {
            usleep(500000); // Wait for 500ms
        }

        // Check if any process stopped
        if (!$serveProcess->isRunning()) {
            $this->error('Laravel server stopped unexpectedly.');
            $cryptoProcess->stop();
        } elseif (!$cryptoProcess->isRunning()) {
            $this->error('crypto:run command stopped unexpectedly.');
            $serveProcess->stop();
        }
    }
}
