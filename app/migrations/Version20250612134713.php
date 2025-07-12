<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250612134713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add eleventh article.';
    }

    public function up(Schema $schema): void
    {
        $contentFr = '<h2>Plany : l\'entreprise</h2>
        <p>Plany est une entreprise proposant une suite d\'outils et logiciels principalement dans le secteur de l\'hôtessariat et de l\'événementiel. L\'entreprise développe des solutions techniques adaptées aux spécificités de ces secteurs d\'activité.</p>
        <h2>Écosystème produit</h2>
        <p>Plany propose aux agences un outil ERP complet pour ce secteur, incluant les fonctionnalités pour gérer toute la partie business : RH, planification, diffusion des missions, automatisation des DPAE, CVthèque et bien d\'autres modules essentiels.</p>
        <p>Les candidats disposent également d\'une application (développée avec PHP, Symfony et Vue.js) utilisée par <strong>250 000+ utilisateurs</strong> où ils peuvent s\'inscrire gratuitement, remplir leur profil, indiquer leur disponibilité et postuler à des missions.</p>
        <h2>Valeur ajoutée</h2>
        <p>La force de Plany réside dans sa capacité à proposer un large panel de missions courtes tout en s\'adaptant au rythme de chacun. C\'est la solution idéale pour des étudiants ou des personnes souhaitant faire un complément de revenus en maîtrisant leurs horaires de disponibilité.</p>
        <h2>Missions développement</h2>
        <p>En tant que développeur backend, mes missions comprennent la <strong>maintenance et évolution d\'une application Symfony à fort trafic</strong> (250 000+ utilisateurs), avec une stack technique incluant PHP, MySQL, OpenSearch, Docker et CI/CD.</p>
        <p>Je développe également une <strong>nouvelle version complète de modules clés</strong> (CVthèque, gestion de candidatures, système de matching) vers une nouvelle application dédiée utilisant PHP et Laravel, avec une architecture moderne et performante.</p>
        <h2>Participation produit</h2>
        <p>Je participe activement aux discussions et réunions permettant de définir les objectifs et évolutions possibles des projets et produits à court, moyen et long terme, contribuant ainsi à la stratégie technique et business de l\'entreprise.</p>
        <h2>Environnement de travail</h2>
        <p>Environnement collaboratif avec méthodologie agile et forte implication dans les décisions d\'architecture.</p>
        <h2>Conclusion</h2>
        <p>Travailler chez Plany m\'offre l\'opportunité de développer des solutions techniques dans un secteur spécialisé, avec des enjeux business concrets et une audience significative. La diversité des missions - entre maintenance d\'applications à fort trafic et développement de nouveaux modules - permet une montée en compétences continue sur différentes technologies.</p>
        <p>La participation aux réflexions produit apporte également une vision globale au-delà du simple développement technique.</p>';

        $contentEn = '<h2>Plany: The Company</h2>
        <p>Plany is a company offering a suite of tools and software primarily in the hospitality and events sector. The company develops technical solutions adapted to the specificities of these business sectors.</p>
        <h2>Product Ecosystem</h2>
        <p>Plany offers agencies a complete ERP tool for this sector, including functionalities to manage the entire business side: HR, planning, mission distribution, DPAE automation, CV database and many other essential modules.</p>
        <p>Candidates also have an application (developed with PHP, Symfony and Vue.js) used by <strong>250,000+ users</strong> where they can register for free, fill out their profile, indicate their availability and apply for missions.</p>
        <h2>Added Value</h2>
        <p>Plany\'s strength lies in its ability to offer a wide range of short missions while adapting to everyone\'s pace. It\'s the ideal solution for students or people wanting to supplement their income while controlling their availability hours.</p>
        <h2>Development Missions</h2>
        <p>As a backend developer, my missions include <strong>maintaining and evolving a high-traffic Symfony application</strong> (250,000+ users), with a technical stack including PHP, MySQL, OpenSearch, Docker and CI/CD.</p>
        <p>I also develop a <strong>complete new version of key modules</strong> (CV database, application management, matching system) towards a new dedicated application using PHP and Laravel, with a modern and performant architecture.</p>
        <h2>Product Participation</h2>
        <p>I actively participate in discussions and meetings to define the objectives and possible evolutions of projects and products in the short, medium and long term, thus contributing to the company\'s technical and business strategy.</p>
        <h2>Technologies and Environment</h2>
        <p>Technical stack: <strong>PHP, Symfony, Laravel, Vue.js, MySQL, Docker, OpenSearch, CI/CD</strong>. Collaborative environment with agile methodology and strong involvement in architecture decisions.</p>
        <h2>Conclusion</h2>
        <p>Working at Plany offers me the opportunity to develop technical solutions in a specialized sector, with concrete business challenges and a significant audience. The diversity of missions - between maintaining high-traffic applications and developing new modules - allows continuous skill development on different technologies.</p>
        <p>Participating in product discussions also provides a global vision beyond simple technical development.</p>';

        $tags = '{
            "fr": [
                "PHP", "Symfony", "Laravel", "MySQL", "OpenSearch", "PHP Unit", "Docker", "Herd", "CI/CD", "Vue.js", "Livewire", "Alpine.js", "Tailwind CSS"
            ], 
            "en": [
                "PHP", "Symfony", "Laravel", "MySQL", "OpenSearch", "PHP Unit", "Docker", "Herd", "CI/CD", "Vue.js", "Livewire", "Alpine.js", "Tailwind CSS"
            ]
        }';

        $resourceLinks = '{
            "fr": [
                {
                    "url": "https://www.plany.jobs/", 
                    "text": "plany.jobs - Le site vitrine de Plany"
                }, 
                {
                    "url": "https://app.plany.jobs/", 
                    "text": "app.plany.jobs - L\'application déiée aux candidats"
                }, 
                {
                    "url": "https://board.plany.app/", 
                    "text": "board.plany.app - La nouvelle version de certains modules (CVthèque, gestion de candidatures)"
                }
            ], 
            "en": [
                {
                    "url": "https://www.plany.jobs/", 
                    "text": "plany.jobs - Plany showcase site"
                }, 
                {
                    "url": "https://app.plany.jobs/", 
                    "text": "app.plany.jobs - Candidate dedicated application"
                }, 
                {
                    "url": "https://board.plany.app/", 
                    "text": "board.plany.app - The new version of certain modules (CV database, application management)"
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
            'Développeur backend chez Plany : Logiciels spécialisés dans l\'événementiel et l\'hôtessariat',
            'Backend developer at Plany: Software specialized in event management and hostess services',
            'developpeur-backend-chez-plany-logiciels-specialises-dans-levenementiel-et-lhotessariat',
            'backend-developer-at-plany-software-specialized-in-event-management-and-hostess-services',
            'Développeur backend chez Plany : maintenance d\'une application Symfony 250k+ utilisateurs, développement de nouvelles fonctionnalités Laravel et participation active à la roadmap produit.',
            'Backend developer at Plany: maintaining a Symfony application with 250k+ users, developing new Laravel features and actively participating in the product roadmap.',
            '" . addslashes($contentFr) . "',
            '" . addslashes($contentEn) . "',
            '" . addslashes($tags) . "',
            '" . addslashes($resourceLinks) . "',
            '2025-06-08 11:00:00',
            '2025-06-08 11:00:00'
        )");

        $this->addSql("INSERT INTO article_medias (
            article_id,
            media,
            alt_text_fr,
            alt_text_en,
            is_cover
        ) VALUES (
            11,
            'homepage-plany-jobs-erp-evenementiel-hostessariat.webp',
            'Page d\'accueil de Plany.jobs, plateforme ERP pour l\'événementiel et l\'hôtessariat où je travaille comme développeur backend',
            'Plany.jobs homepage, ERP platform for events and hospitality where I work as backend developer',
            1
        )");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM article_medias WHERE article_id = 11");
        $this->addSql("DELETE FROM articles WHERE id = 11");
    }
}