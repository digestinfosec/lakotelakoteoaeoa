<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160728143950 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $courseTable = $schema->getTable('classes');
        $courseTable->addColumn('changed_price', 'boolean', ['default' => 0]);
        $courseTable->addColumn('changed_schedule', 'boolean', ['default' => 0]);
        $courseTable->addColumn('changed_venue', 'boolean', ['default' => 0]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $courseTable = $schema->getTable('classes');
        $courseTable->dropColumn('changed_price');
        $courseTable->dropColumn('changed_schedule');
        $courseTable->dropColumn('changed_venue');
    }
}
