<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251218090920 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_torneo (user_id INT NOT NULL, torneo_id INT NOT NULL, INDEX IDX_19B978C3A76ED395 (user_id), INDEX IDX_19B978C3A0139802 (torneo_id), PRIMARY KEY (user_id, torneo_id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('ALTER TABLE user_torneo ADD CONSTRAINT FK_19B978C3A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_torneo ADD CONSTRAINT FK_19B978C3A0139802 FOREIGN KEY (torneo_id) REFERENCES torneo (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_torneo DROP FOREIGN KEY FK_19B978C3A76ED395');
        $this->addSql('ALTER TABLE user_torneo DROP FOREIGN KEY FK_19B978C3A0139802');
        $this->addSql('DROP TABLE user_torneo');
    }
}
