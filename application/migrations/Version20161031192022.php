<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161031192022 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $userTable = $schema->getTable('users');
        $userTable->addColumn('forgot_expire', 'datetime', ['notnull' => false]);

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $userTable = $schema->getTable('users');
        $userTable->dropColumn('forgot_expire');
    }
}
