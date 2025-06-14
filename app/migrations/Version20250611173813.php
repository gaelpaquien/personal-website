<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250611173813 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add fifth article.';
    }

    public function up(Schema $schema): void
    {
        $contentFr = '<h2>Le projet SnowTricks</h2>
        <p>L\'objectif de ce projet était de créer SnowTricks, une application communautaire permettant de partager des tricks de snowboard, en respectant un cahier des charges précis avec PHP et Symfony. Ce projet marquait ma première véritable immersion dans l\'écosystème Symfony et ses spécificités.</p>
        <h2>Fonctionnalités utilisateur</h2>
        <p>L\'application intègre un système complet de gestion utilisateurs : inscription, connexion et réinitialisation de mot de passe sécurisée via l\'utilisation de JWT tokens. Les utilisateurs peuvent créer leurs propres tricks, consulter les tricks existants et modifier ceux dont ils sont les auteurs.</p>
        <p>Côté administration, j\'ai développé un système de modération permettant aux administrateurs de supprimer ou modifier les tricks selon les besoins de la communauté.</p>
        <h2>Gestion des médias</h2>
        <p>Pour chaque trick, il fallait implémenter la possibilité de gérer et associer des médias variés : images et vidéos. Cette fonctionnalité nécessitait de maîtriser l\'upload de fichiers, leur validation et leur association avec les entités Symfony.</p>
        <h2>Optimisations techniques</h2>
        <p>L\'affichage des tricks était optimisé avec un système de pagination par lots de 15 éléments, accompagné d\'un bouton pour charger les tricks suivants. J\'ai également mis en place des DataFixtures pour générer des données d\'exemple et faciliter le développement.</p>
        <h2>Environnement moderne</h2>
        <p>J\'ai mis en place un environnement Docker pour faciliter le développement et le déploiement de l\'application, ainsi qu\'une pipeline CI/CD avec GitHub Actions pour automatiser le déploiement.</p>
        <h2>Conclusion</h2>
        <p>Ce projet m\'a permis de découvrir le framework Symfony et ses composants/services : gestion des entités avec Doctrine, système de routing, injection de dépendances, et architecture du framework. Ce projet m\'a également permis d\'approfondir mes connaissances en PHP et JavaScript pour les interactions utilisateur.</p>
        <p>Dans mon <strong><a href="/fr/blog/bilemo-api-developpement-dune-api-rest-securisee-avec-symfony">prochain article</a></strong>, vous pourrez découvrir plus en détail les coulisses du projet BileMo API et les défis techniques rencontrés.</p>';

        $contentEn = '<h2>The SnowTricks Project</h2>
        <p>The objective of this project was to create SnowTricks, a community application for sharing snowboard tricks, following precise specifications with PHP and Symfony. This project marked my first real immersion into the Symfony ecosystem and its specificities.</p>
        <h2>User Features</h2>
        <p>The application integrates a complete user management system: registration, login and secure password reset via JWT tokens. Users can create their own tricks, view existing tricks and modify those they authored.</p>
        <p>On the administration side, I developed a moderation system allowing administrators to delete or modify tricks according to community needs.</p>
        <h2>Media Management</h2>
        <p>For each trick, it was necessary to implement the ability to manage and associate various media: images and videos. This functionality required mastering file uploads, their validation and their association with Symfony entities.</p>
        <h2>Technical Optimizations</h2>
        <p>The trick display was optimized with a pagination system in batches of 15 elements, accompanied by a button to load the next tricks. I also set up DataFixtures to generate sample data and facilitate development.</p>
        <h2>Modern Environment</h2>
        <p>I set up a Docker environment to facilitate application development and deployment, as well as a CI/CD pipeline with GitHub Actions to automate deployment.</p>
        <h2>Conclusion</h2>
        <p>This project allowed me to discover the Symfony framework and its components/services: entity management with Doctrine, routing system, dependency injection, and framework architecture. This project also allowed me to deepen my knowledge in PHP and JavaScript for user interactions.</p>
        <p>In my <strong><a href="/en/blog/bilemo-api-development-of-a-secure-rest-api-with-symfony">next article</a></strong>, you can discover in more detail the behind-the-scenes of the BileMo API project and the technical challenges encountered.</p>';

        $tags = '{
            "fr": [
                "PHP", "Symfony", "Docker", "CI/CD", "GitHub Actions", "JavaScript"
            ], 
            "en": [
                "PHP", "Symfony", "Docker", "CI/CD", "GitHub Actions", "JavaScript"
            ]
        }';

        $resourceLinks = '{
            "fr": [
                {
                    "url": "https://github.com/gaelpaquien/openclassrooms-snowtricks", 
                    "text": "Repository du projet SnowTricks"
                }, 
                {
                    "url": "https://snowtricks.gaelpaquien.com/", 
                    "text": "Démo du projet SnowTricks"
                }
            ], 
            "en": [
                {
                    "url": "https://github.com/gaelpaquien/openclassrooms-snowtricks", 
                    "text": "SnowTricks project repository"
                }, 
                {
                    "url": "https://snowtricks.gaelpaquien.com/", 
                    "text": "SnowTricks project demo"
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
            'SnowTricks : Ma première application Symfony',
            'SnowTricks: My First Symfony Application',
            'snowtricks-ma-premiere-application-symfony',
            'snowtricks-my-first-symfony-application',
            'Développement de SnowTricks avec Symfony : application communautaire de partage de tricks de snowboard avec gestion utilisateurs, médias et système d\'authentification.',
            'Development of SnowTricks with Symfony: community application for sharing snowboard tricks with user management, media handling and authentication system.',
            '" . addslashes($contentFr) . "',
            '" . addslashes($contentEn) . "',
            '" . addslashes($tags) . "',
            '" . addslashes($resourceLinks) . "',
            '2025-06-08 05:00:00',
            '2025-06-08 05:00:00'
        )");

        $this->addSql("INSERT INTO article_medias (
            article_id,
            media,
            alt_text_fr,
            alt_text_en,
            is_cover
        ) VALUES (
            5,
            'homepage-snowtricks-php-symfony-communautaire.webp',
            'Page d\'accueil de SnowTricks, application Symfony communautaire de partage de tricks de snowboard',
            'SnowTricks homepage, Symfony community application for sharing snowboard tricks',
            1
        )");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM article_medias WHERE article_id = 5");
        $this->addSql("DELETE FROM articles WHERE article_id = 5");
    }
}
