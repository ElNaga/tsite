<?php
/**
 * Transaction Service - Database-backed transactions
 * Handles booking transactions and admin data
 */

class TransactionService {
    private static $pdo = null;
    
    private static function getPdo() {
        if (self::$pdo === null) {
            try {
                $result = require_once __DIR__ . '/../../bootstrap.php';
                
                // If require_once returns true, it means the file was already included
                // In that case, we need to create a new PDO connection
                if ($result === true) {
                    // Create PDO connection manually
                    $config = [
                        'host' => getenv('DB_HOST') ?: '127.0.0.1',
                        'port' => getenv('DB_PORT') ?: '3307',
                        'db'   => getenv('DB_NAME') ?: 'teatar_zatebe',
                        'user' => getenv('DB_USER') ?: 'tzt',
                        'pass' => getenv('DB_PASS') ?: 'tztpass',
                        'charset' => 'utf8mb4'
                    ];

                    $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['db']};charset={$config['charset']}";
                    
                    self::$pdo = new PDO($dsn, $config['user'], $config['pass'], [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]);
                } else {
                    // Got a PDO object directly
                    self::$pdo = $result;
                }
                
                // Verify we got a valid PDO object
                if (!self::$pdo || !(self::$pdo instanceof PDO)) {
                    throw new Exception("Invalid PDO object returned from bootstrap.php");
                }
            } catch (Exception $e) {
                error_log("TransactionService PDO error: " . $e->getMessage());
                throw new Exception("Database connection failed in TransactionService: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
    
    /**
     * Get all transactions
     */
    public static function getAllTransactions(): array {
        try {
            $pdo = self::getPdo();
            $stmt = $pdo->prepare("
                SELECT 
                    t.id,
                    t.event_id,
                    t.user_data,
                    t.status,
                    t.amount,
                    t.payment_method,
                    t.created_at,
                    e.image as event_image,
                    et.title as event_title,
                    et.language_code
                FROM transactions t
                LEFT JOIN events e ON t.event_id = e.id
                LEFT JOIN event_translations et ON e.id = et.event_id
                ORDER BY t.created_at DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Failed to get transactions: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get transactions for a specific event
     */
    public static function getTransactionsForEvent(int $eventId): array {
        try {
            $pdo = self::getPdo();
            $stmt = $pdo->prepare("
                SELECT * FROM transactions 
                WHERE event_id = ? 
                ORDER BY created_at DESC
            ");
            $stmt->execute([$eventId]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Failed to get transactions for event: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Create a new transaction
     */
    public static function createTransaction(array $transactionData): int {
        try {
            $pdo = self::getPdo();
            // Prepare user data as JSON
            $userData = [
                'name' => $transactionData['user_name'] ?? '',
                'email' => $transactionData['user_email'] ?? '',
                'phone' => $transactionData['user_phone'] ?? '',
                'booking_date' => $transactionData['booking_date'] ?? date('Y-m-d H:i:s')
            ];
            
            $stmt = $pdo->prepare("
                INSERT INTO transactions (event_id, user_data, status, amount, payment_method) 
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $transactionData['event_id'],
                json_encode($userData),
                $transactionData['status'] ?? 'pending',
                $transactionData['amount'] ?? null,
                $transactionData['payment_method'] ?? null
            ]);
            
            return (int) $pdo->lastInsertId();
        } catch (Exception $e) {
            error_log("Failed to create transaction: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Update transaction status
     */
    public static function updateTransactionStatus(int $transactionId, string $status): bool {
        try {
            $pdo = self::getPdo();
            $stmt = $pdo->prepare("
                UPDATE transactions 
                SET status = ? 
                WHERE id = ?
            ");
            $stmt->execute([$status, $transactionId]);
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Failed to update transaction status: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Delete transaction
     */
    public static function deleteTransaction(int $transactionId): bool {
        try {
            $pdo = self::getPdo();
            $stmt = $pdo->prepare("DELETE FROM transactions WHERE id = ?");
            $stmt->execute([$transactionId]);
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Failed to delete transaction: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get transaction statistics
     */
    public static function getStatistics(): array {
        try {
            $pdo = self::getPdo();
            
            // Total transactions
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM transactions");
            $total = $stmt->fetch()['total'];
            
            // Pending transactions
            $stmt = $pdo->query("SELECT COUNT(*) as pending FROM transactions WHERE status = 'pending'");
            $pending = $stmt->fetch()['pending'];
            
            // Confirmed transactions
            $stmt = $pdo->query("SELECT COUNT(*) as confirmed FROM transactions WHERE status = 'confirmed'");
            $confirmed = $stmt->fetch()['confirmed'];
            
            // Recent transactions (last 30 days)
            $stmt = $pdo->query("SELECT COUNT(*) as recent FROM transactions WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
            $recent = $stmt->fetch()['recent'];
            
            return [
                'total' => $total,
                'pending' => $pending,
                'confirmed' => $confirmed,
                'recent' => $recent
            ];
        } catch (Exception $e) {
            error_log("Failed to get transaction statistics: " . $e->getMessage());
            return [
                'total' => 0,
                'pending' => 0,
                'confirmed' => 0,
                'recent' => 0
            ];
        }
    }
}
