<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240129102335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etapes (id INT AUTO_INCREMENT NOT NULL, et_numero INT NOT NULL, et_description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quantites ADD etapes_id INT NOT NULL, ADD produits_id INT NOT NULL');
        $this->addSql('ALTER TABLE quantites ADD CONSTRAINT FK_325CF4D94F5CEED2 FOREIGN KEY (etapes_id) REFERENCES etapes (id)');
        $this->addSql('ALTER TABLE quantites ADD CONSTRAINT FK_325CF4D9CD11A2CF FOREIGN KEY (produits_id) REFERENCES produits (id)');
        $this->addSql('CREATE INDEX IDX_325CF4D94F5CEED2 ON quantites (etapes_id)');
        $this->addSql('CREATE INDEX IDX_325CF4D9CD11A2CF ON quantites (produits_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quantites DROP FOREIGN KEY FK_325CF4D94F5CEED2');
        $this->addSql('DROP TABLE etapes');
        $this->addSql('ALTER TABLE quantites DROP FOREIGN KEY FK_325CF4D9CD11A2CF');
        $this->addSql('DROP INDEX IDX_325CF4D94F5CEED2 ON quantites');
        $this->addSql('DROP INDEX IDX_325CF4D9CD11A2CF ON quantites');
        $this->addSql('ALTER TABLE quantites DROP etapes_id, DROP produits_id');
    }
}
