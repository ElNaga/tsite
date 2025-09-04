<?php
/**
 * PDO Bootstrap Usage Examples
 * 
 * This file demonstrates different ways to use the PDO bootstrap
 * in your application.
 */

// Method 1: Direct inclusion (returns PDO instance)
$pdo = require_once __DIR__ . '/../config/pdo_bootstrap.php';

// Example 1: Simple query
try {
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
    $result = $stmt->fetch();
    echo "Total users: " . $result['total'] . "\n";
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage() . "\n";
}

// Example 2: Prepared statement
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([1]);
    $user = $stmt->fetch();
    
    if ($user) {
        echo "User found: " . $user['name'] . "\n";
    } else {
        echo "User not found\n";
    }
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage() . "\n";
}

// Example 3: Transaction
try {
    $pdo->beginTransaction();
    
    // Multiple operations within transaction
    $stmt1 = $pdo->prepare("INSERT INTO logs (message) VALUES (?)");
    $stmt1->execute(['User login']);
    
    $stmt2 = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
    $stmt2->execute([1]);
    
    $pdo->commit();
    echo "Transaction completed successfully\n";
    
} catch (PDOException $e) {
    $pdo->rollback();
    echo "Transaction failed: " . $e->getMessage() . "\n";
}

// Method 2: Using in a class
class UserRepository {
    private PDO $pdo;
    
    public function __construct() {
        $this->pdo = require_once __DIR__ . '/../config/pdo_bootstrap.php';
    }
    
    public function findById(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }
    
    public function create(array $userData): int {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        $stmt->execute([$userData['name'], $userData['email']]);
        return (int) $this->pdo->lastInsertId();
    }
}

// Usage of the repository
$userRepo = new UserRepository();
$user = $userRepo->findById(1);

if ($user) {
    echo "Found user: " . $user['name'] . "\n";
}
