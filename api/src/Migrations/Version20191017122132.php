<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\Migrations\Exception\IrreversibleMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191017122132 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE club (id UUID NOT NULL, name VARCHAR(255) NOT NULL, address_city VARCHAR(255) NOT NULL, address_zip_code VARCHAR(255) NOT NULL, address_street VARCHAR(255) NOT NULL, contact_emails JSON NOT NULL, contact_phone_numbers JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN club.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN club.contact_emails IS \'(DC2Type:json_document)\'');
        $this->addSql('COMMENT ON COLUMN club.contact_phone_numbers IS \'(DC2Type:json_document)\'');
    }

    public function down(Schema $schema) : void
    {
        throw new IrreversibleMigration();
    }
}
