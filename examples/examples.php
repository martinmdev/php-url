<?php

require __DIR__ . '/../vendor/autoload.php';

use Martinm\Url\Url;

$url = new Url('http://example.com/path/to/index.php?x=1&y=2');

$url->getScheme(); // 'http'
$url->getHost(); // 'example.com'
$url->getPort(); // null
$url->getPath(); // '/path/to/index.php'
$url->getQuery(); // 'x=1&y=2'
