<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250612175601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add initial projects data.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO projects (id, article_id, title_fr, title_en, sort_order) VALUES
        (1, 11, 'Plany', 'Plany', 1),
        (2, 9, 'gaelpaquien.com', 'gaelpaquien.com', 2),
        (3, 10, 'VPS Auto-géré', 'Self-Managed VPS', 3),
        (4, 8, 'RG Clean Car', 'RG Clean Car', 4),
        (5, 7, 'ToDo & Co', 'ToDo & Co', 5),
        (6, 6, 'BileMo API', 'BileMo API', 6)
    ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM projects WHERE id IN (1, 2, 3, 4, 5, 6)');
    }
}
