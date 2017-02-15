<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160401103006 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $table = $schema->createTable('categories');
        $table->addColumn('id', 'integer', ['autoincrement' => true, 'unsigned' => true]);
        $table->addColumn('parent_id', 'integer', ['unsigned' => true, 'default' => 0]);
        $table->addColumn('name', 'string', ['length' => 100]);
        $table->addColumn('icon', 'string', ['length' => 100, 'notnull' => false]);
        $table->addColumn('image', 'string', ['length' => 100, 'notnull' => false]);
        $table->addColumn('description', 'text', ['notnull' => false]);
        $table->addColumn('code', 'string', ['length' => 5]);
        $table->setPrimaryKey(['id']);
    }

    public function postUp(Schema $schema)
    {
        $conn = $this->connection;
        $conn->transactional(function ($conn) {
            $conn->insert('categories', ['parent_id' => 0, 'name' => 'Art, design, culture', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => '']);
            $conn->insert('categories', ['parent_id' => 1, 'name' => 'Photography', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'AP']);
            $conn->insert('categories', ['parent_id' => 1, 'name' => 'Graphic & Design', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'AG']);
            $conn->insert('categories', ['parent_id' => 1, 'name' => 'Painting & Drawing', 'icon' => NULL, 'image' => 'cl_painting.png', 'description' => NULL, 'code' => 'APD']);
            $conn->insert('categories', ['parent_id' => 1, 'name' => 'Creative Writing', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'AC']);
            $conn->insert('categories', ['parent_id' => 1, 'name' => 'Advertising', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'AA']);
            $conn->insert('categories', ['parent_id' => 1, 'name' => 'Media & Communication', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'AM']);
            $conn->insert('categories', ['parent_id' => 1, 'name' => 'Film & Video', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'AF']);
            $conn->insert('categories', ['parent_id' => 1, 'name' => 'Music & Audio', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'AMA']);
            $conn->insert('categories', ['parent_id' => 1, 'name' => 'Hobbies & Craft', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'AH']);
            $conn->insert('categories', ['parent_id' => 1, 'name' => 'Dance & Performing Arts', 'icon' => NULL, 'image' => 'cl_tango.png', 'description' => NULL, 'code' => 'ADP']);
            $conn->insert('categories', ['parent_id' => 1, 'name' => 'Fashion & Beauty', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'AFB']);
            $conn->insert('categories', ['parent_id' => 1, 'name' => 'Foreign Languages', 'icon' => NULL, 'image' => 'cl_spanish.png', 'description' => NULL, 'code' => 'AFL']);
            $conn->insert('categories', ['parent_id' => 1, 'name' => 'Home Interior Design', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'AHI']);
            $conn->insert('categories', ['parent_id' => 0, 'name' => 'Business', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => '']);
            $conn->insert('categories', ['parent_id' => 15, 'name' => 'Finance', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'BF']);
            $conn->insert('categories', ['parent_id' => 15, 'name' => 'Marketing & Online Marketing', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'BM']);
            $conn->insert('categories', ['parent_id' => 15, 'name' => 'Entrepreneurship', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'BE']);
            $conn->insert('categories', ['parent_id' => 15, 'name' => 'Business Coaching', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'BB']);
            $conn->insert('categories', ['parent_id' => 15, 'name' => 'Personal Development & Leadership', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'BP']);
            $conn->insert('categories', ['parent_id' => 0, 'name' => 'F&B', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => '']);
            $conn->insert('categories', ['parent_id' => 21, 'name' => 'Cooking & Baking', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'FC']);
            $conn->insert('categories', ['parent_id' => 21, 'name' => 'Drink & Bartending', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'FD']);
            $conn->insert('categories', ['parent_id' => 21, 'name' => 'Wine Culture', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'FW']);
            $conn->insert('categories', ['parent_id' => 0, 'name' => 'Lifestyle', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => '']);
            $conn->insert('categories', ['parent_id' => 25, 'name' => 'General Health & Women\'s Health', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'LG']);
            $conn->insert('categories', ['parent_id' => 25, 'name' => 'Sports, Fitness & Wellness', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'LS']);
            $conn->insert('categories', ['parent_id' => 25, 'name' => 'Diet & Nutrition', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'LD']);
            $conn->insert('categories', ['parent_id' => 25, 'name' => 'Psychology & Therapy', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'LP']);
            $conn->insert('categories', ['parent_id' => 0, 'name' => 'Parenting & Family', 'icon' => NULL, 'image' => '', 'description' => NULL,'code' =>  '']);
            $conn->insert('categories', ['parent_id' => 30, 'name' => 'Parenting Guide', 'icon' => NULL, 'image' => 'cl_parent.png', 'description' => NULL, 'code' => 'PP']);
            $conn->insert('categories', ['parent_id' => 30, 'name' => 'Kids Arts', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'PK']);
            $conn->insert('categories', ['parent_id' => 30, 'name' => 'Kids Sports & Leisure', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'PKS']);
            $conn->insert('categories', ['parent_id' => 0, 'name' => 'Tech', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => '']);
            $conn->insert('categories', ['parent_id' => 34, 'name' => 'Programming', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'TP']);
            $conn->insert('categories', ['parent_id' => 34, 'name' => 'Web Design', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'TW']);
            $conn->insert('categories', ['parent_id' => 34, 'name' => 'Mobile App', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'TM']);
            $conn->insert('categories', ['parent_id' => 34, 'name' => 'Science', 'icon' => NULL, 'image' => '', 'description' => NULL, 'code' => 'TS']);
        });

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $sm = $this->connection->getSchemaManager();
        if ($sm->tablesExist('admin'))
            $schema->dropTable('admin');
        if ($sm->tablesExist('booking_class'))
            $schema->dropTable('booking_class');
        if ($sm->tablesExist('booking_classes'))
            $schema->dropTable('booking_classes');
        if ($sm->tablesExist('classes'))
            $schema->dropTable('classes');
        if ($sm->tablesExist('class_comment'))
            $schema->dropTable('class_comment');
        if ($sm->tablesExist('class_comments'))
            $schema->dropTable('class_comments');
        if ($sm->tablesExist('data_challenge'))
            $schema->dropTable('data_challenge');
        if ($sm->tablesExist('like_class'))
            $schema->dropTable('like_class');
        if ($sm->tablesExist('class_likes'))
            $schema->dropTable('class_likes');
        if ($sm->tablesExist('m_absensi'))
            $schema->dropTable('m_absensi');
        if ($sm->tablesExist('m_category'))
            $schema->dropTable('m_category');
        if ($sm->tablesExist('m_categories'))
            $schema->dropTable('m_categories');
        if ($sm->tablesExist('m_class'))
            $schema->dropTable('m_class');
        if ($sm->tablesExist('m_classes'))
            $schema->dropTable('m_classes');
        if ($sm->tablesExist('m_credit'))
            $schema->dropTable('m_credit');
        if ($sm->tablesExist('m_credit_confirmation'))
            $schema->dropTable('m_credit_confirmation');
        if ($sm->tablesExist('m_institution'))
            $schema->dropTable('m_institution');
        if ($sm->tablesExist('m_institutions'))
            $schema->dropTable('m_institutions');
        if ($sm->tablesExist('m_log'))
            $schema->dropTable('m_log');
        if ($sm->tablesExist('m_news'))
            $schema->dropTable('m_news');
        if ($sm->tablesExist('m_order'))
            $schema->dropTable('m_order');
        if ($sm->tablesExist('m_order_detail'))
            $schema->dropTable('m_order_detail');
        if ($sm->tablesExist('m_page'))
            $schema->dropTable('m_page');
        if ($sm->tablesExist('m_payment'))
            $schema->dropTable('m_payment');
        if ($sm->tablesExist('m_schedule'))
            $schema->dropTable('m_schedule');
        if ($sm->tablesExist('m_schedules'))
            $schema->dropTable('m_schedules');
        if ($sm->tablesExist('m_site_configuration'))
            $schema->dropTable('m_site_configuration');
        if ($sm->tablesExist('m_slideshow'))
            $schema->dropTable('m_slideshow');
        if ($sm->tablesExist('m_strings'))
            $schema->dropTable('m_strings');
        if ($sm->tablesExist('m_users'))
            $schema->dropTable('m_users');
        if ($sm->tablesExist('notif_email'))
            $schema->dropTable('notif_email');
        if ($sm->tablesExist('wishlist_class'))
            $schema->dropTable('wishlist_class');
        if ($sm->tablesExist('class_wishlists'))
            $schema->dropTable('class_wishlists');
        if ($sm->tablesExist('categories'))
            $schema->dropTable('categories');
        if ($sm->tablesExist('user_details'))
            $schema->dropTable('user_details');
        if ($sm->tablesExist('user_attendances'))
            $schema->dropTable('user_attendances');
        if ($sm->tablesExist('users'))
            $schema->dropTable('users');
        if ($sm->tablesExist('migrations'))
            $schema->dropTable('migrations');
    }
}
