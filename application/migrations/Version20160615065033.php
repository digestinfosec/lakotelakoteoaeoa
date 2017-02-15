<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160615065033 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $paymentTable = $schema->createTable('payments');
        $paymentTable->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $paymentTable->addColumn('order_id', 'integer', ['unsigned' => true]);
        $paymentTable->addColumn('payment_method', 'integer');
        $paymentTable->addColumn('payment_date', 'date', ['notnull' => false]);
        $paymentTable->addColumn('amount', 'decimal');
        //paypal
        $paymentTable->addColumn('paypal_email', 'string', ['notnull' => false]);
        $paymentTable->addColumn('paypal_transaction_id', 'string', ['notnull' => false]);
        //bank transfer
        $paymentTable->addColumn('bank_destination_name', 'string', ['notnull' => false]);
        $paymentTable->addColumn('bank_account_name', 'string', ['notnull' => false]);
        $paymentTable->addColumn('bank_account_number', 'string', ['notnull' => false]);

        $paymentTable->addColumn('note', 'string', ['notnull' => false]);
        $paymentTable->setPrimaryKey(['id']);

        $paymentTable->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);
        $paymentTable->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP'
        ]);

        $paymentTable->addForeignKeyConstraint('orders', ["order_id"], ["id"], ["onDelete" => "CASCADE"]);

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('payments');
    }
}
