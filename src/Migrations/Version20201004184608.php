<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201004184608 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, text VARCHAR(255) NOT NULL, date DATETIME NOT NULL, INDEX IDX_9474526CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, map_id INT DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_232B318C53C55F64 (map_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, cost INT NOT NULL, img VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE map (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, img VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, date DATETIME NOT NULL, message VARCHAR(255) NOT NULL, status INT NOT NULL, INDEX IDX_BF5476CAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE play (id INT AUTO_INCREMENT NOT NULL, user_a_id INT DEFAULT NULL, user_b_id INT DEFAULT NULL, winner_id INT DEFAULT NULL, loser_id INT DEFAULT NULL, game_id INT DEFAULT NULL, score VARCHAR(255) DEFAULT NULL, elo_winner INT DEFAULT NULL, INDEX IDX_5E89DEBA415F1F91 (user_a_id), INDEX IDX_5E89DEBA53EAB07F (user_b_id), INDEX IDX_5E89DEBA5DFCD4B8 (winner_id), INDEX IDX_5E89DEBA1BCAA5F6 (loser_id), INDEX IDX_5E89DEBAE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE request (id INT AUTO_INCREMENT NOT NULL, sender_id INT DEFAULT NULL, receiver_id INT DEFAULT NULL, status INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_3B978F9FF624B39D (sender_id), INDEX IDX_3B978F9FCD53EDB6 (receiver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stat (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, game_id INT DEFAULT NULL, headshoots INT NOT NULL, nkills INT NOT NULL, kd NUMERIC(3, 2) NOT NULL, INDEX IDX_20B8FF21A76ED395 (user_id), INDEX IDX_20B8FF21E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nick VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, telephone INT NOT NULL, birth DATE NOT NULL, img_user VARCHAR(255) NOT NULL, img_background VARCHAR(255) NOT NULL, level INT NOT NULL, elo INT NOT NULL, streak INT NOT NULL, fakeit_points INT NOT NULL, twitter VARCHAR(255) NOT NULL, youtube VARCHAR(255) NOT NULL, twitch VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE friend (user_id INT NOT NULL, friend_user_id INT NOT NULL, INDEX IDX_55EEAC61A76ED395 (user_id), INDEX IDX_55EEAC6193D1119E (friend_user_id), PRIMARY KEY(user_id, friend_user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C53C55F64 FOREIGN KEY (map_id) REFERENCES map (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE play ADD CONSTRAINT FK_5E89DEBA415F1F91 FOREIGN KEY (user_a_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE play ADD CONSTRAINT FK_5E89DEBA53EAB07F FOREIGN KEY (user_b_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE play ADD CONSTRAINT FK_5E89DEBA5DFCD4B8 FOREIGN KEY (winner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE play ADD CONSTRAINT FK_5E89DEBA1BCAA5F6 FOREIGN KEY (loser_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE play ADD CONSTRAINT FK_5E89DEBAE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9FF624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9FCD53EDB6 FOREIGN KEY (receiver_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE stat ADD CONSTRAINT FK_20B8FF21A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE stat ADD CONSTRAINT FK_20B8FF21E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE friend ADD CONSTRAINT FK_55EEAC61A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE friend ADD CONSTRAINT FK_55EEAC6193D1119E FOREIGN KEY (friend_user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE play DROP FOREIGN KEY FK_5E89DEBAE48FD905');
        $this->addSql('ALTER TABLE stat DROP FOREIGN KEY FK_20B8FF21E48FD905');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C53C55F64');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAA76ED395');
        $this->addSql('ALTER TABLE play DROP FOREIGN KEY FK_5E89DEBA415F1F91');
        $this->addSql('ALTER TABLE play DROP FOREIGN KEY FK_5E89DEBA53EAB07F');
        $this->addSql('ALTER TABLE play DROP FOREIGN KEY FK_5E89DEBA5DFCD4B8');
        $this->addSql('ALTER TABLE play DROP FOREIGN KEY FK_5E89DEBA1BCAA5F6');
        $this->addSql('ALTER TABLE request DROP FOREIGN KEY FK_3B978F9FF624B39D');
        $this->addSql('ALTER TABLE request DROP FOREIGN KEY FK_3B978F9FCD53EDB6');
        $this->addSql('ALTER TABLE stat DROP FOREIGN KEY FK_20B8FF21A76ED395');
        $this->addSql('ALTER TABLE friend DROP FOREIGN KEY FK_55EEAC61A76ED395');
        $this->addSql('ALTER TABLE friend DROP FOREIGN KEY FK_55EEAC6193D1119E');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE map');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE play');
        $this->addSql('DROP TABLE request');
        $this->addSql('DROP TABLE stat');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE friend');
    }
}
