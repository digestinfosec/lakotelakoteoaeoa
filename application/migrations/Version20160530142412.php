<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160530142412 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $staticPages = $schema->createTable("static_pages");
        $staticPages->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $staticPages->addColumn('author_id', 'integer', ['unsigned' => true]);
        $staticPages->addColumn('last_editor_id', 'integer', ['unsigned' => true]);

        $staticPages->addColumn('summary', 'text', ['notnull' => false]);
        $staticPages->addColumn('title', 'string', ['length' => 100]);
        $staticPages->addColumn('content', 'text', ['notnull' => false]);

        $staticPages->addColumn('published_at', 'datetime', ['notnull' => false]);
        $staticPages->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);
        $staticPages->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP'
        ]);

        $staticPages->setPrimaryKey(['id']);
        $staticPages->addForeignKeyConstraint('users', ["author_id"], ["id"], ["onDelete" => "CASCADE"]);
        $staticPages->addForeignKeyConstraint('users', ["last_editor_id"], ["id"]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('static_pages');
    }
}
