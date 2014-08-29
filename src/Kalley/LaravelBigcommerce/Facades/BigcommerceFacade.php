<?php namespace Kalley\LaravelBigcommerce\Facades;

use Illuminate\Support\Facades\Facade;

class BigcommerceFacade extends Facade {
  /**
   * Get the registered name of the component
   * @return string
   * @codeCoverageIgnore
   */
  protected static function getFacadeAccessor() {
    return 'laravel-bigcommerce.api';
  }

}