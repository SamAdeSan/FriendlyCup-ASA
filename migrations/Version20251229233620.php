<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251229233620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipofantasy_titulares (equipo_fantasy_id INT NOT NULL, jugadores_id INT NOT NULL, INDEX IDX_23BDFCEE9BC4C853 (equipo_fantasy_id), INDEX IDX_23BDFCEE900BE3B3 (jugadores_id), PRIMARY KEY (equipo_fantasy_id, jugadores_id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('ALTER TABLE equipofantasy_titulares ADD CONSTRAINT FK_23BDFCEE9BC4C853 FOREIGN KEY (equipo_fantasy_id) REFERENCES equipo_fantasy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipofantasy_titulares ADD CONSTRAINT FK_23BDFCEE900BE3B3 FOREIGN KEY (jugadores_id) REFERENCES jugadores (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE alineacion_titulares DROP FOREIGN KEY `FK_4A0ECA87900BE3B3`');
        $this->addSql('ALTER TABLE alineacion_titulares DROP FOREIGN KEY `FK_4A0ECA879BC4C853`');
        $this->addSql('DROP TABLE alineacion_titulares');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alineacion_titulares (equipo_fantasy_id INT NOT NULL, jugadores_id INT NOT NULL, INDEX IDX_4A0ECA879BC4C853 (equipo_fantasy_id), INDEX IDX_4A0ECA87900BE3B3 (jugadores_id), PRIMARY KEY (equipo_fantasy_id, jugadores_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE alineacion_titulares ADD CONSTRAINT `FK_4A0ECA87900BE3B3` FOREIGN KEY (jugadores_id) REFERENCES jugadores (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE alineacion_titulares ADD CONSTRAINT `FK_4A0ECA879BC4C853` FOREIGN KEY (equipo_fantasy_id) REFERENCES equipo_fantasy (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipofantasy_titulares DROP FOREIGN KEY FK_23BDFCEE9BC4C853');
        $this->addSql('ALTER TABLE equipofantasy_titulares DROP FOREIGN KEY FK_23BDFCEE900BE3B3');
        $this->addSql('DROP TABLE equipofantasy_titulares');
    }
}
