<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160731182806 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $table = $schema->getTable('user_details');
        $table->addColumn('home_address', 'string', ['length' => 999, 'default' => '']);
        $table->addColumn('business_address', 'string', ['length' => 999, 'default' => '']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $table = $schema->getTable('user_details');
        $table->dropColumn('home_address');
        $table->dropColumn('business_address');
    }
}
