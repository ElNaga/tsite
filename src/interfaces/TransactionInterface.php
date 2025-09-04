<?php
interface TransactionInterface {
    public function getId(): int;
    public function getEventId(): int;
    public function getUserData(): array;
    public function getTimestamp(): string;
    public function getStatus(): string;
    public function getAmount(): ?float;
    public function getPaymentMethod(): ?string;
}

