# Bigcommerce for Laravel

A wrapper package for the [Bigcommerce PHP API](https://github.com/bigcommerce/bigcommerce-api-php).

## Package Installation

Add the following line to your composer.json file:

```javascript
"kalley/laravel-bigcommerce": "dev-master"
```

or run `composer require kalley/laravel-bigcommerce:dev-master` from the command line

Add this line of code to the ```providers``` array located in your ```app/config/app.php``` file:
```php
'Kalley\LaravelBigcommerce\LaravelBigcommerceServiceProvider',
```

And this lines to the ```aliases``` array:
```php
'Bigcommerce' => 'Kalley\LaravelBigcommerce\Client',
```

### Configuration

In order to use the Bigcommerce API, publish its configuration first

```php
php artisan config:publish kalley/laravel-bigcommerce
```

Afterwards edit the file ```app/config/packages/kalley/laravel-bigcommerce/bigcommerce.php``` to suit your needs.

### Migrations

This package comes with all the migrations you need to run a full featured oauth2 server. Run:

```php
php artisan bigcommerce:migrations
```

Then you're ready to go! Look at the [Bigcommerce PHP API](https://github.com/bigcommerce/bigcommerce-api-php) for specifics on how to use the library.

#### Caching

This library will cache the results of any of the API calls if you configure it to. This will always cache the results of the added methods unless you pass `false` as the final argument.

The `cache` configuration option accepts an integer representing minutes (eg. `10`); `false`, `null`, `0` to not cache; or `'forever'` to cache forever. Any other value will be treated as a sign to not cache the result. As with the added methods below, you can pass a boolean as the final argument to force it to cache again if you wish.

## Extensions

This library passes existing Bigcommerce\Api\Client methods through while caching (if configured to do so) the results. It also includes the following methods:

```php
Bigcommerce::createCustomerAddress($customer_id, $object);
```

> This will create an address in the customer's address book in your store. Required fields are as followed:

> *   `first_name`
> *   `last_name`
> *   `phone`
> *   `street_1`
> *   `city`
> *   `state`
> *   `zip`
> *   `country` - this needs to match exactly what Bigcommerce is expecting. See below.

```php
Bigcommerce::getCountries($filter=false, $force=false);
```

> This will give you a list of countries Bigcommerce supports or whatever. Caches it for you so you don't use up your API limit.

> Returns an array of \Bigcommerce\Api\Resource

```php
Bigcommerce::getCountry($id);
```

> If, for whatever reason, you want information on a single country.

> Returns an instance of \Bigcommerce\Api\Resource

```php
Bigcommerce::getCountryStates($country_id, $filter=false, $force=false);
```

> Get states/provinces for the requested country. Caches it for you so you don't use up your API limit.

> Returns an array of \Bigcommerce\Api\Resource

```php
Bigcommerce::getCountryState($country_id, $id);
```

> If, for whatever reason, you want information on a single state.

> Returns an instance of \Bigcommerce\Api\Resource

## Support

Bugs and feature request are tracked on [GitHub](https://github.com/kalley/laravel-bigcommerce/issues)

## License

This package is released under the MIT License.
