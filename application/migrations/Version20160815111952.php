<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160815111952 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $orderTable = $schema->getTable('payments');
        $orderTable->addColumn('with_credit', 'boolean', ['default' => 0]);
        $orderTable->addColumn('credit_amount', 'integer', ['notnull' => false]);

        $creditHistoryTable = $schema->getTable('credit_histories');
        $creditHistoryTable->addColumn('order_id', 'integer', ['unsigned' => true, 'notnull' => false]);
        $creditHistoryTable->addForeignKeyConstraint('orders', ["order_id"], ["id"], ["onDelete" => "SET NULL"]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $orderTable = $schema->getTable('payments');
        $orderTable->dropColumn('with_credit');
        $orderTable->dropColumn('credit_amount');

        $creditHistoryTable = $schema->getTable('credit_histories');
        $creditHistoryTable->removeForeignKey('FK_E3B38B18D9F6D38');
        $creditHistoryTable->dropColumn('order_id');
    }
}
