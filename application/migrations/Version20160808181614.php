<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160808181614 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $courseTable = $schema->getTable('classes');
        $courseTable->addColumn('unique_id', 'string', ['length' => 20, 'notnull' => false]);
        $courseTable->addUniqueIndex(['unique_id']);

        $voucherTable = $schema->getTable('vouchers');
        $voucherTable->addUniqueIndex(['voucher_code']);
        $voucherTable->removeForeignKey('FK_931507488D9F6D38');
        $voucherTable->dropColumn('order_id');

        $voucherTable->addColumn('order_detail_id', 'integer', ['unsigned' => true, 'notnull' => false]);
        $voucherTable->addForeignKeyConstraint('order_details', ["order_detail_id"], ["id"], ["onDelete" => "SET NULL"]);
    }

    public function postUp(Schema $schema)
    {
        $conn = $this->connection;

        $query = "SELECT * FROM classes";
        $stmt = $conn->query($query);
        $courses = $stmt->fetchAll();

        foreach ($courses as $course)
        {
            $querySchedule = "SELECT * FROM schedules WHERE class_id = " . $course['id'] . " LIMIT 1";
            $stmt = $conn->query($querySchedule);
            $schedule = $stmt->fetchAll()[0];

            $queryCategory = "SELECT * FROM categories WHERE id = " . $course['category_id'] . " LIMIT 1";
            $stmt = $conn->query($queryCategory);
            $category = $stmt->fetchAll()[0];

            $time = date('YmdHi', strtotime($schedule['date'] . ' ' . $schedule['start_time']));

            $random_marker = str_pad(rand(1, 999), 3, 0, STR_PAD_LEFT);
            $unique_id = $category['code'] . $time . $random_marker;
            $conn->update('classes', ['unique_id' => $unique_id], ['id' => $course['id']]);
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $voucherTable = $schema->getTable('vouchers');
        $voucherTable->dropIndex('UNIQ_931507487678B020');
        $voucherTable->addColumn('order_id', 'integer', ['unsigned' => true]);
        $voucherTable->addForeignKeyConstraint('orders', ["order_id"], ["id"], ["onDelete" => "RESTRICT"]);
        $voucherTable->removeForeignKey('FK_9315074864577843');
        $voucherTable->dropColumn('order_detail_id');

        $courseTable = $schema->getTable('classes');
        $courseTable->dropColumn('unique_id');
    }
}
