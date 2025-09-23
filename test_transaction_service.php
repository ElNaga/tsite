<?php
// Test TransactionService
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>TransactionService Test</h1>";

try {
    require_once __DIR__ . '/src/services/TransactionService.php';
    
    echo "<p>1. Testing TransactionService::getAllTransactions()...</p>";
    $transactions = TransactionService::getAllTransactions();
    echo "<p>✅ Success! Found " . count($transactions) . " transactions</p>";
    
    if (count($transactions) > 0) {
        echo "<h3>First transaction:</h3>";
        echo "<pre>" . htmlspecialchars(print_r($transactions[0], true)) . "</pre>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p class='error'>Stack trace:</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
} catch (Error $e) {
    echo "<p class='error'>❌ Fatal Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p class='error'>Stack trace:</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
?>
