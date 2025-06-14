<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250609132123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add second article.';
    }

    public function up(Schema $schema): void
    {
        $contentFr = '<h2>Le projet FiveM</h2>
        <p>Durant l\'année 2021-2022, en collaboration avec un ami, j\'ai eu l\'occasion d\'être co-fondateur d\'un serveur roleplay sur FiveM (GTA V). Ce projet représentait un saut technique considérable par rapport à mes expériences précédentes : une codebase plus complexe, des enjeux techniques d\'une autre ampleur que ce que j\'avais pu découvrir durant ma formation de développeur web.</p>
        <h2>Défis techniques multiples</h2>
        <p>Mon rôle était principalement axé sur la partie technique du projet. J\'ai développé des scripts LUA from-scratch, récupéré et adapté des scripts open-source aux besoins spécifiques de notre serveur. La gestion de la base de données MySQL, l\'intégration d\'assets (mapping, modèles 3D, modification de textures) faisaient partie de mes responsabilités quotidiennes.</p>
        <p>J\'ai également développé un bot Discord en Node.js sur mesure pour les besoins du projet, ainsi qu\'un site vitrine, tout en gérant l\'ensemble de l\'hébergement et de l\'infrastructure technique.</p>
        <h2>Gestion de projet et communauté</h2>
        <p>Au-delà des aspects techniques, j\'ai participé activement à l\'administration générale du projet : élaboration de la roadmap de développement, conception d\'un système économique équilibré et pérenne pour le serveur, gestion d\'une communauté de près d\'une centaine de joueurs, avec parfois plusieurs dizaines d\'utilisateurs actifs simultanément sur le serveur.</p>
        <p>Cette double casquette technique et managériale m\'a confronté à des défis de coordination et de planification que je n\'avais pas encore eu l\'occasion d\'expérimenter.</p>
        <h2>Compétences développées</h2>
        <p>Ce projet m\'a permis de monter significativement en compétence dans la conception et la gestion de projets d\'une plus grande envergure. Gestion de performance avec de nombreux utilisateurs simultanés, maintenance d\'une infrastructure stable, coordination d\'équipe : autant d\'aspects cruciaux pour tout développeur backend travaillant avec Node.js et MySQL.</p>
        <h2>Bilan de l\'expérience</h2>
        <p>Cette aventure FiveM a été un véritable accélérateur dans ma progression technique. Elle m\'a donné une vision concrète de ce qu\'implique la gestion d\'un projet avec de vrais utilisateurs, des contraintes de performance réelles et des enjeux de stabilité constants.</p>';

        $contentEn = '<h2>The FiveM Project</h2>
        <p>During 2021-2022, in collaboration with a friend, I had the opportunity to co-found a roleplay server on FiveM (GTA V). This project represented a considerable technical leap compared to my previous experiences: a more complex codebase, technical challenges of a different magnitude than what I had discovered during my web developer training.</p>
        <h2>Multiple Technical Challenges</h2>
        <p>My role was primarily focused on the technical side of the project. I developed LUA scripts from scratch, retrieved and adapted open-source scripts to the specific needs of our server. Managing the MySQL database, integrating assets (mapping, 3D models, texture modifications) were part of my daily responsibilities.</p>
        <p>I also developed a custom Discord bot in Node.js for the project\'s needs, as well as a showcase website, while managing the entire hosting and technical infrastructure.</p>
        <h2>Project and Community Management</h2>
        <p>Beyond technical aspects, I actively participated in the general administration of the project: developing the development roadmap, designing a balanced and sustainable economic system for the server, managing a community of about a hundred players, with sometimes several dozen active users simultaneously on the server.</p>
        <p>This dual technical and managerial role confronted me with coordination and planning challenges that I had not yet had the opportunity to experience.</p>
        <h2>Skills Developed</h2>
        <p>This project allowed me to significantly improve my skills in designing and managing larger-scale projects. Performance management with many simultaneous users, maintaining stable infrastructure, team coordination: all crucial aspects for any backend developer working with Node.js and MySQL.</p>
        <h2>Experience Summary</h2>
        <p>This FiveM adventure was a real accelerator in my technical progression. It gave me a concrete vision of what managing a project with real users implies, with real performance constraints and constant stability challenges.</p>';

        $tags = '{
            "fr": [
                "Node.js", "MySQL", "LUA"
            ], 
            "en": [
                "Node.js", "MySQL", "LUA"
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
            'Co-fondateur d\'un serveur FiveM : gestion technique d\'un projet gaming',
            'FiveM Server Co-founder: Technical Management of a Gaming Project',
            'co-fondateur-dun-serveur-fivem-gestion-technique-dun-projet-gaming',
            'fivem-server-co-founder-technical-management-of-a-gaming-project',
            'Retour d\'expérience sur la co-fondation d\'un serveur FiveM roleplay : défis techniques, gestion de communauté et montée en compétences sur un projet gaming.',
            'Experience feedback on co-founding a FiveM roleplay server: technical challenges, community management and skill development on a large-scale gaming project.',
            '" . addslashes($contentFr) . "',
            '" . addslashes($contentEn) . "',
            '" . addslashes($tags) . "',
            NULL,
            '2025-06-08 02:00:00',
            '2025-06-08 02:00:00'
        )");

        $this->addSql("INSERT INTO article_medias (
            article_id,
            media,
            alt_text_fr,
            alt_text_en,
            is_cover
        ) VALUES (
            2,
            'logo-fivem-serveur-roleplay-gaming.webp',
            'Logo FiveM, plateforme de modding pour serveurs roleplay GTA V',
            'FiveM logo, modding platform for GTA V roleplay servers',
            1
        )");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM article_medias WHERE article_id = 2");
        $this->addSql("DELETE FROM articles WHERE id = 2");
    }
}
