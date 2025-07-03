<?php
require_once __DIR__ . '/../interfaces/Event.php';

class EventDTO implements Event {
    public function __construct(
        private int $id,
        private string $image,
        private array $title,
        private array $desc,
        private string $book_url,
        private array $book_label,
        private array $image_alt,
    ) {}

    public function getId(): int { return $this->id; }
    public function getImage(): string { return $this->image; }
    public function getTitle(): array { return $this->title; }
    public function getDesc(): array { return $this->desc; }
    public function getBookUrl(): string { return $this->book_url; }
    public function getBookLabel(): array { return $this->book_label; }
    public function getImageAlt(): array { return $this->image_alt; }
} 