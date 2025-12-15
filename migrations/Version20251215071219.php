<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251215071219 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE liga_fantasy (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, puntuaje INT NOT NULL, torneo_id INT DEFAULT NULL, INDEX IDX_47E3DA2A0139802 (torneo_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('ALTER TABLE liga_fantasy ADD CONSTRAINT FK_47E3DA2A0139802 FOREIGN KEY (torneo_id) REFERENCES torneo (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liga_fantasy DROP FOREIGN KEY FK_47E3DA2A0139802');
        $this->addSql('DROP TABLE liga_fantasy');
    }
}
