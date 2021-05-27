<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210527145655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE identity (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, gender ENUM(\'M\', \'MME\'), birthdate DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, menu_id INT DEFAULT NULL, route VARCHAR(255) DEFAULT NULL, label VARCHAR(255) NOT NULL, icon VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) NOT NULL, is_uri TINYINT(1) NOT NULL, INDEX IDX_7D053A93CCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', identity_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649FF3ED4A8 (identity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649FF3ED4A8 FOREIGN KEY (identity_id) REFERENCES identity (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649FF3ED4A8');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93CCD7E912');
        $this->addSql('DROP TABLE identity');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE user');
    }
}
