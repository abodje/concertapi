<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230115121246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket ADD typeticket_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3933F254E FOREIGN KEY (typeticket_id) REFERENCES type_ticket (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3933F254E ON ticket (typeticket_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3933F254E');
        $this->addSql('DROP INDEX IDX_97A0ADA3933F254E ON ticket');
        $this->addSql('ALTER TABLE ticket DROP typeticket_id');
    }
}
