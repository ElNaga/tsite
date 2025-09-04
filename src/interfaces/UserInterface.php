<?php
interface UserInterface {
    public function getId(): int;
    public function getEmail(): string;
    public function getName(): string;
    public function getRole(): string;
    public function isActive(): bool;
    public function getCreatedAt(): string;
    public function getUpdatedAt(): string;
}

