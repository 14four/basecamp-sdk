<?php namespace FourteenFour\Basecamp;

use Illuminate\Support\ServiceProvider;
use FourteenFour\Basecamp\Basecamp;

class BasecampServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register() {

        $this->app->bind('basecamp', function ($app) {

            $config = $this->getConfig();

            return new Basecamp( $config['userAgent'] );

        });

        $this->app->alias('basecamp', 'FourteenFour\Basecamp\Client\Provider\Basecamp');

    }


    private function getConfig() {

        $config = $this->app['config']->get('basecamp_auth');

        return $config;
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot() {

        $this->publishes([
            __DIR__ . '/config/basecamp_auth.php' => config_path('basecamp_auth.php'),
        ], 'config');

    }

    /**
     * Define defered binds so laravel can return to it.
     * @return Array Strings of registered binds for Laravel IOC
     */
    public function provides() {
        return [
            'basecamp',
        ];
    }

}
