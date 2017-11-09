<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171109121752 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX strProductCode ON tblProductData');
        $this->addSql('ALTER TABLE tblProductData CHANGE intProductDataId intProductDataId INT AUTO_INCREMENT NOT NULL, CHANGE dtmAdded dtmAdded DATETIME NOT NULL, CHANGE dtmDiscontinued dtmDiscontinued DATETIME NOT NULL, CHANGE stmTimestamp stmTimestamp DATETIME NOT NULL');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tblProductData CHANGE intProductDataId intProductDataId INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE dtmAdded dtmAdded DATETIME DEFAULT NULL, CHANGE dtmDiscontinued dtmDiscontinued DATETIME DEFAULT NULL, CHANGE stmTimestamp stmTimestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX strProductCode ON tblProductData (strProductCode)');

    }
}
