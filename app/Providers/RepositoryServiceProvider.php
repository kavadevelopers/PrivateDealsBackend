<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->bindRepositories();
    }

    private function bindRepositories()
    {
        $repositories = scandir(app_path('Repositories'));

        foreach ($repositories as $repository) {
            if ($repository !== '.' && $repository !== '..') {
                $repositoryClassName = str_replace('.php', '', $repository);
                $this->app->bind("App\Repositories\{$repositoryClassName}", function ($app) use ($repositoryClassName) {
                    return new $repositoryClassName();
                });
            }
        }
    }
}
