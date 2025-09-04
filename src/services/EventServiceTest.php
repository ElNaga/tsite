<?php
require_once __DIR__ . '/EventService.php';

class EventServiceTest {
    
    public static function testGetEvents() {
        echo "Testing EventService::getEvents()...\n";
        
        try {
            $events = EventService::getEvents();
            echo "✅ Success: Found " . count($events) . " events\n";
            
            if (!empty($events)) {
                echo "First event: " . $events[0]['title'] . "\n";
            }
            
        } catch (Exception $e) {
            echo "❌ Error: " . $e->getMessage() . "\n";
        }
    }
    
    public static function testGetAllEvents() {
        echo "Testing EventService::getAllEvents()...\n";
        
        try {
            $all = EventService::getAllEvents();
            echo "✅ Success: Found " . count($all) . " total event records\n";
            
            // Group by language
            $byLang = [];
            foreach ($all as $event) {
                $lang = $event['language_code'];
                if (!isset($byLang[$lang])) {
                    $byLang[$lang] = 0;
                }
                $byLang[$lang]++;
            }
            
            foreach ($byLang as $lang => $count) {
                echo "  - $lang: $count events\n";
            }
            
        } catch (Exception $e) {
            echo "❌ Error: " . $e->getMessage() . "\n";
        }
    }
    
    public static function testGetEvent() {
        echo "Testing EventService::getEvent()...\n";
        
        try {
            $all = EventService::getAllEvents();
            if (!empty($all)) {
                $firstEventId = $all[0]['id'];
                $event = EventService::getEvent($firstEventId);
                
                if ($event) {
                    echo "✅ Success: Found event ID $firstEventId: " . $event['title'] . "\n";
                } else {
                    echo "❌ Error: Event not found\n";
                }
            } else {
                echo "⚠️  No events to test with\n";
            }
            
        } catch (Exception $e) {
            echo "❌ Error: " . $e->getMessage() . "\n";
        }
    }
    
    public static function runAllTests() {
        echo "=== EventService Tests ===\n\n";
        
        self::testGetEvents();
        echo "\n";
        
        self::testGetAllEvents();
        echo "\n";
        
        self::testGetEvent();
        echo "\n";
        
        echo "=== Tests Complete ===\n";
    }
}

// Run tests if called directly
if (php_sapi_name() === 'cli') {
    EventServiceTest::runAllTests();
} 