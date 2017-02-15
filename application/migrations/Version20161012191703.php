<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161012191703 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $classTable = $schema->getTable('classes');
        $classTable->addColumn('draft_step', 'integer', ['default' => 1]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $classTable = $schema->getTable('classes');
        $classTable->dropColumn('draft_step');
    }
}
