<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240402101426 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quantites CHANGE unites_id unites_id INT DEFAULT NULL, CHANGE etapes_id etapes_id INT DEFAULT NULL, CHANGE produits_id produits_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quantites CHANGE unites_id unites_id INT NOT NULL, CHANGE etapes_id etapes_id INT NOT NULL, CHANGE produits_id produits_id INT NOT NULL');
    }
}
