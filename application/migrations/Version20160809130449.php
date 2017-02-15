<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160809130449 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $paymentTable=$schema->getTable('payments');
        $paymentTable->addColumn('photo', 'string', ['length' => '255']);

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $paymentTable=$schema->getTable('payments');
        $paymentTable->dropColumn('photo');

    }
}
