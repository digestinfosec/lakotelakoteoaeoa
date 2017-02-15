<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160719163335 extends AbstractMigration
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
          frequently asked questions
        </div>
      </div>
    </div>
  </section>
  <section class="static-faq-2">
    <div class="container">
      <div class="col-md-12">
        <div class="box-part">
          <div class="title-top">
            <span>Part I. Using skillagogo website:</span>
            <div class="title-highlight"></div>
          </div>
          <div class="description">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">What is skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-1-1" aria-expanded="true" aria-controls="part-1-1">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-1-1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p>
                      skillagogo is a marketplace for learning and teaching. skillagogo features classes, workshops and courses conducted by qualified and experiencedteachers or trainers. On skillagogo, you will discover content in the domains of arts, design &amp; culture, business, food &amp; drink, lifestyle, parenting &amp; family and technology. Our primary goal is to provide you with high quality content from qualified and experienced teachers. Booking a class with skillagogo is free and easy. Sign up
                      <a href="/register">here</a>.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                  <div class="title">How does skillagogo work?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-1-2" aria-expanded="true" aria-controls="part-1-2">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-1-2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                  <div class="panel-body">
                    <p>
                      You can sign up as teacher or as student for free. skillagogo is not a membership-based website and there is no registration fee. If you are interested to book a class with skillagogo, the only thing you need to do is to sign up as student <a href="/register">here</a>. If you are a course provider/teacher and you wish to <a href="/dashboard/teacher/course/new_course"></a> list your classes with us, simply <a href="/register">register</a> as a teacher, <a href="/dashboard/teacher/course/new_course">list your class</a> by filling out a simple form, and publish it. You can leave the rest with us.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                  <div class="title">Who should register on skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-1-3" aria-expanded="true" aria-controls="part-1-3">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-1-3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                  <div class="panel-body">
                    <p>
                      skillagogo is for everybody! Learning and teaching do not have age, gender, interest limitations. Learning a new skill enriches your life and skillagogo encourages you to learn anywhere you want, anytime you want! If you are a course provider, skillagogo allows you to improve your online exposure, build your audience, boost your marketing presence, and, of course, increase your revenue. Our goal is to offer you a complete learning and teaching experience.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                  <div class="title">Where can I find skillagogo classes?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-1-4" aria-expanded="true" aria-controls="part-1-4">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-1-4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                  <div class="panel-body">
                    <p>
                      skillagogo classes are currently available in Singapore and Jakarta, Indonesia. We will be launching soon in other cities in Indonesia. Stay updated and subscribe to our newsletter! Click <a href="#" data-toggle="modal" data-target="#skillagogo-newsletter">here</a>.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                  <div class="title">What classes can I find on skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-1-5" aria-expanded="true" aria-controls="part-1-5">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-1-5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                  <div class="panel-body">
                    <p>
                      skillagogo provides you with various classes in the following categories: 
                    </p>
                    <ul>
                      <li> Arts, Design &amp; Culture: </li>
                        <ul>
                          <li> Photography </li>
                          <li> Graphic &amp; Design </li>
                          <li> Painting &amp; Drawing </li>
                          <li> Creative Writing </li>
                          <li> Advertising </li>
                          <li> Media &amp; Communication </li>
                          <li> Film &amp; Video </li>
                          <li> Music &amp; Audio </li>
                          <li> Hobbies &amp; Craft </li>
                          <li> Dance &amp; Performing Arts </li>
                          <li> Fashion &amp; Beauty </li>
                          <li> Foreign Language </li>
                          <li> Home Interior Design </li>
                        </ul>
                      <li>Business: </li>
                        <ul>
                          <li>Finance</li>
                          <li>Marketing &amp; Online Marketing</li>
                          <li>Entrepreneurship</li>
                          <li>Business Coaching</li>
                          <li>Personal Development &amp; Leadership</li>
                        </ul>
                      <li>F&B:</li>
                        <ul>
                          <li>Cooking &amp; Baking </li>
                          <li>Drink &amp; Bartending </li>
                          <li>Wine Culture </li>
                        </ul>
                      <li>Lifestyle:</li>
                        <ul>
                          <li>General Health &amp; Women&rsquo;s Health </li>
                          <li>Sports, Fitness &amp; Wellness </li>
                          <li>Diet &amp; Nutrition </li>
                          <li>Psychology &amp; Therapy </li>
                        </ul>
                      <li>Parenting &amp; Family:</li>
                        <ul>
                          <li>Parenting Guide </li>
                          <li>Kids Arts </li>
                          <li>Kids Sports &amp; Leisure </li>
                        </ul>
                      <li>Tech:</li>
                        <ul>
                          <li>Programming </li>
                          <li>Web Design </li>
                          <li>Mobile App </li>
                          <li>Science </li>
                        </ul>
                    </ul>
                    <p>The world of knowledge is infinite and we are very likely to add more categories overtime! </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                  <div class="title">Can I recommend a teacher on skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-1-6" aria-expanded="true" aria-controls="part-1-6">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-1-6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                  <div class="panel-body">
                    <p>
                      Yes, avec plaisir! We will be more than happy to welcome qualified teachers based on your recommendation, please click <a href="/teacher/recommend">here</a> or drop us a line at business@skillagogo.com
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                  <div class="title">Are there job openings at skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-1-7" aria-expanded="true" aria-controls="part-1-7">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-1-7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                  <div class="panel-body">
                    <p>
                      We are always looking for good talents to join our international team in Singapore, Jakarta, and other cities in Indonesia. Visit our Career page <a href="/page/career"> here</a> or send your resume to cv@skillagogo.com. We will contact you if your profile matches our requirements.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                  <div class="title">Does skillagogo have a mobile app?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-1-72" aria-expanded="true" aria-controls="part-1-72">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-1-72" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                  <div class="panel-body">
                    <p>
                      We will be launching our mobile application very soon. Be the first to know about our mobile app launch and get a discount or promotion by registering your email address 
                      <a href="#" data-toggle="modal" data-target="#skillagogo-newsletter">here</a>.
                    </p>
                  </div>
                </div>
              </div>
              <br>
              <br>
              <div class="title-top">
                <span>Part II. Learning on skillagogo:</span>
                <div class="title-highlight"></div>
              </div>
              <div class="alert alert-info" style="font-size:18px;">
                A. General:
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Who can register to learn?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-1" aria-expanded="true" aria-controls="part-2-1">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      Everybody above the age of 18 can register with skillagogo. It’s free and hassle-free. Simply go to our sign-up page by clicking <a href="/register">here</a>.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">How much does it cost to sign up?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-2" aria-expanded="true" aria-controls="part-2-2">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      Signing up with skillagogo is absolutely free! You are not required to buy packages or membership plans. You only pay when you book a class with skillagogo.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">How to book a class through skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-3" aria-expanded="true" aria-controls="part-2-3">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      It’s simple! When you find a class that suits you, click on the “Book a Class” button and you will be asked to give your contact details and payment method (currently skillagogo accepts PayPal in Singapore and bank/ATM transfer in Indonesia). After confirming your booking, a confirmation email will be sent to you. You did not receive a confirmation email? Make sure your email address is correct. To check this, go to your Dashboard -> My Account -> Contact Info. Also check your spam/junk folder to see if our emails are filtered by your email client. Your booking will be immediately accessible in your dashboard.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Will I get a Certificate of Completion after attending a class?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-4" aria-expanded="true" aria-controls="part-2-4">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      As skillagogo is not a formal education institution, we do not provide you with a Certificate of Completion. However, some class providers/schools may issue a Certificate of Completion, depending on the class you are attending. You may check whether a class provider issue a Certificate of Completion in the class details section.
                    </p>
                  </div>
                </div>
              </div>
              <div class="alert alert-info" style="font-size:18px;">
                B. Price & Payment:
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">How can I make payment on the website?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-5" aria-expanded="true" aria-controls="part-2-5">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p>
                      skillagogo currently accepts payment by PayPal for classes in Singapore. If you book classes on our website in Indonesia, you may pay by completing a bank or ATM transfer. To complete your payment, you will be redirected to the PayPal payment page where you can choose a way to pay with PayPal: by your credit card or by your Paypal account. If you don’t have a PayPal account, please click <a href="https://www.paypal.com/">here</a>. For payment by bank or ATM transfer, after completing your payment, please send a payment confirmation to skillagogo: pembayaran@skillagogo.com.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Is it safe to pay through skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-6" aria-expanded="true" aria-controls="part-2-6">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p>
                      Payment with skillagogo is safe. By using PayPal, you do not need to share your financial details nor to register your credit card numbers on skillagogo website.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Can I pay the class provider directly?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-7" aria-expanded="true" aria-controls="part-2-7">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p>When booking with skillagogo, you are not able to pay the class provider directly.</p>
                  </div>
                </div>
              </div>
              <div class="alert alert-info" style="font-size:18px;">
                C. Reviews, Attendance & Refunds:
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Can I write a review on the class I just attended?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-8" aria-expanded="true" aria-controls="part-2-8">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-8" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p>
                      Yes, absolutely! We encourage you to share your experience with the teacher on the skillagogo website. This feature becomes available only after you have attended the class. Students who have not attended the class will not be able to write a review on a class or a teacher.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Why does skillagogo recommend that I leave a review?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-9" aria-expanded="true" aria-controls="part-2-9">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-9" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      Your review is important to the teacher. It will help the teacher to improve his/her content of his/her class and his/her online reputation. We encourage you to leave an honest and fair review, as the teacher will value it to better understand his/her performance. Your feedback will help other students to make the right decision when choosing a suitable teacher.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">What happens if the class gets cancelled by the course provider?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-10" aria-expanded="true" aria-controls="part-2-10">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-10" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p>
                      When the course provider cancels a class, you will be notified and we will arrange another schedule for you (if applicable). If the course provider does not have any schedule for the same class, your payment will be converted into skillagogo credits that you can use to pay for another class.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">I book a class, but I can’t make it. Can I change my class schedule?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-11" aria-expanded="true" aria-controls="part-2-11">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-11" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p>
                      Head over to your dashboard and choose the new class schedule. In the event that there is no other class schedule, you may convert your payment into skillagogo credits that you can use to pay for another class.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Can I cancel my registration?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-12" aria-expanded="true" aria-controls="part-2-12">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-12" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p>
                      If you are not able to attend the class you have already booked, you will be able to cancel your registration up to 72 hours before the class starts. Please use the cancellation button in your dashboard.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">What’s the refund policy?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-13" aria-expanded="true" aria-controls="part-2-13">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-13" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p>
                      Unfortunately, we are not able to offer a refund. Your payment will be converted into skillagogo credits that you can use to book another class for yourself or your loved ones!
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">What are skillagogo credits?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-14" aria-expanded="true" aria-controls="part-2-14">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-14" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p>
                      skillagogo credits are a store credit that you can use to pay for any class listed on skillagogo. These credits have a validity of 12 months. You will get an alert when your skillagogo credits are approaching the end of their validity. You may not transfer your skillagogo credit to someone else, nor cash it out. Your skillagogo credits can be used to book classes during promotion or special offer campaigns, terms and conditions may apply.
                    </p>
                  </div>
                </div>
              </div>
              <br>
              <br>
              <div class="title-top">
                <span>Part III. Teaching on skillagogo:</span>
                <div class="title-highlight"></div>
              </div>
              <div class="alert alert-info" style="font-size:18px;">
                A. General
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Who can register to teach on skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-1" aria-expanded="true" aria-controls="part-3-1">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      Everyone who has a skill to share can teach and list his/her classes on skillagogo! Whether you are an individual teacher or a small, medium or big educational institution, skillagogo helps you market your classes more effectively.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">How much does it cost to offer a class?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-2" aria-expanded="true" aria-controls="part-3-2">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      Offering a class with skillagogo is free, and will always be. We do not charge when you list your classes on skillagogo. We take a small commission only when someone registers for your class through skillagogo.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">How much is skillagogo’s commission?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-3" aria-expanded="true" aria-controls="part-3-3">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      When someone registers for your class through killagogo, we take a 15% commission on the class price.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">How do I attract more students and make sure that my class is relevant?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-4" aria-expanded="true" aria-controls="part-3-4">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      As you list your class, we encourage you to write the class description as accurately as possible. Our <a href="/dashboard/teacher/course/new_course">“Create a Class”</a> feature has been designed to give you the flexibility to create a complete description of what you are offering. Filling out all fields in this feature will help you maximise the relevance of your class.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">What is in it for me if I register my class on skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-5" aria-expanded="true" aria-controls="part-3-5">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      skillagogo is a marketplace specialising in providing courses, classes and workshops to the public. As a class provider, registering with skillagogo helps you channel your class to your targeted audience. Now you can focus on teaching, and leave the rest with us.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Does skillagogo provide a venue for teachers?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-6" aria-expanded="true" aria-controls="part-3-6">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      We do not provide a physical venue for teachers. However we will be launching an additional service to help you find a venue for your class. Stay tuned!
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Can I still acquire students outside skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-7" aria-expanded="true" aria-controls="part-3-7">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      Yes, you absolutely can. However if you do so, you will not be able to use skillagogo analytics services to see multiple metrics about your class and improve your marketing campaigns.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Can I offer a Certificate of Completion to my students?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-8" aria-expanded="true" aria-controls="part-3-8">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-8" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      Yes, you can. If your institution gives a certificate to your students, you can state this in your class description.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Can I cancel my class?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-9" aria-expanded="true" aria-controls="part-3-9">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-9" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      We suggest that you change the schedule instead of completely deleting the class. However under certain circumstances, you are allowed to delete your class by filling up the form that you can find in your dashboard, up to 48 hours before the class starts. Please do note that admin fee may apply for class cancellation.
                    </p>
                  </div>
                </div>
              </div>
              <div class="alert alert-info" style="font-size:18px;">
                B. Using “Create a Class
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">How to use “Create a Class” feature?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-10" aria-expanded="true" aria-controls="part-3-10">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-10" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      “Create a Class” is a tool that you can use to create your Class Profile Page. When you are ready to list a class with skillagogo, you can click the “Create a Class” button on our website. This feature is designed to give you flexibility to explain your students what your class is all about. A clear and good copywriting will help you market your class more effectively.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Can I make a change once my class is published?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-11" aria-expanded="true" aria-controls="part-3-11">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-11" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      <p> You may change some information about your class under certain conditions:</p>
                      <ul>
                        <li>
                          <strong>Change of price</strong>: you are only allowed to change your class price when no students are registered
                        </li>
                        <li>
                          <strong>Change of schedule</strong>: you are allowed to change your class schedule up to 48 hours before the class starts.
                        </li>
                        <li>
                          <strong>Change of venue address</strong>: you are allowed to change your class location.
                        </li>
                      </ul>
                      <p> 
                        skillagogo will not be held responsible should there be complaint or registration cancellation from the students due to class change. 
                      </p>
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    How can I contact the skillagogo team when I find problems while using the “Create a Class” feature?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-12" aria-expanded="true" aria-controls="part-3-12">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-12" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      If you have a problem using the “Create a Class” feature, we will be more than happy to help. Drop us a line at support@skillagogo.com.
                    </p>
                  </div>
                </div>
              </div>
              <div class="alert alert-info" style="font-size:18px;">
                C. Pricing
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    How do I price my class?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-13" aria-expanded="true" aria-controls="part-3-13">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-13" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      skillagogo does not want to interfere with your pricing. All prices in Singapore website are in Singaporean Dollar and in Indonesia website are in Indonesian Rupiah.
                    </p>
                  </div>
                </div>
              </div>
              <div class="alert alert-info" style="font-size:18px;">
                D. Payouts & Refunds:
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    What is the teacher payout?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-14" aria-expanded="true" aria-controls="part-3-14">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-14" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      The teacher payout is your earnings from teaching. Each time you successfully deliver a class, you will be able to claim your payouts. We have made these two types of payout transfer available for you:
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    What is the teacher payout?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-15" aria-expanded="true" aria-controls="part-3-15">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-15" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      The teacher payout is your earnings from teaching. Each time you successfully deliver a class, you will be able to claim your payouts. We have made these two types of payout transfer available for you:
                    </p>
                    <ul>
                      <li>Bi-monthly payout: we send your earnings twice a month.</li>
                      <li>Monthly payout: we send your earnings once a month.</li>
                    </ul>
                    <p> 
                      By default, the payout payment is set to “monthly payout”. If you wish to change to a bi-monthly payout payment, you may set your preferred method in your dashboard.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    When do I get my payouts?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-16" aria-expanded="true" aria-controls="part-3-16">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-16" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      Teacher payout will be sent by Paypal for course providers in Singapore and via bank transfer for course providers in Indonesia. If you choose bi-monthly payout, the transfers will reach you every 7<sup>th</sup> and 21<sup>st</sup> of the month. If you opt for monthly payout, you will receive the transfer every 7<sup>th</sup> of the month.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    How can I track the breakdown of all payments made?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-17" aria-expanded="true" aria-controls="part-3-17">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-17" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      The breakdown of your total earnings can be viewed in your dashboard.
                    </p>
                  </div>
                </div>
              </div>
              <div class="alert alert-info" style="font-size:18px;">
                E. Reviews
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    How do reviews work?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-18" aria-expanded="true" aria-controls="part-3-18">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-18" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      Students can write a review after attending your class. The review will be published on the Class Profile Page and Teacher Profile Page. To view all the reviews you have received from your students, you can go to your dashboard in the Reviews section.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    Can I remove a review?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-19" aria-expanded="true" aria-controls="part-3-19">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-19" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      No. After a review is published, it will stay in your profile. We encourage learners to leave an honest and accurate review to help the community learn about your class. Having said that, if you receive a review that violates the community guidelines, you may write to us and we will help you resolve the problem. Send your email to teachercare@skillagogo.com.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    Are reviews shared on social media platforms?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-19" aria-expanded="true" aria-controls="part-3-19">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-19" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      Yes. You can share your reviews on social media. If you pair your skillagogo profile to your social media accounts, you will be able to share your reviews on your social media profiles.
                    </p>
                  </div>
                </div>
              </div>
              <br>
              <br>
              <div class="title-top">
                <span>Part IV. Using Your Dashboard:</span>
                <div class="title-highlight"></div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    How do I manage my account settings?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-4-1" aria-expanded="true" aria-controls="part-4-1">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-4-1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      You can manage your account settings by visiting your dashboard. Go to “My Account” to complete/modify your contact details, such as birthday, address, email address, etc.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    How do I change my password?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-4-2" aria-expanded="true" aria-controls="part-4-2">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-4-2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      You can change your password by visiting your dashboard “My Account” and click the “Password Settings” tab.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    How do I change my email notifications preference?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-4-3" aria-expanded="true" aria-controls="part-4-3">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-4-3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      You can change your email notifications and newsletter subscription preferences in your dashboard by going to “My Account” and clicking the “Email Notifications” tab.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    How do I unsubscribe from email notifications?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-4-4" aria-expanded="true" aria-controls="part-4-4">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-4-4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      Visit your dashboard and click the “Email Notifications” tab. You will be able to unsubscribe from email notifications. If you change your mind you can always re-subscribe anytime at your convenience!
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    How do I see my payment history?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-4-5" aria-expanded="true" aria-controls="part-4-5">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-4-5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      You can see your payment histroy by visiting your dashboard “My Account” and click “Purchase History”.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    How do I track all payments I should receive for my classes?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-4-6" aria-expanded="true" aria-controls="part-4-6">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-4-6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      The list of your earnings (“payout”) will be recorded in your dashboard in the “Teacher Payouts” section.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    Why should I inform skillagogo about My Interests?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-4-7" aria-expanded="true" aria-controls="part-4-7">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-4-7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      Letting us know about your interests will allow us to create a more personalized recommendation for you. We don’t want you to miss interesting classes and based on your interests, you will be recommended classes that suit you.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    If I register for more classes, how can I keep track of them?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-4-8" aria-expanded="true" aria-controls="part-4-8">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-4-8" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      Your class history will reflect in your dashboard. You can visit “My Class List” to see the list of your ongoing classes, as well as your previous classes. In “My Schedule” you will see the dates of your upcoming classes
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    How can I monitor my class occupancy?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-4-9" aria-expanded="true" aria-controls="part-4-9">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-4-9" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      Your class occupancy will be recorded your dashboard under “My Classes” and you can click the “My Class Progress” tab. Should you wish to get information anytime there is a new update about your class progress (someone enrolling in your class, someone adding your class to his/her wishlist, etc.) you can subscribe to our email notification.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    What does My Data mean in my dashboard?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-4-10" aria-expanded="true" aria-controls="part-4-10">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-4-10" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      “My Data” in your dashboard is a tool for you to view the summary of your classes listed on skillagogo. You can view the total number of classes you have conducted, the number of hours, the total number of students, etc.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    How do I delete my account?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-4-11" aria-expanded="true" aria-controls="part-4-11">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-4-11" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      If you wish to delete your account, visit your dashboard “My Account” and click on the “Password Settings” tab. Allow us to remind you that account deletion is permanent and non-reversible. If you delete your account, it will be gone forever.
                    </p>
                  </div>
                </div>
              </div>
            </div>
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
          FAQ
        </div>
      </div>
    </div>
  </section>
  <section class="static-faq-2">
    <div class="container">
      <div class="col-md-12">
        <div class="box-part">
          <div class="title-top">
            <span>Bag I. Cara menggunakan skillagogo website:</span>
            <div class="title-highlight"></div>
          </div>
          <div class="description">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Apa itu skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-1-1" aria-expanded="true" aria-controls="part-1-1">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-1-1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p>
                      skillagogo adalah sebuah marketplace untuk kegiatan belajar mengajar. Di situs skillagogo, Anda bisa mencari berbagai jenis kelas, kursus atau workshop yang diselenggarakan oleh guru, instruktur atau pelatih yang berpengalaman. Temukan bermacam kelas, kursus dan workshop, mulai dari seni, desain, budaya, bisnis, makanan, gaya hidup, teknologi, serta kursus buat anak-anak (lihat daftar lengkap di bawah ini). Tugas kami di skillagogo adalah menghadirkan kelas, kursus serta workshop berkualitas terpercaya dengan pengajar, guru atau pelatih yang berpengalaman. Lalu, bagaimana cara mendaftarkan diri pada kursus favorit lewat skillagogo? Caranya sangat mudah dan bebas biaya! Daftarkan diri Anda di <a href="/register">sini</a>.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                  <div class="title">Bagaimana mendaftarkan diri sebagai “peserta kelas” atau “penyedia kelas” di situs skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-1-2" aria-expanded="true" aria-controls="part-1-2">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-1-2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                  <div class="panel-body">
                    <p>
                      Anda bisa mendaftarkan diri sebagai “peserta kelas” (jika Anda adalah pengguna yang ingin belajar) atau “penyedia kelas” (jika Anda adalah instruktur, pelatih atau guru yang ingin menampilkan kursus, kelas atau workshop Anda di skillagogo). Pendaftaran tidak dipungut biaya apapun. skillagogo bukan situs yang mengharuskan Anda untuk membayar bulanan, dan kami tidak memungut biaya apapun jika Anda ingin memasukkan kelas, kursus atau workshop yang Anda selenggarakan di skillagogo. Jika Anda tertarik untuk mendaftarkan diri di kursus yang ada di skillagogo, silakan buka akun sebagai “peserta kelas” di <a href="/login">sini</a>. Jika Anda adalah guru, pelatih, atau instruktur yang ingin memasukkan kelas, kursus atau workshop di situs skillagogo, silakan daftarkan diri Anda sebagai “penyedia kelas” di <a href="/register">sini</a>, dan untuk memasukkan profil kelas Anda, caranya sangat gampang, hanya dengan mengisi formulir pembuatan profil kelas di <a href="/dashboard/teacher/course/new_course">sini</a>.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                  <div class="title">Siapa saja yang boleh menggunakan skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-1-3" aria-expanded="true" aria-controls="part-1-3">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-1-3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                  <div class="panel-body">
                    <p>
                      Semuanya! Kegiatan belajar mengajar tidak dibatasi oleh umur, jenis kelamin atau minat. Belajar sesuatu yang baru akan membuat hidup Anda lebih kaya dan bermanfaat. Selain itu, percayalah, bahwa memiliki banyak ilmu sangat bagi kesehatan fisik dan mental Anda. Dengan skillagogo, kegiatan belajar dan mengajar Anda jadi lebih mudah. Anda bisa belajar kapan saja, di mana saja dan dengan siapa saja. Selain itu, dengan mudah Anda bisa menemukan kursus yang cocok sesuai dengan anggaran, lokasi serta pengajar. Jadi, lebih hemat waktu dan biaya! Jika Anda adalah guru, instruktur atau pelatih, apa saja keuntungan memasukkan kursus atau kelas Anda di situs skillagogo? Tentu saja kursus atau workshop yang Anda selenggarakan akan jadi lebih terkenal dan gampang diketahui oleh publik. Kemudian, workshop Anda akan mendapatkan eksposur di dunia maya yang akan meningkatkan jumlah peserta kursus (dan pendapatan Anda!). Tak hanya itu, Anda bisa dengan mudah menyelenggarakan kampanye marketing yang sesuai dengan kursus atau workshop yang Anda selenggarakan. Khusus bagi Anda, skillagogo ingin memberikan pengalaman yang menyenangkan di dunia belajar dan mengajar.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                  <div class="title">Ada di mana saja kelas-kelas yang terdapat di situs skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-1-4" aria-expanded="true" aria-controls="part-1-4">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-1-4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                  <div class="panel-body">
                    <p>
                      Saat ini kelas, kursus dan workshop skillagogo terdapat di Singapura dan Jakarta. Dalam waktu dekat kami akan tersedia juga di berbagai kota di Indonesia. Jangan sampai ketinggalan kabar terbaru dari kami, segera daftarkan email Anda untuk menerima e-newsletter berkala dari skillagogo di <a href="#" data-toggle="modal" data-target="#skillagogo-newsletter">sini</a>.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                  <div class="title">Kelas, kursus dan workshop di bidang apa saja yang terdapat di skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-1-5" aria-expanded="true" aria-controls="part-1-5">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-1-5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                  <div class="panel-body">
                    <p>
                    skillagogo menyediakan berbagai kelas dan kursus serta workshop dalam berbagai bidang, antara lain:</p>
                    <ul>
                      <li> Seni, Desain, dan Budaya </li>
                        <ul>
                          <li>Fotografi</li>
                          <li>Grafis dan Desain</li>
                          <li>Gambar dan Lukis</li>
                          <li>Penulisan Kreatif</li>
                          <li>Periklanan</li>
                          <li>Media dan Komunikasi</li>
                          <li>Film dan Video</li>
                          <li>Musik dan Audio</li>
                          <li>Hobby dan Kerajinan</li>
                          <li>Tari dan Seni Pertunjukan</li>
                          <li>Mode dan Kecantikan</li>
                          <li>Bahasa Asing</li>
                          <li>Desain Interior</li>
                        </ul>
                      <li> Bisnis </li>
                        <ul>
                        <li>Keuangan</li>
                        <li>Marketing dan Marketing Online</li>
                        <li>Kewirausahaan</li>
                        <li>Pelatihan Bisnis</li>
                        <li>Pengembangan Pribadi dan Kepemimpinan</li>
                        </ul>
                      <li>Boga</li>
                        <ul>
                          <li>Memasak dan Membuat Kue</li>
                          <li>Minuman dan Bartending</li>
                          <li>Dunia wine</li>
                        </ul>
                      <li>Gaya Hidup</li>
                        <ul>
                          <li>Kesehatan Umum dan Kesehatan Wanita</li>
                          <li>Olahraga, Fitness</li>
                          <li>Diet dan Nutrisi</li>
                          <li>Psikologi dan Terapi</li>
                        </ul>
                      <li>Keluarga</li>
                        <ul>
                          <li>Kelas Parenting</li>
                          <li>Seni Anak</li>
                          <li>Olahraga Anak</li>
                        </ul>
                      <li>Teknologi</li>
                        <ul>
                          <li>Programming</li>
                          <li>Desain Website</li>
                          <li>Aplikasi</li>
                          <li>Sains</li>
                        </ul>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                  <div class="title">Bolehkah saya merekomendasikan guru, pelatih atau instruktur kepada skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-1-6" aria-expanded="true" aria-controls="part-1-6">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-1-6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                  <div class="panel-body">
                    <p>
                      Tentu saja, avec plaisir! Dengan senang hati kami akan menerima rekomendasi dari Anda. Gunakan <a href="/teacher/recommend">formulir</a> yang tersedia di website ini atau silakan kirim email ke business@skillagogo.com.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                  <div class="title">Apakah saat ini ada posisi yang ditawarkan di skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-1-7" aria-expanded="true" aria-controls="part-1-7">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-1-7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                  <div class="panel-body">
                    <p>
                      Kami selalu mencari profil-profil yang penuh talenta dan berpengalaman seperti Anda untuk bergabung dengan tim internasional kami di Singapura dan Indonesia. Silakan kunjungi halaman <a href="/page/career">karrier</a> kami atau kirimkan CV Anda ke cv@skillagogo.com. Kami akan segera mengkontak jika CV Anda sesuai dengan profil yang kami cari.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                  <div class="title">Apakah skillagogo memiliki aplikasi mobile?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-1-72" aria-expanded="true" aria-controls="part-1-72">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-1-72" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                  <div class="panel-body">
                    <p> 
                      Kami akan meluncurkan aplikasi dalam waktu dekat. Jangan sampai ketinggalan kabar terbaru dari kami dan dapatkan diskon atau promosi dengan mendaftarkan alamat email Anda di <a href="#" data-toggle="modal" data-target="#skillagogo-newsletter">sini</a>.
                    </p>
                  </div>
                </div>
              </div>
              <br>
              <br>
              <div class="title-top">
                <span>BAG II. Belajar bersama skillagogo:</span>
                <div class="title-highlight"></div>
              </div>
              <div class="alert alert-info" style="font-size:18px;">
                A. Umum
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Siapa saja yang boleh mendaftarkan diri di skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-1" aria-expanded="true" aria-controls="part-2-1">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p>
                      Siapa saja! Jika Anda berusia di atas 18 tahun, Anda bisa mendaftarkan diri di skillagogo, bebas biaya dan caranya sangat mudah. Silakan daftar di <a href="/register">sini</a>.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Berapa biaya pendaftaran di skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-2" aria-expanded="true" aria-controls="part-2-2">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      Membuka akun dengan skillagogo gratis dan tidak dipungut bayaran. Anda tak perlu membeli paket atau membayar keanggotaan. Anda hanya membayar harga kelas yang Anda daftar serta biaya Paypal jika Anda melakukan booking kelas melalui situs Singapura skillagogo. 
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Bagaimana cara mendaftar di kelas atau kursus yang terdapat di skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-3" aria-expanded="true" aria-controls="part-2-3">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      Sangat mudah! Saat menemukan kelas yang menarik perhatian Anda, langsung klik saja “Daftar Kelas” dan Anda akan diminta untuk mengisi detail pribadi, serta cara pembayaran kelas. Saat ini Anda bisa membayar kelas/kursus/workshop di Singapura melalui Paypal. Untuk booking di situs skillagogo Indonesia, Anda bisa membayar dengan cara transfer bank atau ATM. 
                    </p>
                    <p>
                      Untuk pengguna situs skillagogo di Indonesia:
                      Setelah Anda selesai mendaftar, kami akan mengirimkan email konfirmasi pra-pendaftaran, setelah itu Anda bisa segera membayar melalui transfer bank atau ATM. Setelah transfer, kirimkan konfirmasi pembayaran melalui situs skillagogo. Pendaftaran Anda akan kami proses setelah kami menerima pembayaran dari pihak Anda. Jadwal kelas dan catatan pembayaran akan segera tersimpan di dashboard dan Anda bisa sewaktu-waktu mengaksesnya. Jika Anda menemukan masalah dengan konfirmasi pendaftaran, silakan kirim email ke: studentcare@skillagogo.com.
                    </p>
                    <p>
                      Anda tidak menerima email yang berisi konfirmasi pendaftaran? Pastikan alamat email yang Anda gunakan tertulis dengan benar dan masih aktif. Untuk memeriksanya, silakan akses di Dashboard → Akun Saya → Info Kontak. Selain itu, silakan periksa juga folder spam, mungkin email Anda terfilter di sana.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Apakah saya akan mendapat Sertifikat Kelulusan?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-4" aria-expanded="true" aria-controls="part-2-4">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      skillagogo bukan penyedia pendidikan formal, kami tidak mengeluarkan Sertifikat Kelulusan jika Anda mendaftar sebuah kelas/kursus/workshop melalui situs skillagogo. Jangan khawatir, beberapa penyelenggara kelas/kursus/workshop tertentu memberikan Sertifikat Kelulusan, silakan baca di deskripsi kelas/kursus/workshop yang tertera di Profil Kelas. 
                    </p>
                  </div>
                </div>
              </div>
              <div class="alert alert-info" style="font-size:18px;">
                B. Harga dan Pembayaran:
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Bagaimana cara membayar di situs skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-5" aria-expanded="true" aria-controls="part-2-5">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      Saat ini kami menerima pembayaran melalui Paypal untuk situs Singapura. Untuk melakukan pembayaran, Anda akan dihubungkan langsung dengan situs Paypal. Anda bisa memilih cara pembayaran yaitu membayar melalui akun Paypal atau membayar dengan kartu kredit. Jika Anda tidak memiliki akun Paypal, silakan klik di <a href="//paypal">sini</a>. Jika Anda mendaftar kelas di situs Indonesia, pembayaran bisa dilakukan melalui transfer bank atau ATM. Setelah transfer, silakan konfirmasikan pembayaran Anda dengan cara mengisi formulir pembayaran yang tersedia di situs skillagogo, sehingga kami bisa segera memproses pendaftaran Anda. 
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Apakah membayar di situs skillagogo terjamin keamanannya?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-6" aria-expanded="true" aria-controls="part-2-6">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p>
                      Pembayaran di situs skillagogo terjamin keamananannya. Dengan menggunakan Paypal, Anda tidak perlu memberikan kepada kami detail finansial Anda atau menyimpan nomor kartu kredit Anda di situs skillagogo. 
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Bolehkah saya membayar langsung kepada penyedia kelas?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-7" aria-expanded="true" aria-controls="part-2-7">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      Jika Anda melakukan booking dengan skillagogo, Anda tidak diperbolehkan untuk membayar langsung kepada penyedia kelas.
                    </p>
                  </div>
                </div>
              </div>
              <div class="alert alert-info" style="font-size:18px;">
                C. Ulasan Penilaian, Kehadiran & Uang Ganti
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Apakah saya boleh menulis ulasan penilaian pada kelas/kursus/workshop yang baru saya ikuti?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-8" aria-expanded="true" aria-controls="part-2-8">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-8" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      Tentu saja! Kami sangat menyarankan kepada Anda untuk membagikan pengalaman Anda mengikuti kelas/kursus/workshop tersebut. Anda bisa menulis ulasan penilaian mengenai kelas tersebut dari segi: materi, ketepatan waktu, cara pengajaran, dan lain-lain. Gunakan fitur untuk memberikan ulasan penilaian yang ada di skillagogo. Fitur ini akan tersedia jika Anda telah selesai mengikuti kelas tersebut. Anggota skillagogo yang belum selesai mengikuti kelas atau kursus belum diperbolehkan untuk memberikan ulasan penilaian. 
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Mengapa saya perlu memberikan ulasan penilaian setelah kursus selesai?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-9" aria-expanded="true" aria-controls="part-2-9">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-9" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      Alasannya sangat sederhana. Ulasan penilaian tersebut sangat penting bagi instruktur, guru atau pelatih Anda. Ulasan penilaian Anda akan membantu guru untuk meningkatkan materi kelasnya serta reputasi online mereka. Kami tekankan kepada Anda untuk memberikan ulasan penilaian yang jujur dan seobyektif mungkin, karena dalam hal ini instruktur akan menghargai penilaian Anda sebagai salah satu cara untuk meningkatkan mutu kelasnya. Selain itu, ulasan Anda juga akan membantu pengguna skillagogo yang lain membuat keputusan yang tepat saat memilih kelas yang akan diikuti di skillagogo. 
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Apa yang akan terjadi jika penyedia kelas membatalkan kelas/kursus/workshop dan saya telah membayar?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-10" aria-expanded="true" aria-controls="part-2-10">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-10" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      Jika seorang penyedia kelas membatalkan kelas yang diajarnya karena satu dan lain hal, Anda akan menerima email pemberitahuan dan kami akan mencarikan jadwal di hari lain jika tersedia. Pilihan lain adalah dengan menyimpan pembayaran Anda ke dalam skillagogo credit yang bisa Anda gunakan untuk mendaftar kelas yang lain. 
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Saya ternyata tidak bisa mengikuti datang di jadwal yang telah ditetapkan. Bolehkah saya ganti jadwal?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-11" aria-expanded="true" aria-controls="part-2-11">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-11" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      Jika kursus yang Anda ikuti memiliki jadwal yang lain, Anda diperbolehkan untuk ganti jadwal. Caranya, buka dashboard, dan pilih tanggal lain yang tersedia. Jika ternyata tidak ada tanggal yang lain yang tersedia, Anda bisa mengkonversikan pembayaran kursus Anda ke dalam kredit skillagogo yang bisa dipergunakan untuk booking kelas yang lain.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Bolehkah saya membatalkan kelas saya?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-12" aria-expanded="true" aria-controls="part-2-12">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-12" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      Jika Anda tidak bisa datang ke kelas yang sudah dijadwalkan, Anda bisa membatalkan pendaftaran Anda hingga 72 jam sebelum kelas dimulai. Gunakan tombol pembatalan kelas yang terdapat di dashboard.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Apa kebijaksanaan pembatalan kelas yang ada di skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-13" aria-expanded="true" aria-controls="part-2-13">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-13" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      Anda bisa membatalkan pendaftaran kelas Anda, namun saat ini kami tidak memberikan pengembalian pembayaran yang telah dibayarkan. Pembayaran Anda akan kami konversikan ke dalam kredit skillagogo yang bisa Anda gunakan untuk mendaftar ke kelas yang lain bagi Anda dan orang-orang tercinta Anda.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Apa itu skillagogo credit?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-2-14" aria-expanded="true" aria-controls="part-2-14">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-2-14" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      skillagogo credits adalah dana pembayaran yang tersimpan di akun skillagogo Anda yang bisa digunakan untuk mendaftar kelas/kursus/workshop lain yang ada di situs skillagogo. Kredit ini berlaku selama 12 bulan sejak pertama kali masuk ke akun skillagogo Anda. Kami akan mengirimkan email pemberitahuan jika kredit tersebut mendekati masa berakhir. skillagogo credit tidak bisa dipindahtangankan atau ditukar ke dalam bentuk uang tunai. Kredit ini bisa dipergunakan bersama-sama dengan bentuk promosi lain, sesuai dengan syarat dan ketentuan yang berlaku. 
                    </p>
                  </div>
                </div>
              </div>
              <br>
              <br>
              <div class="title-top">
                <span>Bag III. Mengajar bersama skillagogo:</span>
                <div class="title-highlight"></div>
              </div>
              <div class="alert alert-info" style="font-size:18px;">
                A. Umum
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Siapa saja yang boleh mengajar bersama skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-1" aria-expanded="true" aria-controls="part-3-1">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      Jika Anda memiliki keahlian, ilmu dan pengalaman, kenapa tidak? skillagogo terbuka bagi siapa saja, guru individual, sekolah, lembaga penyedia pendidikan dari segala ukuran, besar, menengah dan besar. skillagogo akan membantu memasarkan kelas/kursus/workshop Anda secara lebih efisien, sekaligus mengajak Anda untuk membangun dan menjaga reputasi online Anda. 
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Berapa biaya komisi skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-2" aria-expanded="true" aria-controls="part-3-2">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      skillagogo mengambil biaya komisi sebesar 15% dari harga kelas.
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Bagaimana cara mendapatkan peserta kursus yang lebih banyak lewat skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-3" aria-expanded="true" aria-controls="part-3-3">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      Kami sarankan agar Anda menuliskan deskripsi dan keterangan mengenai kelas yang Anda ajar seakurat dan selengkap mungkin. Dengan demikian, peserta kursus akan lebih mendapat gambaran lebih jelas dan akan lebih tertarik untuk mengikuti kelas/kursus/workshop bersama Anda. Fitur “<a href="/dashboard/teacher/course/new_course">Buka Kelas</a>” di situs skillagogo diciptakan agar Anda bisa menuliskan informasi yang komprehensif mengenai kelas/kursus/workshop yang Anda selenggarakan. Usahakan untuk mengisi semua bidang yang ada di fitur ini untuk mendapatkan Profil Kelas yang lebih menarik dan komprehensif. Jangan lupa untuk memasang beberapa foto yang menarik dengan resolusi tinggi agar calon peserta kelas/kursus/workshop mendapatkan gambaran yang lebih jelas. 
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Apa keuntungannya memposting kelas/kursus/workshop saya di situs skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-4" aria-expanded="true" aria-controls="part-3-4">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> skillagogo adalah marketplace yang mengkhususkan diri di bidang pendidikan dan menampilkan kelas, kursus, dan workshop berkualitas. Sebagai guru/penyelenggara pendidikan, menjadi anggota skillagogo akan bisa membantu memasarkan kelas Anda kepada audiens yang sesuai target. Selanjutnya Anda bisa lebih berkonsentrasi untuk mengajar, mempersiapkan materi pendidikan, dan meningkatkan mutu kelas Anda! </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Saya ingin menyelenggarakan kursus/workshop, tapi tidak memiliki ruang kelas. Apakah skillagogo menyediakan tempat kursus?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-5" aria-expanded="true" aria-controls="part-3-5">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> Saat ini kami tidak memiliki ruang kelas, ruang meeting atau venue yang bisa digunakan sebagai tempat kelas/kursus atau workshop. Kami sedang mempersiapkan layanan baru di mana Anda bisa menemukan tempat kursus atau ruang kelas yang cocok untuk kelas/kursus/workshop Anda. Tunggu kabar berikutnya mengenai layanan ini.</p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Jika saya posting kursus saya di skillagogo, apakah saya masih bisa memasarkan kursus saya ini di luar skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-6" aria-expanded="true" aria-controls="part-3-6">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> Yes, tentu saja! Meskipun demikian, jika Anda mendapatkan peserta kursus di luar skillagogo, Anda tidak bisa menggunakan perangkat analitik yang tersedia di skillagogo yang bisa Anda manfaatkan kepentingan marketing dan promosi Anda.</p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Bolehkan saya memberikan Sertifikat Kelulusan?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-7" aria-expanded="true" aria-controls="part-3-7">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> Jika karena satu dan lain hal Anda terpaksa tidak bisa mengajar, kami menyarankan kepada Anda untuk menggantinya dengan jadwal yang lain. Namun jika terpaksa Anda tak bisa menyelenggarakan kelas tersebut, Anda bisa menghapusnya dari sistem dengan cara mengisi formulir penghapusan kelas yang terdapat di dashboard, maksimal 48 jam sebelum kelas dimulai. Biaya admin mungkin akan diberlakukan untuk setiap penghapusan kelas.</p>
                  </div>
                </div>
              </div>
              <div class="alert alert-info" style="font-size:18px;">
                B. Menggunakan fitur “Buka Kelas”
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Bagaimana cara menggunakan fitur Buka Kelas?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-10" aria-expanded="true" aria-controls="part-3-10">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-10" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> Fitur “Buka Kelas” adalah perangkat yang bisa Anda gunakan untuk membuat “Profil Kelas”. Anda sudah siap untuk mempublikasikan kelas/kursus/workshop Anda di situs skillagogo? Silakan langsung ke fitur “Buka Kelas”. Fitur ini telah didesain untuk memberikan kebebasan kepada Anda untuk membuat informasi yang menyeluruh mengenai kelas Anda kepada peserta kursus potensial Anda. Teks yang jelas dan tertulis dengan baik dan benar ditambah dengan foto-foto yang menarik akan membantu Anda untuk memasarkan kelas/kursus/workshop Anda dengan lebih efektif.</p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">Bolehkah saya mengedit atau mengganti isi dari kelas yang telah tampil di situs skillagogo?</div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-11" aria-expanded="true" aria-controls="part-3-11">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-11" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> Anda diperbolehkan untuk mengganti beberapa informasi yang terdapat di listing kelas Anda dengan kondisi tertentu. </p>
                    <ul>
                      <li>
                        <strong>Mengganti harga</strong>: Anda hanya diperbolehkan untuk mengganti harga kelas jika belum ada peserta kursus yang mendaftar.
                      </li>
                      <li>
                        <strong>Mengganti jadwal</strong>: Anda diperbolehkan untuk mengganti tanggal kelas Anda hingga 48 jam sebelum kelas dimulai.
                      </li>
                      <li>
                        <strong>Mengganti tempat kursus</strong>: Anda diperbolehkan untuk mengganti tempat kursus Anda.
                      </li>
                    </ul>
                    <p> skillagogo tidak bertanggung jawab terhadap keluhan atau pembatalan pendaftaran dari pihak peserta kursus yang disebabkan oleh hal-hal di atas.</p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    Bagaimana cara mengkontak tim skillagogo jika saya menemukan masalah saat menggunakan fitur “Buka Kelas”?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-12" aria-expanded="true" aria-controls="part-3-12">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-12" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> Jika Anda mengalami masalah saat menggunakan fitur “Buka Kelas”, silakan kontak kami segera di support@skillagogo.com.</p>
                  </div>
                </div>
              </div>
              <div class="alert alert-info" style="font-size:18px;">
                C. Harga Kelas
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    Bagaimana cara menentukan harga kelas saya di skillagogo?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-13" aria-expanded="true" aria-controls="part-3-13">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-13" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> skillagogo memberikan kebebasan kepada Anda untuk menentukan harga kelas/kursus/workshop Anda. Semua harga yang tercantum di situs skillagogo di Singapura adalah dalam dolar Singapura, sedangkan harga yang tercantum di situs Indonesia adalah dalam rupiah.</p>
                  </div>
                </div>
              </div>
              <div class="alert alert-info" style="font-size:18px;">
                D. Payout dan Uang Ganti
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    Apa itu payout?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-14" aria-expanded="true" aria-controls="part-3-14">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-14" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p class="p-ul"> Payout adalah uang yang Anda hasilkan dari kegiatan mengajar Anda di skillagogo. Setiap kali selesai mengajar, Anda berhak mendapatkan payout yang akan kami kirimkan kepada Anda. Di skillagogo, ada dua cara pembayaran payout: </p>
                  <ul>
                      <li>
                        Payout dua-mingguan: kami akan mentransfer pendapatan Anda setiap dua minggu sekali.
                      </li>
                      <li>
                        Payout bulanan: kami akan mentransfer pendapatan Anda sebulan sekali.
                      </li>
                  </ul>
                  <p> Pengaturan di sistem kami menggunakan sistem “Payout dua-mingguan”. Jika Anda menginginkan transfer bulanan, silakan menggantinya di dashboard.</p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    Kapan saya mendapatkan payout saya?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-15" aria-expanded="true" aria-controls="part-3-15">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-15" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> Kami mengirimkan payout melalui Paypal untuk para penyedia kurus yang berada di situs Singapura dan melalui transfer bank untuk penyedia kursus yang berada di situs Indonesia. Untuk payout dua-mingguan, Anda akan menerima transfer setiap tanggal 7 dan 21 setiap bulannya. Sedangkan untuk payout bulanan, Anda menerima transfer pada tanggal 7 setiap bulannya.</p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    Bagaimana cara saya memantau payout saya?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-16" aria-expanded="true" aria-controls="part-3-16">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-16" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> Rincian total payout Anda bisa diakses di Dashboard → Payout.</p>
                  </div>
                </div>
              </div>
              <div class="alert alert-info" style="font-size:18px;">
                E. Ulasan penilaian (review)
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    Bagaimana cara kerja pemberian review?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-18" aria-expanded="true" aria-controls="part-3-18">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-18" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> Para peserta kursus/workshop berhak untuk memberikan ulasan penilaian (“review”) setelah menghadiri kelas Anda. Ulasan ini akan dipublikasikan pada Profil Kelas dan Profil Penyedia Kelas. Untuk melihat ulasan penilaian yang Anda terima dari para peserta kursus Anda, silakan lihat di dashboard Anda.</p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    Bisakah saya menghapus review?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-19" aria-expanded="true" aria-controls="part-3-19">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-19" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p>
                      Tidak. Setelah review tersebut dipublikasikan oleh peserta kursus Anda, maka ulasan tersebut akan tampil di halaman profil kelas dan halaman profil Anda. Kami ingin agar para peserta kursus menuliskan ulasan penilaian yang jujur dan akurat untuk membantu komunitas mendapatkan informasi yang benar mengenai kelas Anda. Jika Anda menerima ulasan yang melanggar aturan komunitas, silakan kirim email ke skillagogo dan kami akan membantu mengatasi masalah Anda: teachercare@skillagogo.com.
                      </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    Apakah ulasan penilaian tersebut bisa saya bagikan melalui media sosial?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-3-19" aria-expanded="true" aria-controls="part-3-19">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-3-19" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> Tentu saja! Anda bisa membagikan ulasan yang diterima di akun media sosial Anda. Jika profil skillagogo Anda terhubung dengan akun media sosial, maka Anda bisa mempublikasikan review tersebut di akun media sosial tersebut.</p>
                  </div>
                </div>
              </div>
              <br>
              <br>
              <div class="title-top">
                <span>Bag IV. Cara menggunakan dashboard</span>
                <div class="title-highlight"></div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    Bagaimana cara menggunakan pengaturan akun?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-4-1" aria-expanded="true" aria-controls="part-4-1">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-4-1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> Pengaturan akun bisa Anda lakukan dengan cara mengakses Dashboard. Silakan masuk ke “Akun Saya” untuk melengkapi atau mengganti detail kontak Anda seperti tanggal lahir, alamat atau alamat email. </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    Bagaimana cara mengganti kata kunci (password)?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-4-2" aria-expanded="true" aria-controls="part-4-2">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-4-2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> Anda bisa mengganti kata kunci (password) di “Akun Saya” lalu klik di “Pengaturan Password”. </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    Bagaimana cara mengganti pilihan dalam notifikasi email?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-4-3" aria-expanded="true" aria-controls="part-4-3">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-4-3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> Anda bisa mengganti pilihan notifikasi email serta langganan newsletter Anda di Dashboard “Akun Saya” lalu klik di “Notifikasi Email”.</p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    Bagaimana menghentikan layanan notifikasi email?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-4-4" aria-expanded="true" aria-controls="part-4-4">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-4-4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> Kunjungi dashboard Anda lalu klik “Notifikasi Email”. Untuk menghentikan layanan notifikasi email, silakan klik “unsubscribe”. Jika di kemudian hari Anda ingin kembali menggunakan layanan ini, Anda bisa menggantinya kembali, kapan saja!</p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    Bagaimana cara mengecek pembayaran yang sudah saya lakukan?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-4-5" aria-expanded="true" aria-controls="part-4-5">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-4-5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> Jika Anda peserta kursus/kelas, Anda bisa mengunjungi dashboard, lalu klik di “Akun Saya” → “Histori Pembayaran”. </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    Bagaimana saya mengecek semua payout yang saya terima?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-4-6" aria-expanded="true" aria-controls="part-4-6">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-4-6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> Daftar semua payout yang Anda terima sebagai penyedia kursus/kelas bisa dilihat di dashboard → “Payouts”.</p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    Mengapa saya harus menyebutkan bidang-bidang yang saya minati di skillagogo?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-4-7" aria-expanded="true" aria-controls="part-4-7">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-4-7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> Menyebutkan bidang-bidang yang Anda minati, seperti misalnya fotografi, desain, bahasa, dan lain-lain akan memudahkan kami untuk memberikan informasi yang lebih personal kepada Anda. Kami ingin agar Anda selalu mendapatkan informasi terkini kursus/kelas atau workshop yang terdapat di skillagogo, dan tentu saja, hanya pada bidang-bidang yang Anda minati.  </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    Jika saya mendaftar lebih di satu kelas/kursus, bagaimana cara memonitor jadwalnya?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-4-8" aria-expanded="true" aria-controls="part-4-8">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-4-8" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> Semua jadwal kelas/kursus/workshop yang akan Anda ikuti akan tersimpan di dashboard Anda. Silakan kunjungi “Daftar Kelas Saya” untuk melihat semua kelas yang akan Anda ikuti, begitu juga dengan kelas yang sudah Anda ikuti. Untuk melihat jadwal semua kegiatan Anda secara lebih lengkap, silakan kunjungi “Jadwal Saya”. </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    Bagaimana cara saya memonitor jumlah peserta kelas/kursus saya?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-4-9" aria-expanded="true" aria-controls="part-4-9">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-4-9" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p>Kapasitas kelas yang tersedia serta jumlah peserta yang sudah mendaftar akan tersimpan di “Kelas Saya” dan Anda bisa klik di “Perkembangan Kelas”. Jika Anda ingin mendapatkan informasi yang menyeluruh mengenai perkembangan kelas Anda (misalnya ada pendaftar baru, seorang user memasukkan kelas Anda di daftar favoritnya, dan lain-lain), Anda bisa menggunakan layanan notifikasi email. Pengaturan notifikasi email ini bisa dilakukan di dashboard Anda. </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    Apa itu “Data” di dashboard?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-4-10" aria-expanded="true" aria-controls="part-4-10">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-4-10" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p> 
                      “Data Saya” yang terdapat di dashboard adalah sebuah perangkat yang bisa Anda gunakan untuk mendapatkan rangkuman kegiatan Anda bersama skillagogo. Anda bisa melihat jumlah total kelas yang sudah Anda selenggarakan, jumlah total berapa jam Anda telah mengajar bersama skillagogo, hingga jumlah total peserta kursus/kelas yang sudah Anda ajar. Sungguh menarik, bukan?</p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <div class="title">
                    Bagaimana cara saya menghapus akun saya di skillagogo?
                  </div>
                  <a class="pull-right" role="button" data-toggle="collapse" data-parent="#accordion" href="#part-4-11" aria-expanded="true" aria-controls="part-4-11">
                    <div class="box-icon">
                      <i class="fa fa-chevron-down"></i>
                    </div>
                  </a>
                </div>
                <div id="part-4-11" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p>Jika Anda ingin menghapus akun Anda di skillagogo, silakan kunjungi dashboard “Akun Saya” dan klik di “Pengaturan Password”. Mohon dicatat bahwa jika Anda menghapus akun Anda di skillagogo, maka semua data dan informasi yang tersimpan di dalamnya akan terhapus. Pastikan Anda betul-betul yakin untuk tidak menggunakan layanan skillagogo lagi. </p>
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
                'title' => 'FAQ',
                'language' => \StaticStatic::ENGLISH,
                'author_id' => $admin[0]['id'],
                'last_editor_id' => $admin[0]['id'],
                'content' => $content_en_encode
            ]);

            $conn->insert('static_pages', [
                'title' => 'FAQ',
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
