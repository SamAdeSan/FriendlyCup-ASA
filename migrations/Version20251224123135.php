<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251224123135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipo_fantasy DROP FOREIGN KEY `FK_5D0D5021900BE3B3`');
        $this->addSql('DROP INDEX IDX_5D0D5021900BE3B3 ON equipo_fantasy');
        $this->addSql('ALTER TABLE equipo_fantasy ADD presupuesto DOUBLE PRECISION NOT NULL, ADD datos_alineacion JSON NOT NULL, DROP jugadores_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipo_fantasy ADD jugadores_id INT DEFAULT NULL, DROP presupuesto, DROP datos_alineacion');
        $this->addSql('ALTER TABLE equipo_fantasy ADD CONSTRAINT `FK_5D0D5021900BE3B3` FOREIGN KEY (jugadores_id) REFERENCES jugadores (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5D0D5021900BE3B3 ON equipo_fantasy (jugadores_id)');
    }
}
