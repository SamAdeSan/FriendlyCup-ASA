<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251215072130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipo_fantasy (id INT AUTO_INCREMENT NOT NULL, puntos INT NOT NULL, ligafantasy_id INT DEFAULT NULL, entrenador_id INT DEFAULT NULL, jugadores_id INT DEFAULT NULL, INDEX IDX_5D0D50218B2F69BF (ligafantasy_id), INDEX IDX_5D0D50214FE90CDB (entrenador_id), INDEX IDX_5D0D5021900BE3B3 (jugadores_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE puntuaje_evento (id INT AUTO_INCREMENT NOT NULL, puntos INT NOT NULL, disputa_id INT DEFAULT NULL, jugador_id INT DEFAULT NULL, INDEX IDX_AFD56FE448D6EBE2 (disputa_id), INDEX IDX_AFD56FE4B8A54D43 (jugador_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('ALTER TABLE equipo_fantasy ADD CONSTRAINT FK_5D0D50218B2F69BF FOREIGN KEY (ligafantasy_id) REFERENCES liga_fantasy (id)');
        $this->addSql('ALTER TABLE equipo_fantasy ADD CONSTRAINT FK_5D0D50214FE90CDB FOREIGN KEY (entrenador_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE equipo_fantasy ADD CONSTRAINT FK_5D0D5021900BE3B3 FOREIGN KEY (jugadores_id) REFERENCES jugadores (id)');
        $this->addSql('ALTER TABLE puntuaje_evento ADD CONSTRAINT FK_AFD56FE448D6EBE2 FOREIGN KEY (disputa_id) REFERENCES disputas (id)');
        $this->addSql('ALTER TABLE puntuaje_evento ADD CONSTRAINT FK_AFD56FE4B8A54D43 FOREIGN KEY (jugador_id) REFERENCES jugadores (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipo_fantasy DROP FOREIGN KEY FK_5D0D50218B2F69BF');
        $this->addSql('ALTER TABLE equipo_fantasy DROP FOREIGN KEY FK_5D0D50214FE90CDB');
        $this->addSql('ALTER TABLE equipo_fantasy DROP FOREIGN KEY FK_5D0D5021900BE3B3');
        $this->addSql('ALTER TABLE puntuaje_evento DROP FOREIGN KEY FK_AFD56FE448D6EBE2');
        $this->addSql('ALTER TABLE puntuaje_evento DROP FOREIGN KEY FK_AFD56FE4B8A54D43');
        $this->addSql('DROP TABLE equipo_fantasy');
        $this->addSql('DROP TABLE puntuaje_evento');
    }
}
