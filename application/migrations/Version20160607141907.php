<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160607141907 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $classRatingPivot = $schema->getTable('class_ratings');
        $classRatingPivot->removeForeignKey('FK_BC36035A32EFC6');
        $classRatingPivot->removeForeignKey('FK_BC36035EA000B10');
        $schema->dropTable('class_ratings');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $classRatingPivot = $schema->createTable('class_ratings');
        $classRatingPivot->addColumn('rating_id', 'integer', ['unsigned' => true]);
        $classRatingPivot->addColumn('class_id', 'integer', ['unsigned' => true]);
        $classRatingPivot->setPrimaryKey(['rating_id', 'class_id']);
        $classRatingPivot->addForeignKeyConstraint('ratings', ['rating_id'], ['id'], ['onDelete' => 'CASCADE']);
        $classRatingPivot->addForeignKeyConstraint('classes', ['class_id'], ['id'], ['onDelete' => 'CASCADE']);
    }
}
