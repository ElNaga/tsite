<?php
session_start();
// Only allow POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['is_admin'] = true;
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
    exit;
}
http_response_code(405);
echo json_encode(['success' => false, 'error' => 'Method not allowed']); 