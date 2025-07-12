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
       <p>L\'objectif de ce projet était de développer BileMo, une API REST sécurisée avec PHP et Symfony. Cette API permet aux utilisateurs authentifiés d\'accéder à des données structurées concernant des produits téléphoniques et la gestion des clients. Le projet respectait intégralement les <strong>principes REST</strong> pour assurer une architecture cohérente et standardisée.</p>
       <h2>Fonctionnalités exposées</h2>
       <p>L\'API expose plusieurs endpoints permettant aux utilisateurs authentifiés de consulter une <strong>liste complète de produits (téléphones)</strong> avec toutes les spécifications techniques associées à chaque modèle. Elle permet également l\'accès aux listes des clients et utilisateurs du magasin, offrant une vue d\'ensemble de l\'écosystème commercial.</p>
       <h2>Architecture REST native</h2>
       <p>Le développement a été réalisé intégralement <strong>sans l\'aide d\'API Platform</strong>, permettant une maîtrise complète de l\'architecture et des mécanismes REST. Cette approche <strong>"from-scratch"</strong> a renforcé ma compréhension des principes fondamentaux des APIs RESTful.</p>
       <h2>Documentation et interface</h2>
       <p>Une <strong>interface API complète</strong> a été mise en place et documentée à l\'aide du <strong>package Nelmio</strong>. Cette documentation interactive facilite la compréhension et l\'utilisation de l\'API par les développeurs tiers.</p>
       <h2>Environnement moderne</h2>
       <p>J\'ai mis en place un <strong>environnement Docker</strong> pour faciliter le développement et le déploiement de l\'application, ainsi qu\'une <strong>pipeline CI/CD avec GitHub Actions</strong> pour automatiser les processus de déploiement.</p>
       <h2>Résultats techniques</h2>
       <p>Cette API REST native offre une <strong>architecture robuste et sécurisée</strong> avec authentification complète et gestion des permissions. Le développement from-scratch garantit une compréhension approfondie des mécanismes REST et une maîtrise totale de l\'architecture.</p>
       <h2>Conclusion</h2>
       <p>Ce projet m\'a permis de renforcer mes compétences concernant les APIs et MySQL avec un schéma de données complet regroupant plusieurs relations pour gérer tous les aspects techniques des produits.</p>
       <p>Dans mon <strong><a href="/fr/blog/todo-and-co-audit-reduction-de-dette-technique-et-optimisation">prochain article</a></strong>, vous pourrez découvrir plus en détail les coulisses du projet ToDo & Co et les défis techniques rencontrés.</p>';

        $contentEn = '<h2>The BileMo API</h2>
       <p>The objective of this project was to develop BileMo, a secure REST API with PHP and Symfony. This API allows authenticated users to access structured data regarding phone products and customer management. The project fully respected <strong>REST principles</strong> to ensure a consistent and standardized architecture.</p>
       <h2>Exposed Features</h2>
       <p>The API exposes several endpoints allowing authenticated users to consult a <strong>complete list of products (phones)</strong> with all technical specifications associated with each model. It also provides access to customer and store user lists, offering an overview of the commercial ecosystem.</p>
       <h2>Native REST Architecture</h2>
       <p>The development was carried out entirely <strong>without the help of API Platform</strong>, allowing complete mastery of REST architecture and mechanisms. This <strong>"from-scratch"</strong> approach reinforced my understanding of fundamental RESTful API principles.</p>
       <h2>Documentation and Interface</h2>
       <p>A <strong>complete API interface</strong> was implemented and documented using the <strong>Nelmio package</strong>. This interactive documentation facilitates understanding and use of the API by third-party developers.</p>
       <h2>Modern Environment</h2>
       <p>I set up a <strong>Docker environment</strong> to facilitate application development and deployment, as well as a <strong>CI/CD pipeline with GitHub Actions</strong> to automate deployment processes.</p>
       <h2>Technical Results</h2>
       <p>This native REST API offers a <strong>robust and secure architecture</strong> with complete authentication and permission management. The from-scratch development ensures deep understanding of REST mechanisms and total architecture mastery.</p>
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
           'Développement from-scratch de BileMo, API REST sécurisée avec Symfony sans API Platform, documentation Nelmio interactive, authentification complète et gestion des permissions avancée.',
           'From-scratch development of BileMo, secure REST API with Symfony without API Platform, interactive Nelmio documentation, complete authentication and advanced permission management.',
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