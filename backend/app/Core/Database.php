<?php

namespace App\Core;

use PDO;
use PDOStatement;
use RuntimeException;

class Database
{
    protected PDO $pdo;

    public function __construct(array $config)
    {
        $driver = $config['driver'] ?? 'mysql';
        $host = $config['host'] ?? '127.0.0.1';
        $port = $config['port'] ?? 3306;
        $database = $config['database'] ?? '';
        $charset = $config['charset'] ?? 'utf8mb4';
        $collation = $config['collation'] ?? 'utf8mb4_unicode_ci';

        $dsn = match ($driver) {
            'mysql' => "mysql:host={$host};port={$port};dbname={$database};charset={$charset}",
            'pgsql' => "pgsql:host={$host};port={$port};dbname={$database};options='--client_encoding={$charset}'",
            default => throw new RuntimeException("Driver database {$driver} belum didukung."),
        };

        $options = $config['options'] ?? [];

        $this->pdo = new PDO(
            $dsn,
            $config['username'] ?? null,
            $config['password'] ?? null,
            $options
        );

        if ($driver === 'mysql') {
            $this->pdo->exec("SET NAMES '{$charset}' COLLATE '{$collation}'");
        }
    }

    public function connection(): PDO
    {
        return $this->pdo;
    }

    public function beginTransaction(): void
    {
        $this->pdo->beginTransaction();
    }

    public function commit(): void
    {
        $this->pdo->commit();
    }

    public function rollBack(): void
    {
        $this->pdo->rollBack();
    }

    public function query(string $query, array $bindings = []): PDOStatement
    {
        $statement = $this->pdo->prepare($query);
        $statement->execute($bindings);

        return $statement;
    }

    public function fetch(string $query, array $bindings = []): ?array
    {
        $statement = $this->query($query, $bindings);
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    public function fetchAll(string $query, array $bindings = []): array
    {
        $statement = $this->query($query, $bindings);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(string $query, array $bindings = []): int
    {
        $this->query($query, $bindings);

        return (int) $this->pdo->lastInsertId();
    }

    public function update(string $query, array $bindings = []): int
    {
        $statement = $this->query($query, $bindings);

        return $statement->rowCount();
    }

    public function delete(string $query, array $bindings = []): int
    {
        return $this->update($query, $bindings);
    }

    public function transaction(callable $callback): mixed
    {
        try {
            $this->beginTransaction();
            $result = $callback($this);
            $this->commit();

            return $result;
        } catch (\Throwable $e) {
            $this->rollBack();
            throw $e;
        }
    }
}
