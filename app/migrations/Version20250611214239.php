<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250611214239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add eighth article.';
    }

    public function up(Schema $schema): void
    {
        $contentFr = '<h2>Le projet client</h2>
        <p>Le développement du site vitrine de RG Clean Car, une entreprise de nettoyage de véhicules à domicile située à Voiron, représentait un défi intéressant : créer une présence web efficace pour une jeune entreprise locale cherchant à attirer ses premiers clients.</p>
        <h2>Développement WordPress</h2>
        <p>Le site a été conçu avec WordPress en respectant scrupuleusement les bonnes pratiques : design responsive pour tous les appareils, utilisation d\'un thème enfant pour préserver les personnalisations, sélection d\'extensions reconnues sans surplus inutile, optimisation SEO et mise en place de mesures de sécurité appropriées.</p>
        <h2>Design et fonctionnalités</h2>
        <p>J\'ai conçu le design en répondant spécifiquement aux attentes du client et à l\'identité de son entreprise. En complément du site, j\'ai également créé une carte de visite et un flyer en respectant la direction artistique du site pour assurer une cohérence visuelle complète. Le développement a nécessité du CSS et JavaScript custom pour répondre aux besoins particuliers du projet. Le site intègre également un formulaire de contact optimisé pour faciliter la prise de contact avec les prospects.</p>
        <h2>Configuration technique</h2>
        <p>Au-delà du développement, j\'ai configuré la boîte mail professionnelle pour le client, assurant ainsi une communication professionnelle cohérente avec l\'image de marque de l\'entreprise.</p>
        <h2>Impact business</h2>
        <p>Ce site a permis au client d\'attirer ses premiers prospects et de développer son activité.</p>
        <h2>Conclusion</h2>
        <p>Bien que l\'entreprise ait aujourd\'hui cessé son activité par manque de temps, une démo du site reste accessible avec l\'accord du client. Vous pourrez la retrouver dans les ressources de l\'article pour découvrir le résultat final.</p>
        <p>Dans mon <strong><a href="/fr/blog/mon-site-personnel-symfony-migration-wordpress-vers-une-application-moderne">prochain article</a></strong>, changement radical de contexte : découvrez la refonte complète de mon site personnel avec une migration WordPress vers Symfony.</p>';

        $contentEn = '<h2>The Client Project</h2>
        <p>Developing the showcase website for RG Clean Car, a home vehicle cleaning company located in Voiron, represented an interesting challenge: creating an effective web presence for a young local business seeking to attract its first customers.</p>
        <h2>WordPress Development</h2>
        <p>The site was designed with WordPress while scrupulously respecting best practices: responsive design for all devices, use of a child theme to preserve customizations, selection of community-recognized extensions without adding superfluous plugins, SEO optimization and implementation of appropriate security measures.</p>
        <h2>Design and Features</h2>
        <p>I designed the layout specifically responding to client expectations and company identity. In addition to the website, I also created a business card and flyer following the site\'s artistic direction to ensure complete visual consistency. Development required custom CSS and JavaScript to meet the project\'s specific needs. The site also integrates an optimized contact form to facilitate prospect contact.</p>
        <h2>Technical Configuration</h2>
        <p>Beyond development, I configured the professional email box for the client, ensuring professional communication consistent with the company\'s brand image.</p>
        <h2>Business Impact</h2>
        <p>This website allowed the client to attract their first prospects and develop their business.</p>
        <h2>Conclusion</h2>
        <p>Although the company has now ceased operations due to lack of time, a demo of the site remains accessible with the client\'s agreement. You can find it in the article resources to discover the final result.</p>
        <p>In my <strong><a href="/en/blog/my-symfony-personal-website-wordpress-migration-to-a-modern-application">next article</a></strong>, radical context change: discover the complete redesign of my personal website with a WordPress to Symfony migration.</p>';

        $tags = '{
            "fr": [
                "WordPress", "CSS", "JavaScript", "SEO"
            ], 
            "en": [
                "WordPress", "CSS", "JavaScript", "SEO"
            ]
        }';

        $resourceLinks = '{
            "fr": [
                {
                    "url": "https://rgcleancar.gaelpaquien.com/", 
                    "text": "Démo du site RG Clean Car"
                }
            ], 
            "en": [
                {
                    "url": "https://rgcleancar.gaelpaquien.com/", 
                    "text": "RG Clean Car website demo"
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
            'RG Clean Car : site vitrine WordPress pour entreprise de nettoyage automobile',
            'RG Clean Car: WordPress Showcase Website for Automotive Cleaning Company',
            'rg-clean-car-site-vitrine-wordpress-pour-entreprise-de-nettoyage-automobile',
            'rg-clean-car-wordpress-showcase-website-for-automotive-cleaning-company',
            'Développement du site vitrine WordPress de RG Clean Car : bonnes pratiques SEO, design sur mesure et configuration email pro pour une entreprise de nettoyage automobile.',
            'Development of RG Clean Car WordPress showcase website: SEO best practices, custom design and professional email configuration for an automotive cleaning company.',
            '" . addslashes($contentFr) . "',
            '" . addslashes($contentEn) . "',
            '" . addslashes($tags) . "',
            '" . addslashes($resourceLinks) . "',
            '2025-06-08 08:00:00',
            '2025-06-08 08:00:00'
        )");

        $this->addSql("INSERT INTO article_medias (
            article_id,
            media,
            alt_text_fr,
            alt_text_en,
            is_cover
        ) VALUES (
            8,
            'homepage-rg-clean-car-wordpress-vitrine.webp',
            'Page d\'accueil du site vitrine RG Clean Car développé avec WordPress, entreprise de nettoyage automobile à domicile',
            'RG Clean Car showcase website homepage developed with WordPress, home car cleaning business',
            1
        )");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM article_medias WHERE article_id = 8");
        $this->addSql("DELETE FROM articles WHERE id = 8");
    }
}
