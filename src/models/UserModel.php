<?php
require_once __DIR__ . '/../interfaces/UserInterface.php';

class UserModel implements UserInterface {
    private int $id;
    private string $email;
    private string $name;
    private string $role;
    private bool $isActive;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(array $data) {
        $this->id = $data['id'];
        $this->email = $data['email'];
        $this->name = $data['name'];
        $this->role = $data['role'];
        $this->isActive = (bool) $data['is_active'];
        $this->createdAt = $data['created_at'];
        $this->updatedAt = $data['updated_at'];
    }

    public function getId(): int { return $this->id; }
    public function getEmail(): string { return $this->email; }
    public function getName(): string { return $this->name; }
    public function getRole(): string { return $this->role; }
    public function isActive(): bool { return $this->isActive; }
    public function getCreatedAt(): string { return $this->createdAt; }
    public function getUpdatedAt(): string { return $this->updatedAt; }

    public function isAdmin(): bool {
        return $this->role === 'admin';
    }

    public function isEditor(): bool {
        return $this->role === 'editor' || $this->role === 'admin';
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'role' => $this->role,
            'is_active' => $this->isActive,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt
        ];
    }
}









