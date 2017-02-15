<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160810064125 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $creditHistory = $schema->createTable('credit_histories');
        $creditHistory->addColumn('id', 'integer', ['autoincrement' => true, 'unsigned' => true]);
        $creditHistory->addColumn('debit', 'decimal', ['default' => 0]);
        $creditHistory->addColumn('credit', 'decimal', ['default' => 0]);
        $creditHistory->addColumn('description', 'text');
        $creditHistory->addColumn('credit_id', 'integer', ['unsigned' => true]);
        $creditHistory->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);
        $creditHistory->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP'
        ]);
        $creditHistory->addForeignKeyConstraint('credits', ["credit_id"], ["id"], ["onDelete" => "CASCADE"]);
        $creditHistory->setPrimaryKey(['id']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('credit_histories');
    }
}
