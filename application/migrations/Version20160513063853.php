<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160513063853 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // Added created_at and updated_at
        $addressesTable = $schema->getTable('addresses');
        $addressesTable->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);
        $addressesTable->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP'
        ]);

        $banksTable = $schema->getTable('banks');
        $banksTable->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);
        $banksTable->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP'
        ]);

        $categoriesTable = $schema->getTable('categories');
        $categoriesTable->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);
        $categoriesTable->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP'
        ]);

        $class_commentsTable = $schema->getTable('class_comments');
        $class_commentsTable->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);
        $class_commentsTable->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP'
        ]);

        $class_ratingsTable = $schema->getTable('class_ratings');
        $class_ratingsTable->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);
        $class_ratingsTable->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP'
        ]);

        $imagesTable = $schema->getTable('images');
        $imagesTable->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);
        $imagesTable->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP'
        ]);

        $institutionsTable = $schema->getTable('institutions');
        $institutionsTable->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);
        $institutionsTable->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP'
        ]);

        $recommend_teachersTable = $schema->getTable('recommend_teachers');
        $recommend_teachersTable->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);
        $recommend_teachersTable->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP'
        ]);

        $student_detailsTable = $schema->getTable('student_details');
        $student_detailsTable->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);
        $student_detailsTable->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP'
        ]);

        $teacher_detailsTable = $schema->getTable('teacher_details');
        $teacher_detailsTable->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);

        $teacher_expertiseTable = $schema->getTable('teacher_expertise');
        $teacher_expertiseTable->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);
        $teacher_expertiseTable->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP'
        ]);

        $user_detailsTable = $schema->getTable('user_details');
        $user_detailsTable->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);

        $venuesTable = $schema->getTable('venues');
        $venuesTable->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP'
        ]);

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // Deleted created_at and updated_at
        $addressTable = $schema->getTable('addresses');
        $addressTable->dropColumn('created_at');
        $addressTable->dropColumn('updated_at');

        $banksTable = $schema->getTable('banks');
        $banksTable->dropColumn('created_at');
        $banksTable->dropColumn('updated_at');

        $categoriesTable = $schema->getTable('categories');
        $categoriesTable->dropColumn('created_at');
        $categoriesTable->dropColumn('updated_at');

        $class_commentsTable = $schema->getTable('class_comments');
        $class_commentsTable->dropColumn('created_at');
        $class_commentsTable->dropColumn('updated_at');

        $class_ratingsTable = $schema->getTable('class_ratings');
        $class_ratingsTable->dropColumn('created_at');
        $class_ratingsTable->dropColumn('updated_at');

        $imagesTable = $schema->getTable('images');
        $imagesTable->dropColumn('created_at');
        $imagesTable->dropColumn('updated_at');

        $institutionsTable = $schema->getTable('institutions');
        $institutionsTable->dropColumn('created_at');
        $institutionsTable->dropColumn('updated_at');

        $recommend_teachersTable = $schema->getTable('recommend_teachers');
        $recommend_teachersTable->dropColumn('created_at');
        $recommend_teachersTable->dropColumn('updated_at');

        $student_detailsTable = $schema->getTable('student_details');
        $student_detailsTable->dropColumn('created_at');
        $student_detailsTable->dropColumn('updated_at');

        $teacher_detailsTable = $schema->getTable('teacher_details');
        $teacher_detailsTable->dropColumn('created_at');

        $user_detailsTable = $schema->getTable('user_details');
        $user_detailsTable->dropColumn('created_at');

        $venuesTable = $schema->getTable('venues');
        $venuesTable->dropColumn('updated_at');
    }
}
