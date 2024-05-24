<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240129102712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cuisson (id INT AUTO_INCREMENT NOT NULL, cu_libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE etapes ADD cuisson_id INT NOT NULL');
        $this->addSql('ALTER TABLE etapes ADD CONSTRAINT FK_E3443E17A5672358 FOREIGN KEY (cuisson_id) REFERENCES cuisson (id)');
        $this->addSql('CREATE INDEX IDX_E3443E17A5672358 ON etapes (cuisson_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etapes DROP FOREIGN KEY FK_E3443E17A5672358');
        $this->addSql('DROP TABLE cuisson');
        $this->addSql('DROP INDEX IDX_E3443E17A5672358 ON etapes');
        $this->addSql('ALTER TABLE etapes DROP cuisson_id');
    }
}
