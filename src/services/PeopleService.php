<?php
/**
 * People Service
 * Handles team member data operations
 */

class PeopleService {
    private static $pdo = null;
    
    /**
     * Get PDO connection
     */
    private static function getPdo() {
        if (self::$pdo === null) {
            try {
                $result = require_once __DIR__ . '/../../bootstrap.php';
                
                // If require_once returns true, it means the file was already included
                // In that case, we need to create a new PDO connection
                if ($result === true) {
                    // Create PDO connection manually
                    $config = [
                        'host' => getenv('DB_HOST') ?: 'localhost',
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
                error_log("PeopleService PDO error: " . $e->getMessage());
                throw new Exception("Database connection failed in PeopleService: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
    
    /**
     * Get all visible people for a specific language
     */
    public static function getVisiblePeople(string $languageCode): array {
        try {
            $pdo = self::getPdo();
            $stmt = $pdo->prepare("
                SELECT id, name, title, description, image_url, display_order
                FROM people 
                WHERE language_code = ? AND is_visible = 1 
                ORDER BY display_order ASC, name ASC
            ");
            $stmt->execute([$languageCode]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Failed to get visible people: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get all people (for admin)
     */
    public static function getAllPeople(): array {
        try {
            $pdo = self::getPdo();
            $stmt = $pdo->prepare("
                SELECT id, name, title, description, image_url, language_code, display_order, is_visible, created_at, updated_at
                FROM people 
                ORDER BY language_code ASC, display_order ASC, name ASC
            ");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Failed to get all people: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get person by ID
     */
    public static function getPersonById(int $id): ?array {
        try {
            $pdo = self::getPdo();
            $stmt = $pdo->prepare("
                SELECT id, name, title, description, image_url, language_code, display_order, is_visible, created_at, updated_at
                FROM people 
                WHERE id = ?
            ");
            $stmt->execute([$id]);
            $result = $stmt->fetch();
            return $result ?: null;
        } catch (Exception $e) {
            error_log("Failed to get person by ID: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Create new person
     */
    public static function createPerson(array $data): int {
        try {
            $pdo = self::getPdo();
            $stmt = $pdo->prepare("
                INSERT INTO people (name, title, description, image_url, language_code, display_order, is_visible) 
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $data['name'],
                $data['title'],
                $data['description'],
                $data['image_url'] ?? null,
                $data['language_code'],
                $data['display_order'] ?? 0,
                $data['is_visible'] ?? true
            ]);
            return (int) $pdo->lastInsertId();
        } catch (Exception $e) {
            error_log("Failed to create person: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Get the next available display order
     */
    public static function getNextDisplayOrder(): int {
        try {
            $pdo = self::getPdo();
            $stmt = $pdo->prepare("SELECT MAX(display_order) FROM people");
            $stmt->execute();
            $maxOrder = $stmt->fetchColumn();
            return ($maxOrder ?: 0) + 1;
        } catch (Exception $e) {
            error_log("Failed to get next display order: " . $e->getMessage());
            return 1;
        }
    }

    /**
     * Update person
     */
    public static function updatePerson(int $id, array $data): bool {
        try {
            $pdo = self::getPdo();
            $stmt = $pdo->prepare("
                UPDATE people 
                SET name = ?, title = ?, description = ?, image_url = ?, language_code = ?, display_order = ?, is_visible = ?
                WHERE id = ?
            ");
            
            $stmt->execute([
                $data['name'],
                $data['title'],
                $data['description'],
                $data['image_url'] ?? null,
                $data['language_code'],
                $data['display_order'] ?? 0,
                $data['is_visible'] ?? true,
                $id
            ]);
            
            $rowCount = $stmt->rowCount();
            error_log("DEBUG: SQL UPDATE executed. Row count: " . $rowCount);
            error_log("DEBUG: Person ID being updated: " . $id);
            error_log("DEBUG: Data being updated: " . print_r($data, true));
            
            return $rowCount > 0;
        } catch (Exception $e) {
            error_log("Failed to update person: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Delete person
     */
    public static function deletePerson(int $id): bool {
        try {
            $pdo = self::getPdo();
            $stmt = $pdo->prepare("DELETE FROM people WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Failed to delete person: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Update display order
     */
    public static function updateDisplayOrder(array $orderData): bool {
        try {
            $pdo = self::getPdo();
            $pdo->beginTransaction();
            
            $stmt = $pdo->prepare("UPDATE people SET display_order = ? WHERE id = ?");
            foreach ($orderData as $item) {
                $stmt->execute([$item['order'], $item['id']]);
            }
            
            $pdo->commit();
            return true;
        } catch (Exception $e) {
            $pdo->rollback();
            error_log("Failed to update display order: " . $e->getMessage());
            throw $e;
        }
    }
}
?>
