<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250611185154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add seventh article.';
    }

    public function up(Schema $schema): void
    {
        $contentFr = '<h2>Reprise d\'application existante</h2>
       <p>L\'objectif de ce projet était de reprendre une application existante de ToDo List appelée ToDo & Co. Cette mission consistait à analyser, optimiser et faire évoluer une codebase développée par d\'autres développeurs, avec ses propres défis techniques et organisationnels.</p>
       <h2>Audit complet</h2>
       <p>Dans un premier temps, j\'ai réalisé un <strong>audit complet de l\'application</strong> pour identifier les points d\'amélioration. Cet audit s\'est appuyé sur des outils spécialisés : <strong>Codacy pour analyser la qualité du code</strong> (complexité, duplication, standards de codage) et <strong>New Relic pour évaluer les performances</strong> de l\'application en conditions réelles.</p>
       <h2>Réduction dette technique</h2>
       <p>Suite à l\'audit, j\'ai entrepris une <strong>réduction significative de la dette technique</strong> en migrant l\'application de Symfony 5 vers Symfony 7. Cette migration majeure nécessitait de comprendre les breaking changes, adapter le code aux nouvelles versions des composants et s\'assurer de la compatibilité avec les dépendances.</p>
       <h2>Nouvelles fonctionnalités</h2>
       <p>J\'ai également développé de nouvelles fonctionnalités pour améliorer la gestion des tâches. Mise en place d\'une <strong>commande pour identifier et associer les tâches sans auteur</strong> à un utilisateur anonyme, avec la possibilité pour les administrateurs de gérer le statut de ces tâches anonymes.</p>
       <h2>Suite de tests</h2>
       <p>Pour garantir la stabilité de l\'application après les modifications, j\'ai mis en place une <strong>suite de tests fonctionnels complète avec PHPUnit</strong>. L\'objectif était d\'obtenir une <strong>couverture de tests totale de l\'application</strong>, assurant ainsi la non-régression des fonctionnalités existantes.</p>
       <h2>Environnement moderne</h2>
       <p>J\'ai modernisé l\'environnement de développement en mettant en place <strong>Docker</strong> pour faciliter le développement et le déploiement, ainsi qu\'une <strong>pipeline CI/CD avec GitHub Actions</strong> pour automatiser les déploiements.</p>
       <h2>Résultats techniques</h2>
       <p>Cette optimisation a permis de <strong>réduire drastiquement la dette technique</strong> et d\'améliorer les performances de l\'application. La migration vers Symfony 7 et la couverture de tests complète garantissent une base solide pour les évolutions futures.</p>
       <h2>Conclusion</h2>
       <p>Ce projet m\'a permis de développer des compétences essentielles en maintenance d\'applications : audit de code, migration Symfony et mise en place de tests complets. Reprendre une codebase existante présente des défis différents du développement from-scratch, mais s\'avère très formateur pour le contexte professionnel.</p>
       <p>Dans mon <strong><a href="/fr/blog/rg-clean-car-site-vitrine-wordpress-pour-entreprise-de-nettoyage-automobile">prochain article</a></strong>, changement de contexte avec un projet client : le développement d\'un site vitrine WordPress.</p>';

        $contentEn = '<h2>Taking Over Existing Application</h2>
       <p>The objective of this project was to take over an existing ToDo List application called ToDo & Co. This mission consisted of analyzing, optimizing and evolving a codebase developed by other developers, with its own technical and organizational challenges.</p>
       <h2>Complete Audit</h2>
       <p>Initially, I performed a <strong>complete audit of the application</strong> to identify improvement points. This audit relied on specialized tools: <strong>Codacy to analyze code quality</strong> (complexity, duplication, coding standards) and <strong>New Relic to evaluate performance</strong> under real conditions.</p>
       <h2>Technical Debt Reduction</h2>
       <p>Following the audit, I undertook a <strong>significant reduction of technical debt</strong> by migrating the application from Symfony 5 to Symfony 7. This major migration required understanding breaking changes, adapting code to new component versions and ensuring compatibility with dependencies.</p>
       <h2>New Features</h2>
       <p>I also developed new features to improve task management. Implementation of a <strong>command to identify and associate tasks without authors</strong> to an anonymous user, with the ability for administrators to manage the status of these anonymous tasks.</p>
       <h2>Test Suite</h2>
       <p>To guarantee application stability after modifications, I implemented a <strong>complete functional test suite with PHPUnit</strong>. The objective was to achieve <strong>total test coverage of the application</strong>, thus ensuring non-regression of existing functionalities.</p>
       <h2>Modern Environment</h2>
       <p>I modernized the development environment by implementing <strong>Docker</strong> to facilitate development and deployment, as well as a <strong>CI/CD pipeline with GitHub Actions</strong> to automate deployments.</p>
       <h2>Technical Results</h2>
       <p>This optimization allowed to <strong>drastically reduce technical debt</strong> and improve application performance. The migration to Symfony 7 and complete test coverage guarantee a solid foundation for future developments.</p>
       <h2>Conclusion</h2>
       <p>This project allowed me to develop essential skills in application maintenance: code auditing, Symfony migration and comprehensive testing. Taking over an existing codebase presents different challenges from from-scratch development, but proves very educational for professional contexts.</p>
       <p>In my <strong><a href="/en/blog/rg-clean-car-wordpress-showcase-website-for-automotive-cleaning-company">next article</a></strong>, context change with a client project: WordPress showcase website development.</p>';

        $tags = '{
           "fr": [
               "PHP", "Symfony", "PHPUnit", "Docker", "CI/CD", "GitHub Actions", "Audit de code", "Codacy", "New Relic"
           ], 
           "en": [
               "PHP", "Symfony", "PHPUnit", "Docker", "CI/CD", "GitHub Actions", "Code Audit", "Codacy", "New Relic"
           ]
       }';

        $resourceLinks = '{
           "fr": [
               {
                   "url": "https://github.com/gaelpaquien/openclassrooms-todoandco", 
                   "text": "Repository du projet ToDo & Co"
               }, 
               {
                   "url": "https://todoandco.gaelpaquien.com/", 
                   "text": "Démo du projet ToDo & Co"
               }
           ], 
           "en": [
               {
                   "url": "https://github.com/gaelpaquien/openclassrooms-todoandco", 
                   "text": "ToDo & Co project repository"
               }, 
               {
                   "url": "https://todoandco.gaelpaquien.com/", 
                   "text": "ToDo & Co project demo"
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
           'ToDo & Co : audit, réduction de dette technique et optimisation',
           'ToDo & Co: audit, technical debt reduction and optimization',
           'todo-and-co-audit-reduction-de-dette-technique-et-optimisation',
           'todo-and-co-audit-technical-debt-reduction-and-optimization',
           'Audit et optimisation complète de ToDo & Co : migration Symfony 5 vers Symfony 7, suite de tests PHPUnit avec couverture totale, optimisation des performances et réduction de la dette technique.',
           'Complete audit and optimization of ToDo & Co: Symfony 5 to Symfony 7 migration, PHPUnit test suite with full coverage, performance optimization and technical debt reduction.',
           '" . addslashes($contentFr) . "',
           '" . addslashes($contentEn) . "',
           '" . addslashes($tags) . "',
           '" . addslashes($resourceLinks) . "',
           '2025-06-08 07:00:00',
           '2025-06-08 07:00:00'
       )");

        $this->addSql("INSERT INTO article_medias (
           article_id,
           media,
           alt_text_fr,
           alt_text_en,
           is_cover
       ) VALUES (
           7,
           'homepage-todo-co-symfony-audit-optimisation.webp',
           'Page d\'accueil de ToDo & Co après audit et migration Symfony, application de gestion de tâches optimisée',
           'ToDo & Co homepage after audit and Symfony migration, optimized task management application',
           1
       )");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM article_medias WHERE article_id = 7");
        $this->addSql("DELETE FROM articles WHERE id = 7");
    }
}