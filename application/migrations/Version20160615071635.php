<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160615071635 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $voucherTable = $schema->createTable('vouchers');
        $voucherTable->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $voucherTable->addColumn('voucher_code', 'string');
        $voucherTable->addColumn('order_id', 'integer', ['unsigned' => true]);
        $voucherTable->addColumn('user_id', 'integer', ['unsigned' => true]);
        $voucherTable->addColumn('status', 'integer', ['default' => \VoucherStatic::VOUCHER_UNUSED]);
        $voucherTable->addForeignKeyConstraint('orders', ["order_id"], ["id"], ["onDelete" => "RESTRICT"]);
        $voucherTable->addForeignKeyConstraint('users', ["user_id"], ["id"], ["onDelete" => "RESTRICT"]);
        $voucherTable->setPrimaryKey(['id']);

        $voucherTable->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);
        $voucherTable->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP'
        ]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('vouchers');

    }
}
