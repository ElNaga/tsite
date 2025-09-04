<?php
interface BlogPostInterface {
    public function getId(): int;
    public function getSlug(): string;
    public function getAuthorId(): int;
    public function getStatus(): string;
    public function getCreatedAt(): string;
    public function getUpdatedAt(): string;
    public function getPublishedAt(): ?string;
}

