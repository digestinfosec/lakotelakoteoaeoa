<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160516141127 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $classCommentPivot = $schema->createTable('class_wishlists');
        $classCommentPivot->addColumn('user_id', 'integer', ['unsigned' => true]);
        $classCommentPivot->addColumn('class_id', 'integer', ['unsigned' => true]);
        $classCommentPivot->setPrimaryKey(['user_id', 'class_id']);
        $classCommentPivot->addForeignKeyConstraint('users', ["user_id"], ["id"], ["onDelete" => "CASCADE"]);
        $classCommentPivot->addForeignKeyConstraint('classes', ["class_id"], ["id"], ["onDelete" => "CASCADE"]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('class_wishlists');
    }
}
