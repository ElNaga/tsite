<?php
require_once __DIR__ . '/../src/database/DatabaseConnection.php';
require_once __DIR__ . '/../src/models/EventModel.php';
require_once __DIR__ . '/../src/models/UserModel.php';
require_once __DIR__ . '/../src/models/TransactionModel.php';
require_once __DIR__ . '/../src/models/TranslationModel.php';

class DatabaseMigration {
    private DatabaseConnection $db;
    private string $schemaFile;

    public function __construct() {
        $this->db = new DatabaseConnection();
        $this->schemaFile = __DIR__ . '/schema.sql';
    }

    public function run(): bool {
        echo "Starting database migration...\n";

        // Connect to database
        if (!$this->db->connect()) {
            echo "Failed to connect to database\n";
            return false;
        }

        // Create database if it doesn't exist
        $this->createDatabaseIfNotExists();

        // Run schema
        if (!$this->runSchema()) {
            echo "Failed to run schema\n";
            return false;
        }

        // Migrate existing data
        if (!$this->migrateExistingData()) {
            echo "Failed to migrate existing data\n";
            return false;
        }

        echo "Database migration completed successfully!\n";
        return true;
    }

    private function createDatabaseIfNotExists(): void {
        $config = require __DIR__ . '/../config/database.php';
        $dbName = $config['database'];
        
        // Connect without database name
        $tempDb = new DatabaseConnection($config['host'], '', $config['username'], $config['password']);
        if ($tempDb->connect()) {
            $tempDb->query("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            echo "Database '{$dbName}' created or already exists\n";
        }
        $tempDb->disconnect();
    }

    private function runSchema(): bool {
        if (!file_exists($this->schemaFile)) {
            echo "Schema file not found: {$this->schemaFile}\n";
            return false;
        }

        $sql = file_get_contents($this->schemaFile);
        $statements = array_filter(array_map('trim', explode(';', $sql)));

        foreach ($statements as $statement) {
            if (empty($statement)) continue;
            
            try {
                $this->db->query($statement);
                echo "Executed: " . substr($statement, 0, 50) . "...\n";
            } catch (Exception $e) {
                echo "Error executing statement: " . $e->getMessage() . "\n";
                return false;
            }
        }

        return true;
    }

    private function migrateExistingData(): bool {
        // Migrate events from JSON
        $this->migrateEvents();
        
        // Migrate transactions from JSON
        $this->migrateTransactions();

        return true;
    }

    private function migrateEvents(): void {
        $eventsFile = __DIR__ . '/../data/events.json';
        if (!file_exists($eventsFile)) {
            echo "No events.json file found, skipping events migration\n";
            return;
        }

        $eventsData = json_decode(file_get_contents($eventsFile), true);
        if (!$eventsData) {
            echo "Invalid events.json file\n";
            return;
        }

        echo "Migrating events...\n";

        foreach (['en', 'mk', 'fr'] as $lang) {
            if (!isset($eventsData[$lang])) continue;

            foreach ($eventsData[$lang] as $eventData) {
                $eventId = $eventData['id'];

                // Check if event already exists
                $existingEvent = $this->db->fetchOne(
                    "SELECT id FROM events WHERE id = ?",
                    [$eventId]
                );

                if (!$existingEvent) {
                    // Insert main event
                    $this->db->insert('events', [
                        'id' => $eventId,
                        'image' => $eventData['image'],
                        'book_url' => $eventData['book_url'],
                        'status' => 'published'
                    ]);
                }

                // Insert/update translation
                $this->db->query(
                    "INSERT INTO event_translations (event_id, language_code, title, description, book_label, image_alt) 
                     VALUES (?, ?, ?, ?, ?, ?) 
                     ON DUPLICATE KEY UPDATE 
                     title = VALUES(title), 
                     description = VALUES(description), 
                     book_label = VALUES(book_label), 
                     image_alt = VALUES(image_alt)",
                    [
                        $eventId,
                        $lang,
                        $eventData['title'],
                        $eventData['desc'],
                        $eventData['book_label'],
                        $eventData['image_alt']
                    ]
                );
            }
        }

        echo "Events migration completed\n";
    }

    private function migrateTransactions(): void {
        $transactionsFile = __DIR__ . '/../data/transactions.json';
        if (!file_exists($transactionsFile)) {
            echo "No transactions.json file found, skipping transactions migration\n";
            return;
        }

        $transactionsData = json_decode(file_get_contents($transactionsFile), true);
        if (!$transactionsData || empty($transactionsData)) {
            echo "No transactions to migrate\n";
            return;
        }

        echo "Migrating transactions...\n";

        foreach ($transactionsData as $transactionData) {
            $this->db->insert('transactions', [
                'event_id' => $transactionData['event_id'],
                'user_data' => json_encode($transactionData['user']),
                'status' => 'confirmed',
                'timestamp' => $transactionData['timestamp']
            ]);
        }

        echo "Transactions migration completed\n";
    }
}

// Run migration if called directly
if (php_sapi_name() === 'cli') {
    $migration = new DatabaseMigration();
    $success = $migration->run();
    exit($success ? 0 : 1);
}
















