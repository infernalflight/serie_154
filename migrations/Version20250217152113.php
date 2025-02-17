<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250217152113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE serie CHANGE vote vote NUMERIC(10, 0) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AA3A93345E237E06A4265897 ON serie (name, first_air_date)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_AA3A93345E237E06A4265897 ON serie');
        $this->addSql('ALTER TABLE serie CHANGE vote vote NUMERIC(3, 1) NOT NULL');
    }
}
