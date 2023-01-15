<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230115135319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE type_ticket ADD typeticketperconcert_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE type_ticket ADD CONSTRAINT FK_B477C69B9E567B68 FOREIGN KEY (typeticketperconcert_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_B477C69B9E567B68 ON type_ticket (typeticketperconcert_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE type_ticket DROP FOREIGN KEY FK_B477C69B9E567B68');
        $this->addSql('DROP INDEX IDX_B477C69B9E567B68 ON type_ticket');
        $this->addSql('ALTER TABLE type_ticket DROP typeticketperconcert_id');
    }
}
