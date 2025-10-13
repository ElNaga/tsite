<?php

require_once __DIR__ . '/../interfaces/ContactInterface.php';

/**
 * Contact Message Model
 * 
 * Represents a contact form submission with all its data.
 * Provides methods to access message properties and check message status.
 * 
 * @package TeatarZaTebe\Models
 */
class ContactModel implements ContactInterface {
    private int $id;
    private string $fullName;
    private string $email;
    private ?string $phone;
    private ?string $subject;
    private string $message;
    private string $status;
    private string $languageCode;
    private ?string $ipAddress;
    private ?string $userAgent;
    private string $createdAt;
    private string $updatedAt;

    /**
     * Create a new ContactModel instance from database data
     * 
     * @param array $data Associative array of contact message data from database
     */
    public function __construct(array $data) {
        $this->id = (int) $data['id'];
        $this->fullName = $data['full_name'];
        $this->email = $data['email'];
        $this->phone = $data['phone'] ?? null;
        $this->subject = $data['subject'] ?? null;
        $this->message = $data['message'];
        $this->status = $data['status'];
        $this->languageCode = $data['language_code'];
        $this->ipAddress = $data['ip_address'] ?? null;
        $this->userAgent = $data['user_agent'] ?? null;
        $this->createdAt = $data['created_at'];
        $this->updatedAt = $data['updated_at'];
    }

    // Interface implementation
    public function getId(): int { 
        return $this->id; 
    }
    
    public function getFullName(): string { 
        return $this->fullName; 
    }
    
    public function getEmail(): string { 
        return $this->email; 
    }
    
    public function getPhone(): ?string { 
        return $this->phone; 
    }
    
    public function getSubject(): ?string { 
        return $this->subject; 
    }
    
    public function getMessage(): string { 
        return $this->message; 
    }
    
    public function getStatus(): string { 
        return $this->status; 
    }
    
    public function getLanguageCode(): string { 
        return $this->languageCode; 
    }
    
    public function getIpAddress(): ?string { 
        return $this->ipAddress; 
    }
    
    public function getCreatedAt(): string { 
        return $this->createdAt; 
    }

    // Additional getters
    public function getUpdatedAt(): string { 
        return $this->updatedAt; 
    }
    
    public function getUserAgent(): ?string { 
        return $this->userAgent; 
    }

    // Status check methods
    /**
     * Check if this message is new (unread)
     * 
     * @return bool True if the message status is 'new'
     */
    public function isNew(): bool {
        return $this->status === 'new';
    }

    /**
     * Check if this message has been read
     * 
     * @return bool True if the message status is 'read'
     */
    public function isRead(): bool {
        return $this->status === 'read';
    }

    /**
     * Check if this message has been replied to
     * 
     * @return bool True if the message status is 'replied'
     */
    public function isReplied(): bool {
        return $this->status === 'replied';
    }

    /**
     * Check if this message is archived
     * 
     * @return bool True if the message status is 'archived'
     */
    public function isArchived(): bool {
        return $this->status === 'archived';
    }

    /**
     * Convert the model to an associative array
     * 
     * @return array Contact message data as array
     */
    public function toArray(): array {
        return [
            'id' => $this->id,
            'full_name' => $this->fullName,
            'email' => $this->email,
            'phone' => $this->phone,
            'subject' => $this->subject,
            'message' => $this->message,
            'status' => $this->status,
            'language_code' => $this->languageCode,
            'ip_address' => $this->ipAddress,
            'user_agent' => $this->userAgent,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt
        ];
    }

    /**
     * Get a short preview of the message (first 100 characters)
     * 
     * @return string Truncated message preview
     */
    public function getMessagePreview(): string {
        if (strlen($this->message) <= 100) {
            return $this->message;
        }
        return substr($this->message, 0, 97) . '...';
    }

    /**
     * Get formatted creation date
     * 
     * @param string $format Date format (default: 'Y-m-d H:i')
     * @return string Formatted date string
     */
    public function getFormattedDate(string $format = 'Y-m-d H:i'): string {
        return date($format, strtotime($this->createdAt));
    }
}

