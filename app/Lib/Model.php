<?php

namespace App\Lib;

use PDO;

class Model
{
    private static PDO $pdo;

    protected string $tableName = '';

    private array  $fields          = ['*'];
    private string $conditionSql    = '';
    private array  $conditionParams = [];
    private array  $orderBy         = [];

    public static function setPDO(PDO $pdo): void
    {
        static::$pdo = $pdo;
    }

    public static function query(): static
    {
        return new static();
    }

    public function select(array $fields = ['*']): static
    {
        $this->fields = $fields;
        return $this;
    }

    public function where(string $sql, array $params = []): static
    {
        $this->conditionSql = $sql;
        $this->conditionParams = $params;
        return $this;
    }

    public function orderBy(string $field): static
    {
        $this->orderBy[] = $field;
        return $this;
    }

    public function paginate(int $currentPage, int $perPage): array
    {
        $sqlParts = [
            'SELECT ' . implode(',', $this->fields),
            "FROM {$this->tableName}",
        ];

        $params = [];

        if ($this->conditionSql) {
            $sqlParts[] = "WHERE {$this->conditionSql}";
            $params = array_merge($this->conditionParams, $params);
        }

        if (count($this->orderBy) > 0) {
            $sqlParts[] = 'ORDER BY ' . implode(',', $this->orderBy);
        }

        $sqlParts[] = "LIMIT ? OFFSET ?";
        $params[] = $perPage;
        $params[] = ($currentPage - 1) * $perPage;

        $statement = static::$pdo->prepare(implode(' ', $sqlParts));
        $statement->execute($params);
        $data = $statement->fetchAll() ?: [];

        $totalRows = $this->total();
        $totalPages = ceil($totalRows / $perPage);

        return [
            'data'         => $data,
            'total_page'   => $totalPages,
            'current_page' => $currentPage,
            'prev_page'    => $currentPage - 1 ?: null,
            'next_page'    => $currentPage + 1 <= $totalPages ? $currentPage + 1 : null,
        ];
    }

    public function get(): array
    {
        $sqlParts = [
            'SELECT ' . implode(',', $this->fields),
            "FROM {$this->tableName}",
        ];

        $params = [];

        if ($this->conditionSql) {
            $sqlParts[] = "WHERE {$this->conditionSql}";
            $params = array_merge($this->conditionParams, $params);
        }

        if (count($this->orderBy) > 0) {
            $sqlParts[] = 'ORDER BY ' . implode(',', $this->orderBy);
        }

        $statement = static::$pdo->prepare(implode(' ', $sqlParts));
        $statement->execute($params);
        return $statement->fetchAll() ?: [];
    }

    public function total()
    {
        $sqlParts = [
            'SELECT COUNT(*)',
            "FROM {$this->tableName}",
        ];

        if ($this->conditionSql) {
            $sqlParts[] = "WHERE {$this->conditionSql}";
        }

        $statement = static::$pdo->prepare(implode(' ', $sqlParts));
        $statement->execute($this->conditionParams);
        return $statement->fetchColumn();
    }

    public function create($columns): bool
    {
        $sqlParts = [
            "INSERT INTO {$this->tableName}",
        ];

        $names = [];
        $placeholders = [];
        $params = [];

        foreach ($columns as $name => $value) {
            $names[] = $name;
            $placeholders[] = '?';
            $params[] = $value;
        }

        $sqlParts[] = '(' . implode(',', $names) . ')';
        $sqlParts[] = 'VALUES (' . implode(',', $placeholders) . ')';

        $statement = static::$pdo->prepare(implode(' ', $sqlParts));
        return $statement->execute($params);
    }

    public function update(array $columns): bool
    {
        $sqlParts = [
            "UPDATE {$this->tableName}",
        ];

        $placeholders = [];
        $params = [];

        foreach ($columns as $name => $value) {
            $placeholders[] = "{$name} = ?";
            $params[] = $value;
        }

        $sqlParts[] = 'SET ' . implode(',', $placeholders);

        if ($this->conditionSql) {
            $sqlParts[] = "WHERE {$this->conditionSql}";
            $params = array_merge($params, $this->conditionParams);
        }

        $statement = static::$pdo->prepare(implode(' ', $sqlParts));
        return $statement->execute($params);
    }
}
