<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230115124649 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7700047D2');
        $this->addSql('DROP INDEX IDX_3BAE0AA7700047D2 ON event');
        $this->addSql('ALTER TABLE event DROP ticket_id');
        $this->addSql('ALTER TABLE ticket ADD event_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA371F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA371F7E88B ON ticket (event_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event ADD ticket_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7700047D2 ON event (ticket_id)');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA371F7E88B');
        $this->addSql('DROP INDEX IDX_97A0ADA371F7E88B ON ticket');
        $this->addSql('ALTER TABLE ticket DROP event_id');
    }
}
