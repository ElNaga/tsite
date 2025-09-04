<?php
/**
 * Database Migration Script for Teatar za tebe
 * 
 * This script:
 * 1. Creates the database if it doesn't exist
 * 2. Creates all tables with proper relationships
 * 3. Inserts default languages and admin user
 * 4. Migrates existing events from events.json
 * 5. Migrates existing transactions from transactions.json
 * 6. Inserts default translations
 */

echo "🚀 Starting Database Migration for Teatar za tebe...\n\n";

try {
    // First, connect without specifying database to create it if needed
    $config = [
        'host' => getenv('DB_HOST') ?: '127.0.0.1',
        'port' => getenv('DB_PORT') ?: '3307',
        'user' => getenv('DB_USER') ?: 'tzt',
        'pass' => getenv('DB_PASS') ?: 'tztpass',
        'charset' => 'utf8mb4'
    ];

    $dsn = "mysql:host={$config['host']};port={$config['port']};charset={$config['charset']}";
    $pdo = new PDO($dsn, $config['user'], $config['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    echo "✅ Connected to MySQL server\n";

    // Create database if it doesn't exist
    $dbName = getenv('DB_NAME') ?: 'teatar_zatebe';
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✅ Database '$dbName' ready\n";

    // Connect to the specific database
    $pdo->exec("USE `$dbName`");
    echo "✅ Connected to database '$dbName'\n\n";

    // Read and execute schema
    echo "📋 Creating database schema...\n";
    $schema = file_get_contents(__DIR__ . '/database/schema.sql');
    
    // Split schema into individual statements
    $statements = array_filter(array_map('trim', explode(';', $schema)));
    
    foreach ($statements as $statement) {
        if (!empty($statement)) {
            $pdo->exec($statement);
        }
    }
    echo "✅ Database schema created successfully\n\n";

    // Migrate events from JSON
    echo "📅 Migrating events from JSON...\n";
    $eventsData = json_decode(file_get_contents(__DIR__ . '/data/events.json'), true);
    
    if ($eventsData) {
        $eventIds = [];
        
        // Get unique event IDs
        foreach ($eventsData as $lang => $events) {
            foreach ($events as $event) {
                $eventIds[$event['id']] = $event;
            }
        }
        
        // Insert events
        $stmt = $pdo->prepare("
            INSERT INTO events (id, image, book_url, status) 
            VALUES (?, ?, ?, 'published')
            ON DUPLICATE KEY UPDATE 
            image = VALUES(image), 
            book_url = VALUES(book_url)
        ");
        
        foreach ($eventIds as $id => $event) {
            $stmt->execute([$id, $event['image'], $event['book_url']]);
        }
        
        // Insert event translations
        $stmt = $pdo->prepare("
            INSERT INTO event_translations (event_id, language_code, title, description, book_label, image_alt) 
            VALUES (?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE 
            title = VALUES(title),
            description = VALUES(description),
            book_label = VALUES(book_label),
            image_alt = VALUES(image_alt)
        ");
        
        foreach ($eventsData as $lang => $events) {
            foreach ($events as $event) {
                $stmt->execute([
                    $event['id'],
                    $lang,
                    $event['title'],
                    $event['desc'],
                    $event['book_label'],
                    $event['image_alt']
                ]);
            }
        }
        
        echo "✅ Migrated " . count($eventIds) . " events with translations\n";
    } else {
        echo "⚠️  No events data found in JSON file\n";
    }

    // Migrate transactions from JSON
    echo "\n💰 Migrating transactions from JSON...\n";
    $transactionsData = json_decode(file_get_contents(__DIR__ . '/data/transactions.json'), true);
    
    if ($transactionsData && count($transactionsData) > 0) {
        $stmt = $pdo->prepare("
            INSERT INTO transactions (event_id, user_data, status, amount, payment_method) 
            VALUES (?, ?, ?, ?, ?)
        ");
        
        foreach ($transactionsData as $transaction) {
            $stmt->execute([
                $transaction['event_id'] ?? 1,
                json_encode($transaction['user_data'] ?? []),
                $transaction['status'] ?? 'completed',
                $transaction['amount'] ?? null,
                $transaction['payment_method'] ?? null
            ]);
        }
        
        echo "✅ Migrated " . count($transactionsData) . " transactions\n";
    } else {
        echo "⚠️  No transactions data found in JSON file\n";
    }

    // Verify migration
    echo "\n🔍 Verifying migration...\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM languages");
    $languages = $stmt->fetch();
    echo "✅ Languages: " . $languages['count'] . " records\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $users = $stmt->fetch();
    echo "✅ Users: " . $users['count'] . " records\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM events");
    $events = $stmt->fetch();
    echo "✅ Events: " . $events['count'] . " records\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM event_translations");
    $eventTranslations = $stmt->fetch();
    echo "✅ Event Translations: " . $eventTranslations['count'] . " records\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM transactions");
    $transactions = $stmt->fetch();
    echo "✅ Transactions: " . $transactions['count'] . " records\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM translations");
    $translations = $stmt->fetch();
    echo "✅ Static Translations: " . $translations['count'] . " records\n";

    echo "\n🎉 Database migration completed successfully!\n";
    echo "\n📋 Summary:\n";
    echo "- Database: $dbName\n";
    echo "- Host: {$config['host']}:{$config['port']}\n";
    echo "- User: {$config['user']}\n";
    echo "- Default admin: admin@teatarzatebe.mk / admin123\n";
    echo "\n🔗 Access URLs:\n";
    echo "- PHPMyAdmin: http://localhost:8081\n";
    echo "- PHP Test: http://localhost:8080/test_docker_connection.php\n";

} catch (PDOException $e) {
    echo "❌ Database Error: " . $e->getMessage() . "\n";
    echo "Error Code: " . $e->getCode() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "❌ General Error: " . $e->getMessage() . "\n";
    exit(1);
}
