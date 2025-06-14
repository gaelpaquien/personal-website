<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250611180821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add sixth article.';
    }

    public function up(Schema $schema): void
    {
        $contentFr = '<h2>L\'API BileMo</h2>
        <p>L\'objectif de ce projet était de développer BileMo, une API REST sécurisée avec PHP et Symfony. Cette API permet aux utilisateurs authentifiés d\'accéder à des données structurées concernant des produits téléphoniques et la gestion des clients. Le projet respectait intégralement les principes REST pour assurer une architecture cohérente et standardisée.</p>
        <h2>Fonctionnalités exposées</h2>
        <p>L\'API expose plusieurs endpoints permettant aux utilisateurs authentifiés de consulter une liste complète de produits (téléphones) avec toutes les spécifications techniques associées à chaque modèle. Elle permet également l\'accès aux listes des clients et utilisateurs du magasin, offrant une vue d\'ensemble de l\'écosystème commercial.</p>
        <h2>Architecture REST native</h2>
        <p>Le développement a été réalisé intégralement sans l\'aide d\'API Platform, permettant une maîtrise complète de l\'architecture et des mécanismes REST. Cette approche "from-scratch" a renforcé ma compréhension des principes fondamentaux des APIs RESTful.</p>
        <h2>Documentation et interface</h2>
        <p>Une interface API complète a été mise en place et documentée à l\'aide du package Nelmio. Cette documentation interactive facilite la compréhension et l\'utilisation de l\'API par les développeurs tiers.</p>
        <h2>Environnement moderne</h2>
        <p>J\'ai mis en place un environnement Docker pour faciliter le développement et le déploiement de l\'application, ainsi qu\'une pipeline CI/CD avec GitHub Actions pour automatiser les processus de déploiement.</p>
        <h2>Conclusion</h2>
        <p>Ce projet m\'a permis de renforcer mes compétences concernant les APIs et MySQL avec un schéma de données complet regroupant plusieurs relations pour gérer tous les aspects techniques des produits.</p>
        <p>Dans mon <strong><a href="/fr/blog/todo-and-co-audit-reduction-de-dette-technique-et-optimisation">prochain article</a></strong>, vous pourrez découvrir plus en détail les coulisses du projet ToDo & Co et les défis techniques rencontrés.</p>';

        $contentEn = '<h2>The BileMo API</h2>
        <p>The objective of this project was to develop BileMo, a secure REST API with PHP and Symfony. This API allows authenticated users to access structured data regarding phone products and customer management. The project fully respected REST principles to ensure a consistent and standardized architecture.</p>
        <h2>Exposed Features</h2>
        <p>The API exposes several endpoints allowing authenticated users to consult a complete list of products (phones) with all technical specifications associated with each model. It also provides access to customer and store user lists, offering an overview of the commercial ecosystem.</p>
        <h2>Native REST Architecture</h2>
        <p>The development was carried out entirely without the help of API Platform, allowing complete mastery of REST architecture and mechanisms. This "from-scratch" approach reinforced my understanding of fundamental RESTful API principles.</p>
        <h2>Documentation and Interface</h2>
        <p>A complete API interface was implemented and documented using the Nelmio package. This interactive documentation facilitates understanding and use of the API by third-party developers.</p>
        <h2>Modern Environment</h2>
        <p>I set up a Docker environment to facilitate application development and deployment, as well as a CI/CD pipeline with GitHub Actions to automate deployment processes.</p>
        <h2>Conclusion</h2>
        <p>This project allowed me to strengthen my skills regarding APIs and MySQL with a complete data schema grouping several relationships to manage all technical aspects of products.</p>
        <p>In my <strong><a href="/en/blog/todo-and-co-audit-technical-debt-reduction-and-optimization">next article</a></strong>, you can discover in more detail the behind-the-scenes of the ToDo & Co project and the technical challenges encountered.</p>';

        $tags = '{
            "fr": [
                "PHP", "Symfony", "MySQL", "Docker", "API REST", "CI/CD", "GitHub Actions"
            ], 
            "en": [
                "PHP", "Symfony", "MySQL", "Docker", "REST API", "CI/CD", "GitHub Actions"
            ]
        }';

        $resourceLinks = '{
            "fr": [
                {
                    "url": "https://github.com/gaelpaquien/openclassrooms-bilemo", 
                    "text": "Repository du projet BileMo API"
                }, 
                {
                    "url": "https://bilemo.gaelpaquien.com/", 
                    "text": "Démo du projet BileMo API"
                }
            ], 
            "en": [
                {
                    "url": "https://github.com/gaelpaquien/openclassrooms-bilemo", 
                    "text": "BileMo API project repository"
                }, 
                {
                    "url": "https://bilemo.gaelpaquien.com/", 
                    "text": "BileMo API project demo"
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
            'BileMo API : développement d\'une API REST sécurisée avec Symfony',
            'BileMo API: Development of a Secure REST API with Symfony',
            'bilemo-api-developpement-dune-api-rest-securisee-avec-symfony',
            'bilemo-api-development-of-a-secure-rest-api-with-symfony',
            'Développement de BileMo, API REST sécurisée avec Symfony pour la gestion de catalogues mobiles et clients destinés aux entreprises.',
            'Development of BileMo, secure REST API with Symfony for mobile catalog and client management for businesses.',
            '" . addslashes($contentFr) . "',
            '" . addslashes($contentEn) . "',
            '" . addslashes($tags) . "',
            '" . addslashes($resourceLinks) . "',
            '2025-06-08 06:00:00',
            '2025-06-08 06:00:00'
        )");

        $this->addSql("INSERT INTO article_medias (
            article_id,
            media,
            alt_text_fr,
            alt_text_en,
            is_cover
        ) VALUES (
            6,
            'bilemo-api-rest-securisee-symfony.webp',
            'Documentation interactive Nelmio de l\'API REST BileMo développée avec Symfony, montrant les endpoints disponibles',
            'Interactive Nelmio documentation of BileMo REST API developed with Symfony, showing available endpoints',
            1
        )");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM article_medias WHERE article_id = 6");
        $this->addSql("DELETE FROM articles WHERE id = 6");
    }
}
