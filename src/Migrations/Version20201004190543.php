<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201004190543 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item CHANGE date date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE telephone telephone INT NOT NULL, CHANGE img_background img_background VARCHAR(255) NOT NULL, CHANGE level level INT NOT NULL, CHANGE elo elo INT NOT NULL, CHANGE streak streak INT NOT NULL, CHANGE fakeit_points fakeit_points INT NOT NULL, CHANGE twitter twitter VARCHAR(255) NOT NULL, CHANGE youtube youtube VARCHAR(255) NOT NULL, CHANGE twitch twitch VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item CHANGE date date DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE user CHANGE telephone telephone INT DEFAULT NULL, CHANGE img_background img_background VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE level level INT DEFAULT 1, CHANGE elo elo INT DEFAULT 100, CHANGE streak streak INT DEFAULT 0, CHANGE fakeit_points fakeit_points INT DEFAULT 0, CHANGE twitter twitter VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE youtube youtube VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE twitch twitch VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
