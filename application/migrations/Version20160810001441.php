<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160810001441 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $creditTable = $schema->getTable('credits');
        $creditTable->addColumn('currency', 'string', ['lenght' => 3, 'default' => 'SGD']);
        $creditTable->addColumn('reason', 'string', ['length' => 20]);
        $creditTable->dropColumn('initial_amount');
        $creditTable->dropColumn('amount_used');
        $creditTable->addColumn('initial_amount', 'decimal');
        $creditTable->addColumn('amount_used', 'decimal', ['default' => 0]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $creditTable = $schema->getTable('credits');
        $creditTable->dropColumn('currency');
        $creditTable->dropColumn('reason');
        $creditTable->dropColumn('initial_amount');
        $creditTable->dropColumn('amount_used');
        $creditTable->addColumn('initial_amount', 'integer');
        $creditTable->addColumn('amount_used', 'integer', ['default' => 0]);
    }
}
