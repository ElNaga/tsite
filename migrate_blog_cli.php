<?php
/**
 * Blog Schema Migration - Command Line Version
 * 
 * Run this from command line: php migrate_blog_cli.php
 */

echo "🔄 Blog Schema Migration\n";
echo "========================\n\n";

try {
    // Get database connection
    $pdo = require_once __DIR__ . '/bootstrap.php';
    
    if (!($pdo instanceof PDO)) {
        throw new Exception("Failed to get database connection");
    }
    
    echo "1. Checking current table structure...\n";
    
    // Check if blog_posts table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'blog_posts'");
    if ($stmt->rowCount() === 0) {
        echo "   📋 blog_posts table does not exist. Creating new table...\n";
        
        // Create the table from scratch
        $createTableSQL = "
        CREATE TABLE blog_posts (
            id INT PRIMARY KEY AUTO_INCREMENT,
            language VARCHAR(2) NOT NULL,
            main_title VARCHAR(255) NOT NULL,
            main_text TEXT NOT NULL,
            main_image VARCHAR(255) NOT NULL,
            secondary_title VARCHAR(255) NOT NULL,
            secondary_text TEXT NOT NULL,
            secondary_image VARCHAR(255) NOT NULL,
            gallery_images TEXT NULL,
            visible BOOLEAN DEFAULT TRUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (language) REFERENCES languages(code),
            INDEX idx_language (language),
            INDEX idx_visible (visible),
            INDEX idx_created_at (created_at)
        )";
        
        $pdo->exec($createTableSQL);
        echo "   ✅ blog_posts table created successfully\n";
        
    } else {
        echo "   📋 blog_posts table exists. Checking structure...\n";
        
        // Get current table structure
        $stmt = $pdo->query("DESCRIBE blog_posts");
        $columns = $stmt->fetchAll();
        
        echo "   Current columns:\n";
        foreach ($columns as $column) {
            echo "     - {$column['Field']} ({$column['Type']})\n";
        }
        
        // Check if we need to migrate
        $columnNames = array_column($columns, 'Field');
        $needsMigration = !in_array('language', $columnNames) || 
                         !in_array('main_title', $columnNames) ||
                         !in_array('main_text', $columnNames);
        
        if ($needsMigration) {
            echo "   ⚠️  Table structure needs migration\n";
            
            // Check if blog_post_translations table exists and drop it first
            $stmt = $pdo->query("SHOW TABLES LIKE 'blog_post_translations'");
            if ($stmt->rowCount() > 0) {
                echo "   🔄 Dropping blog_post_translations table first...\n";
                $pdo->exec("DROP TABLE IF EXISTS blog_post_translations");
            }
            
            echo "   🔄 Dropping old blog_posts table and recreating...\n";
            
            $pdo->exec("DROP TABLE IF EXISTS blog_posts");
            
            $createTableSQL = "
            CREATE TABLE blog_posts (
                id INT PRIMARY KEY AUTO_INCREMENT,
                language VARCHAR(2) NOT NULL,
                main_title VARCHAR(255) NOT NULL,
                main_text TEXT NOT NULL,
                main_image VARCHAR(255) NOT NULL,
                secondary_title VARCHAR(255) NOT NULL,
                secondary_text TEXT NOT NULL,
                secondary_image VARCHAR(255) NOT NULL,
                gallery_images TEXT NULL,
                visible BOOLEAN DEFAULT TRUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (language) REFERENCES languages(code),
                INDEX idx_language (language),
                INDEX idx_visible (visible),
                INDEX idx_created_at (created_at)
            )";
            
            $pdo->exec($createTableSQL);
            echo "   ✅ blog_posts table recreated successfully\n";
            
        } else {
            echo "   ✅ Table structure is already correct\n";
        }
    }
    
    echo "\n2. Verifying new table structure...\n";
    
    $stmt = $pdo->query("DESCRIBE blog_posts");
    $columns = $stmt->fetchAll();
    
    echo "   ✅ New table structure:\n";
    foreach ($columns as $column) {
        echo "     - {$column['Field']} ({$column['Type']})\n";
    }
    
    echo "\n3. Testing BlogService...\n";
    
    require_once __DIR__ . '/src/services/BlogService.php';
    
    try {
        // Test basic functionality
        $posts = BlogService::getBlogPosts('en', 1, 5);
        echo "   ✅ BlogService::getBlogPosts() works - found " . count($posts) . " posts\n";
        
        $total = BlogService::getTotalBlogPosts('en');
        echo "   ✅ BlogService::getTotalBlogPosts() works - total: $total posts\n";
        
    } catch (Exception $e) {
        echo "   ❌ BlogService test failed: " . $e->getMessage() . "\n";
    }
    
    echo "\n========================\n";
    echo "🎉 Migration completed successfully!\n";
    echo "\nNext steps:\n";
    echo "- Run: php populate_blog.php (to add sample data)\n";
    echo "- Visit: http://localhost:8080/blog (to view the blog)\n";
    echo "- Visit: http://localhost:8080/admin/blog (to manage posts)\n";
    
} catch (Exception $e) {
    echo "\n❌ Migration failed: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}
?>
