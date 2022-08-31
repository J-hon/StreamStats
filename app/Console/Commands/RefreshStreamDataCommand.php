<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RefreshStreamDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stream:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the streams data every 15 minutes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call('db:seed --class=StreamSeeder');
        $this->info('Stream refreshed');

        return 0;
    }
}
