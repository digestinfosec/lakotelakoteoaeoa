<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160812164658 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $classAttendees = $schema->getTable('class_attendees');
        $this->addSql('ALTER TABLE class_attendees DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE class_attendees ADD id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY');
        $this->addSql('ALTER TABLE class_attendees DROP FOREIGN KEY FK_A316F41AA76ED395');
        $this->addSql('ALTER TABLE class_attendees DROP user_id');

        $classAttendees->addColumn('voucher_id', 'integer',['unsigned'=> true]);
        $classAttendees->addForeignKeyConstraint('vouchers', ["voucher_id"], ["id"], ["onDelete" => "CASCADE"]);

        $classAttendees->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);
        $classAttendees->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP'
        ]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $classAttendees = $schema->getTable('class_attendees');
        $this->addSql('ALTER TABLE class_attendees DROP id');
        $this->addSql('ALTER TABLE class_attendees DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE class_attendees DROP FOREIGN KEY FK_A316F41A28AA1B6F');
        $this->addSql('ALTER TABLE class_attendees DROP voucher_id');
        $this->addSql('ALTER TABLE class_attendees ADD user_id INT UNSIGNED NOT NULL');
        $classAttendees->dropColumn('created_at');
        $classAttendees->dropColumn('updated_at');

        $classAttendees->dropColumn('id');
        $classAttendees->addForeignKeyConstraint('users', ["user_id"], ["id"], ["onDelete" => "CASCADE"]);
        $classAttendees->setPrimaryKey(['user_id', 'class_id']);
    }
}
