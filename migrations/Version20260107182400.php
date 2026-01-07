<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260107182400 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE puntuaje_evento DROP FOREIGN KEY `FK_AFD56FE4B8A54D43`');
        $this->addSql('DROP INDEX IDX_AFD56FE4B8A54D43 ON puntuaje_evento');
        $this->addSql('ALTER TABLE puntuaje_evento DROP jugador_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE puntuaje_evento ADD jugador_id INT NOT NULL');
        $this->addSql('ALTER TABLE puntuaje_evento ADD CONSTRAINT `FK_AFD56FE4B8A54D43` FOREIGN KEY (jugador_id) REFERENCES jugadores (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_AFD56FE4B8A54D43 ON puntuaje_evento (jugador_id)');
    }
}
