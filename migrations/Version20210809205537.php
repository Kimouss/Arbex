<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210809205537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_affiliation_group_tag (user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', affiliation_group_tag_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_CA82592BA76ED395 (user_id), INDEX IDX_CA82592B2643D821 (affiliation_group_tag_id), PRIMARY KEY(user_id, affiliation_group_tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_availability_tag (user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', availability_tag_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_B1F82E24A76ED395 (user_id), INDEX IDX_B1F82E24CBA737CD (availability_tag_id), PRIMARY KEY(user_id, availability_tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_training_stage_tag (user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', training_stage_tag_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_C3B10030A76ED395 (user_id), INDEX IDX_C3B100303E48EE07 (training_stage_tag_id), PRIMARY KEY(user_id, training_stage_tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_affiliation_group_tag ADD CONSTRAINT FK_CA82592BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_affiliation_group_tag ADD CONSTRAINT FK_CA82592B2643D821 FOREIGN KEY (affiliation_group_tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_availability_tag ADD CONSTRAINT FK_B1F82E24A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_availability_tag ADD CONSTRAINT FK_B1F82E24CBA737CD FOREIGN KEY (availability_tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_training_stage_tag ADD CONSTRAINT FK_C3B10030A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_training_stage_tag ADD CONSTRAINT FK_C3B100303E48EE07 FOREIGN KEY (training_stage_tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE identity CHANGE gender gender ENUM(\'M\', \'MME\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_affiliation_group_tag');
        $this->addSql('DROP TABLE user_availability_tag');
        $this->addSql('DROP TABLE user_training_stage_tag');
        $this->addSql('ALTER TABLE identity CHANGE gender gender VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
