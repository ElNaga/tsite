<?php
require_once __DIR__ . '/../interfaces/BlogPostInterface.php';

class BlogPostModel implements BlogPostInterface {
    private int $id;
    private string $slug;
    private int $authorId;
    private string $status;
    private string $createdAt;
    private string $updatedAt;
    private ?string $publishedAt;
    private ?string $featuredImage;
    private array $translations = [];

    public function __construct(array $data) {
        $this->id = $data['id'];
        $this->slug = $data['slug'];
        $this->authorId = $data['author_id'];
        $this->status = $data['status'];
        $this->createdAt = $data['created_at'];
        $this->updatedAt = $data['updated_at'];
        $this->publishedAt = $data['published_at'] ?? null;
        $this->featuredImage = $data['featured_image'] ?? null;
    }

    public function getId(): int { return $this->id; }
    public function getSlug(): string { return $this->slug; }
    public function getAuthorId(): int { return $this->authorId; }
    public function getStatus(): string { return $this->status; }
    public function getCreatedAt(): string { return $this->createdAt; }
    public function getUpdatedAt(): string { return $this->updatedAt; }
    public function getPublishedAt(): ?string { return $this->publishedAt; }

    public function getFeaturedImage(): ?string { return $this->featuredImage; }

    public function isPublished(): bool {
        return $this->status === 'published' && $this->publishedAt !== null;
    }

    public function isDraft(): bool {
        return $this->status === 'draft';
    }

    public function isArchived(): bool {
        return $this->status === 'archived';
    }

    public function setTranslations(array $translations): void {
        $this->translations = $translations;
    }

    public function getTranslation(string $languageCode): ?array {
        return $this->translations[$languageCode] ?? null;
    }

    public function getTitle(string $languageCode): string {
        $translation = $this->getTranslation($languageCode);
        return $translation['title'] ?? '';
    }

    public function getContent(string $languageCode): string {
        $translation = $this->getTranslation($languageCode);
        return $translation['content'] ?? '';
    }

    public function getExcerpt(string $languageCode): string {
        $translation = $this->getTranslation($languageCode);
        return $translation['excerpt'] ?? '';
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'author_id' => $this->authorId,
            'status' => $this->status,
            'featured_image' => $this->featuredImage,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'published_at' => $this->publishedAt,
            'translations' => $this->translations
        ];
    }
}








