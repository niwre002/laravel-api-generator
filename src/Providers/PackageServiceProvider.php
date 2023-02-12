<?php

namespace App\Providers;
use Erwinnerwin\LaravelApiGenerator\Commands\GenerateApi;
use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerCommands();
        }
    }
 
    public function register()
    {
     
    }

    protected function registerCommands(): void
    {
        $this->commands([
            GenerateApi::class,
        ]);
    }
}