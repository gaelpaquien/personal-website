<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260510000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Drop EN columns and rename FR columns to simple names across articles, article_medias, projects, reviews.';
    }

    public function up(Schema $schema): void
    {
        // articles: drop EN, rename FR, flatten JSON tags & resource_links
        $this->addSql("UPDATE articles SET tags = JSON_EXTRACT(tags, '$.fr')");
        $this->addSql("UPDATE articles SET resource_links = JSON_EXTRACT(resource_links, '$.fr') WHERE resource_links IS NOT NULL");
        $this->addSql('ALTER TABLE articles DROP COLUMN title_en, DROP COLUMN slug_en, DROP COLUMN short_description_en, DROP COLUMN content_en');
        $this->addSql('ALTER TABLE articles CHANGE title_fr title VARCHAR(255) NOT NULL, CHANGE slug_fr slug VARCHAR(255) NOT NULL, CHANGE short_description_fr short_description LONGTEXT NOT NULL, CHANGE content_fr content LONGTEXT NOT NULL');

        // article_medias: drop alt_text_en, rename alt_text_fr -> alt_text
        $this->addSql('ALTER TABLE article_medias DROP COLUMN alt_text_en');
        $this->addSql('ALTER TABLE article_medias CHANGE alt_text_fr alt_text VARCHAR(255) DEFAULT NULL');

        // projects: drop title_en, rename title_fr -> title
        $this->addSql('ALTER TABLE projects DROP COLUMN title_en');
        $this->addSql('ALTER TABLE projects CHANGE title_fr title VARCHAR(255) NOT NULL');

        // reviews: drop author_job_en & content_en, rename author_job_fr -> author_job, content_fr -> content
        $this->addSql('ALTER TABLE reviews DROP COLUMN author_job_en, DROP COLUMN content_en');
        $this->addSql('ALTER TABLE reviews CHANGE author_job_fr author_job VARCHAR(255) NOT NULL, CHANGE content_fr content LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // reviews
        $this->addSql('ALTER TABLE reviews CHANGE author_job author_job_fr VARCHAR(255) NOT NULL, CHANGE content content_fr LONGTEXT NOT NULL');
        $this->addSql("ALTER TABLE reviews ADD author_job_en VARCHAR(255) NOT NULL DEFAULT '', ADD content_en LONGTEXT NOT NULL");

        // projects
        $this->addSql('ALTER TABLE projects CHANGE title title_fr VARCHAR(255) NOT NULL');
        $this->addSql("ALTER TABLE projects ADD title_en VARCHAR(255) NOT NULL DEFAULT ''");

        // article_medias
        $this->addSql('ALTER TABLE article_medias CHANGE alt_text alt_text_fr VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE article_medias ADD alt_text_en VARCHAR(255) DEFAULT NULL');

        // articles
        $this->addSql('ALTER TABLE articles CHANGE title title_fr VARCHAR(255) NOT NULL, CHANGE slug slug_fr VARCHAR(255) NOT NULL, CHANGE short_description short_description_fr LONGTEXT NOT NULL, CHANGE content content_fr LONGTEXT NOT NULL');
        $this->addSql("ALTER TABLE articles ADD title_en VARCHAR(255) NOT NULL DEFAULT '', ADD slug_en VARCHAR(255) NOT NULL DEFAULT '', ADD short_description_en LONGTEXT NOT NULL, ADD content_en LONGTEXT NOT NULL");
        $this->addSql("UPDATE articles SET tags = JSON_OBJECT('fr', tags, 'en', JSON_ARRAY())");
        $this->addSql("UPDATE articles SET resource_links = JSON_OBJECT('fr', resource_links, 'en', JSON_ARRAY()) WHERE resource_links IS NOT NULL");
    }
}
