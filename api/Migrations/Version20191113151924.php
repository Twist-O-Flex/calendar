<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\Migrations\Exception\IrreversibleMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191113151924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE INDEX name_idx ON club USING gin(to_tsvector(\'french\', name))');
        $this->addSql('CREATE INDEX address_city_idx ON club USING gin(to_tsvector(\'french\', address_city))');
        $this->addSql('CREATE INDEX address_zip_code_idx ON club USING gin(to_tsvector(\'french\', address_zip_code))');
        $this->addSql('CREATE INDEX address_zip_code_city_idx ON club USING gin(to_tsvector(\'french\', address_zip_code), to_tsvector(\'french\', address_city))');
    }

    public function down(Schema $schema): void
    {
        throw new IrreversibleMigration();
    }
}
