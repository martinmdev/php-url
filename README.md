PHP Url
=======

[![codecov](https://codecov.io/gh/martinmdev/php-url/branch/master/graph/badge.svg?token=82ErV88q5s)](https://codecov.io/gh/martinmdev/php-url)
[![Build Status](https://travis-ci.com/martinmdev/php-url.svg?token=deEx2ZSYokCjg5tzE2P3&branch=master)](https://travis-ci.com/martinmdev/php-url)
[![Latest Stable Version](https://poser.pugx.org/martinmdev/php-url/v/stable)](https://packagist.org/packages/martinmdev/php-url)
[![Total Downloads](https://poser.pugx.org/martinmdev/php-url/downloads)](https://packagist.org/packages/martinmdev/php-url)
[![Latest Unstable Version](https://poser.pugx.org/martinmdev/php-url/v/unstable)](https://packagist.org/packages/martinmdev/php-url)
[![License](https://poser.pugx.org/martinmdev/php-url/license)](https://packagist.org/packages/martinmdev/php-url)


Usage
-----

```php
<?php

require __DIR__ . '/../vendor/autoload.php';

use Martinm\Url\Url;

$url = new Url('http://example.com/path/to/index.php?x=1&y=2');

$url->getScheme(); // 'http'
$url->getHost(); // 'example.com'
$url->getPort(); // null
$url->getPath(); // '/path/to/index.php'
$url->getQuery(); // 'x=1&y=2'
```

Installation
------------

```shell script
composer require martinmdev/php-url
```
