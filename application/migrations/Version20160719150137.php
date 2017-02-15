<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160719150137 extends AbstractMigration
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
            $content='  <section class="sub-header-skillagogo parallax-skillagogo bg-img-about">
    <div class="bg-overlay-full overlay-purple"></div>
    <div class="container">
      <div class="col-md-12">
        <div class="title">
          TENTANG KAMI
        </div>
      </div>
    </div>
  </section>
  <section class="static-about-2">
    <div class="mission-wrapper">
      <div class="container">
        <div class="col-md-12">
          <div class="tab-mission">
            <ul class="nav nav-pills" role="tablist">
              <li role="presentation" class="active">
                <a href="#story" aria-controls="story" role="tab" data-toggle="tab">
                  TENTANG SKILLAGOGO
                </a>
              </li>
              <li role="presentation">
                <a href="#mission" aria-controls="mission" role="tab" data-toggle="tab">
                  MISI SKILLAGOGO
                </a>
              </li>
            </ul>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="story">
                <p>
                  <em>
                    “Di mana, sih, bisa belajar melukis/memasak/public speaking/merajut/fotografi – atau sebut saja keahlian apa saja di sini – yang bagus di sini?” </br>
                    “Saya harus tambah keahlian atau ketrampilan baru supaya karier makin OK!” </br>
                    “Sudah lama saya ingin mengajar dan berbagi pengetahuan saya!” </br>
                    “Cita-cita saya adalah membuat semua orang senang dengan apa yang saya ajarkan.”
                  </em>
                </p>

                <p> 
                  Apakah Anda pernah mendengar seseorang menanyakan pertanyaan di atas? Atau apakah Anda pernah mengatakan kepada diri sendiri kalau Anda ingin mengajar dan berbagi pengalaman tapi tak tahu bagaimana caranya? Jika jawabannya adalah ya, Anda berada di platform yang tepat!
                </p>

                <p>
                  skillagogo adalah tempat untuk belajar, mengajar dan menikmatinya! Kami adalah platform sosial yang didedikasikan untuk pendidikan dengan tujuan yang sederhana yaitu menyatukan para pengajar yang hebat dan peserta keras yang penuh semangat. Di skilagogo, kami bercita-cita untuk membuat seluruh proses belajar dan mengajar menjadi lebih sosial, interaktif dan menyenangkan.
                </p>

                <p> 
                  Platform skillagogo dibuat untuk memberikan sebuah pengalaman baru bagi Anda di bidang mengajar dan belajar. Apakah Anda ingin belajar ketrampilan baru atau mendalami yang sudah Anda kuasai, skillagogo ingin memberikan semua jawaban yang Anda butuhkan. Dan untuk para pengajar dan yang bercita-cita untuk mengajar, skillagogo ingin menjadi sahabat dekat Anda, karena platform ini memang dirancang dengan satu tujuan pasti: menjadi sarana untuk membantu bisnis Anda.
                </p>

                <p> 
                  Kami selalu merasa kalau berbagi dan belajar keterampilan dan pengetahuan baru itu sangat menyenangkan dan skillagogo ingin memberikan yang terbaik buat Anda.
                </p>
              </div>
              <div role="tabpanel" class="tab-pane" id="mission">
                <p>Kami percaya bahwa ilmu pengetahuan itu wajib dibagikan dan disebarluaskan. Di luar sana banyak sekali para ahli di bidangnya yang perlu ditampilkan: skillagogo ingin membawa semuanya itu ke dalam satu platform yang mudah digunakan.</p>
                <p>Kami tak akan berhenti sampai skillagogo menjadi platform yang memberikan semua informasi tentang semua kelas, kursus, workshop yang Anda butuhkan.</p>
                <p>Kami tak akan berhenti sampai skillagogo menjadi platform di mana Anda bisa mengajar kelas, kursus, workshop yang Anda kuasai.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="team-wrapper">
      <div class="container">
        <div class="col-md-12">
          <div class="text-center">
            <div class="title-team">
              <span>TIM SKILLAGOGO</span>
              <div class="title-highlight"></div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="list-team">
            <div class="row">
              <div class="col-md-4">
                <div class="box-image">
                  <div class="image">
                    <img src="/assets/images/maxime.JPG" alt="">
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="box-content">
                  <div class="name">
                    Maxime Mouton
                  </div>
                  <div class="position">
                    PENDIRI, COO
                  </div>
                  <div class="description">
                    <p>
                      Dua kata untuk menggambarkan latar belakang Maxime: dia adalah insinyur dan ahli strategi. Pria yang berasal dari Prancis dan bapak dua anak ini sangat senang dengan inovasi, menciptakan sesuatu dan menghadapi segala tantangannya. Setelah lulus MBA dari INSEAD, Maxime memutuskan untuk tinggal di Asia Tenggara serta mendedikasikan waktu dan pikirannya untuk membesarkan skillagogo. Saat sedang tidak berkutat dengan angka, Maxime hobi main tenis dan mengedit video.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="list-team">
            <div class="row">
              <div class="col-md-8">
                <div class="box-content">
                  <div class="name">
                    Nino Mouton
                  </div>
                  <div class="position">
                    PENDIRI, CEO
                  </div>
                  <div class="description">
                    <p>
                      Nino, mantan jurnalis-penulis-editor yang ganti profesi jadi webpreneur ini asli Jawa tapi berjiwa kosmopolitan karena pernah tinggal di empat negara: Indonesia, Prancis, Amerika Serikat dan sekarang di Singapura. Lulusan Universitas Gadjah Mada dan Universite de Nancy ini dulunya bekerja sebagai editor-in-chief majalah Cosmopolitan Indonesia. Kini bersama skillagogo, Nino bertekad untuk menghadirkan pengalaman unik di bidang belajar dan mengajar. Di waktu senggangnya, Nino selalu meluangkan waktunya bermain dengan dua putrinya serta menulis cerita pendek untuk situs pribadinya.
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="box-image">
                  <div class="image">
                    <img src="/assets/images/nino.JPG" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="list-team">
            <div class="row">
              <div class="col-md-4">
                <div class="box-image">
                  <div class="image">
                    <img src="/assets/images/hebi.JPG" alt="">
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="box-content">
                  <div class="name">
                    M. Bahri Nurhabibi
                  </div>
                  <div class="position">
                    CTO
                  </div>
                  <div class="description">
                    <p>
                      Seharusnya Hebi bekerja di bidang telekomunikasi sesuai dengan pendidikannya. Tapi lulusan Institut Teknologi Bandung dan Ecole de Telecommunication Paris ini malah senang koding. Sejak masih SD, Hebi sudah tertarik dengan teknologi, kini Hebi juga tertarik untuk terjun di kewirausahaan. Saat sedang tidak mengurusi teknologi, Hebi menghabiskan waktunya dengan membaca buku dan berlatih bela diri.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="list-team">
            <div class="row">              
              <div class="col-md-8">
                <div class="box-content">
                  <div class="name">
                    Daniel J Ellis
                  </div>
                  <div class="position">
                    ANALIS BISNIS
                  </div>
                  <div class="description">
                    <p>
                      Lulusan manajemen keuangan dan akunting yang menggemari teknologi ini punya hobi main-main dengan papan elektronika. Hobinya ini pula yang membuatnya berkecimpung di ekosistem startup di Singapura sejak tahun 2013. Sebagai konsultan dan analis, Daniel bertugas memberikan informasi tentang tantangan yang harus dihadapi oleh startup. Dengan kemampuannya di bidang analisis data, Daniel yang berkebangsaan Singapura keturunan Afrika Selatan ini makin tertantang untuk membawa skillagogo menjadi platform utama bagi kegiatan belajar dan mengajar di Asia Tenggara.
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="box-image">
                  <div class="image">
                    <img src="/assets/images/daniel.JPG" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>';
            $content_encode=htmlentities($content);
            $conn->insert('static_pages', [
                'title' => 'About Us',
                'language' => \StaticStatic::INDONESIA,
                'author_id' => $admin[0]['id'],
                'last_editor_id' => $admin[0]['id'],
                'content' => $content_encode
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
