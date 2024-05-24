<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240405205225 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quantites CHANGE qu_quantites qu_quantites INT NOT NULL');
        $this->addSql('ALTER TABLE recettes CHANGE re_commentaires re_commentaires VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quantites CHANGE qu_quantites qu_quantites INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recettes CHANGE re_commentaires re_commentaires TEXT DEFAULT NULL');
    }
}
