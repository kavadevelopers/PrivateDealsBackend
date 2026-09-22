<?php

namespace App\Providers;

use App\Helpers\AdminHelper;
use App\Models\UserAdminModel;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    /**
     * Register any application services.
     */


    // public function register()
    // {
    //     if ($this->app->environment('local')) {
    //         return;
    //     }

    //     $this->app->register(TelescopeServiceProvider::class);
    // }

    public function register(): void
    {
        Telescope::night();
        $this->hideSensitiveRequestDetails();
        $isLocal = true;
        // Log::debug($isLocal);
        Telescope::filter(function (IncomingEntry $entry) use ($isLocal) {
            return $isLocal ||
                $entry->isReportableException() ||
                $entry->isFailedRequest() ||
                $entry->isFailedJob() ||
                $entry->isScheduledTask() ||
                $entry->hasMonitoredTag();
        });
    }

    /**
     * Prevent sensitive request details from being logged by Telescope.
     */
    protected function hideSensitiveRequestDetails(): void
    {
        if ($this->app->environment('local')) {
            return;
        }

        Telescope::hideRequestParameters(['_token']);

        Telescope::hideRequestHeaders([
            'cookie',
            'x-csrf-token',
            'x-xsrf-token',
        ]);
    }

    /**
     * Register the Telescope gate.
     *
     * This gate determines who can access Telescope in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define('viewTelescope', function ($user) {
            // return in_array($user->email, [
            //     //
            // ]);
            return AdminHelper::hasPermission(['view telescope']);
            // return true;
        });
    }
}
