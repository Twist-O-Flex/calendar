<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\Migrations\Exception\IrreversibleMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191118095532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE club ADD address_city_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE club ADD address_city_zip_code VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE club DROP address_city');
        $this->addSql('ALTER TABLE club DROP address_zip_code');
        $this->addSql('CREATE INDEX name_idx ON club (name)');
        $this->addSql('CREATE INDEX address_city_name_idx ON club (address_city_name)');
        $this->addSql('CREATE INDEX address_city_zip_code_idx ON club (address_city_zip_code)');
        $this->addSql('CREATE INDEX address_city_zip_code_city_name_idx ON club (address_city_zip_code, address_city_name)');
        $this->addSql('ALTER INDEX idx_b50a2cb161190a32 RENAME TO club_idx');
    }

    public function down(Schema $schema): void
    {
        throw new IrreversibleMigration();
    }
}
