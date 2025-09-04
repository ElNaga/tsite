<?php
interface SessionInterface {
    public function getId(): int;
    public function getSessionId(): string;
    public function getUserData(): array;
    public function getCreatedAt(): string;
    public function getUpdatedAt(): string;
    public function getExpiresAt(): ?string;
    public function isExpired(): bool;
}

