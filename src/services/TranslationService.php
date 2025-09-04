<?php
/**
 * Translation Service - Database-backed translations
 * Replaces the static i18n.php file
 */

class TranslationService {
    private static $translations = [];
    private static $currentLang = 'en';
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
                error_log("TranslationService PDO error: " . $e->getMessage());
                throw new Exception("Database connection failed in TranslationService: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
    
    /**
     * Get translation for a key in current language
     */
    public static function t(string $key): string {
        $lang = self::getCurrentLang();
        
        // Check if we have it cached
        if (isset(self::$translations[$lang][$key])) {
            return self::$translations[$lang][$key];
        }
        
        // Load from database
        try {
            $pdo = self::getPdo();
            $stmt = $pdo->prepare("SELECT translation_value FROM translations WHERE language_code = ? AND translation_key = ?");
            $stmt->execute([$lang, $key]);
            $result = $stmt->fetch();
            
            if ($result) {
                // Cache it
                self::$translations[$lang][$key] = $result['translation_value'];
                return $result['translation_value'];
            }
        } catch (Exception $e) {
            error_log("Translation error: " . $e->getMessage());
        }
        
        // Fallback to key if not found
        return $key;
    }
    
    /**
     * Get current language
     */
    public static function getCurrentLang(): string {
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            session_start();
        }
        
        // Check session first (this should be the priority)
        if (isset($_SESSION['lang']) && in_array($_SESSION['lang'], ['en', 'mk', 'fr'])) {
            self::$currentLang = $_SESSION['lang'];
            return self::$currentLang;
        }
        
        // Check URL parameter (for initial language setting)
        if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'mk', 'fr'])) {
            self::$currentLang = $_GET['lang'];
            // Save to session immediately
            if (!headers_sent()) {
                $_SESSION['lang'] = self::$currentLang;
            }
            return self::$currentLang;
        }
        
        // Default to English
        return self::$currentLang;
    }
    
    /**
     * Set language
     */
    public static function setLang(string $lang): void {
        if (in_array($lang, ['en', 'mk', 'fr'])) {
            if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
                session_start();
            }
            if (!headers_sent()) {
                $_SESSION['lang'] = $lang;
            }
            self::$currentLang = $lang;
        }
    }
    
    /**
     * Get available languages
     */
    public static function getLanguages(): array {
        return [
            'en' => 'English',
            'mk' => 'Македонски', 
            'fr' => 'Français'
        ];
    }
    
    /**
     * Load all translations for current language (for performance)
     */
    public static function loadTranslations(): void {
        $lang = self::getCurrentLang();
        
        if (isset(self::$translations[$lang])) {
            return; // Already loaded
        }
        
        try {
            $pdo = self::getPdo();
            $stmt = $pdo->prepare("SELECT translation_key, translation_value FROM translations WHERE language_code = ?");
            $stmt->execute([$lang]);
            $results = $stmt->fetchAll();
            
            self::$translations[$lang] = [];
            foreach ($results as $row) {
                self::$translations[$lang][$row['translation_key']] = $row['translation_value'];
            }
        } catch (Exception $e) {
            error_log("Failed to load translations: " . $e->getMessage());
            self::$translations[$lang] = [];
        }
    }
}
