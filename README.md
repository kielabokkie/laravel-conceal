# Laravel Conceal

[![Author](http://img.shields.io/badge/by-@kielabokkie-lightgrey.svg?style=flat-square)](https://twitter.com/kielabokkie)
[![Build](https://img.shields.io/github/workflow/status/kielabokkie/laravel-conceal/run-tests/master?style=flat-square)](https://github.com/kielabokkie/laravel-conceal/actions)
[![Packagist Version](https://img.shields.io/packagist/v/kielabokkie/laravel-conceal.svg?style=flat-square)](https://packagist.org/packages/kielabokkie/laravel-conceal)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

This package allows you to conceal sensitive data in arrays and collections. This is particularly useful when writing possibly sensitive data to log files.

Once installed you can do things like this:

```php
$data = [
    'username' => 'wouter',
    'api_key' => 'secret'
];

$hide = ['api_key'];

$output = conceal($data, $hide);
print_r($output);

// Outputs: ['username' => 'wouter', 'api_key' => '********']
```

## Requirements

* PHP >= 7.1
* Laravel 5.7+ | 6 | 7

## Installation

Install the package via composer:

```
composer require kielabokkie/laravel-conceal
```

## Package configuration

This package has minimal configuration. All you can do at the moment is set the keys that are concealed by default. If you want to add your own defaults you can do that by publishing the config file by running the following command:

```bash
php artisan vendor:publish --provider="Kielabokkie\LaravelConceal\ConcealServiceProvider"
```

These are the contents of the file that will be published at `config/conceal.php`:

```php
return [
    /*
     * Array of keys that will be concealed automatically.
     */
    'defaults' => [
        'password',
        'password_confirmation',
    ]
];
```

## Usage

Use the default configuration to conceal the password:

```php
$data = [
    'username' => 'wouter',
    'password' => 'secret'
];

$output = conceal($data);
print_r($output);

// Outputs: ['username' => 'wouter', 'password' => '********']
```

Set keys on the fly:

```php
$data = [
    'api_key' => 'secret'
];

$output = conceal($data, ['api_key']);
print_r($output);

// Outputs: ['api_key' => '********']
```

Everything works exactly the same for collections:

```php
$data = new Collection([
    'username' => 'wouter',
    'password' => 'secret'
]);

$output = conceal($data);
print_r($output->toArray());

// Outputs: ['username' => 'wouter', 'password' => '********']
```

And last but not least, it works recursively too:

```php
$data = [
    'password' => 'secret',
    'nextlevel' => [
        'password' => 'secret',
    ]
];

$output = conceal($data);
print_r($output);

// Outputs: ['password' => '********', 'nextlevel' => ['password' => '********']]
```

### Facade

The examples above use the `conceal()` helper function. If Facades are more your thing you can use that instead:

```php
use Kielabokkie\LaravelConceal\Facades\Concealer;

$data = [
    'password' => 'secret'
];

$output = Concealer::conceal($data);
print_r($output);

// Outputs: ['password' => '********']
```
