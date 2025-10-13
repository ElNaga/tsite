<?php

/**
 * Contact Message Interface
 * 
 * Defines the contract for contact message objects.
 * Contact messages are form submissions from users wanting to get in touch.
 * 
 * @package TeatarZaTebe\Interfaces
 */
interface ContactInterface {
    /**
     * Get the unique identifier for this contact message
     * 
     * @return int The message ID
     */
    public function getId(): int;
    
    /**
     * Get the sender's full name
     * 
     * @return string The full name of the person who sent the message
     */
    public function getFullName(): string;
    
    /**
     * Get the sender's email address
     * 
     * @return string The email address for communication
     */
    public function getEmail(): string;
    
    /**
     * Get the sender's phone number (optional)
     * 
     * @return string|null The phone number, or null if not provided
     */
    public function getPhone(): ?string;
    
    /**
     * Get the subject of the message (optional)
     * 
     * @return string|null The subject line, or null if not provided
     */
    public function getSubject(): ?string;
    
    /**
     * Get the message content
     * 
     * @return string The message text
     */
    public function getMessage(): string;
    
    /**
     * Get the current status of this message
     * 
     * @return string One of: 'new', 'read', 'replied', 'archived'
     */
    public function getStatus(): string;
    
    /**
     * Get the language code for this message
     * 
     * @return string Two-letter language code (e.g., 'en', 'mk', 'fr')
     */
    public function getLanguageCode(): string;
    
    /**
     * Get the IP address of the sender
     * 
     * @return string|null The sender's IP address
     */
    public function getIpAddress(): ?string;
    
    /**
     * Get the timestamp when this message was created
     * 
     * @return string ISO 8601 formatted timestamp
     */
    public function getCreatedAt(): string;
}

