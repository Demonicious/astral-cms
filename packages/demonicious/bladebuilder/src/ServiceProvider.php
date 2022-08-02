<?php

namespace Demonicious\BladeBuilder;

use BladeBuilder\BladeBuilder;
use BladeBuilder\Extensions;
use Demonicious\BladeBuilder\Commands\CreateTheme;
use Demonicious\BladeBuilder\Commands\PublishDemo;
use Demonicious\BladeBuilder\Commands\PublishTheme;
use Exception;
use Illuminate\Support\Facades\DB;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Extensions::registerLayout('master', __DIR__ . '/../themes/stub/layouts/master');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     * @throws Exception
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        if (! $this->app->runningInConsole() && empty(config('pagebuilder'))) {
            throw new Exception("No PHPageBuilder config found, please run: php artisan vendor:publish --provider=\"Demonicious\BladeBuilder\ServiceProvider\" --tag=config");
        }

        if(file_exists(base_path('storage/bitflan/installed.stp'))) {
            // register singleton phpPageBuilder (this ensures phpb_ helpers have the right config without first manually creating a PHPageBuilder instance)
            $this->app->singleton('phpPageBuilder', function($app) {
                return new BladeBuilder(config('pagebuilder') ?? []);
            });
            $this->app->make('phpPageBuilder');
        }

        $this->publishes([
            __DIR__ . '/../config/pagebuilder.php' => config_path('pagebuilder.php'),
        ], 'config');
        $this->publishes([
            __DIR__ . '/../themes/demo' => base_path(config('pagebuilder.theme.folder_url') . '/demo'),
        ], 'demo-theme');
    }
}
