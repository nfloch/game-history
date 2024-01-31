<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240131220310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE game_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE party_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE player_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE game (id INT NOT NULL, name VARCHAR(255) NOT NULL, min_players SMALLINT DEFAULT NULL, max_players SMALLINT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE party (id INT NOT NULL, game_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_89954EE0E48FD905 ON party (game_id)');
        $this->addSql('CREATE TABLE party_player (party_id INT NOT NULL, player_id INT NOT NULL, PRIMARY KEY(party_id, player_id))');
        $this->addSql('CREATE INDEX IDX_DE6F013C213C1059 ON party_player (party_id)');
        $this->addSql('CREATE INDEX IDX_DE6F013C99E6F5DF ON party_player (player_id)');
        $this->addSql('CREATE TABLE player (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE party ADD CONSTRAINT FK_89954EE0E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE party_player ADD CONSTRAINT FK_DE6F013C213C1059 FOREIGN KEY (party_id) REFERENCES party (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE party_player ADD CONSTRAINT FK_DE6F013C99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE game_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE party_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE player_id_seq CASCADE');
        $this->addSql('ALTER TABLE party DROP CONSTRAINT FK_89954EE0E48FD905');
        $this->addSql('ALTER TABLE party_player DROP CONSTRAINT FK_DE6F013C213C1059');
        $this->addSql('ALTER TABLE party_player DROP CONSTRAINT FK_DE6F013C99E6F5DF');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE party');
        $this->addSql('DROP TABLE party_player');
        $this->addSql('DROP TABLE player');
    }
}
