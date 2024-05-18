<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240330084222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recettes_tags (recettes_id INT NOT NULL, tags_id INT NOT NULL, INDEX IDX_BE03A9E63E2ED6D6 (recettes_id), INDEX IDX_BE03A9E68D7B4FB4 (tags_id), PRIMARY KEY(recettes_id, tags_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recettes_utilisateurs (recettes_id INT NOT NULL, utilisateurs_id INT NOT NULL, INDEX IDX_A56045B23E2ED6D6 (recettes_id), INDEX IDX_A56045B21E969C5 (utilisateurs_id), PRIMARY KEY(recettes_id, utilisateurs_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recettes_tags ADD CONSTRAINT FK_BE03A9E63E2ED6D6 FOREIGN KEY (recettes_id) REFERENCES recettes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recettes_tags ADD CONSTRAINT FK_BE03A9E68D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recettes_utilisateurs ADD CONSTRAINT FK_A56045B23E2ED6D6 FOREIGN KEY (recettes_id) REFERENCES recettes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recettes_utilisateurs ADD CONSTRAINT FK_A56045B21E969C5 FOREIGN KEY (utilisateurs_id) REFERENCES utilisateurs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recettes DROP etapes, DROP recette_tags, DROP recettes_utilisateurs');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recettes_tags DROP FOREIGN KEY FK_BE03A9E63E2ED6D6');
        $this->addSql('ALTER TABLE recettes_tags DROP FOREIGN KEY FK_BE03A9E68D7B4FB4');
        $this->addSql('ALTER TABLE recettes_utilisateurs DROP FOREIGN KEY FK_A56045B23E2ED6D6');
        $this->addSql('ALTER TABLE recettes_utilisateurs DROP FOREIGN KEY FK_A56045B21E969C5');
        $this->addSql('DROP TABLE recettes_tags');
        $this->addSql('DROP TABLE recettes_utilisateurs');
        $this->addSql('ALTER TABLE recettes ADD etapes VARCHAR(255) DEFAULT NULL, ADD recette_tags VARCHAR(255) DEFAULT NULL, ADD recettes_utilisateurs VARCHAR(255) DEFAULT NULL');
    }
}
