<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201006184256 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE token DROP FOREIGN KEY FK_5F37A13B166D1F9C');
        $this->addSql('DROP INDEX IDX_5F37A13B166D1F9C ON token');
        $this->addSql('ALTER TABLE token ADD project INT NOT NULL, DROP project_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE token ADD project_id INT DEFAULT NULL, DROP project');
        $this->addSql('ALTER TABLE token ADD CONSTRAINT FK_5F37A13B166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('CREATE INDEX IDX_5F37A13B166D1F9C ON token (project_id)');
    }
}
