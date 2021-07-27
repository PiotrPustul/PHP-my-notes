<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\AbstractModel;
use App\Model\ModelInterface;
use App\Exception\StorageException;
use App\Exception\NotFoundException;
use PDO;
use Throwable;

class NoteModel extends AbstractModel implements ModelInterface
{
   public function list(
      int $pageNumber,
      int $pageSize,
      string $sortBy,
      string $sortOrder
   ): array {
      return $this->findBy(null, $pageNumber, $pageSize, $sortBy, $sortOrder);
   }

   public function search(
      string $phrase,
      int $pageNumber,
      int $pageSize,
      string $sortBy,
      string $sortOrder
   ): array {
      return $this->findBy($phrase, $pageNumber, $pageSize, $sortBy, $sortOrder);
   }

   public function count(): int
   {
      try {
         $query = "SELECT count(*) AS notesAmount FROM notes";
         $result = $this->connection->query($query);
         $result =  $result->fetch(PDO::FETCH_ASSOC);
         if ($result === false) {
            throw new StorageException('Could not download the info of the amount of the note', 400);
         }

         return (int) $result['notesAmount'];
      } catch (Throwable $e) {
         throw new StorageException('The number of notes information could not be retrieved', 400, $e);
      }
   }

   public function searchCount(string $phrase): int
   {
      try {
         $phrase = $this->connection->quote('%' . $phrase . '%', PDO::PARAM_STR);
         $query = "SELECT count(*) AS notesAmount 
         FROM notes
         WHERE title LIKE ($phrase)";

         $result = $this->connection->query($query);
         $result =  $result->fetch(PDO::FETCH_ASSOC);
         if ($result === false) {
            throw new StorageException('Could not download the info of the amount of the note', 400);
         }

         return (int) $result['notesAmount'];
      } catch (Throwable $e) {
         throw new StorageException('The number of notes information could not be retrieved', 400, $e);
      }
   }

   public function get(int $id): array
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

   public function create(array $data): void
   {
      try {
         $title = $this->connection->quote($data['title']);
         $descritpion = $this->connection->quote($data['description']);
         $created = $this->connection->quote(date('Y-m-d H:i:s'));

         $query = "INSERT INTO notes(title, description, created)
            VALUES($title, $descritpion, $created)";

         $this->connection->exec($query);
      } catch (Throwable $e) {
         throw new StorageException('Could not create the new note', 400, $e);
      }
   }

   public function edit(int $id, array $data): void
   {
      try {
         $title = $this->connection->quote($data['title']);
         $description = $this->connection->quote($data['description']);

         $query = "UPDATE notes
            SET title = $title, description = $description
            WHERE id = $id";

         $this->connection->exec($query);
      } catch (Throwable $e) {
         throw new StorageException('Could not updated the note !', 400, $e);
      }
   }

   public function delete(int $id): void
   {
      try {
         $query = "DELETE FROM notes WHERE id = $id LIMIT 1";
         $this->connection->exec($query);
      } catch (Throwable $e) {
         throw new StorageException('Could not delete the note', 400, $e);
      }
   }

   private function findBy(
      ?string $phrase,
      int $pageNumber,
      int $pageSize,
      string $sortBy,
      string $sortOrder
   ): array {
      try {
         $limit = $pageSize;
         $offset = ($pageNumber - 1) * $pageSize;

         if (!in_array($sortBy, ['created', 'title'])) {
            $sortBy = 'title';
         }
         if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc';
         }

         $wherePart = '';
         if ($phrase) {
            $phrase = $this->connection->quote('%' . $phrase . '%', PDO::PARAM_STR);
            $wherePart = "WHERE title LIKE ($phrase)";
         }

         $query = "SELECT id, title, created 
         FROM notes
         $wherePart
         ORDER BY $sortBy $sortOrder
         LIMIT $offset, $limit";

         $result = $this->connection->query($query);
         return $result->fetchAll(PDO::FETCH_ASSOC);
      } catch (Throwable $e) {
         throw new StorageException('The notes could not be found', 400, $e);
      }
   }
}
