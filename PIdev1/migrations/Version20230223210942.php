<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230223210942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nb_like ADD commentaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE nb_like ADD CONSTRAINT FK_34BD8122BA9CD190 FOREIGN KEY (commentaire_id) REFERENCES commentaire (id)');
        $this->addSql('CREATE INDEX IDX_34BD8122BA9CD190 ON nb_like (commentaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nb_like DROP FOREIGN KEY FK_34BD8122BA9CD190');
        $this->addSql('DROP INDEX IDX_34BD8122BA9CD190 ON nb_like');
        $this->addSql('ALTER TABLE nb_like DROP commentaire_id');
    }
}
