<?php

error_reporting(E_ALL);

$loader = require __DIR__.'/../vendor/autoload.php';
$loader->addPsr4('CL\\%%REPO_NAMESPACE%%\\Test\\', __DIR__.'/src');
