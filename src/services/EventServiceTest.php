<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/EventService.php';

class EventServiceTest extends TestCase {
    private $backupFile;
    private $backupTransactionsFile;
    private $testFile;
    private $testTransactionsFile;

    protected function setUp(): void {
        // Backup and use a temp file for events and transactions
        $this->backupFile = EventService::$file;
        $this->backupTransactionsFile = EventService::$transactionsFile;
        $this->testFile = __DIR__ . '/test_events.json';
        $this->testTransactionsFile = __DIR__ . '/test_transactions.json';
        EventService::$file = $this->testFile;
        EventService::$transactionsFile = $this->testTransactionsFile;
        file_put_contents($this->testFile, json_encode(['en'=>[], 'mk'=>[], 'fr'=>[]]));
        file_put_contents($this->testTransactionsFile, json_encode([]));
    }

    protected function tearDown(): void {
        // Restore
        EventService::$file = $this->backupFile;
        EventService::$transactionsFile = $this->backupTransactionsFile;
        @unlink($this->testFile);
        @unlink($this->testTransactionsFile);
    }

    public function testAddEvent() {
        $event = [
            'en' => ['title'=>'EN','desc'=>'EN'],
            'mk' => ['title'=>'MK','desc'=>'MK'],
            'fr' => ['title'=>'FR','desc'=>'FR']
        ];
        $id = EventService::addEvent($event);
        $this->assertEquals(1, $id);
        $all = EventService::getAllEvents('en');
        $this->assertCount(1, $all);
        $this->assertEquals('EN', $all[0]['title']);
    }

    public function testEditEvent() {
        $event = [
            'en' => ['title'=>'EN','desc'=>'EN'],
            'mk' => ['title'=>'MK','desc'=>'MK'],
            'fr' => ['title'=>'FR','desc'=>'FR']
        ];
        $id = EventService::addEvent($event);
        $event['en']['title'] = 'EN2';
        EventService::editEvent($id, $event);
        $all = EventService::getAllEvents('en');
        $this->assertEquals('EN2', $all[0]['title']);
    }

    public function testDeleteEvent() {
        $event = [
            'en' => ['title'=>'EN','desc'=>'EN'],
            'mk' => ['title'=>'MK','desc'=>'MK'],
            'fr' => ['title'=>'FR','desc'=>'FR']
        ];
        $id = EventService::addEvent($event);
        EventService::deleteEvent($id);
        $all = EventService::getAllEvents('en');
        $this->assertCount(0, $all);
    }

    public function testAddTransaction() {
        $event = [
            'en' => ['title'=>'EN','desc'=>'EN'],
            'mk' => ['title'=>'MK','desc'=>'MK'],
            'fr' => ['title'=>'FR','desc'=>'FR']
        ];
        $id = EventService::addEvent($event);
        $user = ['name'=>'Test User','email'=>'test@example.com'];
        EventService::addTransaction($id, $user);
        $txs = EventService::getTransactions($id);
        $this->assertCount(1, $txs);
        $this->assertEquals('Test User', $txs[0]['user']['name']);
    }
} 