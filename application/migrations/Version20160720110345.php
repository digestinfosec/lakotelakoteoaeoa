<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160720110345 extends AbstractMigration
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
                        <div class="title">1. Search</div>
                        <div class="image">
                          <img src="/assets/images/how_it_works_search.png" alt="">
                        </div>
                        <div class="description">Skillagogo offers a wide selection of classes you can choose from</div>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="title">2. book</div>
                        <div class="image">
                          <img src="/assets/images/how_it_works_book.png" alt="">
                        </div>
                        <div class="description">Sign up with skillagogo and immediately book your class</div>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="title">3. enjoy</div>
                        <div class="image">
                          <img src="/assets/images/how_it_works_enjoy.png" alt="">
                        </div>
                        <div class="description">Learn and acquire a new skill from our great teachers</div>
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
                        <div class="title">1. Create</div>
                        <div class="image">
                          <img src="/assets/images/how_it_works_create.png" alt="">
                        </div>
                        <div class="description">Pick a topic, write a description, set a price and pick a date</div>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="title">2. publish</div>
                        <div class="image">
                          <img src="/assets/images/how_it_works_publish.png" alt="">
                        </div>
                        <div class="description">Let the world know about your amazing class</div>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="title">3. teach</div>
                        <div class="image">
                          <img src="/assets/images/how_it_works_teach.png" alt="">
                        </div>
                        <div class="description">Share your skill and knowledge and collect your payout</div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>';
            $content_learn_encode=htmlentities($content_1);
            $content_teach_encode=htmlentities($content_2);
            $conn->insert('static_pages', [
                'title' => 'How to Learn',
                'language' => \StaticStatic::ENGLISH,
                'author_id' => $admin[0]['id'],
                'last_editor_id' => $admin[0]['id'],
                'content' => $content_learn_encode
            ]);

            $conn->insert('static_pages', [
                'title' => 'How to Teach',
                'language' => \StaticStatic::ENGLISH,
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
