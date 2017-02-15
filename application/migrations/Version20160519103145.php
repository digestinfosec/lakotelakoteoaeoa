<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160519103145 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $imageTable = $schema->getTable('images');
        $imageTable->changeColumn('entity_id', ['notnull' => false]);
        $imageTable->changeColumn('entity', ['notnull' => false]);
        $imageTable->addColumn('filename', 'string', ['length' => 100]);
        $imageTable->addColumn('extension', 'string', ['length' => 5]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $imageTable = $schema->getTable('images');
        $imageTable->changeColumn('entity_id', ['notnull' => true]);
        $imageTable->changeColumn('entity', ['notnull' => true]);
        $imageTable->dropColumn('filename');
        $imageTable->dropColumn('extension');
    }
}
