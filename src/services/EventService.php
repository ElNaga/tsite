<?php
require_once __DIR__ . '/../models/EventModel.php';
require_once __DIR__ . '/../../i18n.php';

class EventService {
    private static $file = __DIR__ . '/../../data/events.json';
    private static $events = null;
    private static $transactionsFile = __DIR__ . '/../../data/transactions.json';

    private static function loadEvents() {
        if (self::$events !== null) return;
        if (!file_exists(self::$file)) {
            self::$events = [ 'en' => [], 'mk' => [], 'fr' => [] ];
            self::saveEvents();
        } else {
            $json = file_get_contents(self::$file);
            self::$events = json_decode($json, true) ?: [ 'en' => [], 'mk' => [], 'fr' => [] ];
        }
    }

    private static function saveEvents() {
        file_put_contents(self::$file, json_encode(self::$events, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public static function getAllEvents($lang = 'en') {
        self::loadEvents();
        return self::$events[$lang] ?? [];
    }

    public static function getLatestEvent($lang = 'en') {
        $events = self::getAllEvents($lang);
        return $events[0] ?? null;
    }

    public static function addEvent($event) {
        self::loadEvents();
        $id = self::getNextId();
        foreach (['en', 'mk', 'fr'] as $lang) {
            $ev = $event[$lang] ?? [];
            $ev['id'] = $id;
            self::$events[$lang][] = $ev;
        }
        self::saveEvents();
        return $id;
    }

    public static function editEvent($id, $event) {
        self::loadEvents();
        foreach (['en', 'mk', 'fr'] as $lang) {
            foreach (self::$events[$lang] as &$ev) {
                if ($ev['id'] == $id) {
                    $ev = array_merge($ev, $event[$lang] ?? []);
                    $ev['id'] = $id;
                }
            }
        }
        self::saveEvents();
    }

    public static function deleteEvent($id) {
        self::loadEvents();
        foreach (['en', 'mk', 'fr'] as $lang) {
            self::$events[$lang] = array_values(array_filter(self::$events[$lang], function($ev) use ($id) {
                return $ev['id'] != $id;
            }));
        }
        self::saveEvents();
    }

    private static function getNextId() {
        $max = 0;
        foreach (['en', 'mk', 'fr'] as $lang) {
            foreach (self::$events[$lang] as $ev) {
                if (isset($ev['id']) && $ev['id'] > $max) $max = $ev['id'];
            }
        }
        return $max + 1;
    }

    public static function addTransaction($eventId, $user) {
        $transactions = [];
        if (file_exists(self::$transactionsFile)) {
            $transactions = json_decode(file_get_contents(self::$transactionsFile), true) ?: [];
        }
        $transactions[] = [
            'event_id' => $eventId,
            'user' => $user,
            'timestamp' => date('c'),
        ];
        file_put_contents(self::$transactionsFile, json_encode($transactions, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public static function getTransactions($eventId = null) {
        if (!file_exists(self::$transactionsFile)) return [];
        $transactions = json_decode(file_get_contents(self::$transactionsFile), true) ?: [];
        if ($eventId === null) return $transactions;
        return array_values(array_filter($transactions, function($t) use ($eventId) {
            return $t['event_id'] == $eventId;
        }));
    }

    public static function handleEventRequest($method, $input, $query = []) {
        if ($method === 'GET') {
            return [
                'en' => self::getAllEvents('en'),
                'mk' => self::getAllEvents('mk'),
                'fr' => self::getAllEvents('fr'),
            ];
        }
        if ($method === 'POST') {
            // Add event: expects { en: {...}, mk: {...}, fr: {...} }
            $id = self::addEvent($input);
            return ['success' => true, 'id' => $id];
        }
        if ($method === 'PUT') {
            // Edit event: expects { id: ..., en: {...}, mk: {...}, fr: {...} }
            if (!isset($input['id'])) {
                return ['success' => false, 'error' => 'Missing id'];
            }
            self::editEvent($input['id'], $input);
            return ['success' => true];
        }
        if ($method === 'DELETE') {
            // Delete event: expects { id: ... }
            if (!isset($input['id'])) {
                return ['success' => false, 'error' => 'Missing id'];
            }
            self::deleteEvent($input['id']);
            return ['success' => true];
        }
        return ['success' => false, 'error' => 'Method not allowed'];
    }
} 