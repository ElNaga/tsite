<?php
session_start();

class I18nService {
    private static $languages = ['en' => 'English', 'fr' => 'Français', 'mk' => 'Македонски'];
    private static $translations = [
        'en' => [
            'site_title' => 'Teatar za tebe - Interactive Theatre & Events for Kids',
            'site_description' => 'Unforgettable children’s parties, interactive performances, drama studio, and creative workshops. Book your next event with Teatar za tebe!',
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
            'service1_title' => 'Performances for all ages',
            'service1_desc' => 'Interactive and educational theatre performances for children and adults, full of fun and learning.',
            'service2_title' => 'Drama Studio',
            'service2_desc' => 'Creative acting and theatre classes for all ages, led by professionals.',
            'service3_title' => 'Education',
            'service3_desc' => 'Educational programs and workshops that encourage curiosity and development.',
            'service4_title' => 'Courses',
            'service4_desc' => 'Practical courses for new skills, creativity, and personal growth.',
            'service5_title' => 'Workshops',
            'service5_desc' => 'Fun and interactive workshops for kids and youth, focused on teamwork and creativity.',
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
            'footer_intro_title' => 'Introduction',
            'footer_performances' => 'Performances for all ages',
            'footer_drama_studio' => 'Drama studio',
            'footer_education' => 'Education',
            'footer_courses' => 'Courses',
            'footer_workshops' => 'Workshops',
            'footer_page' => 'Page',
            'footer_page_desc' => 'Theater for artistic performances',
            'footer_no_reviews' => 'No reviews yet (0 reviews)',
            'footer_channel' => 'Teatar za tebe',
            'footer_contact_title' => 'Contact',
            'footer_links_title' => 'Quick Links',
            'footer_rights' => 'All rights reserved.',
            'not_found_title' => 'Page Not Found',
            'not_found_message' => 'Sorry, the page you are looking for does not exist or has been moved. Try going back to the homepage.',
        ],
        'fr' => [
            'site_title' => 'Théâtre pour toi - Théâtre interactif et événements pour enfants',
            'site_description' => 'Fêtes d’enfants inoubliables, spectacles interactifs, studio de théâtre et ateliers créatifs. Réservez votre prochain événement avec Théâtre pour toi!',
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
            'service1_title' => 'Spectacles pour tous les âges',
            'service1_desc' => 'Spectacles de théâtre interactifs et éducatifs pour enfants et adultes, pleins de plaisir et d\'apprentissage.',
            'service2_title' => 'Studio de théâtre',
            'service2_desc' => 'Cours de théâtre et d\'art dramatique créatifs pour tous les âges, animés par des professionnels.',
            'service3_title' => 'Éducation',
            'service3_desc' => 'Programmes éducatifs et ateliers qui encouragent la curiosité et le développement.',
            'service4_title' => 'Cours',
            'service4_desc' => 'Cours pratiques pour de nouvelles compétences, la créativité et le développement personnel.',
            'service5_title' => 'Ateliers',
            'service5_desc' => 'Ateliers ludiques et interactifs pour enfants et jeunes, axés sur le travail d\'équipe et la créativité.',
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
            'footer_intro_title' => 'Introduction',
            'footer_performances' => 'Spectacles pour tous les âges',
            'footer_drama_studio' => 'Studio de théâtre',
            'footer_education' => 'Éducation',
            'footer_courses' => 'Cours',
            'footer_workshops' => 'Ateliers',
            'footer_page' => 'Page',
            'footer_page_desc' => 'Théâtre pour représentations artistiques',
            'footer_no_reviews' => 'Pas encore d\'avis (0 avis)',
            'footer_channel' => 'Théâtre pour toi',
            'footer_contact_title' => 'Contact',
            'footer_links_title' => 'Liens rapides',
            'footer_rights' => 'Tous droits réservés.',
            'not_found_title' => 'Page non trouvée',
            'not_found_message' => 'Désolé, la page que vous recherchez n’existe pas ou a été déplacée. Essayez de revenir à la page d’accueil.',
        ],
        'mk' => [
            'site_title' => 'Театар за тебе - Интерактивен театар и настани за деца',
            'site_description' => 'Незаборавни детски родендени, интерактивни претстави, драмско студио и креативни работилници. Закажете го вашиот следен настан со Театар за тебе!',
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
            'service1_title' => 'Претстави за сите возрасти',
            'service1_desc' => 'Интерактивни и едукативни театарски претстави за деца и возрасни, исполнети со забава и учење.',
            'service2_title' => 'Драмско студио',
            'service2_desc' => 'Креативни часови по глума и театар за сите возрасти, водени од професионалци.',
            'service3_title' => 'Едукација',
            'service3_desc' => 'Образовни програми и работилници кои поттикнуваат љубопитност и развој.',
            'service4_title' => 'Курсови',
            'service4_desc' => 'Практични курсеви за нови вештини, креативност и личен развој.',
            'service5_title' => 'Работилници',
            'service5_desc' => 'Забавни и интерактивни работилници за деца и млади, со фокус на тимска работа и креативност.',
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
            'footer_intro_title' => 'Вовед',
            'footer_performances' => 'Претстави за сите возрасти',
            'footer_drama_studio' => 'Драмско студио',
            'footer_education' => 'Едукација',
            'footer_courses' => 'Курсови',
            'footer_workshops' => 'Работилници',
            'footer_page' => 'Страница',
            'footer_page_desc' => 'Театар за уметнички изведби',
            'footer_no_reviews' => 'Сѐ уште нема оценка (0 рецензии)',
            'footer_channel' => 'Театар за тебе',
            'footer_contact_title' => 'Контакт',
            'footer_links_title' => 'Брзи линкови',
            'footer_rights' => 'Сите права се задржани.',
            'not_found_title' => 'Страницата не е пронајдена',
            'not_found_message' => 'Жалиме, страницата што ја барате не постои или е преместена. Обидете се да се вратите на почетната страница.',
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