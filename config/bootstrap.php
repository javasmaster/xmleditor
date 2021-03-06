<?php

require_once 'vendor/autoload.php';
require_once('ImageManipulator.php');
// Instantiate the app
$app = new \Slim\App(['settings' => require __DIR__ . '/../config/settings.php']);

// Set up dependencies
// require  __DIR__ . '/container.php';

// Register middleware
// require __DIR__ . '/middleware.php';

// Register routes
require 'routes.php';

return $app;
