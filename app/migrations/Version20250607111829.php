<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250607111829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add initial reviews data.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO reviews (
            author_firstname, 
            author_lastname, 
            author_job_fr, 
            author_job_en, 
            author_company, 
            content_fr, 
            content_en, 
            source, 
            `order`, 
            status, 
            created_at
        ) VALUES (
            'Thomas',
            'Gérault',
            'Mentor',
            'Mentor',
            'OpenClassrooms',
            'En reconversion professionnelle pour se spécialiser dans le développement web full stack, Gaël a suivi la formation d\\'openclassrooms. Le point fort de Gaël est sa détermination : ne rien lâcher et aller toujours au bout des choses. Sérieux, appliqué et rigoureux, il a su monter en compétence rapidement et réussir ses projets avec brio.',
            'As a career changer specializing in full stack web development, Gaël followed the OpenClassrooms training program. Gaël\\'s greatest strength is his determination: never giving up and always seeing things through to the end. Serious, diligent and rigorous, he was able to quickly build his skills and successfully complete his projects with excellence.',
            'LinkedIn',
            2,
            1,
            '2021-06-28 00:00:00'
        )");

        $this->addSql("INSERT INTO reviews (
            author_firstname, 
            author_lastname, 
            author_job_fr, 
            author_job_en, 
            author_company, 
            content_fr, 
            content_en, 
            source, 
            `order`, 
            status, 
            created_at
        ) VALUES (
            'Jérôme',
            'Gaviot',
            'Cofondateur',
            'Co-founder',
            'RG Clean Car',
            'Gaël a réalisé notre site web WordPress en répondant exactement à nos besoins. Communication claire, suivi régulier de l\\'avancement du projet et respect des délais. Service très professionnel, je recommande !',
            'Gaël created our WordPress website that perfectly met our needs. Clear communication, regular project progress updates and deadlines were respected. Very professional service, I highly recommend!',
            'gaelpaquien.com',
            1,
            1,
            '2024-03-11 00:00:00'
        )");

        $this->addSql("INSERT INTO reviews (
           author_firstname, 
           author_lastname, 
           author_job_fr, 
           author_job_en, 
           author_company, 
           content_fr, 
           content_en, 
           source, 
           `order`, 
           status, 
           created_at
        ) VALUES (
           'Brandon',
           'Fradette',
           'Cofondateur du serveur',
           'Server Co-founder',
           'FiveM',
           'J\'ai eu le plaisir de collaborer avec Gaël sur un projet de serveur FiveM en 2021-2022. Pendant que je gérais la communication et l\'animation communautaire, Gaël pilotait la partie technique. Cette collaboration a été très enrichissante pour nous deux, tant sur le plan technique que managérial. Gaël est un collaborateur idéal, autonome et facile à vivre.',
           'I had the pleasure of collaborating with Gaël on a FiveM server project in 2021-2022. While I handled communication and community management, Gaël was responsible for the technical side. This collaboration was very enriching for both of us, both technically and managerially. Gaël is an ideal collaborator, autonomous and easy to work with.',
           'gaelpaquien.com',
           3,
           1,
           '2022-05-10 00:00:00'
        )");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM reviews WHERE id = 1');
        $this->addSql('DELETE FROM reviews WHERE id = 2');
        $this->addSql('DELETE FROM reviews WHERE id = 3');
    }
}
