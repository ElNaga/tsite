<?php
session_start();

class I18nService {
    private static $languages = ['en' => 'English', 'fr' => 'Français'];
    private static $translations = [
        'en' => [
            'home' => 'Home',
            'about' => 'About',
            'offer' => 'Offer',
            'offer1' => 'Service 1',
            'offer2' => 'Service 2',
            'blog' => 'Blog',
            'contact' => 'Contact',
            'language' => 'Language',
            'event_image_alt' => 'Event image',
            'event_title' => 'Special Event: Summer Gala',
            'event_desc' => 'Join us for an unforgettable evening of fun, food, and festivities. Reserve your spot now!',
            'book_now' => 'Book now',
        ],
        'fr' => [
            'home' => 'Accueil',
            'about' => 'À propos',
            'offer' => 'Offre',
            'offer1' => 'Service 1',
            'offer2' => 'Service 2',
            'blog' => 'Blog',
            'contact' => 'Contact',
            'language' => 'Langue',
            'event_image_alt' => 'Image de l\'événement',
            'event_title' => 'Événement spécial : Gala d\'été',
            'event_desc' => 'Rejoignez-nous pour une soirée inoubliable de plaisir, de gastronomie et de festivités. Réservez votre place dès maintenant !',
            'book_now' => 'Réserver',
        ],
    ];

    public static function getLanguages() {
        return self::$languages;
    }

    public static function getCurrentLang() {
        return $_SESSION['lang'] ?? 'en';
    }

    public static function setLang($lang) {
        if (array_key_exists($lang, self::$languages)) {
            $_SESSION['lang'] = $lang;
        }
    }

    public static function t($key) {
        $lang = self::getCurrentLang();
        return self::$translations[$lang][$key] ?? $key;
    }
}

// Handle language change
if (isset($_GET['lang'])) {
    I18nService::setLang($_GET['lang']);
    // Optionally redirect to remove lang param from URL
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
    exit;
} 