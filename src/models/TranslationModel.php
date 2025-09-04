<?php
require_once __DIR__ . '/../interfaces/TranslationInterface.php';

class TranslationModel implements TranslationInterface {
    private int $id;
    private string $languageCode;
    private string $translationKey;
    private string $translationValue;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(array $data) {
        $this->id = $data['id'];
        $this->languageCode = $data['language_code'];
        $this->translationKey = $data['translation_key'];
        $this->translationValue = $data['translation_value'];
        $this->createdAt = $data['created_at'];
        $this->updatedAt = $data['updated_at'];
    }

    public function getId(): int { return $this->id; }
    public function getLanguageCode(): string { return $this->languageCode; }
    public function getTranslationKey(): string { return $this->translationKey; }
    public function getTranslationValue(): string { return $this->translationValue; }
    public function getCreatedAt(): string { return $this->createdAt; }
    public function getUpdatedAt(): string { return $this->updatedAt; }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'language_code' => $this->languageCode,
            'translation_key' => $this->translationKey,
            'translation_value' => $this->translationValue,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt
        ];
    }
}





