<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\Migrations\Exception\IrreversibleMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191114151222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE INDEX type_idx ON competition (type)');
        $this->addSql('CREATE INDEX formation_idx ON competition (formation)');
        $this->addSql('CREATE INDEX quotation_idx ON competition (quotation)');
        $this->addSql('CREATE INDEX quotation_formation_idx ON competition (quotation, formation)');
        $this->addSql('CREATE INDEX type_formation_idx ON competition (type, formation)');
        $this->addSql('CREATE INDEX type_formation_quotation_idx ON competition (type, formation, quotation)');
        $this->addSql('CREATE INDEX type_formation_club_idx ON competition (type, formation, club_id)');
        $this->addSql('CREATE INDEX type_formation_quotation_club_idx ON competition (type, formation, quotation, club_id)');
    }

    public function down(Schema $schema): void
    {
        throw new IrreversibleMigration();
    }
}
