<?php
interface EventInterface {
    public function getId(): int;
    public function getImage(): string;
    public function getTitle(string $lang): string;
    public function getDesc(string $lang): string;
    public function getBookUrl(): string;
    public function getBookLabel(string $lang): string;
    public function getImageAlt(string $lang): string;
} 