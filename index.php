<?php

define('APP_ROOT', realpath(dirname(__FILE__)));
define('CONTROLLER_ACCESSOR', 'c');
define('ACTION_ACCESSOR', 'p');

require "bootstrap/autoload.php";
require "bootstrap/setup.php";

use App\Framework\Application;

$app = new Application();
var_dump($app->getUri());
$app->render();