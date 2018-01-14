<?php
require_once __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../app/application.php';

// Controller routing for services
$app->mount('/user', new Routes\UserRoutes());
$app->mount('/company', new Routes\CompanyRoutes());
$app->mount('/queue', new Routes\QueueRoutes());

$app->run();
