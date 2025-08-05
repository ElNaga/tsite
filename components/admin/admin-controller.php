<?php
require_once __DIR__ . '/../../src/services/EventService.php';

class AdminController {
    
    public static function getData() {
        // Get all events data
        $events = [
            'en' => EventService::getAllEvents('en'),
            'mk' => EventService::getAllEvents('mk'),
            'fr' => EventService::getAllEvents('fr')
        ];
        
        // Get transactions if needed
        $transactions = EventService::getTransactions();
        
        return [
            'events' => $events,
            'transactions' => $transactions,
            'totalEvents' => count($events['en']),
            'totalTransactions' => count($transactions)
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