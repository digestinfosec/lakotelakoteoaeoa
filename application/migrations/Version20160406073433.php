<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160406073433 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $institutionTable = $schema->createTable('institutions');
        $institutionTable->addColumn('id', 'integer', ['autoincrement' => true, 'unsigned' => true]);
        $institutionTable->addColumn('name', 'string', ['length' => '255']);
        $institutionTable->addColumn('contact_number', 'string', ['length' => '255', 'notnull' => false]);
        $institutionTable->addColumn('email', 'string', ['length' => '255', 'notnull' => false]);
        $institutionTable->addColumn('website', 'string', ['length' => '255', 'notnull' => false]);
        $institutionTable->addColumn('logo', 'string', ['length' => '255', 'default' => 'no-image.jpg']);
        $institutionTable->addColumn('address_id', 'integer', ['unsigned' => true]);
        $institutionTable->addForeignKeyConstraint('addresses', ['address_id'], ['id']);
        $institutionTable->setPrimaryKey(['id']);

        $classTable = $schema->createTable('classes');
        $classTable->addColumn('id', 'integer', ['autoincrement' => true, 'unsigned' => true]);
        $classTable->addColumn('title', 'string', ['length' => '100']);
        $classTable->addColumn('slug', 'string', ['length' => '100']);
        $classTable->addColumn('description', 'text');
        $classTable->addColumn('content', 'text');
        $classTable->addColumn('prerequisite_skill', 'boolean');
        $classTable->addColumn('end_goal', 'text');
        $classTable->addColumn('class_leader', 'string', ['length' => '100']);
        $classTable->addColumn('about_leader', 'text');
        $classTable->addColumn('type', 'integer');
        $classTable->addColumn('price', 'decimal');
        $classTable->addColumn('available_seat', 'integer');
        $classTable->addColumn('special_equipment', 'text', ['notnull' => false]);
        $classTable->addColumn('pack', 'boolean');
        $classTable->addColumn('level', 'integer');
        $classTable->addColumn('publish_status', 'integer');
        $classTable->addColumn('teacher_id', 'integer', ['unsigned' => true]);
        $classTable->addColumn('institution_id', 'integer', ['unsigned' => true, 'notnull' => false]);
        $classTable->addColumn('category_id', 'integer', ['unsigned' => true]);
        $classTable->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);
        $classTable->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP'
        ]);
        $classTable->addColumn('changed_by', 'integer', ['unsigned' => true, 'notnull' => false]);
        $classTable->addForeignKeyConstraint('users', ["teacher_id"], ["id"], ["onDelete" => "CASCADE"]);
        $classTable->addForeignKeyConstraint('institutions', ["institution_id"], ["id"]);
        $classTable->setPrimaryKey(['id']);

        $venueTable = $schema->createTable('venues');
        $venueTable->addColumn('id', 'integer', ['autoincrement' => true, 'unsigned' => true]);
        $venueTable->addColumn('name', 'string', ['length' => 255]);
        $venueTable->addColumn('address_id', 'integer', ['unsigned' => true]);
        $venueTable->addForeignKeyConstraint('addresses', ['address_id'], ['id']);
        $venueTable->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);
        $venueTable->setPrimaryKey(['id']);

        $scheduleTable = $schema->createTable('schedules');
        $scheduleTable->addColumn('id', 'integer', ['autoincrement' => true, 'unsigned' => true]);
        $scheduleTable->addColumn('date', 'date');
        $scheduleTable->addColumn('start_time', 'time');
        $scheduleTable->addColumn('end_time', 'time');
        $scheduleTable->addColumn('available_seat_left', 'integer');
        $scheduleTable->addColumn('venue_id', 'integer', ['unsigned' => true]);
        $scheduleTable->addColumn('class_id', 'integer', ['unsigned' => true]);
        $scheduleTable->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);
        $scheduleTable->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP'
        ]);
        $scheduleTable->addForeignKeyConstraint('venues', ["venue_id"], ["id"]);
        $scheduleTable->addForeignKeyConstraint('classes', ["class_id"], ["id"], ["onDelete" => "CASCADE"]);
        $scheduleTable->setPrimaryKey(['id']);

        $imageTable = $schema->createTable('images');
        $imageTable->addColumn('id', 'integer', ['autoincrement' => true, 'unsigned' => true]);
        $imageTable->addColumn('entity', 'string', ['length' => '20']);
        $imageTable->addColumn('entity_id', 'integer', ['unsigned' => true]);
        $imageTable->addColumn('path', 'string', ['length' => '255']);
        $imageTable->addColumn('title', 'string', ['length' => '255', 'notnull' => false]);
        $imageTable->addColumn('description', 'text', ['notnull' => false]);
        $imageTable->setPrimaryKey(['id']);

        $addressTable = $schema->createTable('addresses');
        $addressTable->addColumn('id', 'integer', ['autoincrement' => true, 'unsigned' => true]);
        $addressTable->addColumn('address_line1', 'text');
        $addressTable->addColumn('address_line2', 'text', ['notnull' => false]);
        $addressTable->addColumn('unit_number', 'string', ['length' => 10, 'notnull' => false]);
        $addressTable->addColumn('postal_code', 'string', ['length' => 10]);
        $addressTable->addColumn('city', 'string');
        $addressTable->addColumn('state', 'string');
        $addressTable->addColumn('country', 'string');
        $addressTable->addColumn('lat', 'string', ['length' => 100, 'notnull' => false]);
        $addressTable->addColumn('long', 'string', ['length' => 100, 'notnull' => false]);
        $addressTable->addColumn('entity', 'string', ['length' => '20']);
        $addressTable->addColumn('entity_id', 'integer', ['unsigned' => true]);
        $addressTable->setPrimaryKey(['id']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('addresses');
        $schema->dropTable('images');
        $schema->dropTable('schedules');
        $schema->dropTable('venues');
        $schema->dropTable('classes');
        $schema->dropTable('institutions');
    }
}
