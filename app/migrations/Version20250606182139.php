<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250606182139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create initial database schema.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE users (
            id INT AUTO_INCREMENT NOT NULL, 
            email VARCHAR(180) NOT NULL, 
            password VARCHAR(255) NOT NULL, 
            firstname VARCHAR(255) NOT NULL, 
            lastname VARCHAR(255) NOT NULL, 
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', 
            UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE articles (
            id INT AUTO_INCREMENT NOT NULL, 
            title_fr VARCHAR(255) NOT NULL, 
            title_en VARCHAR(255) NOT NULL, 
            slug_fr VARCHAR(255) NOT NULL, 
            slug_en VARCHAR(255) NOT NULL, 
            short_description_fr LONGTEXT NOT NULL, 
            short_description_en LONGTEXT NOT NULL, 
            content_fr LONGTEXT NOT NULL, 
            content_en LONGTEXT NOT NULL, 
            tags JSON NOT NULL, 
            resource_links JSON DEFAULT NULL, 
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', 
            updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', 
            UNIQUE INDEX UNIQ_BFDD31684255CF50 (slug_fr), 
            UNIQUE INDEX UNIQ_BFDD31687D79C0DC (slug_en), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE article_medias (
            id INT AUTO_INCREMENT NOT NULL, 
            article_id INT NOT NULL, 
            media VARCHAR(255) NOT NULL, 
            alt_text_fr VARCHAR(255) DEFAULT NULL, 
            alt_text_en VARCHAR(255) DEFAULT NULL, 
            is_cover TINYINT(1) NOT NULL, 
            INDEX IDX_781538017294869C (article_id), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE projects (
            id INT AUTO_INCREMENT NOT NULL, 
            article_id INT NOT NULL, 
            title_fr VARCHAR(255) NOT NULL, 
            title_en VARCHAR(255) NOT NULL, 
            sort_order SMALLINT NOT NULL, 
            UNIQUE INDEX UNIQ_5C93B3A47294869C (article_id), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE reviews (
            id INT AUTO_INCREMENT NOT NULL, 
            author_firstname VARCHAR(255) NOT NULL, 
            author_lastname VARCHAR(255) NOT NULL, 
            author_job_fr VARCHAR(255) NOT NULL, 
            author_job_en VARCHAR(255) NOT NULL, 
            author_company VARCHAR(255) NOT NULL, 
            content_fr LONGTEXT NOT NULL, 
            content_en LONGTEXT NOT NULL, 
            source VARCHAR(255) NOT NULL, 
            sort_order SMALLINT DEFAULT NULL, 
            status SMALLINT NOT NULL, 
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE messenger_messages (
            id BIGINT AUTO_INCREMENT NOT NULL, 
            body LONGTEXT NOT NULL, 
            headers LONGTEXT NOT NULL, 
            queue_name VARCHAR(190) NOT NULL, 
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', 
            available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', 
            delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', 
            INDEX IDX_75EA56E0FB7336F0 (queue_name), 
            INDEX IDX_75EA56E0E3BD61CE (available_at), 
            INDEX IDX_75EA56E016BA31DB (delivered_at), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('ALTER TABLE article_medias ADD CONSTRAINT FK_781538017294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A47294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168F8598E2C');
        $this->addSql('ALTER TABLE article_medias DROP FOREIGN KEY FK_781538017294869C');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A47294869C');
        $this->addSql('DROP TABLE article_medias');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE reviews');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}