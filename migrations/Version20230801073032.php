<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230801073032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX unique_name ON maker (name)');
        $this->addSql('ALTER TABLE property DROP INDEX name_idx, ADD UNIQUE INDEX unique_name (name)');
        $this->addSql('CREATE UNIQUE INDEX unique_name ON type (name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX unique_name ON maker');
        $this->addSql('ALTER TABLE property DROP INDEX unique_name, ADD INDEX name_idx (name)');
        $this->addSql('DROP INDEX unique_name ON type');
    }
}
