<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250610194334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add third article.';
    }

    public function up(Schema $schema): void
    {
        $contentFr = '<h2>Le choix de la spécialisation</h2>
        <p>Comme j\'ai pu l\'évoquer dans mon <strong><a href="/fr/blog/de-technicien-informatique-a-developpeur-web-ma-reconversion">premier article</a></strong>, après avoir finalisé ma première formation de développeur web, j\'étais convaincu de vouloir faire carrière dans ce secteur passionnant. Mais j\'étais également réaliste sur deux points : mes compétences techniques n\'étaient pas encore suffisantes pour répondre aux attentes du marché professionnel, et je devais me spécialiser pour débuter ma carrière. Le choix a été une évidence : le backend.</p>
        <h2>Formation en parallèle : le défi</h2>
        <p>J\'ai donc financé ma seconde formation OpenClassrooms "Développeur d\'application PHP/Symfony", que j\'ai réalisée de décembre 2021 à septembre 2023 en parallèle de mon travail à plein temps de technicien informatique dans le secteur de la presse. Un vrai défi d\'organisation, mais cette immersion dans l\'univers PHP en valait la peine.</p>
        <h2>9 projets pour progresser</h2>
        <p>Cette formation m\'a permis d\'approfondir mes compétences backend à travers 9 projets professionnalisants. Voici les plus marquants :</p>
        <p>La conception d\'un blog complet en PHP natif et MySQL sans framework, en implémentant une architecture MVC. Cet exercice m\'a fait comprendre les fondamentaux avant d\'aborder les frameworks.</p>
        <p>Le projet SnowTricks m\'a fait découvrir Symfony : une application communautaire de partage de tricks de snowboard qui m\'a initié aux bonnes pratiques du framework.</p>
        <p>La création de l\'API REST Bilemo avec Symfony, sécurisée et exposant clients et produits aux utilisateurs authentifiés, a consolidé ma maîtrise des APIs.</p>
        <p>Enfin, l\'audit de performance et qualité sur ToDo & Co m\'a appris à analyser du code existant, réduire la dette technique, migrer une application de Symfony 5 vers Symfony 7 et mettre en place des tests unitaires pour obtenir un coverage complet de l\'application.</p>
        <h2>Les compétences acquises</h2>
        <p>Au terme de cette formation, j\'avais développé une approche méthodique du développement backend. Maîtrise de PHP et MySQL, écosystème Symfony, architecture MVC, conception d\'APIs REST sécurisées, audit de code, gestion de la dette technique et tests unitaires : toutes les compétences essentielles pour débuter sereinement ma carrière sur des projets professionnels étaient désormais acquises.</p>
        <h2>Prêt pour le marché</h2>
        <p>Après l\'obtention de cette formation, je me sentais enfin prêt et déterminé à me tourner vers le marché du travail avec des bases solides et des projets concrets à présenter.</p>
        <p>Dans mon <strong><a href="/fr/blog/blog-php-mvc-developpement-from-scratch-sans-framework">prochain article</a></strong>, vous pourrez découvrir plus en détail les coulisses du projet Blog PHP MVC et les défis techniques rencontrés.</p>';

        $contentEn = '<h2>Choosing specialization</h2>
        <p>As I mentioned in my <strong><a href="/en/blog/from-it-technician-to-web-developer-my-career-change">first article</a></strong>, after completing my first web developer training, I was convinced I wanted to build a career in this exciting field. But I was also realistic about two points: my technical skills were not yet sufficient to meet professional market expectations, and I needed to specialize to start my career. The choice was obvious: backend.</p>
        <h2>Training in parallel: the challenge</h2>
        <p>So I funded my second OpenClassrooms training "PHP/Symfony Application Developer", which I completed from December 2021 to September 2023 while working full-time as an IT technician in the press sector. A real organizational challenge, but this immersion in the PHP universe worth it.</p>
        <h2>9 projects to progress</h2>
        <p>This training allowed me to deepen my backend skills through 9 professional projects. Among the most significant:</p>
        <p>Designing a complete blog in native PHP and MySQL without framework, implementing an MVC architecture. This exercise made me understand the fundamentals before tackling frameworks.</p>
        <p>The SnowTricks project introduced me to Symfony: a community application for sharing snowboard tricks that initiated me to the framework\'s best practices.</p>
        <p>Creating the Bilemo REST API with Symfony, secured and exposing clients, products and companies to authenticated users, consolidated my API mastery.</p>
        <p>Finally, the performance and quality audit on ToDo & Co taught me to analyze existing code, reduce technical debt, migrate an application from Symfony 5 to Symfony 7 and implement unit tests to achieve complete application coverage.</p>
        <h2>Skills acquired</h2>
        <p>At the end of this training, I had developed a methodical approach to backend development. Mastery of PHP and MySQL, Symfony ecosystem, MVC architecture, secure REST API design, code auditing, technical debt management and unit testing: all the essential skills to confidently start my career on professional projects were now acquired.</p>
        <h2>Ready for the market</h2>
        <p>After completing this training, I finally felt ready and determined to turn to the job market with solid foundations and concrete projects to present.</p>
        <p>In my <strong><a href="/en/blog/php-mvc-blog-from-scratch-development-without-framework">next article</a></strong>, you can discover in more detail the behind-the-scenes of the PHP MVC Blog project and the technical challenges encountered.</p>';

        $tags = '{
            "fr": [
                "PHP", "Symfony", "MySQL", "API REST", "PHP Unit", "Architecture MVC"
            ], 
            "en": [
                "PHP", "Symfony", "MySQL", "REST API", "PHP Unit", "MVC Architecture"
            ]
        }';

        $resourceLinks = '{
            "fr": [
                {
                    "url": "https://github.com/gaelpaquien/openclassrooms-archive/tree/master/php-symfony-application-developer", 
                    "text": "Repository contenant tous mes livrables de la formation"
                }, 
                {
                    "url": "https://openclassrooms.com/fr/paths/876-developpeur-dapplication-php-symfony", 
                    "text": "Programme de formation Développeur d\'application PHP Symfony"
                }, 
                {
                    "url": "https://www.francecompetences.fr/recherche/rncp/38038/", 
                    "text": "Certification RNCP obtenue à l\'issue de la formation"
                }
            ], 
            "en": [
                {
                    "url": "https://github.com/gaelpaquien/openclassrooms-archive/tree/master/php-symfony-application-developer", 
                    "text": "Repository containing all my training deliverables"
                }, 
                {
                    "url": "https://openclassrooms.com/fr/paths/876-developpeur-dapplication-php-symfony", 
                    "text": "PHP Symfony Application Developer training program"
                }, 
                {
                    "url": "https://www.francecompetences.fr/recherche/rncp/38038/", 
                    "text": "RNCP certification obtained at the end of the training"
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
            'Formation PHP Symfony : ma montée en compétences backend',
            'PHP Symfony Training: My Backend Skills Development',
            'formation-php-symfony-ma-montee-en-competences-backend',
            'php-symfony-training-my-backend-skills-development',
            'Plongez dans ma formation PHP/Symfony : 9 projets professionnalisants, défis techniques et montée en compétences backend pour devenir développeur professionnel.',
            'Dive into my PHP/Symfony training: 9 professional projects, technical challenges and backend skill development to become a professional developer.',
            '" . addslashes($contentFr) . "',
            '" . addslashes($contentEn) . "',
            '" . addslashes($tags) . "',
            '" . addslashes($resourceLinks) . "',
            '2025-06-08 03:00:00',
            '2025-06-08 03:00:00'
        )");

        $this->addSql("INSERT INTO article_medias (
            article_id,
            media,
            alt_text_fr,
            alt_text_en,
            is_cover
        ) VALUES (
            3,
            'formation-php-symfony-developpeur-backend.webp',
            'Développeur travaillant sur plusieurs écrans avec du code PHP et Symfony, symbolisant la formation backend',
            'Developer working on multiple screens with PHP and Symfony code, representing backend training',
            1
        )");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM article_medias WHERE article_id = 3");
        $this->addSql("DELETE FROM articles WHERE id = 3");
    }
}