<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251229232307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alineacion_titulares (equipo_fantasy_id INT NOT NULL, jugadores_id INT NOT NULL, INDEX IDX_4A0ECA879BC4C853 (equipo_fantasy_id), INDEX IDX_4A0ECA87900BE3B3 (jugadores_id), PRIMARY KEY (equipo_fantasy_id, jugadores_id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('ALTER TABLE alineacion_titulares ADD CONSTRAINT FK_4A0ECA879BC4C853 FOREIGN KEY (equipo_fantasy_id) REFERENCES equipo_fantasy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE alineacion_titulares ADD CONSTRAINT FK_4A0ECA87900BE3B3 FOREIGN KEY (jugadores_id) REFERENCES jugadores (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipo_fantasy DROP datos_alineacion');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alineacion_titulares DROP FOREIGN KEY FK_4A0ECA879BC4C853');
        $this->addSql('ALTER TABLE alineacion_titulares DROP FOREIGN KEY FK_4A0ECA87900BE3B3');
        $this->addSql('DROP TABLE alineacion_titulares');
        $this->addSql('ALTER TABLE equipo_fantasy ADD datos_alineacion JSON NOT NULL');
    }
}
