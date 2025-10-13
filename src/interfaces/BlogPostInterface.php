<?php
interface BlogPostInterface {
    public function getId(): int;
    public function getLanguage(): string;
    public function getMainTitle(): string;
    public function getMainText(): string;
    public function getMainImage(): string;
    public function getSecondaryTitle(): string;
    public function getSecondaryText(): string;
    public function getSecondaryImage(): string;
    public function getGalleryImages(): array;
    public function isVisible(): bool;
    public function getCreatedAt(): string;
    public function getUpdatedAt(): string;
}

