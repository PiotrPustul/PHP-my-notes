<?php

declare(strict_types=1);

namespace App;

use App\Exception\ConfigurationException;
use App\Exception\StorageException;
use App\Exception\NotFoundException;
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

   public function getNote(int $id): array
   {
      try {
         $query = "SELECT * FROM notes WHERE id = $id";
         $result = $this->connection->query($query);
         $note = $result->fetch(PDO::FETCH_ASSOC);
      } catch (Throwable $e) {
         dump($e);
         throw new StorageException('Note could not be retrieved', 400, $e);
      }

      if (!$note) {
         throw new NotFoundException("The note on id: $id does not exist");
         exit('Nie ma');
      }

      return $note;
   }

   public function getNotes(): array
   {
      try {
         $query = "SELECT id, title, created FROM notes";
         $result = $this->connection->query($query);
         return $result->fetchAll(PDO::FETCH_ASSOC);
      } catch (Throwable $e) {
         throw new StorageException('Data on notes could not be retrieved', 400, $e);
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

   public function editNote(int $id, array $data): void
   {
      var_dump($id);

      try {
         $title = $this->connection->quote($data['title']);
         $description = $this->connection->quote($data['description']);

         $query = "
            UPDATE notes
            SET title = $title, description = $description
            WHERE id = $id
         ";

         $this->connection->exec($query);
      } catch (Throwable $e) {
         throw new StorageException('Could not updated the note !', 400, $e);
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
