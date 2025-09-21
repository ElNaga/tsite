<?php
require_once __DIR__ . '/../interfaces/DatabaseInterface.php';

class DatabaseConnection implements DatabaseInterface {
    private ?PDO $connection = null;
    private string $host;
    private string $database;
    private string $username;
    private string $password;
    private string $charset;

    public function __construct(
        string $host = 'localhost',
        string $database = 'teatar_zatebe',
        string $username = 'root',
        string $password = '',
        string $charset = 'utf8mb4'
    ) {
        $this->host = $host;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
        $this->charset = $charset;
    }

    public function connect(): bool {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->database};charset={$this->charset}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            $this->connection = new PDO($dsn, $this->username, $this->password, $options);
            return true;
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            return false;
        }
    }

    public function disconnect(): void {
        $this->connection = null;
    }

    public function query(string $sql, array $params = []): mixed {
        if (!$this->connection) {
            throw new Exception("Database not connected");
        }

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log("Database query failed: " . $e->getMessage());
            throw $e;
        }
    }

    public function insert(string $table, array $data): int {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $this->query($sql, $data);
        
        return (int) $this->connection->lastInsertId();
    }

    public function update(string $table, array $data, array $where): bool {
        $setClause = implode(', ', array_map(fn($col) => "{$col} = :{$col}", array_keys($data)));
        $whereClause = implode(' AND ', array_map(fn($col) => "{$col} = :where_{$col}", array_keys($where)));
        
        $sql = "UPDATE {$table} SET {$setClause} WHERE {$whereClause}";
        
        $params = $data;
        foreach ($where as $key => $value) {
            $params["where_{$key}"] = $value;
        }
        
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount() > 0;
    }

    public function delete(string $table, array $where): bool {
        $whereClause = implode(' AND ', array_map(fn($col) => "{$col} = :{$col}", array_keys($where)));
        $sql = "DELETE FROM {$table} WHERE {$whereClause}";
        
        $stmt = $this->query($sql, $where);
        return $stmt->rowCount() > 0;
    }

    public function fetchAll(string $sql, array $params = []): array {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    public function fetchOne(string $sql, array $params = []): ?array {
        $stmt = $this->query($sql, $params);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function beginTransaction(): bool {
        if (!$this->connection) {
            return false;
        }
        return $this->connection->beginTransaction();
    }

    public function commit(): bool {
        if (!$this->connection) {
            return false;
        }
        return $this->connection->commit();
    }

    public function rollback(): bool {
        if (!$this->connection) {
            return false;
        }
        return $this->connection->rollback();
    }

    public function getConnection(): ?PDO {
        return $this->connection;
    }

    public function isConnected(): bool {
        return $this->connection !== null;
    }
}








