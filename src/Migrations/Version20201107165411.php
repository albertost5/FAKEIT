<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201107165411 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE game');
        $this->addSql('ALTER TABLE play ADD map_id INT DEFAULT NULL, ADD user_a_kills INT NOT NULL, ADD user_b_kills INT NOT NULL, ADD date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE play ADD CONSTRAINT FK_5E89DEBA53C55F64 FOREIGN KEY (map_id) REFERENCES map (id)');
        $this->addSql('CREATE INDEX IDX_5E89DEBA53C55F64 ON play (map_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, map_id INT DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_232B318C53C55F64 (map_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C53C55F64 FOREIGN KEY (map_id) REFERENCES map (id)');
        $this->addSql('ALTER TABLE play DROP FOREIGN KEY FK_5E89DEBA53C55F64');
        $this->addSql('DROP INDEX IDX_5E89DEBA53C55F64 ON play');
        $this->addSql('ALTER TABLE play DROP map_id, DROP user_a_kills, DROP user_b_kills, DROP date');
    }
}
