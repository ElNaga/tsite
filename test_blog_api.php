<?php
/**
 * Test Blog API Endpoints
 * 
 * This file tests the blog API endpoints to ensure they work correctly.
 * Access via: http://localhost:8080/test_blog_api.php
 */

echo "<h1>🧪 Blog API Test</h1>";
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
        echo "<p class='info'>📋 First post ID: " . $firstPost->getId() . "</p>";
        echo "<p class='info'>📋 First post title: " . htmlspecialchars($firstPost->getMainTitle()) . "</p>";
        
        // Test getting post by ID
        $postById = BlogService::getBlogPostById($firstPost->getId());
        if ($postById) {
            echo "<p class='success'>✅ BlogService::getBlogPostById() works</p>";
        } else {
            echo "<p class='error'>❌ BlogService::getBlogPostById() failed</p>";
        }
    }
    
    echo "</div>";
    
    echo "<div class='test-section'>";
    echo "<h2>2. Testing API Endpoints</h2>";
    
    // Test GET /api/blog
    echo "<h3>GET /api/blog</h3>";
    $url = 'http://localhost:8080/api/blog';
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => 'Content-Type: application/json'
        ]
    ]);
    
    $response = file_get_contents($url, false, $context);
    if ($response !== false) {
        $data = json_decode($response, true);
        echo "<p class='success'>✅ API endpoint works</p>";
        echo "<p class='info'>📊 Response contains " . count($data['posts'] ?? []) . " posts</p>";
        echo "<pre>" . htmlspecialchars(json_encode($data, JSON_PRETTY_PRINT)) . "</pre>";
        
        // Test individual post endpoint if we have posts
        if (!empty($data['posts'])) {
            $firstPostId = $data['posts'][0]['id'];
            echo "<h3>GET /api/blog/{$firstPostId}</h3>";
            
            $postUrl = "http://localhost:8080/api/blog/{$firstPostId}";
            $postResponse = file_get_contents($postUrl, false, $context);
            
            if ($postResponse !== false) {
                $postData = json_decode($postResponse, true);
                echo "<p class='success'>✅ Individual post API works</p>";
                echo "<pre>" . htmlspecialchars(json_encode($postData, JSON_PRETTY_PRINT)) . "</pre>";
            } else {
                echo "<p class='error'>❌ Individual post API failed</p>";
            }
        }
        
    } else {
        echo "<p class='error'>❌ API endpoint failed</p>";
    }
    
    echo "</div>";
    
    echo "<div class='test-section'>";
    echo "<h2>3. Testing Blog Page</h2>";
    
    echo "<p class='info'>🔗 Test these pages:</p>";
    echo "<ul>";
    echo "<li><a href='/blog' target='_blank'>Public Blog Page</a></li>";
    echo "<li><a href='/admin/blog' target='_blank'>Admin Blog Management</a></li>";
    echo "</ul>";
    
    echo "</div>";
    
    echo "<h2 class='success'>🎉 Blog API Test Complete!</h2>";
    
} catch (Exception $e) {
    echo "<div class='test-section'>";
    echo "<h2 class='error'>❌ Test Failed</h2>";
    echo "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p class='error'>Stack trace:</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    echo "</div>";
}
?>
