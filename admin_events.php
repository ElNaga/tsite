<?php
require_once __DIR__ . '/src/services/EventService.php';
require_once __DIR__ . '/src/services/TransactionService.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Return all events (all languages)
    $allEvents = EventService::getAllEvents();
    
    // Organize by language for admin display
    $events = [
        'en' => [],
        'mk' => [],
        'fr' => []
    ];
    
    foreach ($allEvents as $event) {
        $lang = $event['language_code'];
        if (isset($events[$lang])) {
            $events[$lang][] = $event;
        }
    }
    
    echo json_encode($events);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

// Transaction endpoints
if ($method === 'POST' && isset($_GET['transactions'])) {
    // Add a transaction: expects { event_id: ..., user: { name, email, phone } }
    if (!isset($input['event_id'], $input['user'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Missing event_id or user']);
        exit;
    }
    
    try {
        $transactionId = TransactionService::createTransaction([
            'event_id' => $input['event_id'],
            'user_name' => $input['user']['name'],
            'user_email' => $input['user']['email'],
            'user_phone' => $input['user']['phone'] ?? '',
            'booking_date' => $input['booking_date'] ?? date('Y-m-d'),
            'status' => 'pending'
        ]);
        echo json_encode(['success' => true, 'id' => $transactionId]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}

if ($method === 'GET' && isset($_GET['transactions'])) {
    // Get transactions, optionally by event_id
    $eventId = isset($_GET['event_id']) ? (int)$_GET['event_id'] : null;
    if ($eventId) {
        $transactions = TransactionService::getTransactionsForEvent($eventId);
    } else {
        $transactions = TransactionService::getAllTransactions();
    }
    echo json_encode(['success' => true, 'transactions' => $transactions]);
    exit;
}

// Event CRUD operations
if (!isset($_GET['transactions'])) {
    try {
        if ($method === 'POST') {
            // Create new event
            $eventData = [
                'image' => $input['en']['image'] ?? '/assets/background-image.png',
                'book_url' => $input['en']['book_url'] ?? '#',
                'status' => 'published'
            ];
            
            $translations = [
                'en' => [
                    'title' => $input['en']['title'],
                    'description' => $input['en']['desc'],
                    'book_label' => $input['en']['book_label'],
                    'image_alt' => $input['en']['image_alt'] ?? ''
                ],
                'mk' => [
                    'title' => $input['mk']['title'],
                    'description' => $input['mk']['desc'],
                    'book_label' => $input['mk']['book_label'],
                    'image_alt' => $input['mk']['image_alt'] ?? ''
                ],
                'fr' => [
                    'title' => $input['fr']['title'],
                    'description' => $input['fr']['desc'],
                    'book_label' => $input['fr']['book_label'],
                    'image_alt' => $input['fr']['image_alt'] ?? ''
                ]
            ];
            
            $eventId = EventService::createEvent($eventData, $translations);
            echo json_encode(['success' => true, 'id' => $eventId]);
            
        } elseif ($method === 'PUT') {
            // Update existing event
            if (!isset($input['id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Missing event ID']);
                exit;
            }
            
            $eventData = [
                'image' => $input['en']['image'] ?? '/assets/background-image.png',
                'book_url' => $input['en']['book_url'] ?? '#',
                'status' => 'published'
            ];
            
            $translations = [
                'en' => [
                    'title' => $input['en']['title'],
                    'description' => $input['en']['desc'],
                    'book_label' => $input['en']['book_label'],
                    'image_alt' => $input['en']['image_alt'] ?? ''
                ],
                'mk' => [
                    'title' => $input['mk']['title'],
                    'description' => $input['mk']['desc'],
                    'book_label' => $input['mk']['book_label'],
                    'image_alt' => $input['mk']['image_alt'] ?? ''
                ],
                'fr' => [
                    'title' => $input['fr']['title'],
                    'description' => $input['fr']['desc'],
                    'book_label' => $input['fr']['book_label'],
                    'image_alt' => $input['fr']['image_alt'] ?? ''
                ]
            ];
            
            $success = EventService::updateEvent((int)$input['id'], $eventData, $translations);
            echo json_encode(['success' => $success]);
            
        } elseif ($method === 'DELETE') {
            // Delete event
            if (!isset($input['id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Missing event ID']);
                exit;
            }
            
            $success = EventService::deleteEvent((int)$input['id']);
            echo json_encode(['success' => $success]);
            
        } else {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Method not allowed']);
        }
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}

http_response_code(405);
echo json_encode(['success' => false, 'error' => 'Method not allowed']); 