<?php

namespace Schrosis\BladeSQL\Providers;

use Illuminate\Support\ServiceProvider;

class BladeSQLServiceProvider extends ServiceProvider
{
    public const CONFIG_PATH = __DIR__.'/../config/blade-sql.php';

    public function boot()
    {
        $this->setUpConfig();
    }

    private function setUpConfig()
    {
        $this->publishes([
            self::CONFIG_PATH => $this->getPublishConfigPath(),
        ]);

        $this->mergeConfigFrom(self::CONFIG_PATH, 'blade-sql');
    }

    private function getPublishConfigPath()
    {
        return $this->app->configPath('blade-sql.php');
    }
}
