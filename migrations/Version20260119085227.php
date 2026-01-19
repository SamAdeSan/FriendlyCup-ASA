<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260119085227 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE disputas ADD ganador_id INT DEFAULT NULL, DROP ganador');
        $this->addSql('ALTER TABLE disputas ADD CONSTRAINT FK_E13A0DFCA338CEA5 FOREIGN KEY (ganador_id) REFERENCES equipos (id)');
        $this->addSql('CREATE INDEX IDX_E13A0DFCA338CEA5 ON disputas (ganador_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE disputas DROP FOREIGN KEY FK_E13A0DFCA338CEA5');
        $this->addSql('DROP INDEX IDX_E13A0DFCA338CEA5 ON disputas');
        $this->addSql('ALTER TABLE disputas ADD ganador VARCHAR(255) NOT NULL, DROP ganador_id');
    }
}
