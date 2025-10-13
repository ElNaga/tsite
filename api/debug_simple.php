<?php
// Simple debug API
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

echo json_encode([
    'status' => 'success',
    'message' => 'Simple API test works',
    'timestamp' => date('Y-m-d H:i:s')
]);
?>
