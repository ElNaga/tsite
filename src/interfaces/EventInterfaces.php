<?php

interface EventI18nFields {
    /**
     * @return array<string, string> [lang => string]
     */
    public function getTitle(): array;
    /**
     * @return array<string, string> [lang => string]
     */
    public function getDesc(): array;
    /**
     * @return array<string, string> [lang => string]
     */
    public function getBookLabel(): array;
    /**
     * @return array<string, string> [lang => string]
     */
    public function getImageAlt(): array;
}

interface Event extends EventI18nFields {
    public function getId(): int;
    public function getImage(): string;
    public function getBookUrl(): string;
}

interface LatestEvent {
    public function getImage(): string;
    public function getTitle(): string;
    public function getDesc(): string;
    public function getBookUrl(): string;
    public function getBookLabel(): string;
    public function getImageAlt(): string;
} 