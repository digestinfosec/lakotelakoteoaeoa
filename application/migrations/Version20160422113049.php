<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160422113049 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $table = $schema->getTable('user_details');
        $table->dropColumn('academic_level');
        $table->addColumn('academic_level', 'string', ['length' => 50, 'default' => '']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $table = $schema->getTable('user_details');
        $table->dropColumn('academic_level');
        $table->addColumn('academic_level', 'integer');
    }
}
