<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260128073736 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // We use RENAME to preserve data from the old table
        $this->addSql('RENAME TABLE puntuaje_evento TO evento');

        // Re-create the foreign key for torneo_id if needed, but RENAME usually keeps indexes dependent on the table. 
        // However, Doctrine often drops/recreates FKs to ensure naming consistency.
        // Let's stick to what Doctrine wants for FKs but keep the data.

        // Drops the old FK constraint name if it existed on the old table name context
        $this->addSql('ALTER TABLE evento DROP FOREIGN KEY FK_AFD56FE4A0139802');

        // Add the constraint with the new name expected by Doctrine
        $this->addSql('ALTER TABLE evento ADD CONSTRAINT FK_47860B05A0139802 FOREIGN KEY (torneo_id) REFERENCES torneo (id)');

        // Update jugador_evento to point to the new table name
        $this->addSql('ALTER TABLE jugador_evento DROP FOREIGN KEY FK_736060F787A5F842');
        $this->addSql('ALTER TABLE jugador_evento ADD CONSTRAINT FK_736060F787A5F842 FOREIGN KEY (evento_id) REFERENCES evento (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE puntuaje_evento (id INT AUTO_INCREMENT NOT NULL, puntos INT NOT NULL, evento VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, torneo_id INT DEFAULT NULL, INDEX IDX_AFD56FE4A0139802 (torneo_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE puntuaje_evento ADD CONSTRAINT `FK_AFD56FE4A0139802` FOREIGN KEY (torneo_id) REFERENCES torneo (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE evento DROP FOREIGN KEY FK_47860B05A0139802');
        $this->addSql('DROP TABLE evento');
        $this->addSql('ALTER TABLE jugador_evento DROP FOREIGN KEY FK_736060F787A5F842');
        $this->addSql('ALTER TABLE jugador_evento ADD CONSTRAINT `FK_736060F787A5F842` FOREIGN KEY (evento_id) REFERENCES puntuaje_evento (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
