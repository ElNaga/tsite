<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Log the request for debugging
error_log("API Request: " . $_SERVER['REQUEST_METHOD'] . " " . $_SERVER['REQUEST_URI']);

require_once __DIR__ . '/../src/services/BlogService.php';
require_once __DIR__ . '/../src/services/TranslationService.php';

// Get the request method and path
$method = $_SERVER['REQUEST_METHOD'];

// Use path parts from index.php if available, otherwise parse manually
if (isset($_GET['path_parts'])) {
    $pathParts = $_GET['path_parts'];
} else {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $pathParts = explode('/', trim($path, '/'));
    
    // Remove 'api' from path parts
    if ($pathParts[0] === 'api') {
        array_shift($pathParts);
    }
}

// Remove 'blog' from path parts
if ($pathParts[0] === 'blog') {
    array_shift($pathParts);
}

try {
    switch ($method) {
        case 'GET':
            if (empty($pathParts)) {
                // GET /api/blog - List blog posts with pagination
                handleGetBlogPosts();
            } elseif (is_numeric($pathParts[0])) {
                // GET /api/blog/{id} - Get specific blog post
                handleGetBlogPost((int)$pathParts[0]);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Not found']);
            }
            break;
            
        case 'POST':
            // POST /api/blog - Create new blog post (admin only)
            handleCreateBlogPost();
            break;
            
        case 'PUT':
            if (is_numeric($pathParts[0])) {
                // PUT /api/blog/{id} - Update blog post (admin only)
                handleUpdateBlogPost((int)$pathParts[0]);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Not found']);
            }
            break;
            
        case 'DELETE':
            if (is_numeric($pathParts[0])) {
                // DELETE /api/blog/{id} - Delete blog post (admin only)
                handleDeleteBlogPost((int)$pathParts[0]);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Not found']);
            }
            break;
            
        default:
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
}

function handleGetBlogPosts() {
    $language = $_GET['lang'] ?? TranslationService::getCurrentLang();
    $page = (int)($_GET['page'] ?? 1);
    $limit = (int)($_GET['limit'] ?? 20);
    
    // Check if this is an admin request (from admin panel)
    $isAdminRequest = isset($_GET['admin']) && $_GET['admin'] === 'true';
    
    if ($isAdminRequest) {
        // Admin panel: show all posts (visible and hidden)
        $posts = BlogService::getAllBlogPosts();
        $paginationInfo = [
            'current_page' => 1,
            'total_pages' => 1,
            'total_posts' => count($posts),
            'posts_per_page' => count($posts)
        ];
    } else {
        // Public access: show only visible posts
        $posts = BlogService::getBlogPosts($language, $page, $limit);
        $paginationInfo = BlogService::getPaginationInfo($language, $page, $limit);
    }
    
    echo json_encode([
        'posts' => array_map(function($post) {
            return $post->toArray();
        }, $posts),
        'pagination' => $paginationInfo
    ]);
}

function handleGetBlogPost($id) {
    $post = BlogService::getBlogPostById($id);
    
    if (!$post) {
        http_response_code(404);
        echo json_encode(['error' => 'Blog post not found']);
        return;
    }
    
    // Check if this is an admin request
    $isAdminRequest = isset($_GET['admin']) && $_GET['admin'] === 'true';
    
    // For public access, only show visible posts
    if (!$isAdminRequest && !$post->isVisible()) {
        http_response_code(404);
        echo json_encode(['error' => 'Blog post not found']);
        return;
    }
    
    echo json_encode($post->toArray());
}

function handleCreateBlogPost() {
    requireAdmin();
    
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON data']);
        return;
    }
    
    // Validate required fields
    $requiredFields = ['language', 'main_title', 'main_text', 'main_image', 'secondary_title', 'secondary_text', 'secondary_image'];
    foreach ($requiredFields as $field) {
        if (empty($input[$field])) {
            http_response_code(400);
            echo json_encode(['error' => "Missing required field: $field"]);
            return;
        }
    }
    
    $id = BlogService::createBlogPost($input);
    
    echo json_encode([
        'success' => true,
        'id' => $id,
        'message' => 'Blog post created successfully'
    ]);
}

function handleUpdateBlogPost($id) {
    requireAdmin();
    
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON data']);
        return;
    }
    
    try {
        // Handle visibility toggle specifically
        if (isset($input['visible']) && count($input) === 1) {
            $success = BlogService::toggleVisibility($id);
        } else {
            // Handle full blog post update
            $success = BlogService::updateBlogPost($id, $input);
        }
        
        if (!$success) {
            http_response_code(404);
            echo json_encode(['error' => 'Blog post not found or update failed']);
            return;
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Blog post updated successfully'
        ]);
    } catch (Exception $e) {
        error_log("Blog update error: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
    }
}

function handleDeleteBlogPost($id) {
    requireAdmin();
    
    $success = BlogService::deleteBlogPost($id);
    
    if (!$success) {
        http_response_code(404);
        echo json_encode(['error' => 'Blog post not found or delete failed']);
        return;
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Blog post deleted successfully'
    ]);
}

function requireAdmin() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (empty($_SESSION['is_admin'])) {
        http_response_code(403);
        echo json_encode(['error' => 'Admin access required']);
        exit;
    }
}
?>
