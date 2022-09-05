<?php

namespace App\Console\Commands;

use Database\Seeders\StreamSeeder;
use Illuminate\Console\Command;

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
    protected $description = 'Refresh the top 1000 streams every 15 minutes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call(StreamSeeder::class);
        $this->info('Stream refreshed');

        return 0;
    }
}
