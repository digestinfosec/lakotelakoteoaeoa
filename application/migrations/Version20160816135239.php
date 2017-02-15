<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160816135239 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $classAttendees = $schema->getTable('vouchers');
        $classAttendees->addColumn('is_redeemed', 'boolean', ['default' => 0]);

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $classAttendees = $schema->getTable('vouchers');
        $classAttendees->dropColumn('is_redeemed');

    }
}
