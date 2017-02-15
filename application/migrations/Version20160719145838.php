<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160719145838 extends AbstractMigration
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
            $content='  
  <section class="sub-header-skillagogo parallax-skillagogo bg-img-about">
    <div class="bg-overlay-full overlay-purple"></div>
    <div class="container">
      <div class="col-md-12">
        <div class="title">
          About us
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
                <a href="#story" aria-controls="story" role="tab" data-toggle="tab">Our Story</a>
              </li>
              <li role="presentation">
                <a href="#mission" aria-controls="mission" role="tab" data-toggle="tab">Our Mission</a>
              </li>
            </ul>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="story">
                <p>
                  <em> “Do you know where I can go to a good art/baking/public speaking/knitting – or name
                    a skill here – class in this city?” </br>
                    “It’s time for me to upgrade myself, I need to learn new skills!” </br>
                    “I’ve been dreaming about becoming a teacher, I want to share my knowledge.” </br>
                    “My passion is to make other people enjoy what I teach.”
                  </em>
                </p>

                <p> 
                  Have you ever heard someone asking you this question? Or, have you ever told yourself about this life goal of yours? If yes, you have come to the right place.
                </p>

                <p>skillagogo is all about learning, teaching and having a great time. We are social education platform with a simple objective to bring together passionate teachers and passionate learners. At skillagogo, we want to make the whole learning process become more social and more interactive. </p>

                <p>
                  Our platform has been designed to serve you with a new experience in teaching and learning. Whether you want to learn a new skill or strengthen an existing one, whether you want reinvent yourself or explore unknown territories, skillagogo wants to have an answer to your knowledge needs. As for great teachers and the aspiring ones out there, skillagogo will be your best friend, as our platform serves one single objective: to help you showcase your expertise and grow your business. 
                </p>

                <p> 
                  We hope that you agree with us. We think sharing and learning knowledge is exciting and skillagogo makes it happen!
                </p>
              </div>
              <div role="tabpanel" class="tab-pane" id="mission">
                <p> 
                  We believe there is plenty knowledge to be shared and plenty of skills to be showcased out there: skillagogo aims to bring all of this only a few clicks away from you!
                </p>
                <p> 
                  We will not stop until skillagogo becomes the go-to platform where you can find all the classes, courses, workshops you have always dreamed of taking.
                </p>
                <p>
                  We will not stop until skillagogo becomes the go-to platform where you can teach all the classes, courses, orkshops you have always dreamed of teaching.
                </p>
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
              <span>our team</span>
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
                    FOUNDER, CHIEF EXECUTIVE OFFICER
                  </div>
                  <div class="description">
                    <p>
                      Maxime has been there all along since the ideas was created. An engineer by
                      training and a strategic thinker by profession, Maxime has always been passionate
                      about all things creating - and about challenging himself in the process. After getting
                      his MBA degree from INSEAD, this French native and dad of two decided to get
                      settled in SEA and to dedicate his time and heart to grow skillagogo in Singapore
                      and Indonesia. When not crunching some numbers, Maxime plays tennis and edits
                      his videos.
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
                    FOUNDER, CHIEF OPERATING OFFICER
                  </div>
                  <div class="description">
                    <p>
                      A former journalist-writer-editor turned web entrepreneur, Nino is a Javanese native who is cosmopolitan at heart: she has lived in Indonesia, France, USA and now Singapore. A while back, this Universite of Gadjah Mada and Universite de Nancy graduate was the Editor in Chief of Cosmopolitan Indonesia. Now at skillagogo, she will try her best to make sure that you have a great experience in teaching or learning. In her spare time, she enjoys spending time with her two young daughters and writing short stories that she publishes on her personal website.
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
                    TECHNICAL ADVISOR
                  </div>
                  <div class="description">
                    <p>
                      Hebi is supposed to work in telecommunication industry, but this Technology Institute of Bandung and Ecole de Telecommunication Paris graduate prefers coding. Being passionate about tech and science since his elementary school years, now Hebi also starts to challenge himself in entrepreneurship. When taking a break from all things tech, Hebi likes to read books and to practice his martial arts skill.
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
                    FINANCIAL MANAGEMENT
                  </div>
                  <div class="description">
                    <p>
                      Daniel is firstly, trained in financial management and accounting, and secondly, a tech geek who loves playing with the latest technologies and electronics boards. It is this hobbyist streak of his that caused him to join the startup ecosystem in 2013 and take on projects many times more complex than his days as an auditor. As a keen analyst and consultant, Daniel has not only aggregated information about the day-to-day challenges startups face but has gone through the entire experience himself. Currently deepening his skills in data analysis he makes a key person and a good fit for the company&#39;s eventual goal of becoming the premier platform for workshops in South East Asia.
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
                'language' => \StaticStatic::ENGLISH,
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
