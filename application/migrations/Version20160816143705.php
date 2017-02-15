<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160816143705 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $payouts = $schema->createTable('payouts');
        $payouts->addColumn('id', 'integer', ['autoincrement' => true, 'unsigned' => true]);
        $payouts->addColumn('teacher_id', 'integer', ['unsigned' => true]);
        $payouts->addColumn('invoice_code', 'string', ['length' => 100, 'notnull' => false]);
        $payouts->addColumn('currency', 'string', ['lenght' => 3, 'default' => 'SGD']);
        $payouts->addColumn('status', 'integer', ['default' => 0]);
        $payouts->addColumn('payment_date', 'date');
        $payouts->addColumn('amount', 'decimal', ['precision' => 10, 'scale' => 2]);
        $payouts->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);
        $payouts->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP'
        ]);
        $payouts->addForeignKeyConstraint('users', ["teacher_id"], ["id"], ["onDelete" => "CASCADE"]);
        $payouts->setPrimaryKey(['id']);


        $classAttendees = $schema->getTable('class_attendees');
        $classAttendees->addColumn('payout_id', 'integer', ['unsigned' => true, 'notnull' => false]);
        $classAttendees->addForeignKeyConstraint('payouts', ["payout_id"], ["id"], ["onDelete" => "SET NULL"]);

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('payouts');

        $classAttendees = $schema->getTable('class_attendees');
        $classAttendees->dropColumn('payout_id');


    }
}
