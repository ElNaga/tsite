<?php
/**
 * Admin API Endpoint
 * Handles admin authentication and management
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set JSON header
header('Content-Type: application/json');

// Get path parts from index.php routing
$pathParts = $_GET['path_parts'] ?? [];
$method = $_SERVER['REQUEST_METHOD'];

// Remove 'admin' from path parts
if (isset($pathParts[0]) && $pathParts[0] === 'admin') {
    array_shift($pathParts);
}

// Route to appropriate handler
$action = $pathParts[0] ?? '';

try {
    switch ($action) {
        case 'login':
            handleAdminLogin();
            break;
        case 'logout':
            handleAdminLogout();
            break;
        default:
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'Admin endpoint not found']);
    }
} catch (Exception $e) {
    error_log("Admin API error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Internal server error']);
}

function handleAdminLogin() {
    // Only allow POST requests
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'error' => 'Method not allowed']);
        return;
    }

    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);

    // Validate input
    if (!isset($input['password']) || empty($input['password'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Password is required']);
        return;
    }

    $password = trim($input['password']);

    try {
        // For now, use simple authentication without database
        // TODO: Implement proper database authentication
        if ($password === 'admin123') {
            // Start session
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            $_SESSION['is_admin'] = true;
            $_SESSION['admin_user_id'] = 1;
            $_SESSION['admin_username'] = 'admin';
            $_SESSION['admin_login_time'] = time();
            
            echo json_encode([
                'success' => true,
                'message' => 'Login successful',
                'redirect' => '/admin'
            ]);
            return;
        } else {
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Invalid credentials']);
            return;
        }
        
        // TODO: Implement database authentication when database is available
        // For now, using simple password verification
        
    } catch (Exception $e) {
        error_log("Admin login error: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Internal server error']);
    }
}

function handleAdminLogout() {
    // Only allow POST requests
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'error' => 'Method not allowed']);
        return;
    }

    try {
        // Include admin controller for session management
        require_once __DIR__ . '/../components/admin/admin-controller.php';
        
        // Clear admin session
        AdminController::clearAdminSession();
        
        // Log logout
        error_log("Admin logout successful");
        
        echo json_encode([
            'success' => true,
            'message' => 'Logged out successfully',
            'redirect' => '/home'
        ]);
        
    } catch (Exception $e) {
        error_log("Admin logout error: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Internal server error']);
    }
}
?>
