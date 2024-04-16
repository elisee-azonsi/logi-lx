<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231212144513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shift CHANGE ferie ferie DOUBLE PRECISION DEFAULT NULL, CHANGE maladie maladie DOUBLE PRECISION DEFAULT NULL, CHANGE cp cp DOUBLE PRECISION DEFAULT NULL, CHANGE autre autre DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shift CHANGE ferie ferie TINYINT(1) DEFAULT NULL, CHANGE maladie maladie TINYINT(1) DEFAULT NULL, CHANGE cp cp TINYINT(1) DEFAULT NULL, CHANGE autre autre VARCHAR(255) DEFAULT NULL');
    }
}
