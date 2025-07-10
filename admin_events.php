<?php
require_once __DIR__ . '/src/services/EventService.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Return all events (all languages)
    echo json_encode([
        'en' => EventService::getAllEvents('en'),
        'mk' => EventService::getAllEvents('mk'),
        'fr' => EventService::getAllEvents('fr'),
    ]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

// Transaction endpoints remain separate
if ($method === 'POST' && isset($_GET['transactions'])) {
    // Add a transaction: expects { event_id: ..., user: { name, email } }
    if (!isset($input['event_id'], $input['user'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Missing event_id or user']);
        exit;
    }
    EventService::addTransaction($input['event_id'], $input['user']);
    echo json_encode(['success' => true]);
    exit;
}

if ($method === 'GET' && isset($_GET['transactions'])) {
    // Get transactions, optionally by event_id
    $eventId = isset($_GET['event_id']) ? $_GET['event_id'] : null;
    $txs = EventService::getTransactions($eventId);
    echo json_encode(['success' => true, 'transactions' => $txs]);
    exit;
}

// All event CRUD logic is now handled by EventService
if (!isset($_GET['transactions'])) {
    $result = EventService::handleEventRequest($method, $input, $_GET);
    if (isset($result['error'])) {
        http_response_code(400);
    }
    echo json_encode($result);
    exit;
}

http_response_code(405);
echo json_encode(['success' => false, 'error' => 'Method not allowed']); 