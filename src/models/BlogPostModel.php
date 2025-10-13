<?php
require_once __DIR__ . '/../interfaces/BlogPostInterface.php';

class BlogPostModel implements BlogPostInterface {
    private int $id;
    private string $language;
    private string $mainTitle;
    private string $mainText;
    private string $mainImage;
    private string $secondaryTitle;
    private string $secondaryText;
    private string $secondaryImage;
    private array $galleryImages;
    private bool $visible;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(array $data) {
        $this->id = $data['id'];
        $this->language = $data['language'];
        $this->mainTitle = $data['main_title'];
        $this->mainText = $data['main_text'];
        $this->mainImage = $data['main_image'];
        $this->secondaryTitle = $data['secondary_title'];
        $this->secondaryText = $data['secondary_text'];
        $this->secondaryImage = $data['secondary_image'];
        $this->galleryImages = $data['gallery_images'] ? json_decode($data['gallery_images'], true) : [];
        $this->visible = (bool) $data['visible'];
        $this->createdAt = $data['created_at'];
        $this->updatedAt = $data['updated_at'];
    }

    public function getId(): int { return $this->id; }
    public function getLanguage(): string { return $this->language; }
    public function getMainTitle(): string { return $this->mainTitle; }
    public function getMainText(): string { return $this->mainText; }
    public function getMainImage(): string { return $this->mainImage; }
    public function getSecondaryTitle(): string { return $this->secondaryTitle; }
    public function getSecondaryText(): string { return $this->secondaryText; }
    public function getSecondaryImage(): string { return $this->secondaryImage; }
    public function getGalleryImages(): array { return $this->galleryImages; }
    public function isVisible(): bool { return $this->visible; }
    public function getCreatedAt(): string { return $this->createdAt; }
    public function getUpdatedAt(): string { return $this->updatedAt; }

    public function getTrimmedMainText(int $length = 150): string {
        return strlen($this->mainText) > $length ? substr($this->mainText, 0, $length) . '...' : $this->mainText;
    }

    public function getTrimmedSecondaryText(int $length = 100): string {
        return strlen($this->secondaryText) > $length ? substr($this->secondaryText, 0, $length) . '...' : $this->secondaryText;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'language' => $this->language,
            'main_title' => $this->mainTitle,
            'main_text' => $this->mainText,
            'main_image' => $this->mainImage,
            'secondary_title' => $this->secondaryTitle,
            'secondary_text' => $this->secondaryText,
            'secondary_image' => $this->secondaryImage,
            'gallery_images' => $this->galleryImages,
            'visible' => $this->visible,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt
        ];
    }
}









