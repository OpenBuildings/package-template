<?php

error_reporting(E_ALL);

$loader = require __DIR__.'/../vendor/autoload.php';
$loader->addPsr4('{%php_namespace_escaped%}\\Test\\', __DIR__.'/src');
