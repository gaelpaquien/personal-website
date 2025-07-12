<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250612133230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add tenth article.';
    }

    public function up(Schema $schema): void
    {
        $contentFr = '<h2>Première solution : o2switch</h2>
       <p>Ma première solution d\'hébergement était l\'offre d\'o2switch, qui me permettait d\'avoir un hébergement simplifié avec une interface d\'administration ergonomique et des déploiements de sites illimités. J\'ai pu très facilement y mettre en place tous mes sites en production, des tâches CRON pour réaliser une maintenance quotidienne sur chaque site, ainsi qu\'un email professionnel.</p>
       <h2>Besoin d\'évolution</h2>
       <p>Cette solution couvrait totalement mes besoins, mais je me suis ensuite trouvé limité sur certains aspects, notamment l\'utilisation de Docker. J\'avais également envie de monter en compétence sur la mise en place de mon propre VPS d\'hébergement.</p>
       <h2>Choix du VPS Infomaniak</h2>
       <p>Je suis donc passé sur un VPS Debian chez Infomaniak que j\'ai totalement configuré <strong>from-scratch</strong>. Cette migration représentait un défi technique intéressant pour approfondir mes connaissances en administration système.</p>
       <h2>Sécurisation du serveur</h2>
       <p>Les premières étapes de mise en place concernaient l\'installation et la sécurisation du VPS : update et upgrade du système, mise en place du <strong>pare-feu ufw couplé au pare-feu Infomaniak</strong>, installation de <strong>fail2ban pour la protection contre les attaques par force brute</strong>, et configuration des règles d\'authentification SSH sécurisées.</p>
       <h2>Architecture d\'hébergement</h2>
       <p>J\'ai ensuite mis en place une <strong>architecture robuste pour l\'hébergement des applications</strong> : nginx global pour gérer les certificats SSL, les headers de sécurité et les redirections vers les domaines et sous-domaines. Chaque application dispose de son propre conteneur Docker avec un nginx spécifique qui redirige via FastCGI vers l\'application PHP-FPM. Un conteneur Docker MySQL avec un réseau partagé permet à tous les conteneurs d\'applications de communiquer entre eux.</p>
       <h2>Monitoring avancé</h2>
       <p>J\'ai développé un <strong>script de monitoring personnalisé</strong> pour obtenir des statistiques en temps réel : consommation et performances du serveur, statut des domaines et sous-domaines, validité des certificats SSL, rapports de sécurité (fail2ban, connexions récentes), et de nombreuses autres métriques essentielles.</p>
       <h2>Résultats techniques</h2>
       <p>Cette architecture permet de <strong>gérer plusieurs applications simultanément</strong> avec une sécurité renforcée et un monitoring complet. La solution offre une <strong>flexibilité totale</strong> pour les déploiements et une <strong>maîtrise complète de l\'environnement</strong> de production.</p>
       <h2>Conclusion</h2>
       <p>Cette nouvelle solution couvre totalement tous mes besoins actuels. Bien évidemment, ce ne serait pas forcément la solution que je choisirais pour une application à grande échelle nécessitant de la très haute disponibilité, de la scalabilité et de gros volumes de données, mais elle répond parfaitement aux exigences de mes projets actuels.</p>
       <p>Dans mon <strong><a href="/fr/blog/developpeur-backend-chez-plany-logiciels-specialises-dans-levenementiel-et-lhotessariat">prochain article</a></strong>, je vous présente mon expérience professionnelle chez Plany, où je développe des logiciels spécialisés dans l\'événementiel et l\'hôtessariat.</p>';

        $contentEn = '<h2>First Solution: o2switch</h2>
       <p>My first hosting solution was o2switch\'s offering, which allowed me to have simplified hosting with an ergonomic administration interface and unlimited site deployments. I was easily able to set up all my production sites, CRON tasks for daily maintenance on each site, as well as professional email.</p>
       <h2>Need for Evolution</h2>
       <p>This solution completely covered my needs, but I then found myself limited on certain aspects, particularly Docker usage. I also wanted to improve my skills in setting up my own hosting VPS.</p>
       <h2>Infomaniak VPS Choice</h2>
       <p>So I switched to a Debian VPS at Infomaniak that I completely configured <strong>from scratch</strong>. This migration represented an interesting technical challenge to deepen my system administration knowledge.</p>
       <h2>Server Security</h2>
       <p>The first setup steps concerned VPS installation and security: system update and upgrade, <strong>ufw firewall setup coupled with Infomaniak\'s firewall</strong>, <strong>fail2ban installation for brute force attack protection</strong>, and secure SSH authentication rules configuration.</p>
       <h2>Hosting Architecture</h2>
       <p>I then set up a <strong>robust architecture for application hosting</strong>: global nginx to manage SSL certificates, security headers and redirections to domains and subdomains. Each application has its own Docker container with specific nginx that redirects via FastCGI to the PHP-FPM application. A Docker MySQL container with shared network allows all application containers to communicate with each other.</p>
       <h2>Advanced Monitoring</h2>
       <p>I developed a <strong>custom monitoring script</strong> to get real-time statistics: server consumption and performance, domain and subdomain status, SSL certificate validity, security reports (fail2ban, recent connections), and many other essential metrics.</p>
       <h2>Technical Results</h2>
       <p>This architecture allows to <strong>manage multiple applications simultaneously</strong> with enhanced security and complete monitoring. The solution offers <strong>total flexibility</strong> for deployments and <strong>complete control of the production environment</strong>.</p>
       <h2>Conclusion</h2>
       <p>This new solution completely covers all my current needs. Obviously, this wouldn\'t necessarily be the solution I would choose for a large-scale application requiring very high availability, scalability and large data volumes, but it perfectly meets the requirements of my current projects.</p>
       <p>In my <strong><a href="/en/blog/backend-developer-at-plany-software-specialized-in-event-management-and-hostess-services">next article</a></strong>, I present my professional experience at Plany, where I develop software specialized in event management and hostess services.</p>';

        $tags = '{
           "fr": [
               "VPS", "Debian", "Docker", "nginx", "Sécurité", "SSL", "Monitoring", "Administration système"
           ], 
           "en": [
               "VPS", "Debian", "Docker", "nginx", "Security", "SSL", "Monitoring", "System Administration"
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
           'Migration d\'hébergement : d\'o2switch vers un VPS Debian auto-géré',
           'Hosting Migration: From o2switch to a Self-Managed Debian VPS',
           'migration-dhebergement-do2switch-vers-un-vps-debian-auto-gere',
           'hosting-migration-from-o2switch-to-a-self-managed-debian-vps',
           'Migration d\'hébergement complète : configuration from-scratch d\'un VPS Debian avec architecture Docker et reverse proxy nginx, monitoring personnalisé et sécurisation avancée.',
           'Complete hosting migration: from-scratch configuration of a Debian VPS with Docker architecture and nginx reverse proxy, custom monitoring and advanced security.',
           '" . addslashes($contentFr) . "',
           '" . addslashes($contentEn) . "',
           '" . addslashes($tags) . "',
           NULL,
           '2025-06-08 10:00:00',
           '2025-06-08 10:00:00'
       )");

        $this->addSql("INSERT INTO article_medias (
           article_id,
           media,
           alt_text_fr,
           alt_text_en,
           is_cover
       ) VALUES (
           10,
           'serveur-physique-vps-debian-hebergement.webp',
           'Serveur physique représentant l\'hébergement VPS Debian auto-géré avec Docker et nginx',
           'Physical server representing self-managed Debian VPS hosting with Docker and nginx',
           1
       )");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM article_medias WHERE article_id = 10");
        $this->addSql("DELETE FROM articles WHERE id = 10");
    }
}