<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220602165916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE interest_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_interest_groups (user_id INT NOT NULL, interest_group_id INT NOT NULL, INDEX IDX_31963CA3A76ED395 (user_id), INDEX IDX_31963CA382874C87 (interest_group_id), PRIMARY KEY(user_id, interest_group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_interest_groups ADD CONSTRAINT FK_31963CA3A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_interest_groups ADD CONSTRAINT FK_31963CA382874C87 FOREIGN KEY (interest_group_id) REFERENCES interest_group (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_interest_groups DROP FOREIGN KEY FK_31963CA382874C87');
        $this->addSql('DROP TABLE interest_group');
        $this->addSql('DROP TABLE users_interest_groups');
    }
}
