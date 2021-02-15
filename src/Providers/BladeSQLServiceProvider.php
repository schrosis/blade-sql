<?php

namespace Schrosis\BladeSQL\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Schrosis\BladeSQL\BladeSQL\BladeSQLCompiler;
use Schrosis\BladeSQL\BladeSQL\BladeSQLExecutor;
use Schrosis\BladeSQL\BladeSQL\Contracts\Compiler;
use Schrosis\BladeSQL\BladeSQL\Contracts\Executor;
use Schrosis\BladeSQL\BladeSQL\View\Directives\InDirective;

class BladeSQLServiceProvider extends ServiceProvider
{
    public const CONFIG_PATH = __DIR__.'/../config/blade-sql.php';

    public $bindings = [
        Executor::class => BladeSQLExecutor::class,
        Compiler::class => BladeSQLCompiler::class,
    ];

    public function boot()
    {
        $this->setUpConfig();
        $this->registerVIews();
    }

    private function setUpConfig()
    {
        $this->publishes([
            self::CONFIG_PATH => $this->getPublishConfigPath(),
        ]);

        $this->mergeConfigFrom(self::CONFIG_PATH, 'blade-sql');
    }

    private function registerVIews()
    {
        $this->loadViewsFrom(Config::get('blade-sql.dir'), 'sql');

        $prefix = Config::get('blade-sql.prefix');
        Blade::directive($prefix.InDirective::NAME, [InDirective::class, 'process']);
    }

    private function getPublishConfigPath()
    {
        return $this->app->configPath('blade-sql.php');
    }
}
