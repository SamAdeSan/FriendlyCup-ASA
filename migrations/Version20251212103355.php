<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251212103355 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE disputas (id INT AUTO_INCREMENT NOT NULL, resultado VARCHAR(255) NOT NULL, equipo1_id INT NOT NULL, equipo2_id INT NOT NULL, torneo_id INT NOT NULL, UNIQUE INDEX UNIQ_E13A0DFC8D588AD (equipo1_id), INDEX IDX_E13A0DFC1A602743 (equipo2_id), INDEX IDX_E13A0DFCA0139802 (torneo_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE equipos (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, torneo_id INT NOT NULL, INDEX IDX_8C188AD0A0139802 (torneo_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE jugadores (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, estadisticas INT NOT NULL, equipo_id INT DEFAULT NULL, INDEX IDX_CF491B7623BFBED (equipo_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE torneo (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, tipo VARCHAR(255) NOT NULL, organizador_id INT NOT NULL, INDEX IDX_7CEB63FEE3445778 (organizador_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('ALTER TABLE disputas ADD CONSTRAINT FK_E13A0DFC8D588AD FOREIGN KEY (equipo1_id) REFERENCES equipos (id)');
        $this->addSql('ALTER TABLE disputas ADD CONSTRAINT FK_E13A0DFC1A602743 FOREIGN KEY (equipo2_id) REFERENCES equipos (id)');
        $this->addSql('ALTER TABLE disputas ADD CONSTRAINT FK_E13A0DFCA0139802 FOREIGN KEY (torneo_id) REFERENCES torneo (id)');
        $this->addSql('ALTER TABLE equipos ADD CONSTRAINT FK_8C188AD0A0139802 FOREIGN KEY (torneo_id) REFERENCES torneo (id)');
        $this->addSql('ALTER TABLE jugadores ADD CONSTRAINT FK_CF491B7623BFBED FOREIGN KEY (equipo_id) REFERENCES equipos (id)');
        $this->addSql('ALTER TABLE torneo ADD CONSTRAINT FK_7CEB63FEE3445778 FOREIGN KEY (organizador_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE disputas DROP FOREIGN KEY FK_E13A0DFC8D588AD');
        $this->addSql('ALTER TABLE disputas DROP FOREIGN KEY FK_E13A0DFC1A602743');
        $this->addSql('ALTER TABLE disputas DROP FOREIGN KEY FK_E13A0DFCA0139802');
        $this->addSql('ALTER TABLE equipos DROP FOREIGN KEY FK_8C188AD0A0139802');
        $this->addSql('ALTER TABLE jugadores DROP FOREIGN KEY FK_CF491B7623BFBED');
        $this->addSql('ALTER TABLE torneo DROP FOREIGN KEY FK_7CEB63FEE3445778');
        $this->addSql('DROP TABLE disputas');
        $this->addSql('DROP TABLE equipos');
        $this->addSql('DROP TABLE jugadores');
        $this->addSql('DROP TABLE torneo');
        $this->addSql('DROP TABLE `user`');
    }
}
