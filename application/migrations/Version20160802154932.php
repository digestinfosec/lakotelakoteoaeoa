<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160802154932 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $classTable = $schema->getTable('classes');
        $classTable->addColumn('cancel_reason', 'text', ['notnull' => true]);
        $classTable->addColumn('cancel_date', 'datetime', ['notnull' => true]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $classTable = $schema->getTable('classes');
        $classTable->dropColumn('cancel_reason');
        $classTable->dropColumn('cancel_date');
    }
}
