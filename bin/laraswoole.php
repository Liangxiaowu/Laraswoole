<?php 

define('LARAVEL_START', microtime(true));
require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bootstrap/app.php';

define('ROOT_PATH',dirname(__DIR__));

(new \Laraswoole\App()) ->run($argv);