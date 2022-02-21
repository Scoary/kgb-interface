<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220214191300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stashs_missions (stashs_id INT NOT NULL, missions_id INT NOT NULL, INDEX IDX_B8D113E5EE826336 (stashs_id), INDEX IDX_B8D113E517C042CF (missions_id), PRIMARY KEY(stashs_id, missions_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stashs_missions ADD CONSTRAINT FK_B8D113E5EE826336 FOREIGN KEY (stashs_id) REFERENCES stashs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stashs_missions ADD CONSTRAINT FK_B8D113E517C042CF FOREIGN KEY (missions_id) REFERENCES missions (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE stashs_missions');
    }
}
