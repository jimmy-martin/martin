<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241106135408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE INDEX idx_address_city ON address (city)');
        $this->addSql('CREATE INDEX idx_party_date ON party (date)');
        $this->addSql('CREATE INDEX idx_party_type_name ON party_type (name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX idx_party_date');
        $this->addSql('DROP INDEX idx_party_type_name');
        $this->addSql('DROP INDEX idx_address_city');
    }
}
