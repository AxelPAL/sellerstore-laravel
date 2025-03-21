<?php

namespace App\Console;

use App\Console\Commands\ParseHomePage;
use App\Console\Commands\ParseSidebar;
use App\Console\Commands\ParseStatistics;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(ParseHomePage::class)->everyTwoHours();
        $schedule->command(ParseSidebar::class)->everySixHours();
        $schedule->command(ParseStatistics::class)->twiceDaily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
