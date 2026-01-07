<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260107133317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE puntuaje_evento DROP FOREIGN KEY `FK_AFD56FE448D6EBE2`');
        $this->addSql('ALTER TABLE puntuaje_evento DROP FOREIGN KEY `FK_AFD56FE4B8A54D43`');
        $this->addSql('DROP INDEX IDX_AFD56FE448D6EBE2 ON puntuaje_evento');
        $this->addSql('DROP INDEX IDX_AFD56FE4B8A54D43 ON puntuaje_evento');
        $this->addSql('ALTER TABLE puntuaje_evento ADD torneo_id INT DEFAULT NULL, DROP disputa_id, DROP jugador_id');
        $this->addSql('ALTER TABLE puntuaje_evento ADD CONSTRAINT FK_AFD56FE4A0139802 FOREIGN KEY (torneo_id) REFERENCES torneo (id)');
        $this->addSql('CREATE INDEX IDX_AFD56FE4A0139802 ON puntuaje_evento (torneo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE puntuaje_evento DROP FOREIGN KEY FK_AFD56FE4A0139802');
        $this->addSql('DROP INDEX IDX_AFD56FE4A0139802 ON puntuaje_evento');
        $this->addSql('ALTER TABLE puntuaje_evento ADD jugador_id INT DEFAULT NULL, CHANGE torneo_id disputa_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE puntuaje_evento ADD CONSTRAINT `FK_AFD56FE448D6EBE2` FOREIGN KEY (disputa_id) REFERENCES disputas (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE puntuaje_evento ADD CONSTRAINT `FK_AFD56FE4B8A54D43` FOREIGN KEY (jugador_id) REFERENCES jugadores (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_AFD56FE448D6EBE2 ON puntuaje_evento (disputa_id)');
        $this->addSql('CREATE INDEX IDX_AFD56FE4B8A54D43 ON puntuaje_evento (jugador_id)');
    }
}
