<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\Migrations\Exception\IrreversibleMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191114140846 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE competition ADD category VARCHAR(255) CHECK(category IN (\'tournament\', \'championship\', \'grand_prix\', \'challenge\', \'national\', \'interclub\')) NOT NULL');
        $this->addSql('ALTER TABLE competition DROP type');
        $this->addSql('COMMENT ON COLUMN competition.category IS \'(DC2Type:CompetitionCategory)\'');
    }

    public function down(Schema $schema): void
    {
        throw new IrreversibleMigration();
    }
}
