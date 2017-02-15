<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160408080708 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $userDetailTable = $schema->getTable('user_details');
        $userDetailTable->dropColumn('number_of_student');
        $userDetailTable->dropColumn('working_as');
        $userDetailTable->dropColumn('teaching_goal');
        $userDetailTable->dropColumn('teaching_in');
        $userDetailTable->dropColumn('teaching_scope');
        $userDetailTable->dropColumn('schedule_available');
        $userDetailTable->dropColumn('field_of_interest');
        $userDetailTable->dropColumn('whitelist_notification');
        $userDetailTable->dropColumn('register_notification');
        $userDetailTable->addColumn('email_notification', 'boolean', ['default' => 1]);
        $userDetailTable->addColumn('nationality', 'string', ['length' => 3, 'default' => 'IDN']);
        $userDetailTable->addColumn('language_preference', 'string', ['length' => 2, 'default' => 'id']);
        $userDetailTable->addColumn('address_id', 'integer', ['unsigned' => true, 'notnull' => false]);
        $userDetailTable->addForeignKeyConstraint('addresses', ["address_id"], ["id"]);

        $bankTable = $schema->createTable('banks');
        $bankTable->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $bankTable->addColumn('name', 'string', ['length' => 100]);
        $bankTable->addColumn('country_code', 'string', ['length' => 3]);
        $bankTable->setPrimaryKey(['id']);

        $teacherInfoTable = $schema->createTable('teacher_details');
        $teacherInfoTable->addColumn('user_id', 'integer', ['unsigned' => true]);
        $teacherInfoTable->addColumn('payout_option', 'string',
            ['length' => 50, 'default' => \TeacherDetailStatic::PAYOUT_MONTHLY]);
        $teacherInfoTable->addColumn('monthly_class_envisaged', 'string');
        $teacherInfoTable->addColumn('goal', 'string', ['notnull' => false]);
        $teacherInfoTable->addColumn('objective', 'string', ['notnull' => false]);
        $teacherInfoTable->addColumn('website_blog', 'string', ['notnull' => false]);
        $teacherInfoTable->addColumn('paypal_email', 'string', ['notnull' => false]);
        $teacherInfoTable->addColumn('bio', 'text');
        $teacherInfoTable->addColumn('profile_pic', 'string', ['length' => 100, 'default' => 'no_profile.jpg']);
        $teacherInfoTable->addColumn('teacher_type', 'integer');
        $teacherInfoTable->addColumn('job', 'string', ['notnull' => false]);
        $teacherInfoTable->addColumn('identity_type', 'integer', ['notnull' => false]);
        $teacherInfoTable->addColumn('identity_id', 'string', ['length' => 50, 'notnull' => false]);
        $teacherInfoTable->addColumn('office_address_id', 'integer', ['unsigned' => true, 'notnull' => false]);
        $teacherInfoTable->addColumn('bank_branch_name', 'string',
            ['length' => 255, 'default' => '', 'notnull' => false]);
        $teacherInfoTable->addColumn('bank_account_number', 'string', ['length' => 50, 'default' => '', 'notnull' => false]);
        $teacherInfoTable->addColumn('bank_id', 'integer', ['unsigned' => true, 'notnull' => false]);
        $teacherInfoTable->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ]);
        $teacherInfoTable->addForeignKeyConstraint('users', ["user_id"], ["id"], ["onDelete" => "CASCADE"]);
        $teacherInfoTable->addForeignKeyConstraint('addresses', ["office_address_id"], ["id"]);
        $teacherInfoTable->setPrimaryKey(['user_id']);

        $expertiseTable = $schema->createTable('teacher_expertise');
        $expertiseTable->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $expertiseTable->addColumn('user_id', 'integer', ['unsigned' => true]);
        $expertiseTable->addColumn('category_id', 'integer', ['unsigned' => true]);
        $expertiseTable->addColumn('level', 'integer', ['notnull' => false]);
        $expertiseTable->addForeignKeyConstraint('users', ["user_id"], ["id"], ["onDelete" => "CASCADE"]);
        $expertiseTable->addForeignKeyConstraint('categories', ["category_id"], ["id"], ["onDelete" => "CASCADE"]);
        $expertiseTable->setPrimaryKey(['id']);

        $studentInfoTable = $schema->createTable('student_details');
        $studentInfoTable->addColumn('user_id', 'integer', ['unsigned' => true]);
        $studentInfoTable->addForeignKeyConstraint('users', ["user_id"], ["id"], ["onDelete" => "CASCADE"]);
        $studentInfoTable->setPrimaryKey(['user_id']);

        $addressTable = $schema->getTable('addresses');
        $addressTable->addColumn('name', 'string', ['length' => 100, 'notnull' => false]);

    }

    public function postUp(Schema $schema)
    {
        $conn = $this->connection;
        $conn->transactional(function ($conn) {
            $conn->insert('banks', ['name' => 'Bank ANZ Indonesia', 'country_code' => 'IDN']);
            $conn->insert('banks', ['name' => 'Bank Bukopin', 'country_code' => 'IDN']);
            $conn->insert('banks', ['name' => 'Bank Central Asia', 'country_code' => 'IDN']);
            $conn->insert('banks', ['name' => 'Bank CIMB Niaga', 'country_code' => 'IDN']);
            $conn->insert('banks', ['name' => 'Bank Danamon', 'country_code' => 'IDN']);
            $conn->insert('banks', ['name' => 'Bank DBS Indonesia', 'country_code' => 'IDN']);
            $conn->insert('banks', ['name' => 'Bank Internasional Indonesia', 'country_code' => 'IDN']);
            $conn->insert('banks', ['name' => 'Bank Muamalat Indonesia', 'country_code' => 'IDN']);
            $conn->insert('banks', ['name' => 'Bank OCBC NISP', 'country_code' => 'IDN']);
            $conn->insert('banks', ['name' => 'Bank Permata', 'country_code' => 'IDN']);
            $conn->insert('banks', ['name' => 'Bank Panin', 'country_code' => 'IDN']);
            $conn->insert('banks', ['name' => 'Bank Syariah Mandiri', 'country_code' => 'IDN']);
            $conn->insert('banks', ['name' => 'Bank UOB Indonesia', 'country_code' => 'IDN']);
            $conn->insert('banks', ['name' => 'Bank Negara Indonesia', 'country_code' => 'IDN']);
            $conn->insert('banks', ['name' => 'Bank Rakyat Indonesia', 'country_code' => 'IDN']);
            $conn->insert('banks', ['name' => 'Bank Mandiri', 'country_code' => 'IDN']);
            $conn->insert('banks', ['name' => 'Bank Tabungan Negara', 'country_code' => 'IDN']);
            $conn->insert('banks', ['name' => 'Citibank', 'country_code' => 'IDN']);
            $conn->insert('banks', ['name' => 'Standard Chartered', 'country_code' => 'IDN']);
            $conn->insert('banks', ['name' => 'HSBC', 'country_code' => 'IDN']);
            $conn->insert('banks', ['name' => 'Maybank', 'country_code' => 'IDN']);
            $conn->insert('banks', ['name' => 'Lain-lain', 'country_code' => 'IDN']);

            $conn->insert('banks', ['name' => 'OCBC', 'country_code' => 'SGP']);
            $conn->insert('banks', ['name' => 'DBS', 'country_code' => 'SGP']);
            $conn->insert('banks', ['name' => 'UOB', 'country_code' => 'SGP']);
            $conn->insert('banks', ['name' => 'HSBC', 'country_code' => 'SGP']);
            $conn->insert('banks', ['name' => 'Citibank', 'country_code' => 'SGP']);
            $conn->insert('banks', ['name' => 'Standard Chartered', 'country_code' => 'SGP']);
            $conn->insert('banks', ['name' => 'Maybank', 'country_code' => 'SGP']);
            $conn->insert('banks', ['name' => 'ABN Amro', 'country_code' => 'SGP']);
            $conn->insert('banks', ['name' => 'Bank of Singapore', 'country_code' => 'SGP']);
            $conn->insert('banks', ['name' => 'Far Eastern Bank', 'country_code' => 'SGP']);
            $conn->insert('banks', ['name' => 'BNP Paribas', 'country_code' => 'SGP']);
            $conn->insert('banks', ['name' => 'Malayan Banking', 'country_code' => 'SGP']);
        });

    }


    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $table = $schema->getTable('user_details');
        $table->dropColumn('nationality');
        $table->dropColumn('address_id');
        $table->dropColumn('language_preference');
        $table->dropColumn('register_notification');
        $table->addColumn('number_of_student', 'integer');
        $table->addColumn('working_as', 'integer');
        $table->addColumn('teaching_goal', 'text');
        $table->addColumn('teaching_in', 'text');
        $table->addColumn('teaching_scope', 'text');
        $table->addColumn('schedule_available', 'text');
        $table->addColumn('field_of_interest', 'text');
        $table->addColumn('whitelist_notification', 'boolean', ['default' => 0]);
        $table->addColumn('register_notification', 'boolean', ['default' => 0]);

        $addressTable = $schema->getTable('addresses');
        $addressTable->dropColumn('name');

        $schema->dropTable('teacher_expertise');
        $schema->dropTable('teacher_details');
        $schema->dropTable('student_details');
        $schema->dropTable('banks');

    }
}
