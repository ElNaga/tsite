<?php
// Test Database Connection and Migration
require_once __DIR__ . '/src/database/DatabaseConnection.php';
require_once __DIR__ . '/database/migrate.php';

echo "=== Database Connection Test ===\n";

// Test basic connection
try {
    $db = new DatabaseConnection();
    if ($db->connect()) {
        echo "✅ Database connection successful!\n";
        
        // Test a simple query
        $result = $db->fetchOne("SELECT VERSION() as version");
        if ($result) {
            echo "✅ MySQL Version: " . $result['version'] . "\n";
        }
        
        $db->disconnect();
    } else {
        echo "❌ Database connection failed!\n";
        exit(1);
    }
} catch (Exception $e) {
    echo "❌ Connection error: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n=== Running Database Migration ===\n";

// Run the migration
$migration = new DatabaseMigration();
$success = $migration->run();

if ($success) {
    echo "\n✅ Migration completed successfully!\n";
    
    // Test if tables were created
    try {
        $db = new DatabaseConnection();
        $db->connect();
        
        $tables = $db->fetchAll("SHOW TABLES");
        echo "\n📋 Created tables:\n";
        foreach ($tables as $table) {
            $tableName = array_values($table)[0];
            echo "  - " . $tableName . "\n";
        }
        
        // Test if data was migrated
        $eventCount = $db->fetchOne("SELECT COUNT(*) as count FROM events");
        $translationCount = $db->fetchOne("SELECT COUNT(*) as count FROM translations");
        
        echo "\n📊 Data summary:\n";
        echo "  - Events: " . $eventCount['count'] . "\n";
        echo "  - Translations: " . $translationCount['count'] . "\n";
        
        $db->disconnect();
        
    } catch (Exception $e) {
        echo "❌ Error testing tables: " . $e->getMessage() . "\n";
    }
    
} else {
    echo "\n❌ Migration failed!\n";
    exit(1);
}

echo "\n=== Test Complete ===\n";
echo "You can now use the database with:\n";
echo "- Admin login: admin@teatarzatebe.mk / admin123\n";
echo "- Database name: teatar_zatebe\n";










