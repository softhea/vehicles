<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230729065229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE property (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, value VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, maker_id INT DEFAULT NULL, INDEX IDX_1B80E486C54C8C93 (type_id), INDEX IDX_1B80E48668DA5EC3 (maker_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle_property (id INT AUTO_INCREMENT NOT NULL, vehicle_id INT DEFAULT NULL, property_id INT DEFAULT NULL, value VARCHAR(50) NOT NULL, INDEX IDX_56E0134A545317D1 (vehicle_id), INDEX IDX_56E0134A549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E48668DA5EC3 FOREIGN KEY (maker_id) REFERENCES maker (id)');
        $this->addSql('ALTER TABLE vehicle_property ADD CONSTRAINT FK_56E0134A545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE vehicle_property ADD CONSTRAINT FK_56E0134A549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E486C54C8C93');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E48668DA5EC3');
        $this->addSql('ALTER TABLE vehicle_property DROP FOREIGN KEY FK_56E0134A545317D1');
        $this->addSql('ALTER TABLE vehicle_property DROP FOREIGN KEY FK_56E0134A549213EC');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE vehicle');
        $this->addSql('DROP TABLE vehicle_property');
    }
}
