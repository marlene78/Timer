<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200915084646 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `group` ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C5166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('CREATE INDEX IDX_6DC044C5166D1F9C ON `group` (project_id)');
        $this->addSql('ALTER TABLE group_user ADD PRIMARY KEY (group_id, user_id)');
        $this->addSql('ALTER TABLE group_user ADD CONSTRAINT FK_A4C98D39FE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_user ADD CONSTRAINT FK_A4C98D39A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_A4C98D39FE54D947 ON group_user (group_id)');
        $this->addSql('CREATE INDEX IDX_A4C98D39A76ED395 ON group_user (user_id)');
        $this->addSql('ALTER TABLE user ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE task ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25C18272 FOREIGN KEY (projet_id) REFERENCES project (id)');
        $this->addSql('CREATE INDEX IDX_527EDB25A76ED395 ON task (user_id)');
        $this->addSql('CREATE INDEX IDX_527EDB25C18272 ON task (projet_id)');
        $this->addSql('ALTER TABLE project ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE73A201E5 FOREIGN KEY (createur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE73A201E5 ON project (createur_id)');
        $this->addSql('ALTER TABLE timer ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE timer ADD CONSTRAINT FK_6AD0DE1A8DB60186 FOREIGN KEY (task_id) REFERENCES task (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6AD0DE1A8DB60186 ON timer (task_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `group` MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE `group` DROP FOREIGN KEY FK_6DC044C5166D1F9C');
        $this->addSql('DROP INDEX IDX_6DC044C5166D1F9C ON `group`');
        $this->addSql('ALTER TABLE `group` DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE group_user DROP FOREIGN KEY FK_A4C98D39FE54D947');
        $this->addSql('ALTER TABLE group_user DROP FOREIGN KEY FK_A4C98D39A76ED395');
        $this->addSql('DROP INDEX IDX_A4C98D39FE54D947 ON group_user');
        $this->addSql('DROP INDEX IDX_A4C98D39A76ED395 ON group_user');
        $this->addSql('ALTER TABLE group_user DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE project MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE73A201E5');
        $this->addSql('DROP INDEX IDX_2FB3D0EE73A201E5 ON project');
        $this->addSql('ALTER TABLE project DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE task MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25A76ED395');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25C18272');
        $this->addSql('DROP INDEX IDX_527EDB25A76ED395 ON task');
        $this->addSql('DROP INDEX IDX_527EDB25C18272 ON task');
        $this->addSql('ALTER TABLE task DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE timer MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE timer DROP FOREIGN KEY FK_6AD0DE1A8DB60186');
        $this->addSql('DROP INDEX UNIQ_6AD0DE1A8DB60186 ON timer');
        $this->addSql('ALTER TABLE timer DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE user MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE user DROP PRIMARY KEY');
    }
}
