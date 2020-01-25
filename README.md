# Laravel Conceal

[![Author](http://img.shields.io/badge/by-@kielabokkie-lightgrey.svg?style=flat-square)](https://twitter.com/kielabokkie)
[![Packagist Version](https://img.shields.io/packagist/v/kielabokkie/laravel-conceal.svg?style=flat-square)](https://packagist.org/packages/kielabokkie/laravel-conceal)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

This package allows you to conceal sensitive data in arrays and collections.

Once installed you can do things like this:

```php
$data = [
    'username' => 'wouter',
    'password' => 'secret'
];

$hide = ['password'];

$output = conceal($data, $hide);
```

Which will return the array with concealed password:

```php
[
    'username' => 'wouter',
    'password' => '********'
]
```

## Installation

Install the package via composer:

```
composer require kielabokkie/laravel-conceal
```
