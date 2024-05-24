<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240128001919 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quantites ADD unites_id INT NOT NULL');
        $this->addSql('ALTER TABLE quantites ADD CONSTRAINT FK_325CF4D9A6998D31 FOREIGN KEY (unites_id) REFERENCES unites (id)');
        $this->addSql('CREATE INDEX IDX_325CF4D9A6998D31 ON quantites (unites_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quantites DROP FOREIGN KEY FK_325CF4D9A6998D31');
        $this->addSql('DROP INDEX IDX_325CF4D9A6998D31 ON quantites');
        $this->addSql('ALTER TABLE quantites DROP unites_id');
    }
}
