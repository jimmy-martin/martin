<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241108185447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id SERIAL NOT NULL, street VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_address_city ON address (lower(city))');
        $this->addSql('CREATE TABLE interest (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6C3E1A675E237E06 ON interest (name)');
        $this->addSql('CREATE TABLE party (id SERIAL NOT NULL, type_id INT DEFAULT NULL, address_id INT DEFAULT NULL, created_by_id INT NOT NULL, name VARCHAR(255) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, max_participants INT NOT NULL, is_free BOOLEAN NOT NULL, price DOUBLE PRECISION DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_89954EE0C54C8C93 ON party (type_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_89954EE0F5B7AF75 ON party (address_id)');
        $this->addSql('CREATE INDEX IDX_89954EE0B03A8386 ON party (created_by_id)');
        $this->addSql('CREATE INDEX idx_party_date ON party (date)');
        $this->addSql('COMMENT ON COLUMN party.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE party_user (party_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(party_id, user_id))');
        $this->addSql('CREATE INDEX IDX_9230179A213C1059 ON party_user (party_id)');
        $this->addSql('CREATE INDEX IDX_9230179AA76ED395 ON party_user (user_id)');
        $this->addSql('CREATE TABLE party_type (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_937D96FA5E237E06 ON party_type (name)');
        $this->addSql('CREATE INDEX idx_party_type_name ON party_type (lower(name))');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, address_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, age INT DEFAULT NULL, average_rating DOUBLE PRECISION DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F5B7AF75 ON "user" (address_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('CREATE TABLE user_interest (user_id INT NOT NULL, interest_id INT NOT NULL, PRIMARY KEY(user_id, interest_id))');
        $this->addSql('CREATE INDEX IDX_8CB3FE67A76ED395 ON user_interest (user_id)');
        $this->addSql('CREATE INDEX IDX_8CB3FE675A95FF89 ON user_interest (interest_id)');
        $this->addSql('ALTER TABLE party ADD CONSTRAINT FK_89954EE0C54C8C93 FOREIGN KEY (type_id) REFERENCES party_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE party ADD CONSTRAINT FK_89954EE0F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE party ADD CONSTRAINT FK_89954EE0B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE party_user ADD CONSTRAINT FK_9230179A213C1059 FOREIGN KEY (party_id) REFERENCES party (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE party_user ADD CONSTRAINT FK_9230179AA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_interest ADD CONSTRAINT FK_8CB3FE67A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_interest ADD CONSTRAINT FK_8CB3FE675A95FF89 FOREIGN KEY (interest_id) REFERENCES interest (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE party DROP CONSTRAINT FK_89954EE0C54C8C93');
        $this->addSql('ALTER TABLE party DROP CONSTRAINT FK_89954EE0F5B7AF75');
        $this->addSql('ALTER TABLE party DROP CONSTRAINT FK_89954EE0B03A8386');
        $this->addSql('ALTER TABLE party_user DROP CONSTRAINT FK_9230179A213C1059');
        $this->addSql('ALTER TABLE party_user DROP CONSTRAINT FK_9230179AA76ED395');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649F5B7AF75');
        $this->addSql('ALTER TABLE user_interest DROP CONSTRAINT FK_8CB3FE67A76ED395');
        $this->addSql('ALTER TABLE user_interest DROP CONSTRAINT FK_8CB3FE675A95FF89');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE interest');
        $this->addSql('DROP TABLE party');
        $this->addSql('DROP TABLE party_user');
        $this->addSql('DROP TABLE party_type');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_interest');
    }
}
