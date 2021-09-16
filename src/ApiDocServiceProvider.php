<?php

namespace Wingly\ApiDoc;

use Illuminate\Support\ServiceProvider;
use Wingly\ApiDoc\Commands\GenerateDocumentationCommand;

class ApiDocServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPublishing();

        $this->registerCommands();

        $this->registerGenerator();

        $this->registerViews();

        $this->registerRoutes();
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/apidoc.php', 'apidoc');
    }

    public function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'apidoc');
    }

    public function registerRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');
    }

    protected function registerGenerator()
    {
        $this->app->bind(DocumentationGenerator::class, function ($app) {
            return (new DocumentationGenerator())
                ->useRootNamespace($app->getNamespace());
        });
    }

    protected function registerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/apidoc.php' => $this->app->configPath('apidoc.php'),
            ], 'apidoc-config');
        }
    }

    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateDocumentationCommand::class
            ]);
        }
    }
}
