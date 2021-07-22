<?php

declare(strict_types=1);

namespace App;

require_once("src/Exception/ConfigurationException.php");

use App\Exception\ConfigurationException;

require_once("src/View.php");
require_once("src/Database.php");

class Controller
{
   private const DEFAULT_ACTION = 'list';
   private $request;
   private $view;
   private static  $configuration = [];

   public static function initConfiguration(array $configuration): void
   {
      self::$configuration = $configuration;
   }

   public function __construct(array $request)
   {
      if (empty(self::$configuration['db'])) {
         throw new ConfigurationException('Configuration Error');
      }

      $db = new Database(self::$configuration['db']);

      $this->request = $request;
      $this->view = new View();
   }

   public function run(): void
   {
      $viewParams = [];

      switch ($this->action()) {
         case 'create':
            $page = 'create';
            $created = false;

            $data = $this->getRequestPost();
            if (!empty($data)) {
               $created = true;
               $viewParams = [
                  'title' =>  $data['title'],
                  'description' =>  $data['description']
               ];
            }

            $viewParams['created'] = $created;
            break;
         case 'show':
            $viewParams = [
               'title' => 'My Title',
               'description' => 'My Description'
            ];
            break;
         default:
            $page = 'list';
            $viewParams['resultList'] = 'Wyswietlamy notatki';
            break;
      }

      $this->view->render($page, $viewParams);
   }

   private function action(): string
   {
      $data = $this->getRequestGet();
      return $data['action'] ?? self::DEFAULT_ACTION;
   }

   private function getRequestGet(): array
   {
      return $this->request['get'] ?? [];
   }

   private function getRequestPost(): array
   {
      return $this->request['post'] ?? [];
   }
}
