<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160818122320 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $voucherTable = $schema->getTable('vouchers');
        $voucherTable->addColumn('cancel_reason', 'text', ['notnull' => false]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $voucherTable = $schema->getTable('vouchers');
        $voucherTable->dropColumn('cancel_reason');
    }
}
