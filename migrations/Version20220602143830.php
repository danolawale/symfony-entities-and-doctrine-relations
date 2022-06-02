<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220602143830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `address` (id INT AUTO_INCREMENT NOT NULL, address_line1 VARCHAR(50) NOT NULL, address_line2 VARCHAR(50) NOT NULL, address_line3 VARCHAR(50) NOT NULL, post_code VARCHAR(10) NOT NULL, country_code VARCHAR(2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users ADD address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9F5B7AF75 FOREIGN KEY (address_id) REFERENCES `address` (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E9F5B7AF75 ON users (address_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9F5B7AF75');
        $this->addSql('DROP TABLE `address`');
        $this->addSql('DROP INDEX IDX_1483A5E9F5B7AF75 ON users');
        $this->addSql('ALTER TABLE users DROP address_id');
    }
}
