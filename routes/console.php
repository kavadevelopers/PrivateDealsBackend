<?php

use Illuminate\Support\Facades\Schedule;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();

// Schedule::command('queue:work')->everySecond();


// Schedule::command('db:backup')->everySecond();

// Schedule::command('backup:clean')->daily()->at('01:00');
// Schedule::command('backup:run')->daily()->at('01:30');
// Schedule::command('backup:clean')->everySecond();
// Schedule::command('backup:run')->everyMinute();


// Schedule::command('backup:clean')->everyMinute();
// Schedule::command('backup:monitor')->daily()->at('03:00');

Schedule::command('telescope:prune')->daily();
Schedule::command('backup:run --only-db')->daily();
// Schedule::command('preipo:auto-cancel')->everyMinute();
// timer scheduler
// Schedule::command('preipo:admin-pending-reminder')->everyFifteenMinutes();
// Schedule::command('preipo:investor-deadline-reminder')->everyFiveMinutes();
// Schedule::command('preipo:investor-morning-deadline-reminder')->dailyAt('10:00');





// Schedule::command('preipo:share-transfer-escalation')->everyFifteenMinutes();
// 
Schedule::command('send:renewal-reminder')->dailyAt('11:00');
Schedule::command('reminder:private-equity-share-price-update')
    ->dailyAt('10:30')
    ->when(function () {
        return !in_array(now()->dayOfWeek, [6, 0]); // 6 = Saturday, 0 = Sunday
    });



Schedule::command('app:dispatch-whats-app-messages')->everyTwoMinutes();
Schedule::command('app:dispatch-push-notifications')->everyTwoMinutes();
Schedule::command('app:company-share-price-update-today-change')->dailyAt('17:00');
Schedule::command('app:company-share-price-data-update')->dailyAt('10:30');
// Schedule::command('import:supported-countries')->dailyAt('02:00');

Schedule::command('app:dispatch-preipo-transaction-reminder-message')->dailyAt('11:30');

Schedule::command('app:send-pending-kyc-reminders')->hourly();

Schedule::command('calendly:sync')->everyMinute();
