<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220214184824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE missions (id INT AUTO_INCREMENT NOT NULL, skill_id INT NOT NULL, mission_type_id INT NOT NULL, status_mission_id INT NOT NULL, country_id INT NOT NULL, title VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, code_name VARCHAR(30) NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, INDEX IDX_34F1D47E5585C142 (skill_id), INDEX IDX_34F1D47E547018DE (mission_type_id), INDEX IDX_34F1D47EBF3F4A16 (status_mission_id), INDEX IDX_34F1D47EF92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE missions ADD CONSTRAINT FK_34F1D47E5585C142 FOREIGN KEY (skill_id) REFERENCES skills (id)');
        $this->addSql('ALTER TABLE missions ADD CONSTRAINT FK_34F1D47E547018DE FOREIGN KEY (mission_type_id) REFERENCES mission_types (id)');
        $this->addSql('ALTER TABLE missions ADD CONSTRAINT FK_34F1D47EBF3F4A16 FOREIGN KEY (status_mission_id) REFERENCES status_missions (id)');
        $this->addSql('ALTER TABLE missions ADD CONSTRAINT FK_34F1D47EF92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE missions');
    }
}
