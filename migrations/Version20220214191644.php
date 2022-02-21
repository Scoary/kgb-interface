<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220214191644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agents_skills (agents_id INT NOT NULL, skills_id INT NOT NULL, INDEX IDX_5088E440709770DC (agents_id), INDEX IDX_5088E4407FF61858 (skills_id), PRIMARY KEY(agents_id, skills_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agents_missions (agents_id INT NOT NULL, missions_id INT NOT NULL, INDEX IDX_B804F404709770DC (agents_id), INDEX IDX_B804F40417C042CF (missions_id), PRIMARY KEY(agents_id, missions_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contacts_missions (contacts_id INT NOT NULL, missions_id INT NOT NULL, INDEX IDX_21A1513B719FB48E (contacts_id), INDEX IDX_21A1513B17C042CF (missions_id), PRIMARY KEY(contacts_id, missions_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE targets_missions (targets_id INT NOT NULL, missions_id INT NOT NULL, INDEX IDX_7BE4006C43B5F743 (targets_id), INDEX IDX_7BE4006C17C042CF (missions_id), PRIMARY KEY(targets_id, missions_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agents_skills ADD CONSTRAINT FK_5088E440709770DC FOREIGN KEY (agents_id) REFERENCES agents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agents_skills ADD CONSTRAINT FK_5088E4407FF61858 FOREIGN KEY (skills_id) REFERENCES skills (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agents_missions ADD CONSTRAINT FK_B804F404709770DC FOREIGN KEY (agents_id) REFERENCES agents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agents_missions ADD CONSTRAINT FK_B804F40417C042CF FOREIGN KEY (missions_id) REFERENCES missions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contacts_missions ADD CONSTRAINT FK_21A1513B719FB48E FOREIGN KEY (contacts_id) REFERENCES contacts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contacts_missions ADD CONSTRAINT FK_21A1513B17C042CF FOREIGN KEY (missions_id) REFERENCES missions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE targets_missions ADD CONSTRAINT FK_7BE4006C43B5F743 FOREIGN KEY (targets_id) REFERENCES targets (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE targets_missions ADD CONSTRAINT FK_7BE4006C17C042CF FOREIGN KEY (missions_id) REFERENCES missions (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE agents_skills');
        $this->addSql('DROP TABLE agents_missions');
        $this->addSql('DROP TABLE contacts_missions');
        $this->addSql('DROP TABLE targets_missions');
    }
}
