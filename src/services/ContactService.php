<?php

require_once __DIR__ . '/../models/ContactModel.php';

/**
 * Contact Service
 * 
 * Handles all business logic related to contact form submissions.
 * Provides methods for creating, retrieving, and managing contact messages.
 * Includes email notification functionality for administrators.
 * 
 * @package TeatarZaTebe\Services
 */
class ContactService {
    private static $pdo = null;
    
    /**
     * Get PDO database connection
     * 
     */
    private static function getPdo() {
        if (self::$pdo === null) {
            self::$pdo = require __DIR__ . '/../../bootstrap.php';
        }
        return self::$pdo;
    }
    
    /**
     * Create a new contact message
     * 
     * Validates and stores a new contact form submission in the database.
     * Optionally sends email notifications to administrators.
     * 
     * @param array $data Contact form data
     * @return int The ID of the newly created message
     * @throws Exception If validation fails or database error occurs
     */
    public static function createMessage(array $data): int {
        // Validate required fields
        if (empty($data['full_name']) || empty($data['email']) || empty($data['message'])) {
            throw new Exception("Missing required fields: full_name, email, and message are required");
        }
        
        // Validate email format
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email address format");
        }
        
        try {
            $pdo = self::getPdo();
            
            $stmt = $pdo->prepare("
                INSERT INTO contact_messages 
                (full_name, email, phone, subject, message, language_code, ip_address, user_agent) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $data['full_name'],
                $data['email'],
                $data['phone'] ?? null,
                $data['subject'] ?? null,
                $data['message'],
                $data['language_code'] ?? 'en',
                $data['ip_address'] ?? null,
                $data['user_agent'] ?? null
            ]);
            
            $messageId = (int) $pdo->lastInsertId();
            
            // Send email notification to admin (optional)
            self::sendAdminNotification($data);
            
            return $messageId;
        } catch (Exception $e) {
            error_log("Failed to create contact message: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Get all contact messages
     * 
     * Retrieves all messages from the database, ordered by creation date (newest first).
     * 
     * @param string|null $status Optional status filter ('new', 'read', 'replied', 'archived')
     * @return ContactModel[] Array of ContactModel objects
     */
    public static function getAllMessages(?string $status = null): array {
        try {
            $pdo = self::getPdo();
            
            if ($status) {
                $stmt = $pdo->prepare("
                    SELECT * FROM contact_messages 
                    WHERE status = ? 
                    ORDER BY created_at DESC
                ");
                $stmt->execute([$status]);
            } else {
                $stmt = $pdo->query("
                    SELECT * FROM contact_messages 
                    ORDER BY created_at DESC
                ");
            }
            
            $messages = [];
            while ($row = $stmt->fetch()) {
                $messages[] = new ContactModel($row);
            }
            
            return $messages;
        } catch (Exception $e) {
            error_log("Failed to get contact messages: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get a single contact message by ID
     * 
     * @param int $id Message ID
     * @return ContactModel|null The message model or null if not found
     */
    public static function getMessageById(int $id): ?ContactModel {
        try {
            $pdo = self::getPdo();
            
            $stmt = $pdo->prepare("SELECT * FROM contact_messages WHERE id = ?");
            $stmt->execute([$id]);
            
            $row = $stmt->fetch();
            if ($row) {
                return new ContactModel($row);
            }
            
            return null;
        } catch (Exception $e) {
            error_log("Failed to get contact message: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Update message status
     * 
     * Changes the status of a message (e.g., from 'new' to 'read')
     * 
     * @param int $id Message ID
     * @param string $status New status ('new', 'read', 'replied', 'archived')
     * @return bool True if update was successful
     */
    public static function updateMessageStatus(int $id, string $status): bool {
        $allowedStatuses = ['new', 'read', 'replied', 'archived'];
        if (!in_array($status, $allowedStatuses)) {
            error_log("Invalid status: $status");
            return false;
        }
        
        try {
            $pdo = self::getPdo();
            
            $stmt = $pdo->prepare("
                UPDATE contact_messages 
                SET status = ? 
                WHERE id = ?
            ");
            $stmt->execute([$status, $id]);
            
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Failed to update message status: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Delete a contact message
     * 
     * Permanently removes a message from the database.
     * Use with caution - consider archiving instead.
     * 
     * @param int $id Message ID
     * @return bool True if deletion was successful
     */
    public static function deleteMessage(int $id): bool {
        try {
            $pdo = self::getPdo();
            
            $stmt = $pdo->prepare("DELETE FROM contact_messages WHERE id = ?");
            $stmt->execute([$id]);
            
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Failed to delete message: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get message statistics
     * 
     * Returns counts of messages by status and other metrics.
     * 
     * @return array Statistics array with counts
     */
    public static function getStatistics(): array {
        try {
            $pdo = self::getPdo();
            
            // Total messages
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM contact_messages");
            $total = $stmt->fetch()['total'];
            
            // New messages
            $stmt = $pdo->query("SELECT COUNT(*) as new FROM contact_messages WHERE status = 'new'");
            $new = $stmt->fetch()['new'];
            
            // Read messages
            $stmt = $pdo->query("SELECT COUNT(*) as read FROM contact_messages WHERE status = 'read'");
            $read = $stmt->fetch()['read'];
            
            // Replied messages
            $stmt = $pdo->query("SELECT COUNT(*) as replied FROM contact_messages WHERE status = 'replied'");
            $replied = $stmt->fetch()['replied'];
            
            // Messages in last 7 days
            $stmt = $pdo->query("SELECT COUNT(*) as recent FROM contact_messages WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
            $recent = $stmt->fetch()['recent'];
            
            return [
                'total' => (int) $total,
                'new' => (int) $new,
                'read' => (int) $read,
                'replied' => (int) $replied,
                'recent' => (int) $recent
            ];
        } catch (Exception $e) {
            error_log("Failed to get message statistics: " . $e->getMessage());
            return [
                'total' => 0,
                'new' => 0,
                'read' => 0,
                'replied' => 0,
                'recent' => 0
            ];
        }
    }
    
    /**
     * Send email notification to administrator
     * 
     * Sends an email to the configured admin address when a new message is received.
     * This is a simple implementation - can be enhanced with email templates.
     * 
     * @param array $data Contact form data
     * @return bool True if email was sent successfully
     */
    private static function sendAdminNotification(array $data): bool {
        $adminEmail = getenv('ADMIN_EMAIL') ?: 'izabelafdu@outlook.com';
        
        $subject = "New Contact Message from " . ($data['full_name'] ?? 'Unknown');
        
        $message = "You have received a new contact message:\n\n";
        $message .= "Name: " . ($data['full_name'] ?? 'N/A') . "\n";
        $message .= "Email: " . ($data['email'] ?? 'N/A') . "\n";
        $message .= "Phone: " . ($data['phone'] ?? 'N/A') . "\n";
        $message .= "Subject: " . ($data['subject'] ?? 'N/A') . "\n";
        $message .= "Message:\n" . ($data['message'] ?? 'N/A') . "\n\n";
        $message .= "Language: " . ($data['language_code'] ?? 'en') . "\n";
        $message .= "Time: " . date('Y-m-d H:i:s') . "\n";
        
        $headers = "From: noreply@teatarzatebe.mk\r\n";
        $headers .= "Reply-To: " . ($data['email'] ?? 'noreply@teatarzatebe.mk') . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        
        try {
            // Note: mail() function may not work in all environments
            // Consider using a proper email library like PHPMailer in production
            $sent = @mail($adminEmail, $subject, $message, $headers);
            
            if (!$sent) {
                error_log("Failed to send admin notification email");
            }
            
            return $sent;
        } catch (Exception $e) {
            error_log("Error sending admin notification: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Validate contact form data
     * 
     * Performs comprehensive validation on contact form data.
     * 
     * @param array $data Form data to validate
     * @return array Array with 'valid' boolean and 'errors' array
     */
    public static function validateFormData(array $data): array {
        $errors = [];
        
        // Validate full name
        if (empty($data['full_name'])) {
            $errors['full_name'] = 'Full name is required';
        } elseif (strlen($data['full_name']) < 2) {
            $errors['full_name'] = 'Full name must be at least 2 characters';
        } elseif (strlen($data['full_name']) > 100) {
            $errors['full_name'] = 'Full name must not exceed 100 characters';
        }
        
        // Validate email
        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }
        
        // Validate phone (if provided)
        if (!empty($data['phone']) && strlen($data['phone']) > 50) {
            $errors['phone'] = 'Phone number must not exceed 50 characters';
        }
        
        // Validate subject (if provided)
        if (!empty($data['subject']) && strlen($data['subject']) > 255) {
            $errors['subject'] = 'Subject must not exceed 255 characters';
        }
        
        // Validate message
        if (empty($data['message'])) {
            $errors['message'] = 'Message is required';
        } elseif (strlen($data['message']) < 10) {
            $errors['message'] = 'Message must be at least 10 characters';
        } elseif (strlen($data['message']) > 5000) {
            $errors['message'] = 'Message must not exceed 5000 characters';
        }
        
        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }
}

