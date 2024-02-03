<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240202161902 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE score DROP CONSTRAINT fk_32993751296cd8ae');
        $this->addSql('DROP INDEX idx_32993751296cd8ae');
        $this->addSql('ALTER TABLE score DROP team_id');
        $this->addSql('ALTER TABLE team ADD score_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F12EB0A51 FOREIGN KEY (score_id) REFERENCES score (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C4E0A61F12EB0A51 ON team (score_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE team DROP CONSTRAINT FK_C4E0A61F12EB0A51');
        $this->addSql('DROP INDEX UNIQ_C4E0A61F12EB0A51');
        $this->addSql('ALTER TABLE team DROP score_id');
        $this->addSql('ALTER TABLE score ADD team_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT fk_32993751296cd8ae FOREIGN KEY (team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_32993751296cd8ae ON score (team_id)');
    }
}
