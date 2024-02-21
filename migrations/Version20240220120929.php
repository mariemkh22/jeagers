<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220120929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison ADD localisation_geographique_id INT NOT NULL');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1FFC3E9FD7 FOREIGN KEY (localisation_geographique_id) REFERENCES localisation_geographique (id)');
        $this->addSql('CREATE INDEX IDX_A60C9F1FFC3E9FD7 ON livraison (localisation_geographique_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1FFC3E9FD7');
        $this->addSql('DROP INDEX IDX_A60C9F1FFC3E9FD7 ON livraison');
        $this->addSql('ALTER TABLE livraison DROP localisation_geographique_id');
    }
}
