<?php
/**
 * Blog Schema Migration
 * 
 * This script migrates the blog_posts table to the new structure.
 * Run this via web browser: http://localhost:8080/migrate_blog_schema.php
 */

echo "<h1>🔄 Blog Schema Migration</h1>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .success { color: green; }
    .error { color: red; }
    .info { color: blue; }
    .warning { color: orange; }
    .step { margin: 15px 0; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
</style>";

try {
    // Get database connection
    $pdo = require_once __DIR__ . '/bootstrap.php';
    
    if (!($pdo instanceof PDO)) {
        throw new Exception("Failed to get database connection");
    }
    
    echo "<div class='step'>";
    echo "<h2>1. Checking Current Table Structure</h2>";
    
    // Check if blog_posts table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'blog_posts'");
    if ($stmt->rowCount() === 0) {
        echo "<p class='info'>📋 blog_posts table does not exist. Creating new table...</p>";
        
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
        echo "<p class='success'>✅ blog_posts table created successfully</p>";
        
    } else {
        echo "<p class='info'>📋 blog_posts table exists. Checking structure...</p>";
        
        // Get current table structure
        $stmt = $pdo->query("DESCRIBE blog_posts");
        $columns = $stmt->fetchAll();
        
        echo "<p class='info'>Current columns:</p><ul>";
        foreach ($columns as $column) {
            echo "<li>{$column['Field']} - {$column['Type']}</li>";
        }
        echo "</ul>";
        
        // Check if we need to migrate
        $columnNames = array_column($columns, 'Field');
        $needsMigration = !in_array('language', $columnNames) || 
                         !in_array('main_title', $columnNames) ||
                         !in_array('main_text', $columnNames);
        
        if ($needsMigration) {
            echo "<p class='warning'>⚠️ Table structure needs migration</p>";
            
            // Check if blog_post_translations table exists and drop it first
            $stmt = $pdo->query("SHOW TABLES LIKE 'blog_post_translations'");
            if ($stmt->rowCount() > 0) {
                echo "<p class='info'>🔄 Dropping blog_post_translations table first...</p>";
                $pdo->exec("DROP TABLE IF EXISTS blog_post_translations");
            }
            
            // Drop the old table and recreate (since structure is completely different)
            echo "<p class='info'>🔄 Dropping old blog_posts table and recreating...</p>";
            
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
            echo "<p class='success'>✅ blog_posts table recreated successfully</p>";
            
        } else {
            echo "<p class='success'>✅ Table structure is already correct</p>";
        }
    }
    
    echo "</div>";
    
    echo "<div class='step'>";
    echo "<h2>2. Verifying New Table Structure</h2>";
    
    $stmt = $pdo->query("DESCRIBE blog_posts");
    $columns = $stmt->fetchAll();
    
    echo "<p class='success'>✅ New table structure:</p><ul>";
    foreach ($columns as $column) {
        echo "<li>{$column['Field']} - {$column['Type']}</li>";
    }
    echo "</ul>";
    
    echo "</div>";
    
    echo "<div class='step'>";
    echo "<h2>3. Testing BlogService</h2>";
    
    require_once __DIR__ . '/src/services/BlogService.php';
    
    try {
        // Test basic functionality
        $posts = BlogService::getBlogPosts('en', 1, 5);
        echo "<p class='success'>✅ BlogService::getBlogPosts() works - found " . count($posts) . " posts</p>";
        
        $total = BlogService::getTotalBlogPosts('en');
        echo "<p class='success'>✅ BlogService::getTotalBlogPosts() works - total: $total posts</p>";
        
    } catch (Exception $e) {
        echo "<p class='error'>❌ BlogService test failed: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    
    echo "</div>";
    
    echo "<div class='step'>";
    echo "<h2>4. Next Steps</h2>";
    
    echo "<p class='info'>🎉 Migration completed successfully!</p>";
    echo "<ul>";
    echo "<li><a href='/populate_blog_web.php' target='_blank'>Add sample blog posts</a></li>";
    echo "<li><a href='/blog' target='_blank'>View the blog page</a></li>";
    echo "<li><a href='/admin/blog' target='_blank'>Manage blog posts</a></li>";
    echo "<li><a href='/test_blog_web.php' target='_blank'>Test blog functionality</a></li>";
    echo "</ul>";
    
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div class='step'>";
    echo "<h2 class='error'>❌ Migration Failed</h2>";
    echo "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p class='error'>Stack trace:</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    echo "</div>";
}
?>
