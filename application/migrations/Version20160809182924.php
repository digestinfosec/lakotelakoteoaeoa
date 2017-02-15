<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160809182924 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $paymentTable=$schema->getTable('payments');
        $paymentTable->addColumn('bank_name', 'string');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $paymentTable=$schema->getTable('payments');
        $paymentTable->dropColumn('bank_name');

    }
}
