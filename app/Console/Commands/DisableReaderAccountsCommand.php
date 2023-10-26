<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ReaderController;

class DisableReaderAccountsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'readers:disable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable reader accounts';

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
        $readerController = new ReaderController();
        $readerController->disableReader();
    }
}
