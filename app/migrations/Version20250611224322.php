<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250611224322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add ninth article.';
    }

    public function up(Schema $schema): void
    {
        $contentFr = '<h2>Migration WordPress vers Symfony</h2>
       <p>L\'objectif de ce projet était de refaire entièrement mon site personnel pour passer d\'un WordPress vers une application PHP/Symfony. Cette migration représentait une évolution technique significative, me permettant de démontrer mes compétences sur un <strong>projet personnel complet et moderne</strong>.</p>
       <h2>Stack technique moderne</h2>
       <p>Le projet utilise <strong>Symfony 7 avec le bundle AssetMapper</strong>, qui inclut le framework JavaScript Stimulus pour les interactions utilisateur et Sass pour la gestion du style. Cette stack moderne offre une approche plus structurée et modulable qu\'un CMS traditionnel.</p>
       <h2>Expérience utilisateur</h2>
       <p>L\'objectif était de créer une expérience utilisateur agréable avec un design simple et efficace, entièrement responsive. Le site propose un <strong>mode light et dark</strong> pour s\'adapter aux préférences des visiteurs.</p>
       <h2>Fonctionnalités développées</h2>
       <p>Le site intègre plusieurs sections : <strong>liste des projets récents, articles de blog, liste des avis clients, formulaire permettant de publier un avis et formulaire de contact</strong>. Chaque fonctionnalité a été développée en respectant les bonnes pratiques Symfony.</p>
       <h2>Interface d\'administration</h2>
       <p>J\'ai développé une <strong>partie administration complète</strong> permettant de gérer tout le contenu du site : projets, articles et avis. Cette interface inclut également un <strong>système de modération</strong> pour les avis créés depuis le site.</p>
       <h2>Multi-langue et SEO</h2>
       <p>Le site supporte <strong>deux langues (français et anglais)</strong> avec une gestion complète des URLs et du contenu localisé. L\'optimisation SEO couvre tous les aspects techniques : structure des URLs, performance et accessibilité.</p>
       <h2>Environnement technique</h2>
       <p>J\'ai mis en place un <strong>environnement Docker</strong> pour faciliter le développement et le déploiement, ainsi qu\'une <strong>pipeline CI/CD avec GitHub Actions</strong> pour automatiser les processus.</p>
       <h2>Résultats techniques</h2>
       <p>Cette migration a permis de créer un site <strong>entièrement sur mesure</strong> avec une architecture moderne et maintenable. Le projet démontre une maîtrise complète de la stack Symfony et des bonnes pratiques de développement.</p>
       <h2>Conclusion</h2>
       <p>Cette migration WordPress vers Symfony m\'a permis de créer un site personnel qui reflète réellement mes compétences techniques. Le projet combine stack moderne, bonnes pratiques et fonctionnalités avancées tout en gardant une approche pragmatique.</p>
       <p>Dans mon <strong><a href="/fr/blog/migration-dhebergement-do2switch-vers-un-vps-debian-auto-gere">prochain article</a></strong>, vous pourrez découvrir comment j\'ai hébergé ce site et mes autres projets sur un VPS auto-géré.</p>';

        $contentEn = '<h2>WordPress to Symfony Migration</h2>
       <p>The objective of this project was to completely rebuild my personal website to migrate from WordPress to a PHP/Symfony application. This migration represented a significant technical evolution, allowing me to demonstrate my skills on a <strong>complete and modern personal project</strong>.</p>
       <h2>Modern Technical Stack</h2>
       <p>The project uses <strong>Symfony 7 with the AssetMapper bundle</strong>, which includes the Stimulus JavaScript framework for user interactions and Sass for style management. This modern stack offers a more structured and modular approach than a traditional CMS.</p>
       <h2>User Experience</h2>
       <p>The goal was to create a pleasant user experience with a simple and efficient design, fully responsive. The site offers <strong>light and dark modes</strong> to adapt to visitor preferences.</p>
       <h2>Developed Features</h2>
       <p>The site integrates several sections: <strong>recent projects list, blog articles, client reviews list, form to publish a review and contact form</strong>. Each functionality was developed following Symfony best practices.</p>
       <h2>Administration Interface</h2>
       <p>I developed a <strong>complete administration section</strong> allowing management of all site content: projects, articles and reviews. This interface also includes a <strong>moderation system</strong> for reviews created from the site.</p>
       <h2>Multi-language and SEO</h2>
       <p>The site supports <strong>two languages (French and English)</strong> with complete URL and localized content management. SEO optimization covers all technical aspects: URL structure, performance and accessibility.</p>
       <h2>Technical Environment</h2>
       <p>I set up a <strong>Docker environment</strong> to facilitate development and deployment, as well as a <strong>CI/CD pipeline with GitHub Actions</strong> to automate processes.</p>
       <h2>Technical Results</h2>
       <p>This migration allowed to create a <strong>completely custom site</strong> with a modern and maintainable architecture. The project demonstrates complete mastery of the Symfony stack and development best practices.</p>
       <h2>Conclusion</h2>
       <p>This WordPress to Symfony migration allowed me to create a personal website that truly reflects my technical skills. The project combines modern stack, best practices and advanced features while maintaining a pragmatic approach.</p>
       <p>In my <strong><a href="/en/blog/hosting-migration-from-o2switch-to-a-self-managed-debian-vps">next article</a></strong>, you can discover how I hosted this site and my other projects on a self-managed VPS.</p>';

        $tags = '{
           "fr": [
               "PHP", "Symfony", "MySQL", "Docker", "CI/CD", "Stimulus", "Sass", "GitHub Actions", "Multi-langue", "SEO"
           ], 
           "en": [
               "PHP", "Symfony", "MySQL", "Docker", "CI/CD", "Stimulus", "Sass", "GitHub Actions", "Multi-language", "SEO"
           ]
       }';

        $resourceLinks = '{
           "fr": [
               {
                   "url": "https://github.com/gaelpaquien/personal-website", 
                   "text": "Repository du projet"
               }
           ], 
           "en": [
               {
                   "url": "https://github.com/gaelpaquien/personal-website", 
                   "text": "Project repository"
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
           'Mon site personnel Symfony : migration WordPress vers une application moderne',
           'My Symfony personal website: WordPress migration to a modern application',
           'mon-site-personnel-symfony-migration-wordpress-vers-une-application-moderne',
           'my-symfony-personal-website-wordpress-migration-to-a-modern-application',
           'Refonte complète de mon site personnel : migration WordPress vers Symfony 7 avec interface admin sur mesure, pipeline CI/CD GitHub Actions et support multi-langues complet.',
           'Complete redesign of my personal website: WordPress to Symfony 7 migration with custom admin interface, CI/CD GitHub Actions pipeline and complete multi-language support.',
           '" . addslashes($contentFr) . "',
           '" . addslashes($contentEn) . "',
           '" . addslashes($tags) . "',
           '" . addslashes($resourceLinks) . "',
           '2025-06-08 09:00:00',
           '2025-06-08 09:00:00'
       )");

        $this->addSql("INSERT INTO article_medias (
           article_id,
           media,
           alt_text_fr,
           alt_text_en,
           is_cover
       ) VALUES (
           9,
           'homepage-personal-website-php-symfony.webp',
           'Page d\'accueil du site personnel développé avec PHP, Symfony 7, Stimulus et Sass',
           'Homepage of the personal website developed with PHP, Symfony 7, Stimulus and Sass',
           1
       )");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM article_medias WHERE article_id = 9");
        $this->addSql("DELETE FROM articles WHERE id = 9");
    }
}