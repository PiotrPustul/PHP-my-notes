<?php

declare(strict_types=1);

namespace App;

require_once("src/utils/debug.php");
require_once("src/Controller.php");
require_once("src/Request.php");
require_once("src/Exception/AppException.php");

use App\Request;
use App\Exception\AppException;
use App\Exception\ConfigurationException;
use Throwable;


$configuration = require_once("config/config.php");

$request = new Request($_GET, $_POST);

try {
   Controller::initConfiguration($configuration);
   (new Controller($request))->run();
   // $controller = new Controller($request);
   // $controller->run();
} catch (ConfigurationException $e) {
   echo "<h1>index.php ===> Aplication Error ConfigurationException</h1>";
   echo 'Aplication Error. You need to contact with admin !!!';
} catch (AppException $e) {
   echo "<h1>index.php ===> Aplication Error AppException</h1>";
   echo '<h3>' . $e->getMessage() . '</h3>';
} catch (Throwable $e) {
   echo "<h1>index.php ===> Aplication Error Throwable</h1>";
   dump($e);
}
