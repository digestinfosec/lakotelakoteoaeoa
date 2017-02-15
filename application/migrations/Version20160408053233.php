<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160408053233 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $table = $schema->getTable('users');
        $table->addColumn('forgot_key', 'string', ['length' => 32, 'notnull' => false]);
        $table->addColumn('last_send_email', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $table = $schema->getTable('users');
        $table->dropColumn('forgot_key');
        $table->dropColumn('last_send_email');
    }
}
