<?php
/**
 * Debug API Response
 * 
 * This file shows exactly what the API is returning.
 * Access via: http://localhost:8080/debug_api.php
 */

echo "<h1>🔍 API Debug</h1>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .success { color: green; }
    .error { color: red; }
    .info { color: blue; }
    .debug-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
    pre { background: #f5f5f5; padding: 10px; border-radius: 4px; overflow-x: auto; white-space: pre-wrap; }
</style>";

echo "<div class='debug-section'>";
echo "<h2>1. Testing API Endpoint Directly</h2>";

// Test the API endpoint directly (since we're inside the container)
echo "<p class='info'>Testing API endpoint directly (we're inside the container)</p>";

// Simulate the API call by including the API file directly
ob_start();
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/api/blog';
$pathParts = ['api', 'blog'];
array_shift($pathParts); // Remove 'api'
array_shift($pathParts); // Remove 'blog'

// Include the API file
try {
    include __DIR__ . '/api/blog.php';
    $response = ob_get_clean();
} catch (Exception $e) {
    $response = json_encode(['error' => $e->getMessage()]);
    ob_end_clean();
}

if ($response === false) {
    echo "<p class='error'>❌ Failed to fetch API response</p>";
} else {
    echo "<p class='success'>✅ Got response from API</p>";
    
    // Get response headers
    $headers = $http_response_header ?? [];
    echo "<h3>Response Headers:</h3>";
    echo "<pre>" . htmlspecialchars(implode("\n", $headers)) . "</pre>";
    
    echo "<h3>Response Body:</h3>";
    echo "<pre>" . htmlspecialchars($response) . "</pre>";
    
    // Try to parse as JSON
    $jsonData = json_decode($response, true);
    if ($jsonData !== null) {
        echo "<p class='success'>✅ Response is valid JSON</p>";
        echo "<h3>Parsed JSON:</h3>";
        echo "<pre>" . htmlspecialchars(json_encode($jsonData, JSON_PRETTY_PRINT)) . "</pre>";
    } else {
        echo "<p class='error'>❌ Response is not valid JSON</p>";
        echo "<p class='error'>JSON Error: " . json_last_error_msg() . "</p>";
        
        // Check if it looks like HTML
        if (strpos($response, '<html') !== false || strpos($response, '<!DOCTYPE') !== false) {
            echo "<p class='error'>⚠️ Response appears to be HTML (likely an error page)</p>";
        }
    }
}

echo "</div>";

echo "<div class='debug-section'>";
echo "<h2>2. Testing BlogService Directly</h2>";

try {
    require_once __DIR__ . '/src/services/BlogService.php';
    
    $posts = BlogService::getBlogPosts('en', 1, 5);
    echo "<p class='success'>✅ BlogService::getBlogPosts() works - found " . count($posts) . " posts</p>";
    
    if (count($posts) > 0) {
        $firstPost = $posts[0];
        echo "<p class='info'>📋 First post ID: " . $firstPost->getId() . "</p>";
        echo "<p class='info'>📋 First post title: " . htmlspecialchars($firstPost->getMainTitle()) . "</p>";
        
        // Test individual post
        $postById = BlogService::getBlogPostById($firstPost->getId());
        if ($postById) {
            echo "<p class='success'>✅ BlogService::getBlogPostById() works</p>";
        } else {
            echo "<p class='error'>❌ BlogService::getBlogPostById() failed</p>";
        }
    } else {
        echo "<p class='error'>❌ No blog posts found</p>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>❌ BlogService error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}

echo "</div>";

echo "<div class='debug-section'>";
echo "<h2>3. Testing API File Directly</h2>";

// Test if the API file exists and is accessible
$apiFile = __DIR__ . '/api/blog.php';
if (file_exists($apiFile)) {
    echo "<p class='success'>✅ API file exists: $apiFile</p>";
    
    // Check file permissions
    if (is_readable($apiFile)) {
        echo "<p class='success'>✅ API file is readable</p>";
    } else {
        echo "<p class='error'>❌ API file is not readable</p>";
    }
} else {
    echo "<p class='error'>❌ API file does not exist: $apiFile</p>";
}

echo "</div>";

echo "<div class='debug-section'>";
echo "<h2>4. Manual API Test</h2>";

echo "<p class='info'>🔗 Test these URLs directly in your browser:</p>";
echo "<ul>";
echo "<li><a href='/api/blog' target='_blank'>GET /api/blog</a></li>";
echo "<li><a href='/api/test.php' target='_blank'>GET /api/test.php</a></li>";
echo "</ul>";

echo "</div>";
?>
