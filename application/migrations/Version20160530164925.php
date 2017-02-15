<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160530164925 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // Doctrine DBAL tidak bisa rename type column tanpa menghapus.
        // TODO : Solusi: 1. Pindah ke create table semua ketika production atau 2. Raw Query

        $teacherInfoTable = $schema->getTable('teacher_details');
        $teacherInfoTable->removeForeignKey('FK_BFE486CBAAA4D314');
        $teacherInfoTable->dropColumn('office_address_id');
        $teacherInfoTable->dropColumn('monthly_class_envisaged');
        $teacherInfoTable->dropColumn('payout_option');
        $teacherInfoTable->dropColumn('objective');

        $teacherInfoTable->addColumn('monthly_class_envisaged', 'integer');
        $teacherInfoTable->addColumn('payout_option', 'integer', ['notnull' => false]);
        $teacherInfoTable->addColumn('objective', 'integer');
        $teacherInfoTable->addColumn('office_address', 'text', ['notnull' => false]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $teacherInfoTable = $schema->getTable('teacher_details');
        $teacherInfoTable->dropColumn('office_address');
        $teacherInfoTable->dropColumn('monthly_class_envisaged');
        $teacherInfoTable->dropColumn('payout_option');
        $teacherInfoTable->dropColumn('objective');

        $teacherInfoTable->addColumn('monthly_class_envisaged', 'string');
        $teacherInfoTable->addColumn('payout_option', 'string',
            ['length' => 50, 'default' => \TeacherDetailStatic::PAYOUT_MONTHLY]);
        $teacherInfoTable->addColumn('objective', 'string');
        $teacherInfoTable->addColumn('office_address_id', 'integer', ['unsigned' => true, 'notnull' => false]);
        $teacherInfoTable->addForeignKeyConstraint('addresses', ["office_address_id"], ["id"]);
    }
}
