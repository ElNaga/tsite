<?php
/**
 * Populate Transactions
 * Adds sample booking transactions with different statuses
 */

require_once __DIR__ . '/bootstrap.php';

try {
    $pdo = require __DIR__ . '/bootstrap.php';
    
    echo "<h1>Populating Transactions</h1>\n";
    echo "<p>Adding sample booking transactions...</p>\n";
    
    // Insert Transactions
    echo "<h2>Inserting Transactions...</h2>\n";
    $transactions = [
        [1, '{"name": "John Smith", "email": "john@example.com", "phone": "+38970123456", "child_name": "Emma", "child_age": 7, "guests": 12, "special_requests": "Emma loves princesses"}', 'confirmed', 150.00, 'bank_transfer'],
        [1, '{"name": "Maria Garcia", "email": "maria@example.com", "phone": "+38970234567", "child_name": "Luka", "child_age": 5, "guests": 8, "allergies": "No nuts please"}', 'pending', 120.00, 'cash'],
        [2, '{"name": "David Johnson", "email": "david@example.com", "phone": "+38970345678", "child_name": "Sofia", "child_age": 9, "guests": 15, "experience": "First time at drama workshop"}', 'completed', 180.00, 'credit_card'],
        [3, '{"name": "Anna Petrov", "email": "anna@example.com", "phone": "+38970456789", "child_name": "Marko", "child_age": 6, "guests": 10, "favorite_story": "Little Red Riding Hood"}', 'confirmed', 140.00, 'bank_transfer'],
        [5, '{"name": "Sarah Wilson", "email": "sarah@example.com", "phone": "+38970567890", "child_name": "Nikola", "child_age": 8, "guests": 20, "theme_preference": "Superhero theme"}', 'pending', 200.00, 'credit_card'],
        [1, '{"name": "Michael Brown", "email": "michael@example.com", "phone": "+38970678901", "child_name": "Elena", "child_age": 4, "guests": 6, "cancellation_reason": "Family emergency"}', 'cancelled', 100.00, 'bank_transfer'],
        [2, '{"name": "Lisa Anderson", "email": "lisa@example.com", "phone": "+38970789012", "child_name": "Alex", "child_age": 10, "guests": 12, "previous_experience": "Has done drama before"}', 'confirmed', 160.00, 'credit_card'],
        [3, '{"name": "Peter Novak", "email": "peter@example.com", "phone": "+38970890123", "child_name": "Mila", "child_age": 7, "guests": 8, "language_preference": "Macedonian"}', 'pending', 130.00, 'cash'],
        [4, '{"name": "Elena Dimitrov", "email": "elena@example.com", "phone": "+38970901234", "child_name": "Stefan", "child_age": 9, "guests": 14, "waitlist": true}', 'pending', 170.00, 'bank_transfer'],
        [5, '{"name": "Mark Thompson", "email": "mark@example.com", "phone": "+38970012345", "child_name": "Zoe", "child_age": 6, "guests": 10, "costume_request": "Princess costume"}', 'completed', 145.00, 'credit_card']
    ];
    
    $stmt = $pdo->prepare("INSERT INTO transactions (event_id, user_data, status, amount, payment_method) VALUES (?, ?, ?, ?, ?)");
    foreach ($transactions as $transaction) {
        $stmt->execute($transaction);
        echo "✓ Inserted transaction for event {$transaction[0]} - Status: {$transaction[2]} - Amount: {$transaction[3]}\n";
    }
    
    echo "<h2>✅ Transactions Population Complete!</h2>\n";
    echo "<p><strong>Summary:</strong></p>\n";
    echo "<ul>\n";
    echo "<li>Transactions: " . count($transactions) . "</li>\n";
    echo "<li>Statuses: confirmed, pending, completed, cancelled</li>\n";
    echo "<li>Payment Methods: bank_transfer, cash, credit_card</li>\n";
    echo "</ul>\n";
    
} catch (Exception $e) {
    echo "<h2>❌ Error during transactions population:</h2>\n";
    echo "<p style='color: red;'>" . htmlspecialchars($e->getMessage()) . "</p>\n";
}
?>
