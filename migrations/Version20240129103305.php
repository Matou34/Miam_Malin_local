<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240129103305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recettes (id INT AUTO_INCREMENT NOT NULL, regions_id INT NOT NULL, re_libelle VARCHAR(255) NOT NULL, re_image LONGTEXT DEFAULT NULL, re_nb_personnes INT NOT NULL, re_temps INT DEFAULT NULL, re_kcal INT DEFAULT NULL, re_commentaires VARCHAR(255) DEFAULT NULL, INDEX IDX_EB48E72CFCE83E5F (regions_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE regions (id INT AUTO_INCREMENT NOT NULL, reg_libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recettes ADD CONSTRAINT FK_EB48E72CFCE83E5F FOREIGN KEY (regions_id) REFERENCES regions (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recettes DROP FOREIGN KEY FK_EB48E72CFCE83E5F');
        $this->addSql('DROP TABLE recettes');
        $this->addSql('DROP TABLE regions');
    }
}
