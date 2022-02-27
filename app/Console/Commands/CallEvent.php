<?php

namespace App\Console\Commands;

use App\Events\CountryChat;
use Illuminate\Console\Command;

class CallEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'call:event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

        broadcast(new CountryChat(date('Y-m-d h:i:s A').": BIG NEWS!"));


        return 0;
    }
}
