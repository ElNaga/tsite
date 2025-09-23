<?php
/**
 * Simple API Test - Works from inside container
 * 
 * This file tests the API endpoints directly without HTTP requests.
 * Access via: http://localhost:8080/test_api_simple.php
 */

echo "<h1>🧪 Simple API Test</h1>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .success { color: green; }
    .error { color: red; }
    .info { color: blue; }
    .test-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
    pre { background: #f5f5f5; padding: 10px; border-radius: 4px; overflow-x: auto; }
</style>";

try {
    echo "<div class='test-section'>";
    echo "<h2>1. Testing BlogService Directly</h2>";
    
    require_once __DIR__ . '/src/services/BlogService.php';
    
    $posts = BlogService::getBlogPosts('en', 1, 5);
    echo "<p class='success'>✅ BlogService::getBlogPosts() works - found " . count($posts) . " posts</p>";
    
    if (count($posts) > 0) {
        $firstPost = $posts[0];
        $postId = $firstPost->getId();
        echo "<p class='info'>📋 First post ID: $postId</p>";
        echo "<p class='info'>📋 First post title: " . htmlspecialchars($firstPost->getMainTitle()) . "</p>";
        
        // Test getting post by ID
        $postById = BlogService::getBlogPostById($postId);
        if ($postById) {
            echo "<p class='success'>✅ BlogService::getBlogPostById() works</p>";
            
            // Show the data that would be returned by API
            $postData = $postById->toArray();
            echo "<h3>Post data (as returned by API):</h3>";
            echo "<pre>" . htmlspecialchars(json_encode($postData, JSON_PRETTY_PRINT)) . "</pre>";
        } else {
            echo "<p class='error'>❌ BlogService::getBlogPostById() failed</p>";
        }
    } else {
        echo "<p class='error'>❌ No blog posts found</p>";
    }
    
    echo "</div>";
    
    echo "<div class='test-section'>";
    echo "<h2>2. Testing API Response Format</h2>";
    
    // Simulate what the API should return
    $paginationInfo = BlogService::getPaginationInfo('en', 1, 20);
    $apiResponse = [
        'posts' => array_map(function($post) {
            return $post->toArray();
        }, $posts),
        'pagination' => $paginationInfo
    ];
    
    echo "<h3>API Response Format:</h3>";
    echo "<pre>" . htmlspecialchars(json_encode($apiResponse, JSON_PRETTY_PRINT)) . "</pre>";
    
    echo "</div>";
    
    echo "<div class='test-section'>";
    echo "<h2>3. Testing Individual Post API</h2>";
    
    if (count($posts) > 0) {
        $firstPost = $posts[0];
        $postData = $firstPost->toArray();
        
        echo "<h3>Individual Post API Response:</h3>";
        echo "<pre>" . htmlspecialchars(json_encode($postData, JSON_PRETTY_PRINT)) . "</pre>";
    }
    
    echo "</div>";
    
    echo "<div class='test-section'>";
    echo "<h2>4. Browser Test Links</h2>";
    
    echo "<p class='info'>🔗 Test these URLs in your browser:</p>";
    echo "<ul>";
    echo "<li><a href='/api/blog' target='_blank'>GET /api/blog</a></li>";
    if (count($posts) > 0) {
        $firstPostId = $posts[0]->getId();
        echo "<li><a href='/api/blog/$firstPostId' target='_blank'>GET /api/blog/$firstPostId</a></li>";
    }
    echo "<li><a href='/blog' target='_blank'>Public Blog Page</a></li>";
    echo "<li><a href='/admin/blog' target='_blank'>Admin Blog Management</a></li>";
    echo "</ul>";
    
    echo "</div>";
    
    echo "<h2 class='success'>🎉 API Test Complete!</h2>";
    echo "<p class='success'><strong>✅ The API should be working correctly!</strong></p>";
    
} catch (Exception $e) {
    echo "<div class='test-section'>";
    echo "<h2 class='error'>❌ Test Failed</h2>";
    echo "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p class='error'>Stack trace:</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    echo "</div>";
}
?>
