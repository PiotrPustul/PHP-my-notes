<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request;
use App\Database;
use App\View;
use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;
use App\Exception\StorageException;


abstract class AbstractController
{
   protected const DEFAULT_ACTION = 'list';

   private static  $configuration = [];

   protected $database;
   protected $request;
   protected $view;

   public static function initConfiguration(array $configuration): void
   {
      self::$configuration = $configuration;
   }

   public function __construct(Request $request)
   {
      if (empty(self::$configuration['db'])) {
         throw new ConfigurationException('Configuration Error');
      }

      $this->database = new Database(self::$configuration['db']);
      $this->request = $request;
      $this->view = new View();
   }

   final public function run(): void
   {
      try {
         $action = $this->action() . 'Action';
         if (!method_exists($this, $action)) {
            $action = self::DEFAULT_ACTION . 'Action';
         }
         $this->$action();
      } catch (StorageException $e) {
         $this->view->render(
            'error',
            ['message' => $e->getMessage()]
         );
      } catch (NotFoundException $e) {
         $this->redirect('/', ['error' => 'noteNotFound']);
      }
   }

   protected function redirect(string $to, array $params): void
   {
      $location = $to;

      if (count($params)) {
         $queryParams = [];
         foreach ($params as $key => $value) {
            $queryParams[] = urlencode($key) . '=' . urlencode($value);
         }
         $queryParams = implode('&', $queryParams);
         $location .= '?' . $queryParams;
      }

      header("Location: $location");
      exit;
   }

   private function action(): string
   {
      return $this->request->getParam('action', self::DEFAULT_ACTION);
   }
}
