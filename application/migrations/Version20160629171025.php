<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160629171025 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $courseTable = $schema->getTable('classes');
        $courseTable->addColumn('status', 'integer', ['default' => \CourseStatic::STATUS_NOT_STARTED]);

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $courseTable = $schema->getTable('classes');
        $courseTable->dropColumn('status');

    }
}
