<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251225171030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liga_fantasy ADD administrador_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE liga_fantasy ADD CONSTRAINT FK_47E3DA248DFEBB7 FOREIGN KEY (administrador_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_47E3DA248DFEBB7 ON liga_fantasy (administrador_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liga_fantasy DROP FOREIGN KEY FK_47E3DA248DFEBB7');
        $this->addSql('DROP INDEX IDX_47E3DA248DFEBB7 ON liga_fantasy');
        $this->addSql('ALTER TABLE liga_fantasy DROP administrador_id');
    }
}
