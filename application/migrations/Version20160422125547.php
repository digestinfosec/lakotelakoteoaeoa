<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160422125547 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $table = $schema->getTable('teacher_details');
        $table->dropColumn('profile_pic');

        $userTable = $schema->getTable('users');
        $userTable->addColumn('profile_pic', 'string', ['length' => 100, 'default' => 'no_profile.jpg']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $table = $schema->getTable('users');
        $table->dropColumn('profile_pic');

        $teacherTable = $schema->getTable('users');
        $teacherTable->addColumn('profile_pic', 'string', ['length' => 100, 'default' => 'no_profile.jpg']);
    }
}
