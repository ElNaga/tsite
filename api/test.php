<?php
/**
 * Simple API Test
 * 
 * This file tests if the API directory is accessible.
 * Access via: http://localhost:8080/api/test.php
 */

header('Content-Type: application/json');

echo json_encode([
    'status' => 'success',
    'message' => 'API directory is accessible',
    'timestamp' => date('Y-m-d H:i:s'),
    'server' => $_SERVER['SERVER_NAME'] ?? 'unknown'
]);
?>
