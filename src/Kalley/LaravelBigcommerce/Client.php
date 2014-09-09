<?php namespace Kalley\LaravelBigcommerce;

use Bigcommerce\Api\Client as Bigcommerce;
use Bigcommerce\Api\Filter;
use \Cache;

class Client extends Bigcommerce {

  protected static function getCachedCollection($endpoint, $force) {
    $cacheKey = 'bigcommerce' . str_replace('/', '.', $endpoint);
    $cached = $force ? false : Cache::get($cacheKey);
    if ( $cached === null ) {
      $cached = self::getCollection($endpoint);
      if ( $cached === null ) $cached = false;
      Cache::forever($cacheKey, $cached);
    }
    return $cached;
  }

  public static function createCustomerAddress($customer_id, $object) {
    return self::createResource('/customers/' . $customer_id . '/addresses', $object);
  }

  public static function getCountries($filter=false, $force=false) {
    $filter = Filter::create($filter);
    return self::getCachedCollection('/countries' . $filter->toQuery(), $force);
  }

  public static function getCountry($id) {
    return self::getResource('/countries/' . $id);
  }

  public static function getCountryStates($country_id, $filter=false, $force=false) {
    $filter = Filter::create($filter);
    return self::getCachedCollection('/countries/' . $country_id . '/states' . $filter->toQuery(), $force);
  }

  public static function getCountryState($country_id, $id) {
    return self::getResource('/countries/' . $country_id . '/states/' . $id);
  }

}