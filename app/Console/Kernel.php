<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use \App\Models\Proces as ProcesModel;
use \App\Models\Ticket as TicketModel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            $overdue = TicketModel::where('closed_at', '<', now());
            ProcesModel::whereIn('ticket_id', $overdue->pluck('id'))->update(['status_id' => 5]);
        })->everyTenSeconds();

        $schedule->command('queue:work')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
