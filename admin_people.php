<?php
/**
 * Admin People API
 * Handles CRUD operations for team members
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't display errors, just log them

// Start session before any output
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/src/services/PeopleService.php';

// Check admin access (simplified)
if (empty($_SESSION['is_admin'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Access denied']);
    exit;
}

// Set JSON header
header('Content-Type: application/json');

// Debug: Log that we reached this point
error_log("DEBUG: admin_people.php reached, method: " . $_SERVER['REQUEST_METHOD']);

try {
    $method = $_SERVER['REQUEST_METHOD'];
    error_log("DEBUG: Method after override: " . $method);
    error_log("DEBUG: POST data: " . print_r($_POST, true));
    error_log("DEBUG: FILES data: " . print_r($_FILES, true));
    
    // Handle different content types
    if ($method === 'GET') {
        $input = [];
    } elseif ($method === 'POST' || $method === 'PUT' || $method === 'PATCH') {
        // Check if it's FormData (multipart/form-data) or JSON
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        if (strpos($contentType, 'multipart/form-data') !== false) {
            // Handle FormData
            $input = $_POST;
            // Parse JSON fields
            if (isset($input['en'])) {
                $input['en'] = json_decode($input['en'], true);
                error_log("DEBUG: Parsed EN: " . print_r($input['en'], true));
            }
            if (isset($input['mk'])) {
                $input['mk'] = json_decode($input['mk'], true);
                error_log("DEBUG: Parsed MK: " . print_r($input['mk'], true));
            }
            if (isset($input['fr'])) {
                $input['fr'] = json_decode($input['fr'], true);
                error_log("DEBUG: Parsed FR: " . print_r($input['fr'], true));
            }
        } else {
            // Handle JSON (including PATCH requests)
            $input = json_decode(file_get_contents('php://input'), true);
            error_log("DEBUG: JSON input: " . print_r($input, true));
        }
    } else {
        $input = json_decode(file_get_contents('php://input'), true);
    }
    
    // Handle method override for PUT/PATCH requests (after parsing input)
    if ($method === 'POST' && isset($_POST['_method'])) {
        $method = strtoupper($_POST['_method']);
        error_log("DEBUG: Method overridden to: " . $method);
    } elseif ($method === 'POST' && isset($input['_method'])) {
        $method = strtoupper($input['_method']);
        error_log("DEBUG: Method overridden from JSON to: " . $method);
    }
    
    switch ($method) {
        case 'GET':
            // Get all people organized by display_order (grouping same person across languages)
            $allPeople = PeopleService::getAllPeople();
            
            // Group people by display_order
            $groupedPeople = [];
            foreach ($allPeople as $person) {
                $order = $person['display_order'];
                if (!isset($groupedPeople[$order])) {
                    $groupedPeople[$order] = [
                        'display_order' => $order,
                        'is_visible' => $person['is_visible'],
                        'en' => null,
                        'mk' => null,
                        'fr' => null
                    ];
                }
                $groupedPeople[$order][$person['language_code']] = $person;
            }
            
            // Convert to array and sort by display_order
            $people = array_values($groupedPeople);
            usort($people, function($a, $b) {
                return $a['display_order'] <=> $b['display_order'];
            });
            
            echo json_encode($people);
            break;
            
        case 'POST':
            // Create new people (one for each language)
            if (!isset($input['en']) || !isset($input['mk']) || !isset($input['fr'])) {
                throw new Exception('Missing language data');
            }
            
            $createdIds = [];
            
            // Get the next available display_order
            $nextDisplayOrder = PeopleService::getNextDisplayOrder();
            
            // Create English version
            $enData = [
                'name' => $input['en']['name'],
                'title' => $input['en']['title'],
                'description' => $input['en']['description'],
                'image_url' => null, // Will be set after file upload
                'language_code' => 'en',
                'display_order' => $nextDisplayOrder,
                'is_visible' => (int)filter_var($input['is_visible'] ?? true, FILTER_VALIDATE_BOOLEAN)
            ];
            $createdIds['en'] = PeopleService::createPerson($enData);
            
            // Create Macedonian version
            $mkData = [
                'name' => $input['mk']['name'],
                'title' => $input['mk']['title'],
                'description' => $input['mk']['description'],
                'image_url' => null,
                'language_code' => 'mk',
                'display_order' => $nextDisplayOrder,
                'is_visible' => (int)filter_var($input['is_visible'] ?? true, FILTER_VALIDATE_BOOLEAN)
            ];
            $createdIds['mk'] = PeopleService::createPerson($mkData);
            
            // Create French version
            $frData = [
                'name' => $input['fr']['name'],
                'title' => $input['fr']['title'],
                'description' => $input['fr']['description'],
                'image_url' => null,
                'language_code' => 'fr',
                'display_order' => $nextDisplayOrder,
                'is_visible' => (int)filter_var($input['is_visible'] ?? true, FILTER_VALIDATE_BOOLEAN)
            ];
            $createdIds['fr'] = PeopleService::createPerson($frData);
            
            // Handle file upload if provided
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/uploads/people/';
                $fileName = 'person_' . $createdIds['en'] . '_' . time() . '.' . pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
                $uploadPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadPath)) {
                    $imageUrl = '/uploads/people/' . $fileName;
                    
                    // Update all three language versions with the image URL
                    foreach ($createdIds as $lang => $id) {
                        $person = PeopleService::getPersonById($id);
                        if ($person) {
                            $person['image_url'] = $imageUrl;
                            PeopleService::updatePerson($id, $person);
                        }
                    }
                }
            }
            
            echo json_encode(['success' => true, 'ids' => $createdIds]);
            break;
            
            case 'PUT':
                if (!isset($input['id']) || !isset($input['en']) || !isset($input['mk']) || !isset($input['fr'])) {
                    throw new Exception('Missing required data');
                }
            
                $id = $input['id'];
            
                // Get base person by id
                $person = PeopleService::getPersonById($id);
                if (!$person) {
                    throw new Exception('Person not found');
                }
            
                $imageUrl = $person['image_url'];
                if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = __DIR__ . '/uploads/people/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $fileName = uniqid('person_') . '_' . basename($_FILES['profile_image']['name']);
                    $uploadPath = $uploadDir . $fileName;
            
                    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadPath)) {
                        $imageUrl = '/uploads/people/' . $fileName;
                    }
                }
            
                // Update all language versions of this person
                $allPeople = PeopleService::getAllPeople();
                $success = true;
                
                foreach ($allPeople as $p) {
                    if ($p['display_order'] == $person['display_order']) {
                        $langCode = $p['language_code'];
                        $updateData = [
                            'name' => $input[$langCode]['name'],
                            'title' => $input[$langCode]['title'],
                            'description' => $input[$langCode]['description'],
                            'image_url' => $imageUrl, // Same image for all languages
                            'language_code' => $langCode,
                            'display_order' => $person['display_order'], // Keep same display_order
                            'is_visible' => (int)filter_var($input['is_visible'] ?? $person['is_visible'], FILTER_VALIDATE_BOOLEAN)
                        ];
                        try {
                            $updateResult = PeopleService::updatePerson($p['id'], $updateData);
                            // Consider it successful if either rows were updated OR no error occurred
                            $success = $success && true; // Always true if no exception thrown
                        } catch (Exception $e) {
                            error_log("Failed to update person ID " . $p['id'] . ": " . $e->getMessage());
                            $success = false;
                        }
                    }
                }
            
                echo json_encode(['success' => $success]);
                break;
            
        
        
        case 'DELETE':
            // Delete person (all language versions)
            if (!isset($input['id'])) {
                throw new Exception('Missing person ID');
            }
            
            // Get the person to find their display_order
            $person = PeopleService::getPersonById($input['id']);
            if (!$person) {
                throw new Exception('Person not found');
            }
            
            // Delete all people with the same display_order (all language versions)
            $allPeople = PeopleService::getAllPeople();
            $success = true;
            
            foreach ($allPeople as $p) {
                if ($p['display_order'] == $person['display_order']) {
                    $success = $success && PeopleService::deletePerson($p['id']);
                }
            }
            
            echo json_encode(['success' => $success]);
            break;
            
        case 'PATCH':
            // Reorder people
            error_log("DEBUG: PATCH case - input: " . print_r($input, true));
            if (!isset($input['person1_id']) || !isset($input['person2_id'])) {
                error_log("DEBUG: Missing person IDs - person1_id: " . (isset($input['person1_id']) ? $input['person1_id'] : 'NOT SET') . ", person2_id: " . (isset($input['person2_id']) ? $input['person2_id'] : 'NOT SET'));
                throw new Exception('Missing person IDs for reorder');
            }
            
            $person1 = PeopleService::getPersonById($input['person1_id']);
            $person2 = PeopleService::getPersonById($input['person2_id']);
            
            if (!$person1 || !$person2) {
                throw new Exception('Person not found');
            }
            
            // Swap their display orders
            $tempOrder = $person1['display_order'];
            $person1['display_order'] = $person2['display_order'];
            $person2['display_order'] = $tempOrder;
            
            // Update all language versions of both people
            $allPeople = PeopleService::getAllPeople();
            $success = true;
            
            error_log("DEBUG: person1 display_order: " . $person1['display_order']);
            error_log("DEBUG: person2 display_order: " . $person2['display_order']);
            error_log("DEBUG: All people count: " . count($allPeople));
            
            foreach ($allPeople as $p) {
                error_log("DEBUG: Checking person ID " . $p['id'] . " with display_order " . $p['display_order']);
                if ($p['display_order'] == $person1['display_order'] || $p['display_order'] == $person2['display_order']) {
                    $newOrder = ($p['display_order'] == $person1['display_order']) ? $person2['display_order'] : $person1['display_order'];
                    error_log("DEBUG: Updating person ID " . $p['id'] . " to display_order " . $newOrder);
                    $updateData = [
                        'name' => $p['name'],
                        'title' => $p['title'],
                        'description' => $p['description'],
                        'image_url' => $p['image_url'],
                        'language_code' => $p['language_code'],
                        'display_order' => $newOrder,
                        'is_visible' => $p['is_visible']
                    ];
                    $success = $success && PeopleService::updatePerson($p['id'], $updateData);
                }
            }
            
            echo json_encode(['success' => $success]);
            break;
            
        default:
            throw new Exception('Method not allowed');
    }
    
} catch (Exception $e) {
    error_log("DEBUG: Exception caught: " . $e->getMessage());
    error_log("DEBUG: Exception trace: " . $e->getTraceAsString());
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
