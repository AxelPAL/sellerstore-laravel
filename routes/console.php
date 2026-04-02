<?php

use App\Console\Commands\ParseHomePage;
use App\Console\Commands\ParseSidebar;
use App\Console\Commands\ParseStatistics;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(ParseHomePage::class)->everyTwoHours();
Schedule::command(ParseSidebar::class)->everySixHours();
Schedule::command(ParseStatistics::class)->twiceDaily();
