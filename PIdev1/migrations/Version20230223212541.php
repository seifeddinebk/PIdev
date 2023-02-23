<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230223212541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA2843073');
        $this->addSql('DROP INDEX IDX_67F068BCA2843073 ON commentaire');
        $this->addSql('ALTER TABLE commentaire CHANGE actualiteId actualite_id INT DEFAULT NULL, CHANGE idUser id_user INT NOT NULL, CHANGE dateCommentaire date_commentaire DATE NOT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA2843073 FOREIGN KEY (actualite_id) REFERENCES actualite (id)');
        $this->addSql('CREATE INDEX IDX_67F068BCA2843073 ON commentaire (actualite_id)');
        $this->addSql('ALTER TABLE nb_like DROP FOREIGN KEY FK_34BD8122BA9CD190');
        $this->addSql('DROP INDEX IDX_34BD8122BA9CD190 ON nb_like');
        $this->addSql('ALTER TABLE nb_like ADD id_user INT NOT NULL, CHANGE commentaireId commentaire_id INT DEFAULT NULL, CHANGE idUser id_commentaire INT NOT NULL');
        $this->addSql('ALTER TABLE nb_like ADD CONSTRAINT FK_34BD8122BA9CD190 FOREIGN KEY (commentaire_id) REFERENCES commentaire (id)');
        $this->addSql('CREATE INDEX IDX_34BD8122BA9CD190 ON nb_like (commentaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA2843073');
        $this->addSql('DROP INDEX IDX_67F068BCA2843073 ON commentaire');
        $this->addSql('ALTER TABLE commentaire CHANGE id_user idUser INT NOT NULL, CHANGE date_commentaire dateCommentaire DATE NOT NULL, CHANGE actualite_id actualiteId INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA2843073 FOREIGN KEY (actualiteId) REFERENCES actualite (id)');
        $this->addSql('CREATE INDEX IDX_67F068BCA2843073 ON commentaire (actualiteId)');
        $this->addSql('ALTER TABLE nb_like DROP FOREIGN KEY FK_34BD8122BA9CD190');
        $this->addSql('DROP INDEX IDX_34BD8122BA9CD190 ON nb_like');
        $this->addSql('ALTER TABLE nb_like ADD idUser INT NOT NULL, DROP id_commentaire, DROP id_user, CHANGE commentaire_id commentaireId INT DEFAULT NULL');
        $this->addSql('ALTER TABLE nb_like ADD CONSTRAINT FK_34BD8122BA9CD190 FOREIGN KEY (commentaireId) REFERENCES commentaire (id)');
        $this->addSql('CREATE INDEX IDX_34BD8122BA9CD190 ON nb_like (commentaireId)');
    }
}
