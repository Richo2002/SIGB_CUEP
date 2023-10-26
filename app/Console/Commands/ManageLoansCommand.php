<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ReaderController;

class ManageLoansCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loans:manage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'manage loans';

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
        $loanController = new LoanController();
        $loanController->manageDelays();

        $readerController = new ReaderController();
        $readerController->sendNotificationToLateReader();

        $groupController = new GroupController();
        $groupController->sendNotificationToLateGroupMembers();
    }
}
