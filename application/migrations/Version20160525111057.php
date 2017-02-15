<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160525111057 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $classUserPivot = $schema->createTable('class_attendees');
        $classUserPivot->addColumn('user_id', 'integer', ['unsigned' => true]);
        $classUserPivot->addColumn('class_id', 'integer', ['unsigned' => true]);
        $classUserPivot->setPrimaryKey(['user_id', 'class_id']);
        $classUserPivot->addForeignKeyConstraint('users', ["user_id"], ["id"], ["onDelete" => "CASCADE"]);
        $classUserPivot->addForeignKeyConstraint('classes', ["class_id"], ["id"], ["onDelete" => "CASCADE"]);

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('class_attendees');

    }
}
