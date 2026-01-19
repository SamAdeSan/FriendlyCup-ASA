<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260119124035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE jugador_evento (id INT AUTO_INCREMENT NOT NULL, cantidad INT NOT NULL, jugador_id INT NOT NULL, evento_id INT NOT NULL, INDEX IDX_736060F7B8A54D43 (jugador_id), INDEX IDX_736060F787A5F842 (evento_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('ALTER TABLE jugador_evento ADD CONSTRAINT FK_736060F7B8A54D43 FOREIGN KEY (jugador_id) REFERENCES jugadores (id)');
        $this->addSql('ALTER TABLE jugador_evento ADD CONSTRAINT FK_736060F787A5F842 FOREIGN KEY (evento_id) REFERENCES puntuaje_evento (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE jugador_evento DROP FOREIGN KEY FK_736060F7B8A54D43');
        $this->addSql('ALTER TABLE jugador_evento DROP FOREIGN KEY FK_736060F787A5F842');
        $this->addSql('DROP TABLE jugador_evento');
    }
}
