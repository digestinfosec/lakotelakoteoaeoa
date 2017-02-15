<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160901163518 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $creditTable = $schema->getTable('credits');
        $creditTable->dropColumn('expired_date');
        $creditTable->addColumn('expired_date', 'datetime');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $creditTable = $schema->getTable('credits');
        $creditTable->dropColumn('expired_date');
        $creditTable->addColumn('expired_date', 'date');
    }
}
