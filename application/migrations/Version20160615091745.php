<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160615091745 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $creditTable = $schema->createTable('credits');
        $creditTable->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $creditTable->addColumn('voucher_id', 'integer', ['unsigned' => true]);
        $creditTable->addColumn('user_id', 'integer', ['unsigned' => true]);
        $creditTable->addColumn('initial_amount', 'integer');
        $creditTable->addColumn('expired_date', 'date');
        $creditTable->addColumn('amount_used', 'integer', ['default' => 0]);

        $creditTable->addForeignKeyConstraint('vouchers', ["voucher_id"], ["id"], ["onDelete" => "RESTRICT"]);
        $creditTable->addForeignKeyConstraint('users', ["user_id"], ["id"], ["onDelete" => "RESTRICT"]);
        $creditTable->setPrimaryKey(['id']);

        $creditTable->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);
        $creditTable->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP'
        ]);


    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('credits');
    }
}
