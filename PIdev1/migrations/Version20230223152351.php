<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230223152351 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualite ADD url_image VARCHAR(255) NOT NULL');

        $this->addSql('ALTER TABLE commentaire ADD actualite_id INT DEFAULT NULL, CHANGE dateCommentaire date_commentaire DATE NOT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA2843073 FOREIGN KEY (actualite_id) REFERENCES actualite (id)');
        $this->addSql('CREATE INDEX IDX_67F068BCA2843073 ON commentaire (actualite_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA2843073');
        $this->addSql('DROP INDEX IDX_67F068BCA2843073 ON commentaire');
        $this->addSql('ALTER TABLE commentaire DROP actualite_id, CHANGE date_commentaire dateCommentaire DATE NOT NULL');
    }
}
