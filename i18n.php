<?php
// This file now uses the database-backed TranslationService
// The old static translations have been moved to the database

// Load the new service
require_once __DIR__ . '/src/services/TranslationService.php';

// Handle language change
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'mk', 'fr'])) {
    TranslationService::setLang($_GET['lang']);
    
    // Only redirect if we're not already on a page that should handle the language
    $currentPath = $_SERVER['REQUEST_URI'];
    $pathWithoutLang = strtok($currentPath, '?');
    
    // Don't redirect if we're on the main pages
    if (!in_array($pathWithoutLang, ['/', '/home', '/about', '/blog', '/contact', '/offer1', '/offer2'])) {
        // Redirect to remove lang param from URL
        header('Location: ' . $pathWithoutLang);
        exit;
    }
} 