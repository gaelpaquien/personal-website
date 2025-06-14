<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250611164511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add fourth article.';
    }

    public function up(Schema $schema): void
    {
        $contentFr = '<h2>Le défi du projet</h2>
        <p>L\'objectif de ce projet était de créer un blog complet avec uniquement PHP natif, sans aucun framework, en respectant un cahier des charges précis. Cette contrainte volontaire avait pour but de comprendre les mécanismes internes avant d\'utiliser des outils plus avancés. Le code devait impérativement respecter une architecture MVC (Model, View, Controller) implémentée manuellement.</p>
        <h2>Architecture MVC native</h2>
        <p>Développer une architecture MVC from-scratch m\'a permis de saisir concrètement le rôle de chaque composant. La séparation des responsabilités entre les modèles (gestion des données), les vues (affichage) et les contrôleurs (logique métier) a pris tout son sens à travers cette implémentation manuelle.</p>
        <p>Cette approche m\'a familiarisé avec PHP natif sans la "magie" des frameworks, donnant une compréhension solide des fondamentaux.</p>
        <h2>Fonctionnalités développées</h2>
        <p>Le blog intégrait un système complet de gestion utilisateurs : inscription, connexion, publication de commentaires et consultation des articles avec un système de pagination.</p>
        <p>Côté administration, j\'ai développé un panel permettant de créer, modifier et supprimer des articles, ainsi qu\'un système de modération des commentaires et de gestion des utilisateurs.</p>
        <h2>Environnement moderne</h2>
        <p>Malgré l\'approche "old-school" du développement PHP natif, j\'ai mis en place un environnement Docker pour faciliter le développement et le déploiement de l\'application. J\'ai également intégré une pipeline CI/CD avec GitHub Actions pour automatiser le déploiement.</p>
        <h2>Conclusion</h2>
        <p>Ce projet a été formateur à plusieurs niveaux : maîtrise des fondamentaux PHP, compréhension approfondie de l\'architecture MVC, gestion manuelle du routing et des sessions.</p>
        <p>Dans mon <strong><a href="/fr/blog/snowtricks-ma-premiere-application-symfony">prochain article</a></strong>, vous pourrez découvrir plus en détail les coulisses du projet SnowTricks et les défis techniques rencontrés.</p>';

        $contentEn = '<h2>The Project Challenge</h2>
        <p>The objective of this project was to create a complete blog using only native PHP, without any framework, while respecting precise specifications. This voluntary constraint aimed to understand internal mechanisms before using more advanced tools. The code had to strictly follow an MVC (Model, View, Controller) architecture implemented manually.</p>
        <h2>Native MVC Architecture</h2>
        <p>Developing an MVC architecture from scratch allowed me to concretely grasp the role of each component. The separation of responsibilities between models (data management), views (display) and controllers (business logic) took on its full meaning through this manual implementation.</p>
        <p>This approach familiarized me with native PHP without having any "magic" performed by frameworks, providing a solid understanding of the fundamentals.</p>
        <h2>Developed Features</h2>
        <p>The blog integrated a complete user management system: registration, login, comment publishing and article consultation with a pagination system.</p>
        <p>On the administration side, I developed a panel allowing to create, modify and delete articles, as well as a comment moderation system and user management.</p>
        <h2>Modern Environment</h2>
        <p>Despite the "old-school" approach of native PHP development, I set up a Docker environment to facilitate application development and deployment. I also integrated a CI/CD pipeline with GitHub Actions to automate deployment.</p>
        <h2>Conclusion</h2>
        <p>This project was educational on several levels: mastering PHP fundamentals, deep understanding of MVC architecture, manual handling of routing and sessions.</p>
        <p>In my <strong><a href="/en/blog/snowtricks-my-first-symfony-application">next article</a></strong>, you can discover in more detail the behind-the-scenes of the SnowTricks project and the technical challenges encountered.</p>';

        $tags = '{
            "fr": [
                "PHP", "Architecture MVC", "MySQL", "Docker", "CI/CD", "GitHub Actions"
            ], 
            "en": [
                "PHP", "MVC Architecture", "MySQL", "Docker", "CI/CD", "GitHub Actions"
            ]
        }';

        $resourceLinks = '{
            "fr": [
                {
                    "url": "https://github.com/gaelpaquien/openclassrooms-blog-php-mvc", 
                    "text": "Repository du projet Blog PHP MVC"
                }, 
                {
                    "url": "https://blogphpmvc.gaelpaquien.com/", 
                    "text": "Démo du projet Blog PHP MVC"
                }
            ], 
            "en": [
                {
                    "url": "https://github.com/gaelpaquien/openclassrooms-blog-php-mvc", 
                    "text": "PHP MVC Blog project repository"
                }, 
                {
                    "url": "https://blogphpmvc.gaelpaquien.com/", 
                    "text": "PHP MVC Blog project demo"
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
            'Blog PHP MVC : développement from-scratch sans framework',
            'PHP MVC Blog: From-Scratch Development Without Framework',
            'blog-php-mvc-developpement-from-scratch-sans-framework',
            'php-mvc-blog-from-scratch-development-without-framework',
            'Développement d\'un blog complet en PHP natif avec architecture MVC : gestion utilisateurs, système d\'administration et mise en place d\'un environnement Docker avec CI/CD.',
            'Development of a complete blog in native PHP with MVC architecture: user management, administration system and Docker environment setup with CI/CD.',
            '" . addslashes($contentFr) . "',
            '" . addslashes($contentEn) . "',
            '" . addslashes($tags) . "',
            '" . addslashes($resourceLinks) . "',
            '2025-06-08 04:00:00',
            '2025-06-08 04:00:00'
        )");

        $this->addSql("INSERT INTO article_medias (
            article_id,
            media,
            alt_text_fr,
            alt_text_en,
            is_cover
        ) VALUES (
            4,
            'homepage-php-mvc-natif-sans-framework.webp',
            'Page d\'accueil du blog PHP MVC développé sans framework',
            'Homepage of the PHP MVC blog developed without framework',
            1
        )");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM article_medias WHERE article_id = 4");
        $this->addSql("DELETE FROM articles WHERE id = 4");
    }
}
