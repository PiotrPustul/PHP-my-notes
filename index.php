<?php

declare(strict_types=1);

spl_autoload_register(function (string $classNameSpace) {
   $path = str_replace(['\\', 'App/'], ['/', ''], $classNameSpace);
   $path = "src/$path.php";
   require_once($path);
});

require_once realpath(__DIR__ . "/vendor/autoload.php");
require_once("src/utils/debug.php");

use App\Controller\AbstractController;
use App\Controller\NoteController;
use App\Request;
use App\Exception\AppException;
use App\Exception\ConfigurationException;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$configuration = [
   'db' => [
      'host' => $_ENV['DB_HOST'],
      'database' => $_ENV['DB_NAME'],
      'user' => $_ENV['DB_USER'],
      'password' => $_ENV['DB_PASS'],
   ]
];

$request = new Request($_GET, $_POST, $_SERVER);

try {
   // $controller = new Controller($request);
   // $controller->run();
   AbstractController::initConfiguration($configuration);
   (new NoteController($request))->run();
} catch (ConfigurationException $e) {
   echo "<h1>index.php ===> Aplication Error ConfigurationException</h1>";
   echo 'Aplication Error. You need to contact with admin !!!';
} catch (AppException $e) {
   echo "<h1>index.php ===> Aplication Error AppException</h1>";
   echo '<h3>' . $e->getMessage() . '</h3>';
} catch (\Throwable $e) {
   echo "<h1>index.php ===> Aplication Error Throwable</h1>";
   dump($e);
}
