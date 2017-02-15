<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160403181021 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $table = $schema->createTable('recommend_teachers');
        $table->addColumn('id', 'integer', ['autoincrement' => true, 'unsigned' => true]);
        $table->addColumn('submitter_name', 'string', ['length' => 100]);
        $table->addColumn('submitter_email', 'string', ['length' => 100]);
        $table->addColumn('teacher_name', 'string', ['length' => 100]);
        $table->addColumn('teacher_contact', 'string', ['length' => 100]);
        $table->addColumn('teacher_email', 'string', ['length' => 100]);
        $table->addColumn('teacher_website', 'string', ['length' => 100]);
        $table->addColumn('teacher_country', 'string', ['length' => 100]);
        $table->addColumn('status', 'integer', ['default' => 0]);
        $table->addUniqueIndex(['id']);
        $table->setPrimaryKey(['id']);

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('recommend_teachers');
    }
}
