<?php
session_start();

class I18nService {
    private static $languages = ['en' => 'English', 'fr' => 'Français', 'mk' => 'Македонски'];
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
            'service1_title' => 'Birthdays with Animators',
            'service1_desc' => 'Unforgettable birthdays with games, music, and professional animators to entertain the kids.',
            'service2_title' => 'Theatre Performances',
            'service2_desc' => 'Interactive and educational theatre shows for children of all ages.',
            'service3_title' => 'Creative Workshops',
            'service3_desc' => 'Creative workshops where kids learn through play, drawing, and making crafts.',
            'about_mission_title' => 'Our Mission',
            'about_mission_desc' => 'We create unforgettable experiences for children through interactive entertainment, education, and creative expression.',
            'about_values_title' => 'Our Values',
            'about_values_desc' => 'Every child deserves joy, learning, and magical moments. We believe in nurturing creativity and building confidence.',
            'about_approach_title' => 'Our Approach',
            'about_approach_list' => 'Interactive performances that engage children|Educational content disguised as fun|Safe, inclusive environments for all|Professional animators and educators|Customized experiences for different ages',
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
            'service1_title' => 'Anniversaires avec animateurs',
            'service1_desc' => 'Des anniversaires inoubliables avec des jeux, de la musique et des animateurs professionnels pour divertir les enfants.',
            'service2_title' => 'Spectacles de théâtre',
            'service2_desc' => 'Des spectacles de théâtre interactifs et éducatifs pour les enfants de tous âges.',
            'service3_title' => 'Ateliers créatifs',
            'service3_desc' => 'Des ateliers créatifs où les enfants apprennent en jouant, dessinant et fabriquant des objets.',
            'about_mission_title' => 'Notre Mission',
            'about_mission_desc' => 'Nous créons des expériences inoubliables pour les enfants à travers le divertissement interactif, l\'éducation et l\'expression créative.',
            'about_values_title' => 'Nos Valeurs',
            'about_values_desc' => 'Chaque enfant mérite la joie, l\'apprentissage et des moments magiques. Nous croyons en l\'épanouissement de la créativité et le développement de la confiance.',
            'about_approach_title' => 'Notre Approche',
            'about_approach_list' => 'Spectacles interactifs qui engagent les enfants|Contenu éducatif déguisé en amusement|Environnements sûrs et inclusifs pour tous|Animateurs et éducateurs professionnels|Expériences personnalisées selon l\'âge',
        ],
        'mk' => [
            'home' => 'Дома',
            'about' => 'За нас',
            'offer' => 'Понуда',
            'offer1' => 'Услуга 1',
            'offer2' => 'Услуга 2',
            'blog' => 'Блог',
            'contact' => 'Контакт',
            'language' => 'Јазик',
            'event_image_alt' => 'Слика од настанот',
            'event_title' => 'Специјален настан: Летен гала',
            'event_desc' => 'Придружете ни се за незаборавна вечер исполнета со забава, храна и свечености. Резервирајте го вашето место сега!',
            'book_now' => 'Резервирај',
            'service1_title' => 'Родендени со аниматори',
            'service1_desc' => 'Незаборавни родендени со игри, музика и професионални аниматори кои ги забавуваат децата.',
            'service2_title' => 'Претстави',
            'service2_desc' => 'Интерактивни и едукативни театарски претстави за деца од сите возрасти.',
            'service3_title' => 'Работилници',
            'service3_desc' => 'Креативни работилници каде децата учат преку игра, цртање и изработка на ракотворби.',
            'about_mission_title' => 'Нашата Мисија',
            'about_mission_desc' => 'Создаваме незаборавни искуства за децата преку интерактивна забава, едукација и креативна експресија.',
            'about_values_title' => 'Нашите Вредности',
            'about_values_desc' => 'Секое дете заслужува радост, учење и магични моменти. Веруваме во негување на креативноста и градење на самодоверба.',
            'about_approach_title' => 'Нашиот Пристап',
            'about_approach_list' => 'Интерактивни претстави што ги ангажираат децата|Едукативна содржина преправена како забава|Безбедни, инклузивни средини за сите|Професионални аниматори и едукатори|Прилагодени искуства за различни возрасти',
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