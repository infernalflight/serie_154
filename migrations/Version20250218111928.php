<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250218111928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE serie CHANGE vote vote NUMERIC(10, 0) NOT NULL, CHANGE last_air_date last_air_date DATE DEFAULT NULL, CHANGE backdrop backdrop VARCHAR(255) DEFAULT NULL, CHANGE poster poster VARCHAR(255) DEFAULT NULL, CHANGE tmdb_id tmdb_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE serie CHANGE vote vote NUMERIC(3, 1) NOT NULL, CHANGE last_air_date last_air_date DATE NOT NULL, CHANGE backdrop backdrop VARCHAR(255) NOT NULL, CHANGE poster poster VARCHAR(255) NOT NULL, CHANGE tmdb_id tmdb_id INT NOT NULL');
    }
}
