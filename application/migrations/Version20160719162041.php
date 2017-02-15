<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160719162041 extends AbstractMigration
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
            $content_en='  <section class="sub-header-skillagogo parallax-skillagogo bg-img-about">
    <div class="bg-overlay-full overlay-purple"></div>
    <div class="container">
      <div class="col-md-12">
        <div class="title">
          Privacy Policy
        </div>
        <div class="description">
          <p>
            Your privacy is our priority. This privacy policy sets out how skillagogo.com uses and protects any information that you give skillagogo.com when you use this website. skillagogo.com is committed to ensuring that your privacy is protected. Should we ask you to provide certain information by which you can be identified when using this website, then you can be assured that it will only be used in accordance with this privacy statement.
          </p>
          <p>
            skillagogo.com may change this policy by updating this page. You should check this page from time to time to ensure that you are happy with any changes. This policy is effective from 6 June 2016.
          </p>
        </div>
      </div>
    </div>
  </section>
  <section class="static-privacy-2">
    <div class="container">
      <div class="col-md-12">
        <div class="list-privacy">
          <div class="title-top">
            <span>WHAT WE COLLECT</span>
            <div class="title-highlight"></div>
          </div>
          <div class="description">
            <p>We may collect the following information:</p>
            <ul>
              <li class="check">
                Personal information including name, age, gender, and job title 
              </li>
              <li class="check">
                Contact information including telephone numbers and email address
              </li>
              <li class="check">
                Demographic information including postcode, home address, office addres
              </li>
              <li class="check">
                Other information relevant to customer surveys and/or offers including preferences and interests
              </li>
            </ul>
          </div>
        </div>
        <div class="list-privacy">
          <div class="title-top">
            <span>WHAT WE DO WITH THE INFORMATION WE GATHER</span>
            <div class="title-highlight"></div>
          </div>
          <div class="description">
            <p>
              We require this information to understand your needs and provide you with a better service, and in particular for the following reasons:
            </p>
            <ul>
              <li class="check">Internal record keeping.</li>
              <li class="check">
                We may use the information to improve our products and services. 
              </li>
              <li class="check">
                We may periodically send promotional emails about new products, special offers or other information which we think you may find interesting using the email address which you have provided.
              </li>
              <li class="check">
                From time to time, we may also use your information to contact you for market research purposes. We may contact you by email, phone, fax or mail. We may use the information to customise the website according to your interests.
              </li>
            </ul>
          </div>
        </div>
        <div class="list-privacy">
          <div class="title-top">
            <span>SECURITY</span>
            <div class="title-highlight"></div>
          </div>
          <div class="description">
            <p>
              We are committed to ensuring that your information is secure. In order to prevent unauthorised access or disclosure, we have put in place suitable physical, electronic and managerial procedures to safeguard and secure the information we collect online.
            </p>
          </div>
        </div>
        <div class="list-privacy">
          <div class="title-top">
            <span>HOW WE USE COOKIES</span>
            <div class="title-highlight"></div>
          </div>
          <div class="description">
            <p>
              A cookie is a small file that asks permission to be placed on your computer’s hard drive. Once you agree, the file is added and the cookie helps analyse web traffic or lets you know when you visit a particular site. Cookies allow web applications to respond to you as an individual. The web application can tailor its operations to your needs, likes and dislikes by gathering and remembering information about your preferences.
            </p>
            <p>
              We may use traffic log cookies to identify which pages are being used. This helps us analyse data about web page traffic and improve our website in order to tailor it to customer needs. We only use this information for statistical analysis purposes and then the data is removed from the system.
            </p>
            <p>
              Overall, cookies help us provide you with a better website, by enabling us to monitor which pages you find useful and which you do not. A cookie in no way gives us access to your computer or any information about you, other than the data you choose to share with us.
            </p>
            <p>
              You can choose to accept or decline cookies. Most web browsers automatically accept cookies, but you can usually modify your browser setting to decline cookies if you prefer. This may prevent you from taking full advantage of the website.
            </p>
          </div>
        </div>
        <div class="list-privacy">
          <div class="title-top">
            <span>LINKS TO OTHER WEBSITES</span>
            <div class="title-highlight"></div>
          </div>
          <div class="description">
            <p>
              Our website may contain links to other websites of interest. However, once you have used these links to leave our site, you should note that we do not have any control over that other website. Therefore, we cannot be responsible for the protection and privacy of any information which you provide whilst visiting such sites and such sites are not governed by this privacy statement. You should exercise caution and look at the privacy statement applicable to the website in question.
            </p>
            <p>
              We will not sell, distribute or lease your personal information to third parties unless we have your permission or are required by law to do so. We may use your personal information to send you promotional information about third parties which we think you may find interesting if you tell us that you wish this to happen.
            </p>
            <p>
              If you believe that any information we are holding on you is incorrect or incomplete, please write to or email us as soon as possible at contact@skillagogo.com. We will promptly correct any information found to be incorrect.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>';
            $content_id='<section class="sub-header-skillagogo parallax-skillagogo bg-img-about">
  <div class="bg-overlay-full overlay-purple"></div>
  <div class="container">
    <div class="col-md-12">
      <div class="title">
        KEBIJAKAN PRIVASI
      </div>
      <div class="description">
        <p>
          Privasi Anda adalah prioritas kami. Kebijakan privasi dibuat untuk menjelaskan bagaimana skillagogo.com menggunakan dan melindungi informasi yang Anda berikan kepada skillagogo.com saat Anda menggunakan situs ini. skillagogo.com berkomitmen untuk menjaga agar privasi Anda selalu terlindungi. Jika kami menanyakan kepada Anda untuk memberikan informasi tertentu yang bisa membuat Anda teridentifikasi saat menggunakan situs ini, kami jamin kepada Anda bahwa informasi tersebut hanya akan digunakan sesuai dengan pernyataan privasi ini.
        </p>
        <p>
          skillagogo.com mungkin akan mengganti kebijakan ini dengan cara memperbarui laman ini. Anda perlu memeriksa laman ini secara berkala untuk memastikan bahwa Anda setuju dengan perubahan yang ada. Kebijakan ini efektif diberlakukan mulai 6 Juni 2016.
        </p>
      </div>
    </div>
  </div>
</section>
<section class="static-privacy-2">
  <div class="container">
    <div class="col-md-12">
      <div class="list-privacy">
        <div class="title-top">
          <span>YANG KAMI KUMPULKAN</span>
          <div class="title-highlight"></div>
        </div>
        <div class="description">
          <p>Kami mungkin mengumpulkan beberapa informasi berikut ini:</p>
          <ul>
            <li class="check">
              Informasi pribadi termasuk nama, umur, jenis kelamin, dan pekerjaan 
            </li>
            <li class="check">
              Informasi kontak termasuk nomor telepon dan alamat email.
            </li>
            <li class="check">
              Informasi demografis termasuk kode pos, alamat rumah, alamat kantor,
            </li>
            <li class="check">
              Informasi lain yang berkaitan dengan survei konsumer, dan/atau penawaran, termasuk pilihan dan minat.
            </li>
          </ul>
        </div>
      </div>
      <div class="list-privacy">
        <div class="title-top">
          <span>APA YANG KAMI LAKUKAN DENGAN INFORMASI YANG TERKUMPUL</span>
          <div class="title-highlight"></div>
        </div>
        <div class="description">
          <p>
            Kami memerlukan informasi ini untuk memahami kebutuhan Anda dan memberikan kepada Anda layanan yang lebih baik, dan khususnya karena alasan berikut:
          </p>
          <ul>
            <li class="check">Rekaman data internal</li>
            <li class="check">
              Kami mungkin menggunakan informasi tersebut untuk meningkatkan produk dan layanan kami 
            </li>
            <li class="check">
              Secara berkala kami mungkin mengirimkan email promosi mengenai produk baru, promo, dan juga informasi lain yang kami rasa berguna bagi Anda menggunakan alamat email yang telah Anda berikan kepada kami 
            </li>
            <li class="check">
              Secara berkala, kami juga menggunakan informasi untuk mengkontak Anda untuk kebutuhan riset pasar. Kami mungkin mengkontak Anda melalui email, telepon, faks atau surat. Kami mungkin menggunakan informasi tersebut untuk mengkostumisasi situs berdasarkan minat Anda 
            </li>
          </ul>
        </div>
      </div>
      <div class="list-privacy">
        <div class="title-top">
          <span>KEAMANAN</span>
          <div class="title-highlight"></div>
        </div>
        <div class="description">
          <p>
            Kami berkomitmen untuk memastikan bahwa semua informasi terjaga dengan baik. Untuk menghindari akses yang tidak diinginkan dan kemungkinan informasi yang bocor di publik, kami membuat prosedur manajerial, fisik dan elektronik untuk menjaga dan mengamankan informasi yang dapatkan secara online.
          </p>
        </div>
      </div>
      <div class="list-privacy">
        <div class="title-top">
          <span>BAGAIMANA KAMI MENGGUNAKAN COOKIES</span>
          <div class="title-highlight"></div>
        </div>
        <div class="description">
          <p>
            Cookie adalah berkas kecil yang akan meminta pesetujuan Anda untuk ditempatkan di perangkat keras komputer Anda. Pada saat Anda setuju, berkas tersebut ditambahkan dan cookie akan membantu menganalisa trafik situs dan memberitahu kepada Anda saat Anda mengunjungi satu situs tertentu. Cookie juga membiarkan aplikasi web untuk merespon kepada Anda sebagai individual. Aplikasi web ini bisa membuat operasi kerjanya sesuai dengan kebutuhan Anda, apa yang Anda sukai dan tidak sukai dengan cara mengumpulkan dan mengingat informasi mengenai pilihan Anda.
          </p>
          <p>
            Kami mungkin menggunakan cookie log trafik untuk mengidentifikasi laman-laman mana yang sedang digunakan. Hal ini akan membantu kami menganalisa data mengenai trafik laman situs dan meningkatkan situs ini agar bisa memenuhi kebutuhan konsumer. Kami hanya menggunakan informasi ini untuk kebutuhan analisa statistik dan kemudian data tersebut akan kami hilangkan dari sistem.
          </p>
          <p>
            Secara keseluruhan, cookie membantu kami untuk memberikan dan meningkatkan layanan yang terbaik bagi situs, dengan cara memberikan akses kepada kami untuk memonitor laman mana yang Anda rasa berguna dan juga tidak berguna. Cookie tidak memberikan akses ke komputer Anda atau informasi apa saja mengenai Anda, kami hanya mendapatkan data yang sudah Anda setujui untuk dibagikan kepada kami.
          </p>
          <p>
            Anda boleh memilih untuk menerima atau menolak cookie. Kebanyakan browser web secara otomatis akan menerima cookie, tapi Anda bisa mengubah pengaturan browser Anda untuk menolak cookie jika Anda tidak mau. Namun hal ini kemungkinan bisa membuat Anda tidak bisa menikmati situs dengan sepenuhnya.
          </p>
        </div>
      </div>
      <div class="list-privacy">
        <div class="title-top">
          <span>TAUTAN KE SITUS LAIN</span>
          <div class="title-highlight"></div>
        </div>
        <div class="description">
          <p>
            Situs kami mungkin mengandung tautan ke situs-situs yang lain. Saat Anda sudah menggunakan tautan ini dan meninggalkan situs kami, perlu kami beritahukan bahwa kami tidak memiliki kendali atas apa yang ada di situs lain. Oleh karena itu kami tidak bertanggung jawab untuk melindungi privasi dari setiap informasi yang Anda berikan saat mengunjungi situs lain tersebut, dan situs lain tersebut tidak berada di dalam Kebijakan Privasi ini. Anda perlu berhati-hati dan memeriksa laman pernyataan Kebijakan Privasi yang terdapat di situs yang bersangkutan.
          </p>
          <p>
            Kami tidak akan menjual, membagikan atau menyewakan informasi pribadi Anda kepada pihak ketiga, kecuali kami memiliki ijin atau diminta oleh hukum untuk melakukannya. Kami mungkin akan menggunakan informasi pribadi Anda untuk mengirimkan informasi promosi dari pihak ketiga yang kami rasa berguna bagi Anda, jika Anda rasa perlu.
          </p>
          <p>
            Jika Anda berpikir bahwa setiap informasi yang kami punyai mengenai Anda ternyata salah atau tidak lengkap, silakan kirimkan email kepada kami secepatnya di  contact@skillagogo.com. Kami akan segera membetulkan setiap informasi yang salah.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>';
            $content_en_encode=htmlentities($content_en);
            $content_id_encode=htmlentities($content_id);
            $conn->insert('static_pages', [
                'title' => 'Privacy Policy',
                'language' => \StaticStatic::ENGLISH,
                'author_id' => $admin[0]['id'],
                'last_editor_id' => $admin[0]['id'],
                'content' => $content_en_encode
            ]);

            $conn->insert('static_pages', [
                'title' => 'Privacy Policy',
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
