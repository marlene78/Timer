<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201007120122 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles_user (roles_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_57048B3038C751C4 (roles_id), INDEX IDX_57048B30A76ED395 (user_id), PRIMARY KEY(roles_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_6DC044C5166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_user (group_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A4C98D39FE54D947 (group_id), INDEX IDX_A4C98D39A76ED395 (user_id), PRIMARY KEY(group_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, confirm_password VARCHAR(255) NOT NULL, color VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, projet_id INT NOT NULL, nom VARCHAR(255) NOT NULL, demarre TINYINT(1) NOT NULL, cloture TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, priorite VARCHAR(255) NOT NULL, temps_estime INT NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_527EDB25A76ED395 (user_id), INDEX IDX_527EDB25C18272 (projet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, createur_id INT NOT NULL, nom VARCHAR(255) NOT NULL, etat VARCHAR(255) NOT NULL, date_de_debut DATE NOT NULL, date_de_fin DATE NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_2FB3D0EE73A201E5 (createur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE timer (id INT AUTO_INCREMENT NOT NULL, task_id INT NOT NULL, progress INT NOT NULL, heure INT NOT NULL, minute INT NOT NULL, seconde INT NOT NULL, UNIQUE INDEX UNIQ_6AD0DE1A8DB60186 (task_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, user_id INT NOT NULL, content LONGTEXT NOT NULL, create_at DATETIME NOT NULL, INDEX IDX_B6BD307F166D1F9C (project_id), INDEX IDX_B6BD307FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE roles_user ADD CONSTRAINT FK_57048B3038C751C4 FOREIGN KEY (roles_id) REFERENCES roles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE roles_user ADD CONSTRAINT FK_57048B30A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C5166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE group_user ADD CONSTRAINT FK_A4C98D39FE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_user ADD CONSTRAINT FK_A4C98D39A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25C18272 FOREIGN KEY (projet_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE73A201E5 FOREIGN KEY (createur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE timer ADD CONSTRAINT FK_6AD0DE1A8DB60186 FOREIGN KEY (task_id) REFERENCES task (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE roles_user DROP FOREIGN KEY FK_57048B3038C751C4');
        $this->addSql('ALTER TABLE group_user DROP FOREIGN KEY FK_A4C98D39FE54D947');
        $this->addSql('ALTER TABLE roles_user DROP FOREIGN KEY FK_57048B30A76ED395');
        $this->addSql('ALTER TABLE group_user DROP FOREIGN KEY FK_A4C98D39A76ED395');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25A76ED395');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE73A201E5');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA76ED395');
        $this->addSql('ALTER TABLE timer DROP FOREIGN KEY FK_6AD0DE1A8DB60186');
        $this->addSql('ALTER TABLE `group` DROP FOREIGN KEY FK_6DC044C5166D1F9C');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25C18272');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F166D1F9C');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE roles_user');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE group_user');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE timer');
        $this->addSql('DROP TABLE message');
    }
}
