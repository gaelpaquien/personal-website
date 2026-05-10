<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260511000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add roles column to users table for admin access control.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users ADD roles JSON NULL');
        $this->addSql("UPDATE users SET roles = '[]' WHERE roles IS NULL");
        $this->addSql('ALTER TABLE users MODIFY roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users DROP COLUMN roles');
    }
}
