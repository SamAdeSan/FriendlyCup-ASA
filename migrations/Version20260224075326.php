<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260224075326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evento RENAME INDEX idx_afd56fe4a0139802 TO IDX_47860B05A0139802');
        $this->addSql('ALTER TABLE jugador_evento DROP FOREIGN KEY `FK_736060F787A5F842`');
        $this->addSql('ALTER TABLE jugador_evento ADD CONSTRAINT FK_736060F787A5F842 FOREIGN KEY (evento_id) REFERENCES evento (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evento RENAME INDEX idx_47860b05a0139802 TO IDX_AFD56FE4A0139802');
        $this->addSql('ALTER TABLE jugador_evento DROP FOREIGN KEY FK_736060F787A5F842');
        $this->addSql('ALTER TABLE jugador_evento ADD CONSTRAINT `FK_736060F787A5F842` FOREIGN KEY (evento_id) REFERENCES evento (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
