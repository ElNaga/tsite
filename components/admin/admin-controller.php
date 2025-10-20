<?php
require_once __DIR__ . '/../../src/services/EventService.php';
require_once __DIR__ . '/../../src/services/TransactionService.php';
require_once __DIR__ . '/../../src/services/PeopleService.php';
require_once __DIR__ . '/../../src/services/BlogService.php';

class AdminController {
    
    public static function getData() {
        // Get all events data in all languages
        $allEvents = EventService::getAllEvents();
        
        // Organize events by language for admin display
        $events = [
            'en' => [],
            'mk' => [],
            'fr' => []
        ];
        
        // Group events by language
        foreach ($allEvents as $event) {
            $lang = $event['language_code'];
            if (isset($events[$lang])) {
                $events[$lang][] = $event;
            }
        }
        
        // Get transactions
        $transactions = TransactionService::getAllTransactions();
        
        // Get all people data
        $allPeople = PeopleService::getAllPeople();
        
        // Organize people by language for admin display
        $people = [
            'en' => [],
            'mk' => [],
            'fr' => []
        ];
        
        // Group people by language
        foreach ($allPeople as $person) {
            $lang = $person['language_code'];
            if (isset($people[$lang])) {
                $people[$lang][] = $person;
            }
        }
        
        // Get blog posts
        $blogPosts = BlogService::getAllBlogPosts();
        
        return [
            'events' => $events,
            'people' => $people,
            'transactions' => $transactions,
            'blogPosts' => $blogPosts,
            'totalEvents' => count($allEvents),
            'totalPeople' => count($allPeople),
            'totalTransactions' => count($transactions),
            'totalBlogPosts' => count($blogPosts)
        ];
    }
    
    public static function isAdmin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if admin session exists and is valid
        if (empty($_SESSION['is_admin']) || empty($_SESSION['admin_user_id'])) {
            return false;
        }
        
        // Check session timeout (24 hours)
        $sessionTimeout = 24 * 60 * 60; // 24 hours in seconds
        if (isset($_SESSION['admin_login_time']) && (time() - $_SESSION['admin_login_time']) > $sessionTimeout) {
            // Session expired, clear admin session
            self::clearAdminSession();
            return false;
        }
        
        return true;
    }
    
    public static function clearAdminSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['is_admin']);
        unset($_SESSION['admin_user_id']);
        unset($_SESSION['admin_username']);
        unset($_SESSION['admin_login_time']);
    }
    
    public static function requireAdmin() {
        if (!self::isAdmin()) {
            header('Location: /home');
            exit;
        }
    }
}
?> 