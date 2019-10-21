<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\Migrations\Exception\IrreversibleMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191021142826 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE competition (id UUID NOT NULL, club_id UUID DEFAULT NULL, type VARCHAR(255) NOT NULL, formation VARCHAR(255) NOT NULL, start_date DATE NOT NULL, duration INT NOT NULL, quotation VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B50A2CB161190A32 ON competition (club_id)');
        $this->addSql('COMMENT ON COLUMN competition.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN competition.club_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN competition.start_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB161190A32 FOREIGN KEY (club_id) REFERENCES club (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        throw new IrreversibleMigration();
    }
}
