<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171110163109 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tblProductData ADD intProductStock int(10) unsigned NOT NULL AFTER strProductDesc;');
        $this->addSql('ALTER TABLE tblProductData ADD numProductCost numeric(7,2) unsigned NOT NULL AFTER intProductStock;');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tblProductData DROP COLUMN intProductStock');
        $this->addSql('ALTER TABLE tblProductData DROP COLUMN numProductCost');

    }
}
