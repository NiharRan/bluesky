<?php

use Dotenv\Dotenv;
use \Bluesky\Core\Application;

require_once "./vendor/autoload.php";
require_once "./vendor/larapack/dd/src/helper.php";

define("ROOT_DIR", dirname(__FILE__));

$dotenv = Dotenv::createImmutable(ROOT_DIR);
$dotenv->load();

$app = Application::init();

include "./routes/web.php";
include "./routes/api.php";


$app->resolveRequest();


