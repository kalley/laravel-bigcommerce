<?php namespace Kalley\LaravelBigcommerce;

use Illuminate\Support\ServiceProvider;
use Kalley\LaravelBigcommerce\Console\MigrationCommand;

use Bigcommerce\Api\Client as Bigcommerce;

class LaravelBigcommerceServiceProvider extends ServiceProvider {

  /**
   * Indicates if loading of the provider is deferred.
   *
   * @var bool
   */
  protected $defer = false;

  protected function config($key) {
   return isset($_ENV['bigcommerce'][$key]) ? $_ENV['bigcommerce'][$key] : $this->app['config']->get('laravel-bigcommerce::bigcommerce.' . $key);
  }

  /**
   * Bootstrap the application events.
   *
   * @return void
   */
  public function boot() {
    $this->package('kalley/laravel-bigcommerce');

    $store_url = $this->config('store_url');
    $username = $this->config('username');
    $api_key = $this->config('api_key');

    Bigcommerce::configure([
      'store_url' => $store_url,
      'username' => $username,
      'api_key' => $api_key,
    ]);
  }

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register() {
    $this->registerCommands();
  }

  public function registerCommands() {
    $this->app->bindShared('command.bigcommerce.migration', function ($app) {
      return new MigrationCommand($app);
    });
    $this->commands('command.bigcommerce.migration');
  }

  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides() {
    return array();
  }

}
