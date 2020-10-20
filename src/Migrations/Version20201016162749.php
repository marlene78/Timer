<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201016162749 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE token (id INT AUTO_INCREMENT NOT NULL, token VARCHAR(255) NOT NULL, email_invite VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, project INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE token_group (token_id INT NOT NULL, group_id INT NOT NULL, INDEX IDX_CE1E408441DEE7B9 (token_id), INDEX IDX_CE1E4084FE54D947 (group_id), PRIMARY KEY(token_id, group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE token_group ADD CONSTRAINT FK_CE1E408441DEE7B9 FOREIGN KEY (token_id) REFERENCES token (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE token_group ADD CONSTRAINT FK_CE1E4084FE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE token_group DROP FOREIGN KEY FK_CE1E408441DEE7B9');
        $this->addSql('DROP TABLE token');
        $this->addSql('DROP TABLE token_group');
    }
}
