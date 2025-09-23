<?php
require_once __DIR__ . '/../../src/services/EventService.php';
require_once __DIR__ . '/../../src/services/TransactionService.php';
require_once __DIR__ . '/../../src/services/PeopleService.php';

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
        
        return [
            'events' => $events,
            'people' => $people,
            'transactions' => $transactions,
            'totalEvents' => count($allEvents),
            'totalPeople' => count($allPeople),
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