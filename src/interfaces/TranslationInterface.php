<?php
interface TranslationInterface {
    public function getId(): int;
    public function getLanguageCode(): string;
    public function getTranslationKey(): string;
    public function getTranslationValue(): string;
    public function getCreatedAt(): string;
    public function getUpdatedAt(): string;
}

