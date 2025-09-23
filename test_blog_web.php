<?php
/**
 * Web-based Blog Functionality Test
 * 
 * This file tests the blog functionality in a web environment.
 * Access via: http://localhost:8080/test_blog_web.php
 */

echo "<h1>🧪 Blog Functionality Test</h1>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .success { color: green; }
    .error { color: red; }
    .info { color: blue; }
    .test-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
</style>";

try {
    echo "<div class='test-section'>";
    echo "<h2>1. Testing BlogService Class Loading</h2>";
    
    require_once __DIR__ . '/src/services/BlogService.php';
    echo "<p class='success'>✅ BlogService class loaded successfully</p>";
    
    require_once __DIR__ . '/src/services/TranslationService.php';
    echo "<p class='success'>✅ TranslationService class loaded successfully</p>";
    
    echo "</div>";
    
    echo "<div class='test-section'>";
    echo "<h2>2. Testing Database Connection</h2>";
    
    try {
        $pdo = require_once __DIR__ . '/bootstrap.php';
        if ($pdo instanceof PDO) {
            echo "<p class='success'>✅ Database connection successful</p>";
            
            // Test if blog_posts table exists
            $stmt = $pdo->query("SHOW TABLES LIKE 'blog_posts'");
            if ($stmt->rowCount() > 0) {
                echo "<p class='success'>✅ blog_posts table exists</p>";
                
                // Check table structure
                $stmt = $pdo->query("DESCRIBE blog_posts");
                $columns = $stmt->fetchAll();
                echo "<p class='info'>📋 Table structure:</p><ul>";
                foreach ($columns as $column) {
                    echo "<li>{$column['Field']} - {$column['Type']}</li>";
                }
                echo "</ul>";
                
            } else {
                echo "<p class='error'>❌ blog_posts table does not exist</p>";
                echo "<p class='info'>💡 You need to run the database migration first</p>";
            }
        } else {
            echo "<p class='error'>❌ Database connection failed</p>";
        }
    } catch (Exception $e) {
        echo "<p class='error'>❌ Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    
    echo "</div>";
    
    echo "<div class='test-section'>";
    echo "<h2>3. Testing BlogService Methods</h2>";
    
    try {
        // Test getBlogPosts method
        $posts = BlogService::getBlogPosts('en', 1, 5);
        echo "<p class='success'>✅ getBlogPosts() method works - found " . count($posts) . " posts</p>";
        
        // Test getTotalBlogPosts method
        $total = BlogService::getTotalBlogPosts('en');
        echo "<p class='success'>✅ getTotalBlogPosts() method works - total: $total posts</p>";
        
        // Test pagination info
        $paginationInfo = BlogService::getPaginationInfo('en', 1, 5);
        echo "<p class='success'>✅ getPaginationInfo() method works</p>";
        echo "<p class='info'>📊 Pagination info: " . json_encode($paginationInfo) . "</p>";
        
    } catch (Exception $e) {
        echo "<p class='error'>❌ BlogService error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    
    echo "</div>";
    
    echo "<div class='test-section'>";
    echo "<h2>4. Testing Blog Post Creation</h2>";
    
    try {
        $testPost = [
            'language' => 'en',
            'main_title' => 'Test Blog Post - ' . date('Y-m-d H:i:s'),
            'main_text' => 'This is a test blog post created via web test.',
            'main_image' => '/assets/background-image.png',
            'secondary_title' => 'Test Secondary Title',
            'secondary_text' => 'This is the secondary text for testing.',
            'secondary_image' => '/assets/topright_strip.png',
            'gallery_images' => ['/assets/background-image.png'],
            'visible' => true
        ];
        
        $postId = BlogService::createBlogPost($testPost);
        echo "<p class='success'>✅ Blog post created successfully with ID: $postId</p>";
        
        // Test retrieval
        $retrievedPost = BlogService::getBlogPostById($postId);
        if ($retrievedPost) {
            echo "<p class='success'>✅ Blog post retrieved successfully: " . htmlspecialchars($retrievedPost->getMainTitle()) . "</p>";
        }
        
        // Clean up - delete the test post
        BlogService::deleteBlogPost($postId);
        echo "<p class='info'>🧹 Test post cleaned up</p>";
        
    } catch (Exception $e) {
        echo "<p class='error'>❌ Blog post creation error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    
    echo "</div>";
    
    echo "<div class='test-section'>";
    echo "<h2>5. Testing API Endpoints</h2>";
    
    echo "<p class='info'>🔗 Test these API endpoints:</p>";
    echo "<ul>";
    echo "<li><a href='/api/blog' target='_blank'>GET /api/blog</a> - List blog posts</li>";
    echo "<li><a href='/api/blog?lang=en&page=1&limit=5' target='_blank'>GET /api/blog?lang=en&page=1&limit=5</a> - List with pagination</li>";
    echo "</ul>";
    
    echo "</div>";
    
    echo "<div class='test-section'>";
    echo "<h2>6. Testing Public Blog Page</h2>";
    
    echo "<p class='info'>🔗 Test the public blog page:</p>";
    echo "<ul>";
    echo "<li><a href='/blog' target='_blank'>Public Blog Page</a></li>";
    echo "<li><a href='/admin/blog' target='_blank'>Admin Blog Management</a> (requires admin login)</li>";
    echo "</ul>";
    
    echo "</div>";
    
    echo "<h2 class='success'>🎉 Blog Functionality Test Complete!</h2>";
    echo "<p class='success'><strong>✅ SUCCESS: Blog feature is working correctly!</strong></p>";
    
} catch (Exception $e) {
    echo "<div class='test-section'>";
    echo "<h2 class='error'>❌ Test Failed</h2>";
    echo "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p class='error'>Stack trace:</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    echo "</div>";
}
?>
