<?php
require_once __DIR__ . '/../../src/services/EventService.php';
require_once __DIR__ . '/../../src/services/TransactionService.php';
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
        
        // Get blog posts
        $blogPosts = BlogService::getAllBlogPosts();
        
        return [
            'events' => $events,
            'transactions' => $transactions,
            'blogPosts' => $blogPosts,
            'totalEvents' => count($allEvents),
            'totalTransactions' => count($transactions),
            'totalBlogPosts' => count($blogPosts)
        ];
    }
    
    public static function isAdmin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return !empty($_SESSION['is_admin']);
    }
    
    public static function requireAdmin() {
        if (!self::isAdmin()) {
            header('Location: /home');
            exit;
        }
    }
}
?> 