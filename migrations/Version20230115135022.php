<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230115135022 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event ADD type_ticket_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7C4C606C2 FOREIGN KEY (type_ticket_id) REFERENCES type_ticket (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7C4C606C2 ON event (type_ticket_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7C4C606C2');
        $this->addSql('DROP INDEX IDX_3BAE0AA7C4C606C2 ON event');
        $this->addSql('ALTER TABLE event DROP type_ticket_id');
    }
}
