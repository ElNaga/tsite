<?php
require_once __DIR__ . '/../../i18n.php';

class EventService {
    // Simulate fetching all events from a database
    public static function getAllEvents($lang = 'en') {
        return [
            [
                'id' => 1,
                'image' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80',
                'title' => [
                    'en' => 'Special Event: Summer Gala',
                    'fr' => 'Événement spécial : Gala d\'été',
                ],
                'desc' => [
                    'en' => 'Join us for an unforgettable evening of fun, food, and festivities. Reserve your spot now!',
                    'fr' => 'Rejoignez-nous pour une soirée inoubliable de plaisir, de gastronomie et de festivités. Réservez votre place dès maintenant !',
                ],
                'book_url' => '#book',
                'book_label' => [
                    'en' => 'Book now',
                    'fr' => 'Réserver',
                ],
                'image_alt' => [
                    'en' => 'Event image',
                    'fr' => 'Image de l\'événement',
                ],
            ],
            [
                'id' => 2,
                'image' => 'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?auto=format&fit=crop&w=800&q=80',
                'title' => [
                    'en' => 'Kids Birthday Bash',
                    'fr' => 'Fête d\'anniversaire pour enfants',
                ],
                'desc' => [
                    'en' => 'A fun-filled birthday party for kids with games, cake, and surprises. Don\'t miss out!',
                    'fr' => 'Une fête d\'anniversaire amusante pour les enfants avec des jeux, du gâteau et des surprises. Ne manquez pas ça !',
                ],
                'book_url' => '#book2',
                'book_label' => [
                    'en' => 'Book now',
                    'fr' => 'Réserver',
                ],
                'image_alt' => [
                    'en' => 'Kids birthday party image',
                    'fr' => 'Image de fête d\'anniversaire pour enfants',
                ],
            ],
        ];
    }

    // Simulate fetching the latest event (first in the array)
    public static function getLatestEvent($lang = 'en') {
        $events = self::getAllEvents($lang);
        $event = $events[0];
        return [
            'image' => $event['image'],
            'title' => $event['title'][$lang] ?? $event['title']['en'],
            'desc' => $event['desc'][$lang] ?? $event['desc']['en'],
            'book_url' => $event['book_url'],
            'book_label' => $event['book_label'][$lang] ?? $event['book_label']['en'],
            'image_alt' => $event['image_alt'][$lang] ?? $event['image_alt']['en'],
        ];
    }
} 