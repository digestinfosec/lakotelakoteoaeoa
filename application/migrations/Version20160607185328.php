<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160607185328 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $orderTable = $schema->getTable('orders');
        $orderTable->addColumn('currency', 'string', ['lenght' => 3, 'default' => 'IDR']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $orderTable = $schema->getTable('orders');
        $orderTable->dropColumn('currency');
    }
}
