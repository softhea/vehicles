<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230730073148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE INDEX name_idx ON property (name)');
        $this->addSql('ALTER TABLE vehicle_property CHANGE value value VARCHAR(50) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX unique_vehicle_property ON vehicle_property (vehicle_id, property_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX name_idx ON property');
        $this->addSql('DROP INDEX unique_vehicle_property ON vehicle_property');
        $this->addSql('ALTER TABLE vehicle_property CHANGE value value VARCHAR(50) NOT NULL');
    }
}
