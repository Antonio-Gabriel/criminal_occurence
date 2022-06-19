<?php

declare(strict_types=1);

session_start();
session_regenerate_id();

error_reporting(E_ALL);
ini_set("display_error", 1);

require_once "./vendor/autoload.php";
require_once "./bootstrap.php";

require_once "./src/utils/Functions.php";

use CriminalOccurence\http\HttpClient;

use Slim\App;

$app = new App();

HttpClient::routes($app);

$app->run();