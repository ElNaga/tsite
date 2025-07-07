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
            'party_animation_title' => "Children's parties Animation",
            'party_animation_body' => "We organize children's parties and we believe it is essential to be constantly aware of trends and current events. Only in this way can we live up to the children's universe and fully correspond to their preferences. Our team is young and active, available and ready to embark on any adventure.\n\nWe do different activities depending on the theme of the party and the children's preferences. We have science or cooking workshops and we organize football matches. We have magic or puppet shows available and we do face painting. We work with teams of animators who make the entertainment properly characterized or through mascots.",
            'party_ideas_title' => 'Ideas for birthday parties',
            'party_ideas_body' => 'No ideas for birthday parties? At Animate we are available to help. We are creative, we are always innovating and looking for what makes children happy according to the current situation, always adapting each game to their age. Talk to us and together we will have the best ideas for memorable birthday parties that will delight the kids and guests.',
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
            'party_animation_title' => "Animation pour fêtes d'enfants",
            'party_animation_body' => "Nous organisons des fêtes pour enfants et nous pensons qu'il est essentiel de rester constamment à l'écoute des tendances et des événements actuels. Ce n'est qu'ainsi que nous pouvons répondre à l'univers des enfants et à leurs préférences. Notre équipe est jeune et dynamique, disponible et prête à se lancer dans toutes les aventures.\n\nNous proposons différentes activités selon le thème de la fête et les préférences des enfants. Nous organisons des ateliers scientifiques ou culinaires et des matchs de football. Nous proposons des spectacles de magie ou de marionnettes et nous faisons du maquillage. Nous travaillons avec des équipes d'animateurs qui assurent une animation adaptée ou sous forme de mascottes.",
            'party_ideas_title' => 'Idées pour les fêtes d\'anniversaire',
            'party_ideas_body' => "Pas d'idées pour les fêtes d'anniversaire ? Chez Animate, nous sommes là pour vous aider. Nous sommes créatifs, nous innovons sans cesse et cherchons ce qui rend les enfants heureux selon la situation actuelle, en adaptant chaque jeu à leur âge. Parlez-nous et ensemble nous trouverons les meilleures idées pour des fêtes d'anniversaire mémorables qui raviront les enfants et les invités.",
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
            'party_animation_title' => 'Анимација за детски народи',
            'party_animation_body' => 'Организираме детски народи и веруваме дека е важно постојано да се следат трендовите и актуелните настани. Само така можеме да одговориме на детскиот универзум и целосно да ги исполниме нивните желби. Нашиот тим е млад и активен, секогаш подготвен за нови авантури.\n\nОрганизираме различни активности според темата на роденденот и желбите на децата. Имаме научни или кулинарски работилници, организираме фудбалски натпревари, магионичарски или куклени претстави, како и осликување на лице. Работиме со тимови на аниматори кои ја прават забавата уникатна и прилагодена.',
            'party_ideas_title' => 'Идеи за родендени',
            'party_ideas_body' => 'Немате идеи за роденден? Во Animate сме тука да помогнеме. Креативни сме, постојано иновираме и бараме што ги прави децата среќни според моменталната ситуација, секогаш прилагодувајќи ги игрите според возраста. Контактирајте не и заедно ќе ги најдеме најдобрите идеи за незаборавни народи кои ќе ги воодушеват децата и гостите.',
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