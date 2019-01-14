<?php

namespace DigitalCloud\Blameable;

use DigitalCloud\Blameable\Commands\AddBlameableColumns;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class BlameableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/blameable.php' => config_path('blameable.php'),
        ], 'config');

        $this->registerMacroHelpers();

        if ($this->app->runningInConsole()) {
            $this->commands([AddBlameableColumns::class]);
        }

    }

    public function register() {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/blameable.php',
            'blameable'
        );
    }

    public function registerMacroHelpers() {
        Blueprint::macro('blameable', function () {
            $this->unsignedBigInteger(Config::get('blameable.column_names.createdByAttribute', 'created_by'))->nullable();
            $this->unsignedBigInteger(Config::get('blameable.column_names.updatedByAttribute', 'updated_by'))->nullable();
        });
    }

}
