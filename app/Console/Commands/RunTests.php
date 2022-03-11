<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RunTests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:tests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to run tests with flag --env=testing';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('config:clear', [
            '--env' => 'testing'
        ]);
        $this->call('test');

        return 0;
    }
}
