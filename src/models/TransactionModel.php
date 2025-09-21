<?php
require_once __DIR__ . '/../interfaces/TransactionInterface.php';

class TransactionModel implements TransactionInterface {
    private int $id;
    private int $eventId;
    private array $userData;
    private string $timestamp;
    private string $status;
    private ?float $amount;
    private ?string $paymentMethod;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(array $data) {
        $this->id = $data['id'];
        $this->eventId = $data['event_id'];
        $this->userData = is_string($data['user_data']) ? json_decode($data['user_data'], true) : $data['user_data'];
        $this->timestamp = $data['timestamp'];
        $this->status = $data['status'];
        $this->amount = $data['amount'] ?? null;
        $this->paymentMethod = $data['payment_method'] ?? null;
        $this->createdAt = $data['created_at'];
        $this->updatedAt = $data['updated_at'];
    }

    public function getId(): int { return $this->id; }
    public function getEventId(): int { return $this->eventId; }
    public function getUserData(): array { return $this->userData; }
    public function getTimestamp(): string { return $this->timestamp; }
    public function getStatus(): string { return $this->status; }
    public function getAmount(): ?float { return $this->amount; }
    public function getPaymentMethod(): ?string { return $this->paymentMethod; }

    public function getCreatedAt(): string { return $this->createdAt; }
    public function getUpdatedAt(): string { return $this->updatedAt; }

    public function isPending(): bool {
        return $this->status === 'pending';
    }

    public function isConfirmed(): bool {
        return $this->status === 'confirmed';
    }

    public function isCancelled(): bool {
        return $this->status === 'cancelled';
    }

    public function isCompleted(): bool {
        return $this->status === 'completed';
    }

    public function getUserName(): string {
        return $this->userData['name'] ?? '';
    }

    public function getUserEmail(): string {
        return $this->userData['email'] ?? '';
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'event_id' => $this->eventId,
            'user_data' => $this->userData,
            'timestamp' => $this->timestamp,
            'status' => $this->status,
            'amount' => $this->amount,
            'payment_method' => $this->paymentMethod,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt
        ];
    }
}








