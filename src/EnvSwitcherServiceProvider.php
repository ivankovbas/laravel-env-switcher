<?php namespace IKovbas\EnvSwitcher;

use IKovbas\EnvSwitcher\Commands\EnvSwitchCommand;
use Illuminate\Support\ServiceProvider;

class EnvSwitcherServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {

        // Add commands
        $this->app['env.switch'] = $this->app->share(
            function($app) {
                return new EnvSwitchCommand($app);
            }
        );

        $this->commands([
            'env.switch',
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {

    }

}
