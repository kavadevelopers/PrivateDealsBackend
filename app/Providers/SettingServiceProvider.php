<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\AppSettingsModel;
use App\Models\GlobalSettingModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // if ($this->databaseExists(config('database.connections.mysql.database')) && Schema::hasTable('app_settings')) {
        //     $this->app->singleton(GlobalSettingModel::class, function ($app) {
        //         return new GlobalSettingModel(AppSettingsModel::all());
        //     });
        // }

        // $this->app->singleton(GlobalSettingModel::class, function ($app) {
        //     return new GlobalSettingModel(AppSettingsModel::all());
        // });
    }

    /**
     * Bootstrap services.
     */
    public function boot(GlobalSettingModel $settinsInstance): void
    {
        // if ($this->databaseExists(config('database.connections.mysql.database')) && Schema::hasTable('app_settings')) {
        //     View::share('globalsettings', $settinsInstance);
        // }
        // View::share('globalsettings', $settinsInstance);
    }

    protected function databaseExists(string $databaseName): bool
    {
        try {
            DB::connection()->statement("USE $databaseName");
            return true;
        } catch (\Illuminate\Database\QueryException $e) {
            return false;
        }
    }
}
