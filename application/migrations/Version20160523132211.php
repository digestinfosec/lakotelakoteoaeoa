<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160523132211 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $recommend_teacher_table = $schema->getTable('recommend_teachers');
        $recommend_teacher_table->addColumn('user_id', 'integer', ['unsigned' => true]);
        $recommend_teacher_table->addForeignKeyConstraint('users', ["user_id"], ["id"], ["onDelete" => "CASCADE"], 'FK_USER_RECOMMEND');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $recommend_teacher_table= $schema->getTable('recommend_teachers');
        $recommend_teacher_table->removeForeignKey('FK_USER_RECOMMEND');
        $recommend_teacher_table->dropColumn('user_id');
    }
}
