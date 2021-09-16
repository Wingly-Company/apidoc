<?php

namespace Wingly\ApiDoc;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Wingly\ApiDoc\Commands\GenerateDocumentationCommand;

class ApiDocServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->authorization();

        $this->registerPublishing();

        $this->registerCommands();

        $this->registerGenerator();

        $this->registerViews();

        $this->registerRoutes();
    }

    public function authorization(): void
    {
        $this->gate();

        AuthorizesRequests::auth(function ($request) {
            return app()->environment('local') ||
                Gate::check('viewApiDocs', [$request->user()]);
        });
    }

    public function gate(): void
    {
        Gate::define('viewApiDocs', function ($user = null) {
            return in_array($user->email, [
                //
            ]);
        });
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
