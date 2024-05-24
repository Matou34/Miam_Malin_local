<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240129104304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recettes_utilisateurs (recettes_id INT NOT NULL, utilisateurs_id INT NOT NULL, INDEX IDX_A56045B23E2ED6D6 (recettes_id), INDEX IDX_A56045B21E969C5 (utilisateurs_id), PRIMARY KEY(recettes_id, utilisateurs_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, ro_libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateurs (id INT AUTO_INCREMENT NOT NULL, roles_id INT NOT NULL, ut_surnom VARCHAR(255) NOT NULL, ut_prenom VARCHAR(255) NOT NULL, ut_nom VARCHAR(255) NOT NULL, ut_email VARCHAR(255) NOT NULL, ut_password VARCHAR(255) NOT NULL, INDEX IDX_497B315E38C751C4 (roles_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recettes_utilisateurs ADD CONSTRAINT FK_A56045B23E2ED6D6 FOREIGN KEY (recettes_id) REFERENCES recettes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recettes_utilisateurs ADD CONSTRAINT FK_A56045B21E969C5 FOREIGN KEY (utilisateurs_id) REFERENCES utilisateurs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateurs ADD CONSTRAINT FK_497B315E38C751C4 FOREIGN KEY (roles_id) REFERENCES roles (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recettes_utilisateurs DROP FOREIGN KEY FK_A56045B23E2ED6D6');
        $this->addSql('ALTER TABLE recettes_utilisateurs DROP FOREIGN KEY FK_A56045B21E969C5');
        $this->addSql('ALTER TABLE utilisateurs DROP FOREIGN KEY FK_497B315E38C751C4');
        $this->addSql('DROP TABLE recettes_utilisateurs');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE utilisateurs');
    }
}
