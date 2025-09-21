<?php
/**
 * Event Service - Database-backed events
 * Replaces the static data/events.json file
 */

class EventService {
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
                error_log("EventService PDO error: " . $e->getMessage());
                throw new Exception("Database connection failed in EventService: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
    
    /**
     * Get all events with translations for current language
     */
    public static function getEvents(string $lang = null): array {
        if ($lang === null) {
            $lang = TranslationService::getCurrentLang();
        }
        
        try {
            $pdo = self::getPdo();
            $stmt = $pdo->prepare("
                SELECT 
                    e.id,
                    e.image,
                    e.book_url,
                    e.status,
                    et.title,
                    et.description,
                    et.book_label,
                    et.image_alt
                FROM events e
                JOIN event_translations et ON e.id = et.event_id
                WHERE et.language_code = ? AND e.status = 'published'
                ORDER BY e.id ASC
            ");
            $stmt->execute([$lang]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Failed to get events: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get event by ID with translations
     */
    public static function getEvent(int $id, string $lang = null): ?array {
        if ($lang === null) {
            $lang = TranslationService::getCurrentLang();
        }
        
        try {
            $pdo = self::getPdo();
            $stmt = $pdo->prepare("
                SELECT 
                    e.id,
                    e.image,
                    e.book_url,
                    e.status,
                    et.title,
                    et.description,
                    et.book_label,
                    et.image_alt
                FROM events e
                JOIN event_translations et ON e.id = et.event_id
                WHERE e.id = ? AND et.language_code = ? AND e.status = 'published'
            ");
            $stmt->execute([$id, $lang]);
            return $stmt->fetch() ?: null;
        } catch (Exception $e) {
            error_log("Failed to get event: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Get events in all languages (for admin)
     */
    public static function getAllEvents(): array {
        try {
            $pdo = self::getPdo();
            $stmt = $pdo->prepare("
                SELECT 
                    e.id,
                    e.image,
                    e.book_url,
                    e.status,
                    et.language_code,
                    et.title,
                    et.description,
                    et.book_label,
                    et.image_alt
                FROM events e
                JOIN event_translations et ON e.id = et.event_id
                ORDER BY e.id ASC, et.language_code ASC
            ");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Failed to get all events: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Create new event
     */
    public static function createEvent(array $eventData, array $translations): int {
        $pdo = null;
        try {
            $pdo = self::getPdo();
            $pdo->beginTransaction();
            
            // Insert event
            $stmt = $pdo->prepare("
                INSERT INTO events (image, book_url, status) 
                VALUES (?, ?, ?)
            ");
            $stmt->execute([
                $eventData['image'],
                $eventData['book_url'],
                $eventData['status'] ?? 'published'
            ]);
            
            $eventId = (int) $pdo->lastInsertId();
            
            // Insert translations
            $stmt = $pdo->prepare("
                INSERT INTO event_translations (event_id, language_code, title, description, book_label, image_alt) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            
            foreach ($translations as $lang => $translation) {
                $stmt->execute([
                    $eventId,
                    $lang,
                    $translation['title'],
                    $translation['description'],
                    $translation['book_label'],
                    $translation['image_alt']
                ]);
            }
            
            $pdo->commit();
            return $eventId;
        } catch (Exception $e) {
            if ($pdo !== null) {
                $pdo->rollback();
            }
            error_log("Failed to create event: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Update event
     */
    public static function updateEvent(int $id, array $eventData, array $translations): bool {
        $pdo = null;
        try {
            $pdo = self::getPdo();
            $pdo->beginTransaction();
            
            // Update event
            $stmt = $pdo->prepare("
                UPDATE events 
                SET image = ?, book_url = ?, status = ?
                WHERE id = ?
            ");
            $stmt->execute([
                $eventData['image'],
                $eventData['book_url'],
                $eventData['status'] ?? 'published',
                $id
            ]);
            
            // Update translations
            $stmt = $pdo->prepare("
                UPDATE event_translations 
                SET title = ?, description = ?, book_label = ?, image_alt = ?
                WHERE event_id = ? AND language_code = ?
            ");
            
            foreach ($translations as $lang => $translation) {
                $stmt->execute([
                    $translation['title'],
                    $translation['description'],
                    $translation['book_label'],
                    $translation['image_alt'],
                    $id,
                    $lang
                ]);
            }
            
            $pdo->commit();
            return true;
        } catch (Exception $e) {
            if ($pdo !== null) {
                $pdo->rollback();
            }
            error_log("Failed to update event: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Delete event
     */
    public static function deleteEvent(int $id): bool {
        try {
            $pdo = self::getPdo();
            $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Failed to delete event: " . $e->getMessage());
            return false;
        }
    }
} 