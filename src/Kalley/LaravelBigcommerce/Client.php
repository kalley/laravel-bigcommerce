<?php namespace Kalley\LaravelBigcommerce;

use Bigcommerce\Api\Client as Bigcommerce;
use Bigcommerce\Api\Filter;
use Cache;
use Config;

class Client {

  protected static function getCachedCollection($endpoint, $force) {
    $cacheKey = 'bigcommerce' . str_replace('/', '.', $endpoint);
    $cached = $force ? null : Cache::get($cacheKey);
    if ( $cached === null ) {
      $cached = Bigcommerce::getCollection($endpoint);
      if ( $cached === null ) $cached = false;
      Cache::forever($cacheKey, $cached);
    }
    return $cached;
  }

  public static function createCustomerAddress($customer_id, $object) {
    return Bigcommerce::createResource('/customers/' . $customer_id . '/addresses', $object);
  }

  public static function getCountries($filter=false, $force=false) {
    $filter = Filter::create($filter);
    return self::getCachedCollection('/countries' . $filter->toQuery(), $force);
  }

  public static function getCountry($id) {
    return Bigcommerce::getResource('/countries/' . $id);
  }

  public static function getCountryStates($country_id, $filter=false, $force=false) {
    $filter = Filter::create($filter);
    return self::getCachedCollection('/countries/' . $country_id . '/states' . $filter->toQuery(), $force);
  }

  public static function getCountryState($country_id, $id) {
    return Bigcommerce::getResource('/countries/' . $country_id . '/states/' . $id);
  }

  public static function __callStatic($method, $args) {
    $cacheMinutes = Config::get('laravel-bigcommerce::bigcommerce.cache');
    $force = false;
    if ( $cacheMinutes ) {
      if ( count($args) && is_bool($args[count($args) - 1]) ) {
        $force = array_pop($args);
      }
      $cacheKey = 'bigcommerce' . $method . implode(':', $args);
      $cached = $force ? null : Cache::get($cacheKey);
    } else {
      $force = true;
      $cached = null;
    }
    if ( $cached === null ) {
      switch ( count($args) ) {
        case 0: $cached = Bigcommerce::$method(); break;
        case 1: $cached = Bigcommerce::$method($args[0]); break;
        case 2: $cached = Bigcommerce::$method($args[0], $args[1]); break;
        case 3: $cached = Bigcommerce::$method($args[0], $args[1], $args[2]); break;
        default: $cached = forward_static_call_array(array('Bigcommerce', $method), $args);
      }
      if ( $cached === null ) $cached = false;
      if ( $cacheMinutes ) {
        if ( is_numeric($cacheMinutes) ) {
          Cache::put($cacheKey, $cached, $cacheMinutes);
        } elseif ( $cacheMinutes === 'forever' ) {
          Cache::forever($cacheKey, $cached);
        }
      }
    }
    return $cached;
  }

}
