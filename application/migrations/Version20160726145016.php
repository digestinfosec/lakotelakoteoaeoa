<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160726145016 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $conn = $this->connection;
        $conn->transactional(function ($conn) {

            $query = "SELECT * FROM users WHERE users.email = 'admin@skillagogo.com'";
            $stmt = $conn->query($query);
            $admin = $stmt->fetchAll();
            $content_1= '  <section class="static-how-to-teach-wrapper bg-sgogo-yellow2">
                <div class="container">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="title">1. Jelajahi</div>
                        <div class="image">
                          <img src="/assets/images/how_it_works_search.png" alt="">
                        </div>
                        <div class="description">skillagogo menawarkan berbagai kursus, kelas dan workshop yang bisa segera Anda pilih</div>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="title">2. Pesan</div>
                        <div class="image">
                          <img src="/assets/images/how_it_works_book.png" alt="">
                        </div>
                        <div class="description">Daftarkan diri Anda di skillagogo dan segera pesan kelas-kelas yang Anda minati!</div>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="title">3. Nikmati</div>
                        <div class="image">
                          <img src="/assets/images/how_it_works_enjoy.png" alt="">
                        </div>
                        <div class="description">Dapatkan pengetahuan dan ketrampilan baru, langsung dari pengajar yang berpengalaman di bidangnya. Selamat belajar!</div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>';
            $content_2= '  <section class="static-how-to-teach-wrapper bg-sgogo-blue-light">
                <div class="container">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="title">1. Buka kelas</div>
                        <div class="image">
                          <img src="/assets/images/how_it_works_create.png" alt="">
                        </div>
                        <div class="description">Sudah punya topik yang ingin diajarkan? Tulis deskripsi tentang kelas Anda secara lengkap dan jelas, tetapkan harganya, tentukan tanggal dan lokasi kelas</div>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="title">2. Tampilkan</div>
                        <div class="image">
                          <img src="/assets/images/how_it_works_publish.png" alt="">
                        </div>
                        <div class="description">Setelah siap, klik tombol “tampilkan” dan kelas Anda akan segera tampil di platform skillagogo</div>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="title">3. Mengajar</div>
                        <div class="image">
                          <img src="/assets/images/how_it_works_teach.png" alt="">
                        </div>
                        <div class="description">Berbagi pengetahuan dan keahlian itu sungguh menyenangkan! Setelah mengajar, segera dapatkan payout Anda</div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>';
            $content_learn_encode=htmlentities($content_1);
            $content_teach_encode=htmlentities($content_2);
            $conn->insert('static_pages', [
                'title' => 'How to Learn',
                'language' => \StaticStatic::INDONESIA,
                'author_id' => $admin[0]['id'],
                'last_editor_id' => $admin[0]['id'],
                'content' => $content_learn_encode
            ]);

            $conn->insert('static_pages', [
                'title' => 'How to Teach',
                'language' => \StaticStatic::INDONESIA,
                'author_id' => $admin[0]['id'],
                'last_editor_id' => $admin[0]['id'],
                'content' => $content_teach_encode
            ]);

        });
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
