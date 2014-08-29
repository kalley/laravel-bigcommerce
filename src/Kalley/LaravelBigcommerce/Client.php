<?php namespace Kalley\LaravelBigcommerce;

use Bigcommerce\Api\Client as Bigcommerce;

class Client extends Bigcommerce {

  public static function createCustomerAddress($customer_id, $object) {
    return self::createResource('/customers/' . $customer_id . '/addresses', $object);
  }

}