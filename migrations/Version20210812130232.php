<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210812130232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `team_member` (id INT AUTO_INCREMENT NOT NULL, hierarchy_id INT DEFAULT NULL, full_name VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, job VARCHAR(255) NOT NULL, domain VARCHAR(255) NOT NULL, school VARCHAR(255) NOT NULL, INDEX IDX_6FFBDA1582A8328 (hierarchy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `team_role` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `team_member` ADD CONSTRAINT FK_6FFBDA1582A8328 FOREIGN KEY (hierarchy_id) REFERENCES `team_role` (id)');
        $this->addSql('ALTER TABLE identity CHANGE gender gender ENUM(\'M\', \'MME\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `team_member` DROP FOREIGN KEY FK_6FFBDA1582A8328');
        $this->addSql('DROP TABLE `team_member`');
        $this->addSql('DROP TABLE `team_role`');
        $this->addSql('ALTER TABLE identity CHANGE gender gender VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
