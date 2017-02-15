<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160607122021 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // id, user_id, created_at, created_date, total
        $orderTable = $schema->createTable('orders');
        $orderTable->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $orderTable->addColumn('user_id', 'integer', ['unsigned' => true]);
        $orderTable->addColumn('receipt_code', 'string', ['length' => 100, 'notnull' => false]);
        $orderTable->addColumn('transaction_code', 'string', ['length' => 100, 'notnull' => false]);
        $orderTable->addColumn('status', 'integer');
        $orderTable->addColumn('total', 'decimal');
        $orderTable->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);
        $orderTable->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP'
        ]);
        $orderTable->setPrimaryKey(['id']);
        $orderTable->addForeignKeyConstraint('users', ["user_id"], ["id"], ["onDelete" => "CASCADE"]);


        $orderDetailTable = $schema->createTable('order_details');
        $orderDetailTable->addColumn('order_id', 'integer', ['unsigned' => true]);
        $orderDetailTable->addColumn('class_id', 'integer', ['unsigned' => true]);
        $orderDetailTable->addColumn('schedule_id', 'integer', ['unsigned' => true]);
        $orderDetailTable->addColumn('price', 'decimal');
        $orderDetailTable->addColumn('pax', 'integer', ['default' => 1]);
        $orderDetailTable->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);
        $orderDetailTable->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP'
        ]);
        $orderDetailTable->setPrimaryKey(['order_id', 'class_id']);
        $orderDetailTable->addForeignKeyConstraint('classes', ["class_id"], ["id"], ["onDelete" => "CASCADE"]);
        $orderDetailTable->addForeignKeyConstraint('orders', ["order_id"], ["id"], ["onDelete" => "CASCADE"]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('order_details');
        $schema->dropTable('orders');
    }
}
