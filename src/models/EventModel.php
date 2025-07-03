<?php
require_once __DIR__ . '/../interfaces/EventInterface.php';

class EventModel implements EventInterface {
    private int $id;
    private string $image;
    private array $title;
    private array $desc;
    private string $book_url;
    private array $book_label;
    private array $image_alt;

    public function __construct(array $data) {
        $this->id = $data['id'];
        $this->image = $data['image'];
        $this->title = $data['title'];
        $this->desc = $data['desc'];
        $this->book_url = $data['book_url'];
        $this->book_label = $data['book_label'];
        $this->image_alt = $data['image_alt'];
    }

    public function getId(): int { return $this->id; }
    public function getImage(): string { return $this->image; }
    public function getTitle(string $lang): string { return $this->title[$lang] ?? $this->title['en']; }
    public function getDesc(string $lang): string { return $this->desc[$lang] ?? $this->desc['en']; }
    public function getBookUrl(): string { return $this->book_url; }
    public function getBookLabel(string $lang): string { return $this->book_label[$lang] ?? $this->book_label['en']; }
    public function getImageAlt(string $lang): string { return $this->image_alt[$lang] ?? $this->image_alt['en']; }
} 