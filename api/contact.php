<?php

/**
 * Contact Form API Endpoint
 * 
 * Handles contact form submissions via POST requests.
 * Returns JSON responses with success or error messages.
 * 
 * Endpoints:
 * - POST /api/contact - Submit a new contact form
 * - GET /api/contact - Get all contact messages (admin only)
 * 
 * @package TeatarZaTebe\API
 */

header('Content-Type: application/json');

require_once __DIR__ . '/../src/services/ContactService.php';
require_once __DIR__ . '/../src/services/TranslationService.php';

// Start session for language detection
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get current language from session or default to 'en'
$currentLang = $_SESSION['lang'] ?? 'en';

/**
 * Get client IP address
 * Handles proxy scenarios
 */
function getClientIp(): string {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    }
}

/**
 * Sanitize input data
 */
function sanitizeInput(string $data): string {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

try {
    $method = $_SERVER['REQUEST_METHOD'];
    
    switch ($method) {
        case 'POST':
            // Handle contact form submission
            
            // Get POST data
            $rawData = file_get_contents('php://input');
            $postData = json_decode($rawData, true);
            
            // If JSON decode failed, try $_POST
            if (!$postData) {
                $postData = $_POST;
            }
            
            // Sanitize and prepare data
            $formData = [
                'full_name' => sanitizeInput($postData['full_name'] ?? ''),
                'email' => sanitizeInput($postData['email'] ?? ''),
                'phone' => !empty($postData['phone']) ? sanitizeInput($postData['phone']) : null,
                'subject' => !empty($postData['subject']) ? sanitizeInput($postData['subject']) : null,
                'message' => sanitizeInput($postData['message'] ?? ''),
                'language_code' => $postData['language_code'] ?? $currentLang,
                'ip_address' => getClientIp(),
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null
            ];
            
            // Validate the data
            $validation = ContactService::validateFormData($formData);
            
            if (!$validation['valid']) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'errors' => $validation['errors'],
                    'message' => 'Validation failed'
                ]);
                exit;
            }
            
            // Create the contact message
            $messageId = ContactService::createMessage($formData);
            
            // Success response
            http_response_code(201);
            echo json_encode([
                'success' => true,
                'message' => 'Thank you for your message! We will get back to you soon.',
                'message_id' => $messageId
            ]);
            break;
            
        case 'GET':
            // Get all messages (admin only)
            // For security, this should be protected with authentication
            
            // Simple admin check - in production, use proper authentication
            if (empty($_SESSION['is_admin'])) {
                http_response_code(403);
                echo json_encode([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ]);
                exit;
            }
            
            $status = $_GET['status'] ?? null;
            $messages = ContactService::getAllMessages($status);
            
            // Convert models to arrays
            $messagesArray = array_map(function($msg) {
                return $msg->toArray();
            }, $messages);
            
            echo json_encode([
                'success' => true,
                'count' => count($messagesArray),
                'messages' => $messagesArray
            ]);
            break;
            
        default:
            http_response_code(405);
            echo json_encode([
                'success' => false,
                'message' => 'Method not allowed'
            ]);
            break;
    }
    
} catch (Exception $e) {
    error_log("Contact API Error: " . $e->getMessage());
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred while processing your request. Please try again later.',
        'error' => $e->getMessage() // Remove in production
    ]);
}

