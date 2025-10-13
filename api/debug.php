<?php
/**
 * API Debug Test
 * 
 * This file tests if the API directory is working and can execute PHP.
 * Access via: http://localhost:8080/api/debug.php
 */

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

try {
    // Test basic functionality
    $result = [
        'status' => 'success',
        'message' => 'API directory is working',
        'timestamp' => date('Y-m-d H:i:s'),
        'php_version' => PHP_VERSION,
        'server' => $_SERVER['SERVER_NAME'] ?? 'unknown',
        'request_uri' => $_SERVER['REQUEST_URI'] ?? 'unknown',
        'request_method' => $_SERVER['REQUEST_METHOD'] ?? 'unknown'
    ];
    
    // Test if we can require the BlogService
    try {
        require_once __DIR__ . '/../src/services/BlogService.php';
        $result['blog_service'] = 'loaded successfully';
        
        // Test if we can call BlogService methods
        $posts = BlogService::getBlogPosts('en', 1, 1);
        $result['blog_service_test'] = 'works - found ' . count($posts) . ' posts';
        
    } catch (Exception $e) {
        $result['blog_service_error'] = $e->getMessage();
    }
    
    echo json_encode($result, JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ], JSON_PRETTY_PRINT);
}
?>
