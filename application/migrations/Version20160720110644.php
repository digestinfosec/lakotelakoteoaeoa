<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160720110644 extends AbstractMigration
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
            $content_en='<section class="sub-header-skillagogo parallax-skillagogo bg-img-about">
  <div class="bg-overlay-full overlay-purple"></div>
  <div class="container">
    <div class="col-md-12">
      <div class="title">
        Careers
      </div>
      <div class="description">
        We are growing and we are always looking for great talents.  Are you a smart, talented, passionate and hard-working individual living in Singapore or Indonesia? Send us your CV at <a href="mailto:career@skillagogo.com">career@skillagogo.com</a>
      </div>
    </div>
  </div>
</section>
<section class="position-career" id="position">
  <div class="sub-position-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="headingOne">
                <div class="title">Business Development Director</div>
                <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#android-developer" aria-expanded="true" aria-controls="android-developer">
                  <div class="box-icon">
                    <i class="fa fa-chevron-down"></i>
                  </div>
                </a>
              </div>
              <div id="android-developer" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-12">
                      <p>
                        Mandate: build market position by locating, developing, defining, negotiating, and closing business relationships with content providers (e.g. free lancers and educational institutions) but also potential partners (e.g. venue providers, transportation providers, etc.)
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>';
            $content_id='  <section class="static-career-wrapper">
                <div class="container">
                  <div class="col-md-12">
                    <div class="desc-top">
                      <div class="title">
                        BERGABUNGLAH DENGAN SKILLAGOGO
                      </div>
                      <div class="description">
                        Sejalan dengan perkembangan yang sangat pesat, skilagogo akan terus mencari profil menarik seperti yang Anda miliki. Apakah Anda cerdas, berbakat, penuh semangat, senang bekerja keras dan tinggal di Singapura atau Jakarta? Kirimkan CV kepada kami di career@skillagogo.com.
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    POSISI YANG SEDANG KAMI CARI:
                    Maaf, saat ini belum ada posisi yang terbuka di Jakarta. Periksa kembali laman ini secara teratur untuk melihat posisi yang sedang kami cari.
                  </div>
                </div>
              </section>';
            $content_en_encode=htmlentities($content_en);
            $content_id_encode=htmlentities($content_id);
            $conn->insert('static_pages', [
                'title' => 'Career',
                'language' => \StaticStatic::ENGLISH,
                'author_id' => $admin[0]['id'],
                'last_editor_id' => $admin[0]['id'],
                'content' => $content_en_encode
            ]);

            $conn->insert('static_pages', [
                'title' => 'Career',
                'language' => \StaticStatic::INDONESIA,
                'author_id' => $admin[0]['id'],
                'last_editor_id' => $admin[0]['id'],
                'content' => $content_id_encode
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
