<?php
interface DatabaseInterface {
    public function connect(): bool;
    public function disconnect(): void;
    public function query(string $sql, array $params = []): mixed;
    public function insert(string $table, array $data): int;
    public function update(string $table, array $data, array $where): bool;
    public function delete(string $table, array $where): bool;
    public function fetchAll(string $sql, array $params = []): array;
    public function fetchOne(string $sql, array $params = []): ?array;
    public function beginTransaction(): bool;
    public function commit(): bool;
    public function rollback(): bool;
}

