<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240222105353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2BCF5E72D');
        $this->addSql('CREATE TABLE disponibilite (id INT AUTO_INCREMENT NOT NULL, etat TINYINT(1) NOT NULL, date_disponibilite DATE NOT NULL, localisation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livraison (id INT AUTO_INCREMENT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, entrprise VARCHAR(255) NOT NULL, frais INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE categorie_service');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DF347EFB');
        $this->addSql('DROP INDEX IDX_6EEAA67DF347EFB ON commande');
        $this->addSql('ALTER TABLE commande ADD etat TINYINT(1) NOT NULL, DROP produit_id, DROP ville, CHANGE date_cmd date DATE NOT NULL');
        $this->addSql('ALTER TABLE messagerie ADD sender_id INT NOT NULL, ADD recepient_id INT NOT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD is_read TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE messagerie ADD CONSTRAINT FK_14E8F60CF624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE messagerie ADD CONSTRAINT FK_14E8F60CF1B7C6C FOREIGN KEY (recepient_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_14E8F60CF624B39D ON messagerie (sender_id)');
        $this->addSql('CREATE INDEX IDX_14E8F60CF1B7C6C ON messagerie (recepient_id)');
        $this->addSql('ALTER TABLE notification CHANGE date_envoie date_envoi DATE NOT NULL');
        $this->addSql('ALTER TABLE produit DROP equiv');
        $this->addSql('DROP INDEX IDX_E19D9AD2BCF5E72D ON service');
        $this->addSql('ALTER TABLE service ADD nom_service VARCHAR(255) NOT NULL, ADD type_service VARCHAR(255) NOT NULL, ADD description VARCHAR(255) NOT NULL, ADD duree VARCHAR(255) NOT NULL, DROP categorie_id, DROP name_s, DROP description_s, DROP localisation, DROP state, DROP dispo_date');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie_service (id INT AUTO_INCREMENT NOT NULL, name_c VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description_c VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE disponibilite');
        $this->addSql('DROP TABLE livraison');
        $this->addSql('ALTER TABLE commande ADD produit_id INT NOT NULL, ADD ville VARCHAR(255) NOT NULL, DROP etat, CHANGE date date_cmd DATE NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DF347EFB ON commande (produit_id)');
        $this->addSql('ALTER TABLE messagerie DROP FOREIGN KEY FK_14E8F60CF624B39D');
        $this->addSql('ALTER TABLE messagerie DROP FOREIGN KEY FK_14E8F60CF1B7C6C');
        $this->addSql('DROP INDEX IDX_14E8F60CF624B39D ON messagerie');
        $this->addSql('DROP INDEX IDX_14E8F60CF1B7C6C ON messagerie');
        $this->addSql('ALTER TABLE messagerie DROP sender_id, DROP recepient_id, DROP created_at, DROP is_read');
        $this->addSql('ALTER TABLE notification CHANGE date_envoi date_envoie DATE NOT NULL');
        $this->addSql('ALTER TABLE produit ADD equiv DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE service ADD categorie_id INT DEFAULT NULL, ADD name_s VARCHAR(255) NOT NULL, ADD description_s VARCHAR(255) NOT NULL, ADD localisation VARCHAR(255) NOT NULL, ADD state VARCHAR(255) NOT NULL, ADD dispo_date VARCHAR(255) NOT NULL, DROP nom_service, DROP type_service, DROP description, DROP duree');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie_service (id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD2BCF5E72D ON service (categorie_id)');
    }
}
