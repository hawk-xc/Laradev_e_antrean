<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use \App\Models\Proces as ProcesModel;
use \App\Models\Ticket as TicketModel;
use \App\Models\Notification as NotificationModel;

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
            if (ProcesModel::whereIn('ticket_id', $overdue->pluck('id'))->where('status_id', '!=', 5)->count()) {
                ProcesModel::whereIn('ticket_id', $overdue->pluck('id'))->where('status_id', '!=', 4)->update(['status_id' => 5]);

                $userLists = \App\Models\Device::whereIn('id', \App\Models\Ticket::whereIn('id', \App\Models\Proces::whereIn('ticket_id', \App\Models\Ticket::where('closed_at', '<', now())->pluck('id'))->pluck('ticket_id'))->pluck('device_id'))->pluck('user_id');

                $blueprint_message = "<p>Hallo User</p><br><p>Terima kasih atas kesabaran dan pengertian Anda selama kami menangani permintaan perbaikan Anda.</p><br><p>Kami ingin menginformasikan bahwa untuk saat ini, proses perbaikan mengalami kegagalan karena <b>ditolak oleh team atau dibatalkan oleh pengguna</b></p><br><p>Kami mohon maaf atas ketidaknyamanan yang ditimbulkan. Tim kami sedang bekerja keras untuk menyelesaikan masalah ini secepat mungkin. Kami akan segera menghubungi Anda begitu perbaikan telah berhasil dilakukan.</p><br><p>Apabila Anda memiliki pertanyaan lebih lanjut atau memerlukan bantuan lainnya, jangan ragu untuk menghubungi kami melalui virtual chat ini.</p><br><p>Terima kasih atas pengertian dan kerjasamanya.</p><br><p>Salam hormat, Fitri</p><br><p>Helpdesk E-Service</p>";

                foreach ($userLists as $user) {
                    NotificationModel::create(
                        [
                            'user_id' => $user,
                            'message' => $blueprint_message,
                            'is_read' => 0,
                            'is_user' => 0
                        ]
                    );
                }
            }
        })->everyTenSeconds();

        $schedule->command('queue:work')->everyMinute();
    }

    /**
     * Register the commands for the application.SS
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
