<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160401164619 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $table = $schema->createTable('user_details');
        $table->addColumn('user_id', 'integer', ['unsigned' => true]);
        $table->addColumn('birth_date', 'date');
        $table->addColumn('home_phone', 'string',
            ['length' => 30, 'notnull' => false]
        );
        $table->addColumn('mobile_phone', 'string', ['length' => 30]);
        $table->addColumn('gender', 'integer');
        $table->addColumn('marital_status', 'integer');
        $table->addColumn('academic_level', 'integer');
        $table->addColumn('number_of_student', 'integer');
        $table->addColumn('working_as', 'integer');
        $table->addColumn('teaching_goal', 'text');
        $table->addColumn('teaching_in', 'text');
        $table->addColumn('teaching_scope', 'text');
        $table->addColumn('schedule_available', 'text');
        $table->addColumn('field_of_interest', 'text');
        $table->addColumn('register_notification', 'boolean', ['default' => 0]);
        $table->addColumn('whitelist_notification', 'boolean', ['default' => 0]);
        $table->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ]);
        $table->addForeignKeyConstraint('users', ["user_id"], ["id"], ["onDelete" => "CASCADE"]);
        $table->setPrimaryKey(['user_id']);
        $table->addUniqueIndex(['user_id']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('user_details');
    }
}
