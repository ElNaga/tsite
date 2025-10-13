<?php
/**
 * Direct API Test
 * 
 * This file tests the API endpoints directly to see what's happening.
 * Access via: http://localhost:8080/test_api_direct.php
 */

echo "<h1>🔍 Direct API Test</h1>";
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
        echo "<p class='info'>📋 Testing with post ID: $postId</p>";
        
        // Test getting post by ID directly
        $postById = BlogService::getBlogPostById($postId);
        if ($postById) {
            echo "<p class='success'>✅ BlogService::getBlogPostById() works</p>";
            echo "<p class='info'>📋 Post title: " . htmlspecialchars($postById->getMainTitle()) . "</p>";
            
            // Show the post data as it would be returned by API
            $postData = $postById->toArray();
            echo "<h3>Post data (as would be returned by API):</h3>";
            echo "<pre>" . htmlspecialchars(json_encode($postData, JSON_PRETTY_PRINT)) . "</pre>";
        } else {
            echo "<p class='error'>❌ BlogService::getBlogPostById() failed</p>";
        }
    } else {
        echo "<p class='error'>❌ No blog posts found</p>";
    }
    
    echo "</div>";
    
    echo "<div class='test-section'>";
    echo "<h2>2. Testing API Endpoint URLs</h2>";
    
    echo "<p class='info'>🔗 Test these URLs directly in your browser:</p>";
    echo "<ul>";
    echo "<li><a href='/api/blog' target='_blank'>GET /api/blog</a></li>";
    if (count($posts) > 0) {
        $firstPostId = $posts[0]->getId();
        echo "<li><a href='/api/blog/$firstPostId' target='_blank'>GET /api/blog/$firstPostId</a></li>";
    }
    echo "</ul>";
    
    echo "</div>";
    
    echo "<div class='test-section'>";
    echo "<h2>3. Testing API with cURL</h2>";
    
    if (count($posts) > 0) {
        $firstPostId = $posts[0]->getId();
        $url = "http://localhost:8080/api/blog/$firstPostId";
        
        echo "<p class='info'>Testing URL: $url</p>";
        
        // Test with cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        
        curl_close($ch);
        
        $headers = substr($response, 0, $headerSize);
        $body = substr($response, $headerSize);
        
        echo "<p class='info'>HTTP Status: $httpCode</p>";
        echo "<h3>Response Headers:</h3>";
        echo "<pre>" . htmlspecialchars($headers) . "</pre>";
        echo "<h3>Response Body:</h3>";
        echo "<pre>" . htmlspecialchars($body) . "</pre>";
        
        // Try to parse as JSON
        $jsonData = json_decode($body, true);
        if ($jsonData !== null) {
            echo "<p class='success'>✅ Response is valid JSON</p>";
        } else {
            echo "<p class='error'>❌ Response is not valid JSON</p>";
            echo "<p class='error'>JSON Error: " . json_last_error_msg() . "</p>";
        }
    }
    
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div class='test-section'>";
    echo "<h2 class='error'>❌ Test Failed</h2>";
    echo "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p class='error'>Stack trace:</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    echo "</div>";
}
?>
