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
use Schrosis\BladeSQL\BladeSQL\View\Directives\LikeDirective;

class BladeSQLServiceProvider extends ServiceProvider
{
    public const CONFIG_PATH = __DIR__ . '/../config/blade-sql.php';
    public const VIEWS_DIR = __DIR__ . '/../views';

    public $bindings = [
        Executor::class => BladeSQLExecutor::class,
        Compiler::class => BladeSQLCompiler::class,
    ];

    public function boot()
    {
        $this->setUpConfig();
        $this->registerViews();
    }

    private function setUpConfig()
    {
        $this->publishes([
            self::CONFIG_PATH => $this->getPublishConfigPath(),
        ]);

        $this->mergeConfigFrom(self::CONFIG_PATH, 'blade-sql');
    }

    private function registerViews()
    {
        $this->loadViewsFrom(self::VIEWS_DIR, 'BladeSQL');
        $this->loadViewsFrom(Config::get('blade-sql.dir'), 'sql');

        $prefix = Config::get('blade-sql.prefix');
        $this->registerBladeDirectives($prefix);
        $this->registerBladeComponent($prefix);
    }

    private function registerBladeDirectives(string $prefix)
    {
        Blade::directive($prefix . InDirective::NAME, [InDirective::class, 'process']);
        Blade::directive($prefix . LikeDirective::NAME, [LikeDirective::class, 'process']);
    }

    private function registerBladeComponent(string $prefix)
    {
        $aliasComponentMethod = version_compare(app()->version(), '7', '>=')
            ? 'aliasComponent' : 'component';
        $aliasComponent = [Blade::class, $aliasComponentMethod];

        $aliasComponent('BladeSQL::components.trim', $prefix . 'trim');
        $aliasComponent('BladeSQL::components.where', $prefix . 'where');
        $aliasComponent('BladeSQL::components.set', $prefix . 'set');
    }

    private function getPublishConfigPath()
    {
        return $this->app->configPath('blade-sql.php');
    }
}
