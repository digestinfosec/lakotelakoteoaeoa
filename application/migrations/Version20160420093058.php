<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160420093058 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $table = $schema->getTable('users');
        $table->dropColumn('fb_secret');
        $table->addColumn('fb_id', 'string', ['length' => 128, 'notnull' => false]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $table = $schema->getTable('users');
        $table->dropColumn('fb_id');
        $table->addColumn('fb_secret', 'string', ['length' => 128, 'notnull' => false]);
    }
}
