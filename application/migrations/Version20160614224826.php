<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160614224826 extends AbstractMigration
{

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $venueTable = $schema->getTable('venues');
        $venueTable->removeForeignKey('FK_652E22ADF5B7AF75');
        $schema->dropTable('venues');

        $scheduleTable = $schema->getTable('schedules');
        $scheduleTable->dropColumn('venue_id');
        $scheduleTable->addColumn('address_id', 'integer', ['unsigned' => true]);
        $scheduleTable->addForeignKeyConstraint('addresses', ["address_id"], ["id"]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $venueTable = $schema->createTable('venues');
        $venueTable->addColumn('id', 'integer', ['autoincrement' => true, 'unsigned' => true]);
        $venueTable->addColumn('name', 'string', ['length' => 255]);
        $venueTable->addColumn('address_id', 'integer', ['unsigned' => true]);
        $venueTable->addForeignKeyConstraint('addresses', ['address_id'], ['id']);
        $venueTable->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);
        $venueTable->setPrimaryKey(['id']);

    }
}
