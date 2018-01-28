<?php

namespace Lakshmaji\Validators;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Illuminate\Support\ServiceProvider;
use Lakshmaji\Validators\Console\Commands\Creators\ValidatorCreator;
use Lakshmaji\Validators\Console\Commands\MakeValidatorCommand;

/**
 * ValidatorServiceProvider
 *
 * @author     lakshmaji 
 * @package    Validators
 * @version    1.0.0
 * @since      Class available since Release 1.0.0
 */
class ValidatorServiceProvider extends ServiceProvider
{
    /** Indicates if loading of the provider is deferred. @var bool */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $config_path = __DIR__ . '/config/validator.php';

        $this->publishes(
            [$config_path => config_path('validator.php')],
            'validator'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->registerMakeValidatorCommand();
        $this->commands(['command.validator.make']);

        $config_path = __DIR__ . '/config/validator.php';

        $this->mergeConfigFrom(
            $config_path,
            'validator'
        );
    }

    /**
     * Register the bindings.
     */
    protected function registerBindings()
    {
        $this->app->instance('FileSystem', new Filesystem());
        $this->app->bind('Composer', function ($app) {
            return new Composer($app['FileSystem']);
        });

        $this->app->singleton('ValidatorCreator', function ($app) {
            return new ValidatorCreator($app['FileSystem']);
        });
    }

    /**
     * Register the make:validator command.
     */
    protected function registerMakeValidatorCommand()
    {
        if (method_exists(\Illuminate\Foundation\Application::class, 'singleton')) {
            $this->app->singleton('command.validator.make', function ($app) {
                return new MakeValidatorCommand($app['ValidatorCreator'], $app['Composer']);
            });
        } else {
            $this->app['command.validator.make'] = $this->app->share(
                function ($app) {
                    return new MakeValidatorCommand($app['ValidatorCreator'], $app['Composer']);
                }
            );
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'command.validator.make',
        ];
    }
}
// end of class ValidatorServiceProvider
// end of file ValidatorServiceProvider.php
