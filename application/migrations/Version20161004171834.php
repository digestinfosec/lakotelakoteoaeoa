<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161004171834 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $classTable = $schema->getTable('classes');
        $classTable->addColumn('prerequisite_detail', 'string', ['notnull' => false]);
        $classTable->addColumn('create_session', 'integer', ['notnull' => false]);

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $classTable = $schema->getTable('classes');
        $classTable->dropColumn('prerequisite_detail');
        $classTable->dropColumn('create_session');
    }
}

