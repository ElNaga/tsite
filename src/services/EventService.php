<?php
require_once __DIR__ . '/../models/EventModel.php';
require_once __DIR__ . '/../../i18n.php';

class EventService {
    private static $events = [
        'en' => [
            [
                'id' => 1,
                'image' => 'https://www.teatarzatebe.mk/assets/images/roden_den_so_veselba.jpg',
                'title' => 'Birthday Without Fun',
                'desc' => 'A humorous kids play with balloons, music, and surprises. Don’t miss it!',
                'book_url' => '#book1',
                'book_label' => 'Book now',
                'image_alt' => 'Image from Birthday Without Fun play',
            ],
            [
                'id' => 2,
                'image' => 'https://www.teatarzatebe.mk/assets/images/patot_na_ljubovta.jpg',
                'title' => 'The Path of Love',
                'desc' => 'An educational show about emotions, friendship, and love – perfect for family audiences.',
                'book_url' => '#book2',
                'book_label' => 'Book now',
                'image_alt' => 'Image from The Path of Love play',
            ],
            [
                'id' => 3,
                'image' => 'https://www.teatarzatebe.mk/assets/images/magichna_zabava.jpg',
                'title' => 'Magical Fun',
                'desc' => 'Magic, laughter, and unforgettable fun for the little ones. A show that wins hearts!',
                'book_url' => '#book3',
                'book_label' => 'Book now',
                'image_alt' => 'Image from Magical Fun show',
            ],
            [
                'id' => 4,
                'image' => 'https://www.teatarzatebe.mk/assets/images/detski_karneval.jpg',
                'title' => 'Kids Carnival',
                'desc' => 'A cheerful carnival for the little ones, with costumes, games, and prizes!',
                'book_url' => '#book4',
                'book_label' => 'Book now',
                'image_alt' => 'Image from Kids Carnival',
            ],
            [
                'id' => 5,
                'image' => 'https://www.teatarzatebe.mk/assets/images/vecher_na_prikazni.jpg',
                'title' => 'Storytelling Night',
                'desc' => 'An interactive night with classic and modern children’s stories brought to life.',
                'book_url' => '#book5',
                'book_label' => 'Book now',
                'image_alt' => 'Image from Storytelling Night',
            ],
        ],
        'mk' => [
            [
                'id' => 1,
                'image' => 'https://www.teatarzatebe.mk/assets/images/roden_den_so_veselba.jpg',
                'title' => 'Роденден без Веселба',
                'desc' => 'Хумористична претстава за деца со балони, музика и изненадувања. Не ја пропуштајте!',
                'book_url' => '#book1',
                'book_label' => 'Резервирај',
                'image_alt' => 'Слика од претставата Роденден без Веселба',
            ],
            [
                'id' => 2,
                'image' => 'https://www.teatarzatebe.mk/assets/images/patot_na_ljubovta.jpg',
                'title' => 'Патот на Љубовта',
                'desc' => 'Едукативна претстава за емоциите, пријателството и љубовта – совршена за семејна публика.',
                'book_url' => '#book2',
                'book_label' => 'Резервирај',
                'image_alt' => 'Слика од претставата Патот на Љубовта',
            ],
            [
                'id' => 3,
                'image' => 'https://www.teatarzatebe.mk/assets/images/magichna_zabava.jpg',
                'title' => 'Магична Забава',
                'desc' => 'Магија, смеење и незаборавна забава за најмалите. Претстава што ги освојува срцата!',
                'book_url' => '#book3',
                'book_label' => 'Резервирај',
                'image_alt' => 'Слика од претставата Магична Забава',
            ],
            [
                'id' => 4,
                'image' => 'https://www.teatarzatebe.mk/assets/images/detski_karneval.jpg',
                'title' => 'Детски Карневал',
                'desc' => 'Весела и шарена карневалска атмосфера за најмладите, со маски, игри и награди!',
                'book_url' => '#book4',
                'book_label' => 'Резервирај',
                'image_alt' => 'Слика од Детски Карневал',
            ],
            [
                'id' => 5,
                'image' => 'https://www.teatarzatebe.mk/assets/images/vecher_na_prikazni.jpg',
                'title' => 'Вечер на Приказни',
                'desc' => 'Интерактивна вечер со класични и нови детски приказни оживеани на сцена.',
                'book_url' => '#book5',
                'book_label' => 'Резервирај',
                'image_alt' => 'Слика од Вечер на Приказни',
            ],
        ],
        'fr' => [
            [
                'id' => 1,
                'image' => 'https://www.teatarzatebe.mk/assets/images/roden_den_so_veselba.jpg',
                'title' => 'Anniversaire Sans Joie',
                'desc' => 'Une pièce humoristique pour enfants avec des ballons, de la musique et des surprises. Ne la manquez pas !',
                'book_url' => '#book1',
                'book_label' => 'Réserver',
                'image_alt' => 'Image de la pièce Anniversaire Sans Joie',
            ],
            [
                'id' => 2,
                'image' => 'https://www.teatarzatebe.mk/assets/images/patot_na_ljubovta.jpg',
                'title' => 'Le Chemin de l’Amour',
                'desc' => 'Un spectacle éducatif sur les émotions, l’amitié et l’amour – parfait pour toute la famille.',
                'book_url' => '#book2',
                'book_label' => 'Réserver',
                'image_alt' => 'Image de la pièce Le Chemin de l’Amour',
            ],
            [
                'id' => 3,
                'image' => 'https://www.teatarzatebe.mk/assets/images/magichna_zabava.jpg',
                'title' => 'Amusement Magique',
                'desc' => 'Magie, rires et divertissement inoubliable pour les plus petits. Un spectacle qui touche les cœurs !',
                'book_url' => '#book3',
                'book_label' => 'Réserver',
                'image_alt' => 'Image du spectacle Amusement Magique',
            ],
            [
                'id' => 4,
                'image' => 'https://www.teatarzatebe.mk/assets/images/detski_karneval.jpg',
                'title' => 'Carnaval pour Enfants',
                'desc' => 'Un carnaval joyeux pour les petits, avec des costumes, des jeux et des prix !',
                'book_url' => '#book4',
                'book_label' => 'Réserver',
                'image_alt' => 'Image du Carnaval pour Enfants',
            ],
            [
                'id' => 5,
                'image' => 'https://www.teatarzatebe.mk/assets/images/vecher_na_prikazni.jpg',
                'title' => 'Soirée de Contes',
                'desc' => 'Une soirée interactive avec des contes classiques et modernes pour enfants, mis en scène.',
                'book_url' => '#book5',
                'book_label' => 'Réserver',
                'image_alt' => 'Image de la Soirée de Contes',
            ],
        ],
    ];

    /**
     * @param string $lang
     * @return EventModel[]
     */
    public static function getAllEvents($lang = 'en') {
        return self::$events[$lang] ?? self::$events['en'];
    }

    /**
     * @param string $lang
     * @return EventModel
     */
    public static function getLatestEvent($lang = 'en') {
        $events = self::getAllEvents($lang);
        return $events[0] ?? null;
    }
} 