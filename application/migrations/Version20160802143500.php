<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160802143500 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $orderDetails = $schema->getTable('order_details');
        $this->addSql('ALTER TABLE order_details DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE order_details ADD id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY');
        $orderDetails->addUniqueIndex(['order_id', 'class_id']);
    }


    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $orderDetails = $schema->getTable('order_details');
        $orderDetails->dropPrimaryKey();
        $orderDetails->dropIndex('UNIQ_845CA2C18D9F6D38EA000B10');
        $orderDetails->dropColumn('id');
        $orderDetails->setPrimaryKey(['order_id', 'class_id']);
    }
}
