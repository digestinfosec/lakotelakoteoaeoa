<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160415032618 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $table = $schema->getTable('users');
        $table->addColumn('pre_register', 'boolean', ['default' => false]);
        $table->addColumn('send_updates', 'boolean', ['default' => false]);
        $table->addColumn('fb_token', 'string', ['length' => 128, 'notnull' => false]);
        $table->addColumn('fb_secret', 'string', ['length' => 128, 'notnull' => false]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $table = $schema->getTable('users');
        $table->dropColumn('pre_register');
        $table->dropColumn('send_updates');
        $table->dropColumn('fb_token');
        $table->dropColumn('fb_secret');
    }
}
