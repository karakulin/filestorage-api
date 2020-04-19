<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exception\FilesException;

class FilesRepository extends BaseRepository
{
    const HIDDEN_ROWS = [ 'real_location', 'path', 'deleted' ];

    public function __construct(\PDO $database)
    {
        $this->database = $database;
    }

    public function checkAndGet(int $filesId)
    {
        $query = 'SELECT * FROM files WHERE id = :id AND deleted = false';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $filesId);
        $statement->execute();
        $files = $statement->fetchObject();
        if (empty($files)) {
            throw new FilesException('Files not found.', 404);
        }

        return $files;
    }

    public function getAll(): array
    {
        $query = 'SELECT id, name, created_at, updated_at FROM files WHERE deleted = false ORDER BY id';
        $statement = $this->getDb()->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function create($files)
    {
        $query = 'INSERT INTO `files` 
            (`id`, `name`, `path`, `real_location`) 
            VALUES (:id, :name, :path, :real_location)';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $files->id);
        $statement->bindParam('name', $files->name);
        $statement->bindParam('path', $files->path);
        $statement->bindParam('real_location', $files->real_location);
        $statement->execute();

        return $this->checkAndGet((int)$this->getDb()->lastInsertId());
    }

    public function update($files, $data)
    {
        if (isset($data->name)) {
            $files->name = $data->name;
        }
        if (isset($data->path)) {
            $files->path = $data->path;
        }

        $query = 'UPDATE `files` 
            SET `name` = :name, 
            `path` = :path, 
            `updated_at` = NOW() WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $files->id);
        $statement->bindParam('name', $files->name);
        $statement->bindParam('path', $files->path);
        $statement->execute();

        return $this->checkAndGet((int)$files->id);
    }

    public function delete(int $filesId)
    {
        $query = 'UPDATE `files` SET `deleted` = TRUE WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $filesId);
        $statement->execute();
    }
}
