<?php

declare(strict_types=1);

namespace App;

require_once("Exception/AppException.php");

use App\Exception\ConfigurationException;
use App\Exception\StorageException;

use PDO;
use PDOException;
use Throwable;

class Database
{
   private $connection;

   public function __construct(array $config)
   {
      try {
         $this->validateConfig($config);
         $this->createConnection($config);
      } catch (PDOException $e) {
         throw new StorageException('Connection Error');
      }
   }

   public function createNote(array $data): void
   {
      try {
         $title = $this->connection->quote($data['title']);
         $descritpion = $this->connection->quote($data['description']);
         $created = $this->connection->quote(date('Y-m-d H:i:s'));

         $query = "
            INSERT INTO notes(title, description, created)
            VALUES($title, $descritpion, $created)
          ";

         $this->connection->exec($query);
      } catch (Throwable $e) {
         throw new StorageException('Could not create the new note', 400, $e);
      }
   }

   private function createConnection(array $config): void
   {
      $dsn = "mysql:dbname={$config['database']};host={$config['host']}";
      $this->connection = new PDO(
         $dsn,
         $config['user'],
         $config['password'],
         [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         ]
      );
   }

   private function validateConfig(array $config): void
   {
      if (
         empty($config['database']) ||
         empty($config['host']) ||
         empty($config['user']) ||
         empty($config['password'])
      ) {
         throw new ConfigurationException('Storage Configuration Error');
      }
   }
}
