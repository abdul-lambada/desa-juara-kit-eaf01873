<?php

namespace App\Models;

use App\Core\Database;
use PDO;

abstract class Model
{
    protected Database $db;

    public function __construct(Database $database)
    {
        $this->db = $database;
    }

    abstract protected function table(): string;

    public function all(array $columns = ['*']): array
    {
        $cols = $columns === ['*'] ? '*' : implode(', ', $columns);
        $query = "SELECT {$cols} FROM {$this->table()}";

        return $this->db->fetchAll($query);
    }

    public function find(int|string $id, string $column = 'id'): ?array
    {
        $query = "SELECT * FROM {$this->table()} WHERE {$column} = :value LIMIT 1";
        return $this->db->fetch($query, ['value' => $id]);
    }

    public function insert(array $data): int
    {
        $columns = array_keys($data);
        $placeholders = array_map(fn ($column) => ':' . $column, $columns);

        $query = "INSERT INTO {$this->table()} (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";

        return $this->db->insert($query, $data);
    }

    public function update(int|string $id, array $data, string $column = 'id'): int
    {
        if (empty($data)) {
            return 0;
        }

        $set = implode(', ', array_map(fn ($key) => "{$key} = :{$key}", array_keys($data)));
        $data['__id'] = $id;

        $query = "UPDATE {$this->table()} SET {$set} WHERE {$column} = :__id";

        return $this->db->update($query, $data);
    }

    public function delete(int|string $id, string $column = 'id'): int
    {
        $query = "DELETE FROM {$this->table()} WHERE {$column} = :value";

        return $this->db->delete($query, ['value' => $id]);
    }

    public function countAll(): int
    {
        $result = $this->db->fetch("SELECT COUNT(*) AS aggregate FROM {$this->table()}");

        return (int) ($result['aggregate'] ?? 0);
    }

    public function exists(string $column, mixed $value, int|string|null $ignoreId = null, string $idColumn = 'id'): bool
    {
        $query = "SELECT COUNT(*) AS aggregate FROM {$this->table()} WHERE {$column} = :value";
        $params = ['value' => $value];

        if ($ignoreId !== null) {
            $query .= " AND {$idColumn} != :ignore";
            $params['ignore'] = $ignoreId;
        }

        $result = $this->db->fetch($query, $params);

        return (int) ($result['aggregate'] ?? 0) > 0;
    }

    protected function generateUniqueSlug(string $value, string $column = 'slug', int|string|null $ignoreId = null, string $idColumn = 'id'): string
    {
        $base = str_slug($value);
        $slug = $base;
        $counter = 2;

        while ($this->exists($column, $slug, $ignoreId, $idColumn)) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function uniqueSlug(string $value, string $column = 'slug', int|string|null $ignoreId = null, string $idColumn = 'id'): string
    {
        return $this->generateUniqueSlug($value, $column, $ignoreId, $idColumn);
    }

    protected function pdo(): PDO
    {
        return $this->db->connection();
    }
}
