<?php

namespace App\Console;

use App\Transaction;
use App\Payutc\Payutc;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            /*
            // Récupère les transactions dépassées encore en attente // TODO
            $outdated = Transaction::outdated()->get();
            foreach ($outdated as $trans) {
                $transPayutc = Payutc::checkTransaction($trans->id);

                $trans->etat = $transPayutc->status;    // Maj des état
                // Encore en attente
                if ($trans->etat == 'W') {
                    $data = Payutc::cancelTransaction($trans->id);          // Annulation de la transaction
                    dd($data);
                }


                $trans->save();
            }
            */
        })->everyMinute();
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
