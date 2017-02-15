<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160719162420 extends AbstractMigration
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
          Terms of Service
        </div>
      </div>
    </div>
  </section>
  <section class="static-terms-2">
    <div class="service-wrapper">
      <div class="container">
        <div class="col-md-12">
          <div class="list-service">
            <div class="row">
              <div class="col-md-12">
                <div class="box-content">
                  <div class="title-top">
                    <span>DEFINITIONS</span>
                    <div class="title-highlight"></div>
                  </div>
                  <div class="description">
                    <p>
                      This website (the “Website”) is operated by Skillagogo Pte. Ltd., a Singapore private company (Reg. no.&nbsp;201507746N).
                    </p>
                    <ol>
                      <li>
                        <p>
                          The classes on the Website are offered for users who wish to attend classes, courses, workshops from the class provider or their legal representative (“the Teacher”) to the learner (“the Student”) under the following Terms of Service. Some classes also have Courses Specific Terms of Service, available on the class provider’s page or the school/institution’s page on the Website. When booking a seat on the Website and/or making inquiry on the Website or via email or telephone, the Student accepts and agrees to these Terms of Service and to the Courses Specific Terms of Service.
                        </p>
                      </li>
                      <li>
                        <p>
                          The Website provides an online platform through which the Teachers can advertise their classes, courses and workshops. By booking a seat through the Website, the Students enters into a direct, legally binding, contractual relationship with the relevant Teachers. The Website acts solely as an intermediary between the Student and the Teacher, sending the booking and payment details to the Teacher and sending the Student a confirmation email for and on behalf of the Teacher.
                        </p>
                      </li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="list-service">
            <div class="row">
              <div class="col-md-12">
                <div class="box-content">
                  <div class="title-top">
                    <span>BOOKING</span>
                    <div class="title-highlight"></div>
                  </div>
                  <div class="description">
                    <ol>
                      <li>
                        <p>
                          To book a seat on the class offered by the Teacher, the Student must pay to the Website a class full price as advertised on the Website (unless otherwise specified in the Courses Specific Terms of Service). Upon reception of the confirmation email and payment, the Website, on behalf of the Teacher, will send a class confirmation email and an attendance voucher. The booking will be effective immediately after the confirmation email has been sent to the Student.
                        </p>
                      </li>
                      <li>
                        <p>
                          Class booking can only be accepted from users aged 18 or over at the time of booking.
                        </p>
                      </li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="list-service">
            <div class="row">
              <div class="col-md-12">
                <div class="box-content">
                  <div class="title-top">
                    <span>PRICE AND PAYMENTS</span>
                    <div class="title-highlight"></div>
                  </div>
                  <div class="description">
                    <ol>
                      <li>
                        <p>The Student is responsible for the payments of the class cost and for compliance with these Terms of Service.</p>
                      </li>
                      <li>
                        <p>The class prices include the following: </p>
                        <ul>
                          <li>Class/course/workshop content offered by the Teacher</li>
                          <li>Use of class facilities (if any)</li>
                          <li>Certificate of Completion (if any)</li>
                        </ul>
                      </li>
                      <li>
                        <p>Prices DO NOT include the following: </p>
                        <ul>
                          <li>Other additional specific tools and/or equipment needed for the class as specified in the Class Profile Page</li>
                        </ul>
                      </li>
                      <li>
                        <p>
                          For classes in Singapore, the class prices are all in Singapore Dollars (S$). For classes in Indonesia, the class prices are all in Indonesia Rupiah (Rp). Payment can be made only in respective currencies.
                        </p>
                      </li>
                      <li>
                        <p>Payments can be made by Paypal (S$ only), bank/ATM transfer (Rp only).</p>
                      </li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="list-service">
            <div class="row">              
              <div class="col-md-12">
                <div class="box-content">
                  <div class="title-top">
                    <span>CANCELLATION</span>
                    <div class="title-highlight"></div>
                  </div>
                  <div class="description">
                    <ol>
                      <li>
                        <p>
                          If the cancellation is made by the Student, the payment will be revised into skillagogo credits which can be used to attend other class. skillagogo credits has a validity of 12 months after opening.
                        </p>
                      </li>
                      <li>
                        <p>
                          If the cancellation is made by the Teacher, the Student will be offered an opportunity to change her/his schedule. In the event that there is no available new class schedule, the Student will be given skillagogo credits. Class cancellation made by the Teacher is subject to admin fees as stated in the Teacher Cancellation scheme.
                        </p>
                      </li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="list-service">
            <div class="row">
              <div class="col-md-12">
                <div class="box-content">
                  <div class="title-top">
                    <span>REVIEWS</span>
                    <div class="title-highlight"></div>
                  </div>
                  <div class="description">
                    <ol>
                      <li>
                        <p>
                          The Student reviews may be uploaded onto the Teacher’s website and/or his/her social media accounts, as well as on our website for the sole purpose of informing future Students of other opinions of the service level and quality of the class and/or the Teacher.
                        </p>
                      </li>
                      <li>
                        <p>The Website reserves the right to accept, refuse or remove reviews at our sole discretion.</p>
                      </li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="list-service">
            <div class="row">              
              <div class="col-md-12">
                <div class="box-content">
                  <div class="title-top">
                    <span>LIABILITY</span>
                    <div class="title-highlight"></div>
                  </div>
                  <div class="description">
                    <ol>
                      <li>
                        <p>
                          Neither Teacher nor the Website shall be liable for events beyond their control which may interfere with the Student’s scheduled occupancy, including but not limited to Acts of God, acts of governmental agencies, fire, strikes, terrorism, war, inclement weather, flooding, disturbance or noise coming from outside the class premises such as private or public construction, traffic, animals or neighbours. No rebate of refund will be offered in these circumstances.
                        </p>
                      </li>
                      <li>
                        <p>
                          The Website assumes no liability for property loss or damages, nor liability for injury, accidents, delay, or irregularity which may be occasioned during the class session.
                        </p>
                      </li>
                      <li>
                        <p>
                          Any exception to these Terms of Service granted by the Website for the Student’s benefit in no way modifies the present Terms of Service. Complete or partial nullity of any clause in the Terms of Service does not entail the nullity of the other Terms of Service
                        </p>
                      </li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="list-service">
            <div class="row">
              <div class="col-md-12">
                <div class="box-content">
                  <div class="title-top">
                    <span>LANGUAGE AND APPLICABLE LAW</span>
                    <div class="title-highlight"></div>
                  </div>
                  <div class="description">
                    <ol>
                      <li>
                        <p>
                          These Terms of Service are written in English. The English writing will prevail over any translation available.
                        </p>
                      </li>
                      <li>
                        <p>
                          These Terms of Service are submitted to the exclusive jurisdiction of the Singapore courts under Singapore laws.
                        </p>
                      </li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>';
            $content_id='  <section class="sub-header-skillagogo parallax-skillagogo bg-img-about">
    <div class="bg-overlay-full overlay-purple"></div>
    <div class="container">
      <div class="col-md-12">
        <div class="title">
          Ketentuan Penggunaan
        </div>
      </div>
    </div>
  </section>
  <section class="static-terms-2">
    <div class="service-wrapper">
      <div class="container">
        <div class="col-md-12">
          <div class="list-service">
            <div class="row">
              <div class="col-md-12">
                <div class="box-content">
                  <div class="title-top">
                    <span>Definisi</span>
                    <div class="title-highlight"></div>
                  </div>
                  <div class="description">
                    <p>
                      Situs ini ("Situs") dikelola oleh Skillagogo Pte Ltd, sebuah perusahaan swasta yang berkedudukan di Singapura dengan nomor pendaftaran 201507746N.
                    </p>
                    <ol>
                      <li>
                        <p>
                          Kelas-kelas yang ditampilkan di Situs ini ditawarkan kepada para pengguna yang ingin menghadiri kelas, kursus atau workshop yang diberikan oleh Penyedia Kelas atau perwakilan hukumnya (“Pengajar”) kepada peserta kelas (“Peserta Kelas”) dengan mengacu pada Ketentuan Penggunaan berikut ini. Beberapa kelas juga memiliki Syarat dan Ketentuan Khusus, dan tersedia di halaman profil Pengajar yang terdapat di Situs. Saat melakukan pemesanan di Situs atau mengirimkan pertanyaan atau meminta penjelasan terhadap layanan yang tersedia di Situs melalui email atau telepon, Peserta Kelas sudah menerima dan setuju dengan Ketentuan Penggunaan dan Syarat dan Ketentuan Khusus yang terdapat di Situs.
                        </p>
                      </li>
                      <li>
                        <p>
                          Situs menyediakan platform online di mana Penyedia Kelas bisa memasang kelas, kursus dan workshopnya di Situs ini. Dengan memesan tempat melalui Situs, Peserta Kelas sudah masuk ke dalam suatu hubungan yang mengikat antara Peserta Kelas dan Penyedia Kelas yang bersangkutan. Situs akan bertindak semata sebagai penengah antara Peserta Kelas dan Penyedia Kelas, dengan cara mengirimkan detail pemesanan kelas dan pembayaran kepada Penyedia Kelas serta mengirimkan konfirmasi pemesanan kelas kepada Peserta Kelas atas nama Penyedia Kelas.
                        </p>
                      </li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="list-service">
            <div class="row">
              <div class="col-md-12">
                <div class="box-content">
                  <div class="title-top">
                    <span>PEMESANAN</span>
                    <div class="title-highlight"></div>
                  </div>
                  <div class="description">
                    <ol>
                      <li>
                        <p>
                          Untuk memesan tempat di kelas yang ditawarkan oleh Penyedia Kelas, Peserta Kelas harus membayar kepada Situs harga kelas seperti yang dimuat di Situs (kecuali jika ada Syarat dan Ketentuan yang lain). Setelah penerimaan konfirmasi pembayaran, Situs atas nama Penyedia Kelas, akan mengirimkan email konfirmasi pendaftaran kelas. Pemesanan kelas akan langsung efektif setelah email konfirmasi dikirimkan kepada Penyedia Kelas.
                        </p>
                      </li>
                      <li>
                        <p>
                          Pemesanan kelas hanya bisa diterima oleh pengguna yang telah berusia 18 tahun ke atas pada saat pemesanan.
                        </p>
                      </li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="list-service">
            <div class="row">
              <div class="col-md-12">
                <div class="box-content">
                  <div class="title-top">
                    <span>Harga dan Pembayaran</span>
                    <div class="title-highlight"></div>
                  </div>
                  <div class="description">
                    <ol>
                      <li>
                        <p>Peserta Kelas bertanggung jawab atas pembayaran dari harga kelas sesuai dengan Ketentuan Penggunaan ini.</p>
                      </li>
                      <li>
                        <p>Harga kelas mencakup:</p>
                        <ul>
                          <li>Isi dari kelas/kursus/workshop yang diberikan oleh Penyedia Kelas </li>
                          <li>Penggunaan fasilitas kelas (jika ada)</li>
                          <li>Sertifikat Peserta (jika ada)</li>
                        </ul>
                      </li>
                      <li>
                        <p>Harga TIDAK mencakup: </p>
                        <ul>
                          <li>Peralatan atau perlengkapan lain yang diperlukan di kelas seperti yang tercantum di Halaman Profil Kelas.</li>
                        </ul>
                      </li>
                      <li>
                        <p>
                          Untuk kelas di Singapura, harga kelas adalah dalam mata uang Dolar Singapura (S$). Untuk kelas di Indonesia, harga kelas adalah dalam mata uang Indonesia Rupiah (Rp). Cara pembayaran hanya dapat dilakukan dalam mata uang yang bersangkutan.
                        </p>
                      </li>
                      <li>
                        <p>Pembayaran dapat dilakukan melalui Paypal (untuk Dolar Singapura) dan transfer ATM/bank (untuk Rupiah). </p>
                      </li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="list-service">
            <div class="row">              
              <div class="col-md-12">
                <div class="box-content">
                  <div class="title-top">
                    <span>PEMBATALAN</span>
                    <div class="title-highlight"></div>
                  </div>
                  <div class="description">
                    <ol>
                      <li>
                        <p>
                          Jika pembatalan dibuat oleh Peserta Kelas, maka uang yang telah dibayarkan akan dimasukkan menjadi skillagogo credits yang bisa digunakan untuk memesan kelas yang lain. skillagogo credits memiliki masa berlaku selama 12 bulan setelah pembukaan kredit.
                        </p>
                      </li>
                      <li>
                        <p>
                          Jika pembatalan dilakukan oleh Penyedia Kelas, maka Peserta Kelas akan diberikan kesempatan untuk mengganti jadwal ke tanggal yang lain. Jika ternyata tidak ada jadwal kelas yang tersedia, maka Peserta Kelas akan mendapatkan skillagogo credits. Pembatalan yang dilakukan oleh Penyedia Kelas akan dikenakan biaya administrasi.
                        </p>
                      </li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="list-service">
            <div class="row">
              <div class="col-md-12">
                <div class="box-content">
                  <div class="title-top">
                    <span>ULASAN TINJAUAN</span>
                    <div class="title-highlight"></div>
                  </div>
                  <div class="description">
                    <ol>
                      <li>
                        <p>
                          Ulasan Tinjauan yang diberikan oleh Peserta Kelas akan diunggah di situs Profil Penyedia Kelas serta akun media sosial, demikan juga di Situs dengan tujuan untuk memberikan informasi kepada calon Peserta Kelas mengenai pendapat dari tingkat dan mutu layanan dari kelas yang ditawarkan serta Penyedia Kelas yang bersangkutan.
                        </p>
                      </li>
                      <li>
                        <p>Situs memiliki hak untuk menerima, menolak dan menghilangkan ulasan tinjauan tanpa harus memberi tahu kepada pihak yang bersangkutan.</p>
                      </li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="list-service">
            <div class="row">              
              <div class="col-md-12">
                <div class="box-content">
                  <div class="title-top">
                    <span>TANGGUNG JAWAB</span>
                    <div class="title-highlight"></div>
                  </div>
                  <div class="description">
                    <ol start="14">
                      <li>
                        <p>
                          Baik Penyedia Kelas dan Situs tidak bertanggung jawab terhadap peristiwa yang berada di luar kekuasaan yang mengganggu jadwal Peserta Kelas, misalnya seperti bencana alam, peristiwa yang disebabkan oleh pemerintahan, kebakaran, mogok kerja, demo, terorisme, perang, banjir, gangguan yang datang dari luar ruangan kelas seperti pembangunan gedung pribadi atau publik, lalu lintas, binatang dan tetangga. Di bawah kondisi seperti ini, Situs tidak bisa memberikan potongan harga atau pengembalian uang.
                        </p>
                      </li>
                      <li>
                        <p>
                          Situs tak bertanggung jawab atas kehilangan atau kerusakan, atau cedera, kecelakaan, keterlambatan atau ketidak teraturan yang mungkin terjadi pada saat kelas sedang berlangsung.
                        </p>
                      </li>
                      <li>
                        <p>
                          Perkecualian yang terdapat di Ketentuan Penggunaan yang diberikan oleh Situs kepada Peserta Kelas tidak akan mengubah seluruhnya Ketentuan Penggunaan ini. Ketidaksahan yang terdapat di satu klausul, baik seluruhnya atau sebagian, tidak akan membuat Ketentuan Penggunaan ini menjadi tidak sah.
                        </p>
                      </li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="list-service">
            <div class="row">
              <div class="col-md-12">
                <div class="box-content">
                  <div class="title-top">
                    <span>Bahasa dan hukum yang berlaku</span>
                    <div class="title-highlight"></div>
                  </div>
                  <div class="description">
                    <ol>
                      <li>
                        <p>
                          Ketentuan Penggunaan yang ada di Situs ditulis dalam bahasa Inggris.  Tulisan dalam Bahasa Inggris akan diberlakukan terhadap terjemahan dalam bahasa yang lain.
                        </p>
                      </li>
                      <li>
                        <p>
                          Ketentuan Penggunaan ini telah diberikan kepada yuridis Singapura di bawah hukum Singapura.
                        </p>
                      </li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>';
            $content_en_encode=htmlentities($content_en);
            $content_id_encode=htmlentities($content_id);
            $conn->insert('static_pages', [
                'title' => 'Terms of Service',
                'language' => \StaticStatic::ENGLISH,
                'author_id' => $admin[0]['id'],
                'last_editor_id' => $admin[0]['id'],
                'content' => $content_en_encode
            ]);

            $conn->insert('static_pages', [
                'title' => 'Terms of Service',
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
