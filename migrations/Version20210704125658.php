<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210704125658 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE publication_publication_tag (publication_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', publication_tag_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_336925D038B217A7 (publication_id), INDEX IDX_336925D05E39725C (publication_tag_id), PRIMARY KEY(publication_id, publication_tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_user_tag (user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', user_tag_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_8123208A76ED395 (user_id), INDEX IDX_8123208DF80782C (user_tag_id), PRIMARY KEY(user_id, user_tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE publication_publication_tag ADD CONSTRAINT FK_336925D038B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE publication_publication_tag ADD CONSTRAINT FK_336925D05E39725C FOREIGN KEY (publication_tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_user_tag ADD CONSTRAINT FK_8123208A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_user_tag ADD CONSTRAINT FK_8123208DF80782C FOREIGN KEY (user_tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE identity CHANGE gender gender ENUM(\'M\', \'MME\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE publication_publication_tag DROP FOREIGN KEY FK_336925D05E39725C');
        $this->addSql('ALTER TABLE user_user_tag DROP FOREIGN KEY FK_8123208DF80782C');
        $this->addSql('DROP TABLE publication_publication_tag');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE user_user_tag');
        $this->addSql('ALTER TABLE identity CHANGE gender gender VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
