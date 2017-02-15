<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Rougin\SparkPlug\Instance;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160428143130 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $ratingTable = $schema->createTable("ratings");
        $ratingTable->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $ratingTable->addColumn('class_id', 'integer', ['unsigned' => true]);
        $ratingTable->addColumn('user_id', 'integer', ['unsigned' => true]);
        $ratingTable->addColumn('review', 'text', ['notnull' => false]);
        $ratingTable->addColumn('rate', 'integer', ['notnull' => false]);
        $ratingTable->addColumn('status', 'integer', ['default' => 0]);
        $ratingTable->addColumn('reply_to', 'integer', ['unsigned' => true, 'default' => 0]);
        $ratingTable->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);
        $ratingTable->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP'
        ]);
        $ratingTable->setPrimaryKey(['id']);
        $ratingTable->addForeignKeyConstraint('users', ["user_id"], ["id"], ["onDelete" => "CASCADE"]);
        $ratingTable->addForeignKeyConstraint('classes', ["class_id"], ["id"], ["onDelete" => "CASCADE"]);
        $ratingTable->addUniqueIndex(['class_id', 'user_id']);

        $commentTable = $schema->createTable('comments');
        $commentTable->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $commentTable->addColumn('user_id', 'integer', ['unsigned' => true]);
        $commentTable->addColumn('comment', 'text');
        $commentTable->addColumn('status', 'integer', ['default' => 0]);
        $commentTable->addColumn('reply_to', 'integer', ['unsigned' => true, 'default' => 0]);
        $commentTable->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);
        $commentTable->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP'
        ]);
        $commentTable->setPrimaryKey(['id']);
        $commentTable->addForeignKeyConstraint('users', ["user_id"], ["id"], ["onDelete" => "CASCADE"]);


        $classCommentPivot = $schema->createTable('class_comments');
        $classCommentPivot->addColumn('comment_id', 'integer', ['unsigned' => true]);
        $classCommentPivot->addColumn('class_id', 'integer', ['unsigned' => true]);
        $classCommentPivot->setPrimaryKey(['comment_id', 'class_id']);
        $classCommentPivot->addForeignKeyConstraint('comments', ["comment_id"], ["id"], ["onDelete" => "CASCADE"]);
        $classCommentPivot->addForeignKeyConstraint('classes', ["class_id"], ["id"], ["onDelete" => "CASCADE"]);

        $classRatingPivot = $schema->createTable('class_ratings');
        $classRatingPivot->addColumn('rating_id', 'integer', ['unsigned' => true]);
        $classRatingPivot->addColumn('class_id', 'integer', ['unsigned' => true]);
        $classRatingPivot->setPrimaryKey(['rating_id', 'class_id']);
        $classRatingPivot->addForeignKeyConstraint('ratings', ["rating_id"], ["id"], ["onDelete" => "CASCADE"]);
        $classRatingPivot->addForeignKeyConstraint('classes', ["class_id"], ["id"], ["onDelete" => "CASCADE"]);

        $addressTable = $schema->getTable('addresses');
        $addressTable->dropColumn('entity_id');
        $addressTable->dropColumn('entity');
        $addressTable->dropColumn('lat');
        $addressTable->dropColumn('long');
        $addressTable->addColumn('latitude', 'string', ['length' => 100, 'notnull' => false]);
        $addressTable->addColumn('longitude', 'string', ['length' => 100, 'notnull' => false]);

        $classTable = $schema->getTable('classes');
        $classTable->addColumn('currency', 'string', ['lenght' => 3, 'default' => 'IDR']);

        $userTable = $schema->getTable('users');
        $keys = array_keys($userTable->getIndexes());
        $userTable->dropIndex($keys[1]);
        $userTable->addUniqueIndex(['email'], 'UNIQ_EMAIL_USER');
        $userTable->addUniqueIndex(['username'], 'UNIQ_USERNAME_USER');
    }

    public function postUp(Schema $schema)
    {
//         $conn = $this->connection;

//         $conn->transactional(function ($conn) {
//             $conn->insert('addresses', [
//                 'address_line1' => 'Jl. Cilandak Permai Raya No. 17 Kav 3 Cilandak',
//                 'postal_code' => '12560',
//                 'city' => 'Jakarta Selatan',
//                 'state' => 'DKI Jakarta',
//                 'country' => 'Indonesia',
//                 'latitude' => "-6.2976049",
//                 'longitude' => "106.8027571"
//             ]);

//             $address_id = $conn->lastInsertId();

//             $conn->insert('venues', [
//                 'name' => 'Apecsa Optima Solusi HQ',
//                 'address_id' => $address_id
//             ]);

//             $venue_id = $conn->lastInsertId();
//             $query = "SELECT * FROM users WHERE users.email = 'msulhas@gmail.com'";
//             $stmt = $conn->query($query);
//             $teacher = $stmt->fetchAll();

//             $conn->insert('classes', [
//                 'teacher_id' => 1,
//                 'title' => 'Belajar Pemrograman Web',
//                 'slug' => 'belajar-pemrograman-web',
//                 'description' => '<p>Ingin belajar web programming, harus mulai dari mana?” Pertanyaan ini juga ada dipikiran saya sewaktu mulai belajar web programming, apakah mesti belajar algoritma dulu? HTML? PHP? atau apa? Juga berapa lama waktu yang dibutuhkan untuk menjadi web programmer yang ahli?</p>
//                 <p>Saya akan mencoba menjawab semua pertanyaan ini berdasarkan pengalaman pribadi. Bagi rekan-rekan yang sudah lama ‘makan asam garam’ web programming, mungkin memiliki pendapat berbeda, silahkan tinggalkan komentar di akhir artikel… :)</p>',
//                 'content' => '<p>Teori Dasar dan Sejarah PHP:</p>
//                     <ol>
//                     <li>Tutorial PHP Dasar Untuk Pemula</li>
//                     <li>Tutorial PHP Part 1: Pengertian dan Fungsi PHP dalam Pemograman Web</li>
//                     <li>Tutorial PHP Part 2: Sejarah PHP dan Perkembangan Versi PHP</li>
//                     </ol>
//                     <p>Cara Menginstal XAMPP dan Menjalankan PHP:</p>
//                     <ol>
//                     <li>Tutorial PHP Part 3: Cara Menginstall PHP dengan XAMPP 1.8.3</li>
//                     <li>Tutorial PHP Part 4: Cara Menjalankan Web Server Apache dengan XAMPP</li>
//                     <li>Tutorial PHP Part 5: Cara Menjalankan File PHP dengan XAMPP</li>
//                     <li>Tutorial PHP Part 6: Cara Kerja Web Server Menjalankan Kode PHP</li>
//                     <li>Tutorial PHP Part 7: Cara Memasukkan kode PHP ke dalam HTML</li>
//                     <li>Tutorial PHP Part 8: Cara Mengubah File Konfigurasi PHP (php.ini)</li>
//                     </ol>
//                     <p>Aturan Penulisan PHP:</p>
//                     <ol>
//                     <li>Tutorial PHP Part 9: Aturan Dasar Penulisan Kode PHP</li>
//                     <li>Tutorial PHP Part 10: Cara Penulisan Komentar dalam Kode PHP</li>
//                     <li>Tutorial PHP Part 11: Pengertian Variabel dan Cara Penulisan Variabel PHP</li>
//                     <li>Tutorial PHP Part 12: Pengertian Konstanta dan Cara Penulisan Konstanta PHP</li>
//                     </ol>
//                     <p>Tipe data dalam PHP:</p>
//                     <ol>
//                     <li>Tutorial PHP Part 13: Mengenal Tipe Data Integer dan Cara Penulisan Integer dalam PHP</li>
//                     <li>Tutorial PHP Part 14: Mengenal Tipe Data Float dan Cara Penulisan Float dalam PHP</li>
//                     <li>Tutorial PHP Part 15: Mengenal Tipe Data String dan Cara Penulisan String dalam PHP</li>
//                     <li>Tutorial PHP Part 16: Mengenal Tipe Data Boolean dan Cara Penulisan Boolean dalam PHP</li>
//                     <li>Tutorial PHP Part 17: Mengenal Tipe Data Array dan Cara Penulisan Array dalam PHP</li>
//                     </ol>',
//                 'prerequisite_skill' => 0,
//                 'end_goal' => 'Mengerti tentang Web Development dengan PHP',
//                 'class_leader' => 'M. Sulton Hasanuddin',
//                 'about_leader' => 'Web Developer based on Jakarta, Indonesia',
//                 'type' => \CourseStatic::CLASS_SINGLE,
//                 'price' => '200000',
//                 'currency' => 'IDR',
//                 'available_seat' => 20,
//                 'special_equipment' => '',
//                 'pack' => 0,
//                 'level' => \CourseStatic::LEVEL_BEGINNER,
//                 'publish_status' => \CourseStatic::PUBLISH_SUCCESS,
//                 'category_id' => 35,
//                 'teacher_id' => $teacher[0]['id']
//             ]);

//             $class_id = $conn->lastInsertId();

//             $conn->insert('schedules', [
//                 'venue_id' => $venue_id,
//                 'class_id' => $class_id,
// //                'date' => '2016-04-27',
//                 'available_seat_left' => 20,
//                 'date' => '2016-06-30',
//                 'start_time' => '08:00',
//                 'end_time' => '14:00',
//             ]);

//             $ci = Instance::create(ROOT_PATH);
//             $ci->load->library('encrypt');

//             $conn = $this->connection;
//             $conn->insert('users', [
//                 'first_name' => 'Kenzo',
//                 'last_name' => 'Hayashi',
//                 'email' => 'shcode@live.com',
//                 'username' => 'kenzo',
//                 'password' => $ci->encrypt->encode('User1234'),
//                 'type' => \UserStatic::TYPE_CUSTOMER,
//                 'is_student' => 1,
//                 'status' => \UserStatic::STATUS_ACTIVE,
//                 'profile_pic' => 'kenzo.png'
//             ]);

//             $user_id = $conn->lastInsertId();
//             $conn->insert('user_details', [
//                 'birth_date' => '1992-03-10',
//                 'home_phone' => '021-1234567',
//                 'mobile_phone' => '08568883855',
//                 'gender' => \UserDetailStatic::GENDER_MALE,
//                 'marital_status' => \UserDetailStatic::MARITAL_SINGLE,
//                 'academic_level' => 4,
//                 'user_id' => $user_id
//             ]);

//             $conn->insert('ratings', [
//                 'review' => 'Terima kasih atas kelasnya, sekarang saya bisa membuat website sendiri.',
//                 'rate' => 5,
//                 'user_id' => $user_id,
//                 'class_id' => $class_id
//             ]);

//             $rating_id = $conn->lastInsertId();

//             $conn->insert('comments', [
//                 'comment' => 'Apakah ada kelas untuk membuat template untuk wordpress, kalau ada saya mau ikut. Terima kasih',
//                 'user_id' => $user_id
//             ]);

//             $comment_id = $conn->lastInsertId();

//             $conn->insert('class_ratings', [
//                 'class_id' => $class_id,
//                 'rating_id' => $rating_id
//             ]);

//             $conn->insert('class_comments', [
//                 'class_id' => $class_id,
//                 'comment_id' => $comment_id
//             ]);

//         });
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('ratings');
        $schema->dropTable('comments');
        $schema->dropTable('class_comments');
        $schema->dropTable('class_ratings');

        $addressTable = $schema->getTable('addresses');
        $addressTable->addColumn('entity', 'string', ['length' => '20']);
        $addressTable->addColumn('entity_id', 'integer', ['unsigned' => true]);
        $addressTable->dropColumn('latitude');
        $addressTable->dropColumn('longitude');
        $addressTable->addColumn('lat', 'string', ['length' => 100, 'notnull' => false]);
        $addressTable->addColumn('long', 'string', ['length' => 100, 'notnull' => false]);

        $classTable = $schema->getTable('classes');
        $classTable->dropColumn('currency');

        $userTable = $schema->getTable('users');
        $userTable->dropIndex('UNIQ_EMAIL_USER');
        $userTable->dropIndex('UNIQ_USERNAME_USER');
        $userTable->addUniqueIndex(['id', 'username', 'email']);
    }

    public function postDown(Schema $schema)
    {
        $conn = $this->connection;
        $dbPlatform = $conn->getDatabasePlatform();
        $conn->query('SET FOREIGN_KEY_CHECKS=0');
        $q = $dbPlatform->getTruncateTableSQL('schedules');
        $conn->executeUpdate($q);
        $q = $dbPlatform->getTruncateTableSQL('classes');
        $conn->executeUpdate($q);
        $q = $dbPlatform->getTruncateTableSQL('venues');
        $conn->executeUpdate($q);
        $q = $dbPlatform->getTruncateTableSQL('addresses');
        $conn->executeUpdate($q);
        $conn->query('SET FOREIGN_KEY_CHECKS=1');

        // $conn->delete('users', ['email' => 'shcode@live.com']);
        // $conn->delete('classes', ['slug' => 'belajar-pemrograman-web']);
    }
}
