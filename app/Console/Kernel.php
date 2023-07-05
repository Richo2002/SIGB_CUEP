<?php

namespace App\Console;

use App\Http\Controllers\LoanController;
use App\Http\Controllers\ReaderController;
use Illuminate\Console\Scheduling\Schedule;
use App\Http\Controllers\ReservationController;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {

            $readerController = new ReaderController();
            $readerController->disableReader();

            $loanController = new LoanController();
            $loanController->manageDelays();

            $reservationController = new ReservationController();
            $reservationController->manageDelays();
        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
