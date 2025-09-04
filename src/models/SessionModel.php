<?php
require_once __DIR__ . '/../interfaces/SessionInterface.php';

class SessionModel implements SessionInterface {
    private int $id;
    private string $sessionId;
    private ?int $userId;
    private array $userData;
    private string $createdAt;
    private string $updatedAt;
    private ?string $expiresAt;

    public function __construct(array $data) {
        $this->id = $data['id'];
        $this->sessionId = $data['session_id'];
        $this->userId = $data['user_id'] ?? null;
        $this->userData = is_string($data['user_data']) ? json_decode($data['user_data'], true) : ($data['user_data'] ?? []);
        $this->createdAt = $data['created_at'];
        $this->updatedAt = $data['updated_at'];
        $this->expiresAt = $data['expires_at'] ?? null;
    }

    public function getId(): int { return $this->id; }
    public function getSessionId(): string { return $this->sessionId; }
    public function getUserData(): array { return $this->userData; }
    public function getCreatedAt(): string { return $this->createdAt; }
    public function getUpdatedAt(): string { return $this->updatedAt; }
    public function getExpiresAt(): ?string { return $this->expiresAt; }

    public function getUserId(): ?int { return $this->userId; }

    public function isExpired(): bool {
        if ($this->expiresAt === null) {
            return false;
        }
        return strtotime($this->expiresAt) < time();
    }

    public function isAdmin(): bool {
        return isset($this->userData['is_admin']) && $this->userData['is_admin'] === true;
    }

    public function getLanguage(): string {
        return $this->userData['lang'] ?? 'en';
    }

    public function setUserData(array $data): void {
        $this->userData = array_merge($this->userData, $data);
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'session_id' => $this->sessionId,
            'user_id' => $this->userId,
            'user_data' => $this->userData,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'expires_at' => $this->expiresAt
        ];
    }
}





