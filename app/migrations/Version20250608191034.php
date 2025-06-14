<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250608191034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add first article.';
    }

    public function up(Schema $schema): void
    {
        $contentFr = '<h2>Le déclic d\'une conversation</h2>
        <p>Tout a commencé par une simple discussion à la machine à café. En tant que technicien informatique dans le secteur bancaire, j\'assistais les utilisateurs et résolvais leurs incidents hardware/software, en escaladant vers les équipes spécialisées si nécessaire. Ce jour-là, un collègue m\'a parlé de développement web. Cette conversation a éveillé ma curiosité.</p>
        <h2>Premiers pas avec OpenClassrooms</h2>
        <p>Intrigué, j\'ai commencé le cours HTML/CSS sur OpenClassrooms le soir même. L\'effet a été immédiat : créer une page web, voir le résultat en temps réel, comprendre comment fonctionnent les sites que j\'utilisais quotidiennement... Cette découverte occupait désormais tout mon temps libre.</p>
        <h2>Le grand saut : formation Développeur Web</h2>
        <p>Face à cette passion grandissante, j\'ai pris une décision importante : me lancer à plein temps dans la formation "Développeur Web" d\'OpenClassrooms de janvier à novembre 2020. Dix mois intensifs avec 7 projets professionnalisants qui ont nourri ma curiosité et développé mes compétences.</p>
        <h2>Les projets qui m\'ont marqué</h2>
        <p>Parmi les réalisations importantes : l\'optimisation complète d\'un site existant (performances, SEO, accessibilité), le développement d\'une API REST sécurisée avec Node.js et MongoDB, et la création d\'un réseau social d\'entreprise avec Vue.js en frontend et Node.js/MySQL en backend.</p>
        <h2>L\'attrait pour le backend</h2>
        <p>C\'est sur ce dernier projet que j\'ai découvert une préférence : l\'architecture des données, la logique métier, la sécurisation des API... Le backend m\'attirait particulièrement, sans pour autant délaisser les aspects frontend.</p>
        <h2>La suite de l\'aventure</h2>
        <p>Conscient que mes connaissances étaient encore limitées pour le marché professionnel, j\'ai économisé grâce à un poste de technicien informatique dans le secteur de la presse pour financer ma spécialisation PHP/Symfony. Cette seconde formation, réalisée en parallèle de mon travail, a été le véritable tournant de ma carrière.</p>
        <p>Découvrez la suite de mon parcours dans un article consacré à cette seconde formation : <strong><a href="/fr/blog/formation-php-symfony-ma-montee-en-competences-backend">Formation PHP/Symfony : ma montée en compétences backend</a></strong>.</p>';

        $contentEn = '<h2>The spark of a conversation</h2>
        <p>It all started with a simple discussion at the coffee machine. As an IT technician in the banking sector, I assisted users and resolved their hardware/software incidents, escalating to specialized teams when necessary. That day, a colleague talked to me about web development. This conversation sparked my curiosity.</p>
        <h2>First steps with OpenClassrooms</h2>
        <p>Intrigued, I started the HTML/CSS course on OpenClassrooms that very evening. The effect was immediate: creating a web page, seeing the result in real time, understanding how the websites I used daily worked... This discovery now occupied all my free time.</p>
        <h2>The big leap: Web Developer training</h2>
        <p>Faced with this growing passion, I made an important decision: to dive full-time into OpenClassrooms\' "Web Developer" training from January to November 2020. Ten intensive months with 7 professional projects that fueled my curiosity and developed my skills.</p>
        <h2>The projects that marked me</h2>
        <p>Among the important achievements: complete optimization of an existing site (performance, SEO, accessibility), development of a secure REST API with Node.js and MongoDB, and creation of a corporate social network with Vue.js on the frontend and Node.js/MySQL on the backend.</p>
        <h2>The attraction to backend</h2>
        <p>It was on this last project that I discovered a preference: data architecture, business logic, API security... Backend particularly attracted me, without neglecting frontend aspects.</p>
        <h2>The next chapter</h2>
        <p>Aware that my knowledge was still limited for the professional market, I saved money through an IT technician position in the press sector to fund my PHP/Symfony specialization. This second training, done alongside my work, was the real turning point of my career.</p>
        <p>Discover the continuation of my journey in my next article: <strong><a href="/en/blog/php-symfony-training-my-backend-skills-development">PHP/Symfony Training: My Backend Skills Development</a></strong>.</p>';

        $tags = '{
            "fr": [
                "Node.js", "MySQL", "MongoDB", "API REST", "Vue.js", "Sass", "Bootstrap"
            ], 
            "en": [
                "Node.js", "MySQL", "MongoDB", "REST API", "Vue.js", "Sass", "Bootstrap"
            ]
        }';

        $resourceLinks = '{
            "fr": [
                {
                    "url": "https://github.com/gaelpaquien/openclassrooms-archive/tree/master/web-developer", 
                    "text": "Repository contenant tous mes livrables de la formation"
                }, 
                {
                    "url": "https://openclassrooms.com/fr/paths/899-developpeur-web", 
                    "text": "Programme de formation Développeur Web"
                }, 
                {
                    "url": "https://www.francecompetences.fr/recherche/rncp/38145/", 
                    "text": "Certification RNCP obtenue à l\'issue de la formation"
                }
            ], 
            "en": [
                {
                    "url": "https://github.com/gaelpaquien/openclassrooms-archive/tree/master/web-developer", 
                    "text": "Repository containing all my training deliverables"
                }, 
                {
                    "url": "https://openclassrooms.com/fr/paths/899-developpeur-web", 
                    "text": "Web Developer training program"
                }, 
                {
                    "url": "https://www.francecompetences.fr/recherche/rncp/38145/", 
                    "text": "RNCP certification obtained at the end of the training"
                }
            ]
        }';

        $this->addSql("INSERT INTO articles (
            title_fr, 
            title_en, 
            slug_fr, 
            slug_en, 
            short_description_fr,
            short_description_en,
            content_fr, 
            content_en, 
            tags, 
            resource_links,
            created_at, 
            updated_at
        ) VALUES (
            'De technicien informatique à développeur web : ma reconversion',
            'From IT technician to web developer: my career change',
            'de-technicien-informatique-a-developpeur-web-ma-reconversion',
            'from-it-technician-to-web-developer-my-career-change',
            'Découvrez mon parcours de reconversion professionnelle, de technicien informatique à développeur web. Formation, projets marquants et premiers pas vers ma spécialisation backend.',
            'Discover my career change journey from IT technician to web developer. Training, significant projects, and first steps towards my backend specialization.',
            '" . addslashes($contentFr) . "',
            '" . addslashes($contentEn) . "',
            '" . addslashes($tags) . "',
            '" . addslashes($resourceLinks) . "',
            '2025-06-08 01:00:00',
            '2025-06-08 01:00:00'
        )");

        $this->addSql("INSERT INTO article_medias (
            article_id,
            media,
            alt_text_fr,
            alt_text_en,
            is_cover
        ) VALUES (
            1,
            'reconversion-technicien-developpeur-web.webp',
            'Développeur web travaillant sur du code, tenant un stylo et tapant au clavier devant un écran affichant du code',
            'Web developer working on code, holding a pen and typing on keyboard in front of a screen displaying code',
            1
        )");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM article_medias WHERE article_id = 1");
        $this->addSql("DELETE FROM articles WHERE id = 1");
    }
}