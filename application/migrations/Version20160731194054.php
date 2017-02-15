<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160731194054 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $table = $schema->getTable('user_details');
        $table->addColumn('notification_newsletter', 'boolean', ['default' => 1]);

        $table = $schema->getTable('teacher_details');
        $table->addColumn('notification_class_register', 'boolean', ['default' => 1]);
        $table->addColumn('notification_class_add_wishlist', 'boolean', ['default' => 1]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $table = $schema->getTable('user_details');
        $table->dropColumn('notification_newsletter');

        $table = $schema->getTable('teacher_details');
        $table->dropColumn('notification_class_register');
        $table->dropColumn('notification_class_add_wishlist');
    }
}
