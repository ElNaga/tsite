<?php
require_once __DIR__ . '/../interfaces/EventInterface.php';

class EventModel implements EventInterface {
    private int $id;
    private string $image;
    private string $bookUrl;
    private string $status;
    private string $createdAt;
    private string $updatedAt;
    private array $translations = [];

    public function __construct(array $data) {
        $this->id = $data['id'];
        $this->image = $data['image'];
        $this->bookUrl = $data['book_url'];
        $this->status = $data['status'];
        $this->createdAt = $data['created_at'];
        $this->updatedAt = $data['updated_at'];
    }

    public function getId(): int { return $this->id; }
    public function getImage(): string { return $this->image; }
    public function getBookUrl(): string { return $this->bookUrl; }
    public function getStatus(): string { return $this->status; }
    public function getCreatedAt(): string { return $this->createdAt; }
    public function getUpdatedAt(): string { return $this->updatedAt; }

    public function setTranslations(array $translations): void {
        $this->translations = $translations;
    }

    public function getTranslation(string $languageCode): ?array {
        return $this->translations[$languageCode] ?? null;
    }

    public function getTitle(string $lang): string { 
        $translation = $this->getTranslation($lang);
        return $translation['title'] ?? ''; 
    }
    
    public function getDesc(string $lang): string { 
        $translation = $this->getTranslation($lang);
        return $translation['description'] ?? ''; 
    }
    
    public function getBookLabel(string $lang): string { 
        $translation = $this->getTranslation($lang);
        return $translation['book_label'] ?? ''; 
    }
    
    public function getImageAlt(string $lang): string { 
        $translation = $this->getTranslation($lang);
        return $translation['image_alt'] ?? ''; 
    }

    public function isPublished(): bool {
        return $this->status === 'published';
    }

    public function isDraft(): bool {
        return $this->status === 'draft';
    }

    public function isArchived(): bool {
        return $this->status === 'archived';
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'image' => $this->image,
            'book_url' => $this->bookUrl,
            'status' => $this->status,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'translations' => $this->translations
        ];
    }
} 