<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Seeder extends CI_Controller
{
    private $faker;

    function __construct()
    {
        parent::__construct();

        // can only be called from the command line
        if (!$this->input->is_cli_request()) {
            redirect('/');
        }

        // can only be run in the development environment
        if (ENVIRONMENT !== 'development') {
            exit('Wowsers! You don\'t want to do that!');
        }

        // initiate faker
        $this->faker = Faker\Factory::create('en_SG');

        // load any required models
        $this->load->model('user_model');

        // load library for encrypt password
        $this->load->library('encrypt');
    }


    function slug($str, $sep='-'){
        $str = strtolower(trim($str));
        $str = preg_replace('/[^a-z0-9'.$sep.']/', $sep, $str);
        $str = preg_replace('/'.$sep.'+/', $sep, $str);
        $str = trim($str, $sep);
        
        return $str;
    }

    /**
     * seed local database
     */
    function seed()
    {
        // purge existing data
        // $this->_truncate_db();

        // seed users
        $args = func_get_args();
        if (empty($args)) {
            echo "Usage: php public/index.php seeder seed [number-of-user-teacher]
            [number-of-user-student] [number-of-address-class-schedule] [number-of-user-comment] [number-of-wishlist] [number-of-orders]" . PHP_EOL;
        } else {
            $args[0] = empty($args[0]) ? 0 : $args[0];
            $args[1] = empty($args[1]) ? 0 : $args[1];
            $args[2] = empty($args[2]) ? 0 : $args[2];
            $args[3] = empty($args[3]) ? 0 : $args[3];
            $args[4] = empty($args[4]) ? 0 : $args[4];
            $args[5] = empty($args[5]) ? 0 : $args[5];
            $this->_seed_teachers($args[0]);
            $this->_seed_students($args[1]);
            $this->_seed_orders($args[5]);
            $this->_seed_address_class_schedule($args[2]);
            // $this->_seed_comments($args[3]);
            $this->_seed_wishlists($args[4]);
        }
    }

    function _seed_teachers($limit_user_teacher)
    {
        echo "seeding $limit_user_teacher users as teacher";
        // create user as teacher
        for ($i = 0; $i < $limit_user_teacher; $i++) {
            echo ".";

            $data = array(
                'first_name' => $this->faker->firstName,
                'last_name' => $this->faker->lastName,
                'email' => $this->faker->email,
                'username' => $this->faker->unique()->userName, // get a unique nickname
                'password' => $this->encrypt->encode('password123'),
                'status' => 1,
                'is_teacher' => 1,
                'is_student' => 0,
            );
            $this->db->insert('users', $data);

            $user_id = $this->db->insert_id();
            $data_user_details = array(
                'user_id' => $user_id,
                'birth_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
                'home_phone' => $this->faker->phoneNumber,
                'mobile_phone' => $this->faker->phoneNumber,
                'gender' => $this->faker->numberBetween($min = 1, $max = 2),
                'marital_status' => $this->faker->numberBetween($min = 1, $max = 3),
                'academic_level' => $this->faker->numberBetween($min = 1, $max = 3),
                'email_notification' => 1,
                'nationality' => 'IDN',
                'language_preference' => 'id'
            );
            $this->db->insert('user_details', $data_user_details);

            $data_teacher_details = array(
                'user_id' => $user_id,
                'bank_id' => 37,
                'payout_option' => 'teacher_detail.payout_monthly',
                'monthly_class_envisaged' => 'teacher_detail.class_option2',
                'goal' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
                'objective' => 'teacher_detail.objective_grow_business',
                'bio' => $this->faker->paragraph($nbSentences = 3, $variableNbSentences = true),
                'teacher_type' => 1,
                'job' => 'PHP Programmer',
                'bank_branch_name' => 'KCP Harmoni Pusat',
                'bank_account_number' => $this->faker->randomNumber($nbDigits = null)
            );
            $this->db->insert('teacher_details', $data_teacher_details);
        }
        echo PHP_EOL;
    }

    function _seed_students($limit_user_student)
    {
        echo "seeding $limit_user_student users as student";
        // create user as student
        for ($i = 0; $i < $limit_user_student; $i++) {
            echo ".";

            $data = array(
                'first_name' => $this->faker->firstName,
                'last_name' => $this->faker->lastName,
                'email' => $this->faker->email,
                'username' => $this->faker->unique()->userName, // get a unique nickname
                'password' => $this->encrypt->encode('password123'),
                'status' => 1,
                'is_teacher' => 0,
                'is_student' => 1,
            );

            $this->db->insert('users', $data);

            $user_id = $this->db->insert_id();
            $data_user_details = array(
                'user_id' => $user_id,
                'birth_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
                'home_phone' => $this->faker->phoneNumber,
                'mobile_phone' => $this->faker->phoneNumber,
                'gender' => $this->faker->numberBetween($min = 1, $max = 2),
                'marital_status' => $this->faker->numberBetween($min = 1, $max = 3),
                'academic_level' => $this->faker->numberBetween($min = 1, $max = 3),
                'email_notification' => 1,
                'nationality' => 'IDN',
                'language_preference' => 'id'
            );
            $this->db->insert('user_details', $data_user_details);

            $data_student_details = array(
                'user_id' => $user_id
            );
            $this->db->insert('student_details', $data_student_details);
        }
        echo PHP_EOL;
    }

    function _seed_address_class_schedule($limit_address)
    {
        echo "seeding $limit_address addresses, classes, and schedules for all teachers";

        $query = "SELECT * FROM users WHERE users.is_teacher = 1";
        $row = $this->db->query($query);
        $count_teacher = $row->num_rows();

        for ($teacher_id = 1; $teacher_id <= $count_teacher; $teacher_id++) {
            for ($i = 0; $i < $limit_address; $i++) {
                echo ".";
                $currency = $this->faker->randomElement(['SGD', 'IDR']);
                if ($currency == "IDR") {
                    $this->faker = Faker\Factory::create('id_ID');
                    $state = $this->faker->state;
                    $city = $this->faker->city;
                    $country = "INDONESIA";
                } else {
                    $this->faker = Faker\Factory::create('en_SG');
                    $state = $this->faker->country;
                    $country = "SINGAPORE";
                    $city = $this->faker->townName;
                }

                $data_address = array(
                    'address_line1' => $this->faker->streetAddress,
                    'postal_code' => $this->faker->postcode,
                    'city' => $city,
                    'state' => $state,
                    'country' => $country,
                    'latitude' => $this->faker->latitude,
                    'longitude' => $this->faker->longitude,
                    'name' => $this->faker->sentence(5),
                );

                $this->db->insert('addresses', $data_address);

                $address_id = $this->db->insert_id();
                $type = $this->faker->biasedNumberBetween(1, 3);
                $title = $this->faker->sentence(4);

                do {
                    $category_id = $this->faker->biasedNumberBetween(1, 38);
                } while (in_array($category_id, [1, 15, 21, 25, 30, 34]));

                $available_seat = $this->faker->randomNumber(2);
                $data_class = array(
                    'title' => $title,
                    'slug' => $this->slug($title),
                    'description' => $this->faker->sentence(10),
                    'content' => $this->faker->text(500),
                    'prerequisite_skill' => $this->faker->boolean(33),
                    'end_goal' => $this->faker->sentence(6),
                    'class_leader' => $this->faker->name,
                    'about_leader' => $this->faker->sentence(12),
                    'type' => $type,
                    'price' => $this->faker->randomNumber(3),
                    'currency' => $currency,
                    'available_seat' => $available_seat,
                    'special_equipment' => '',
                    'pack' => $this->faker->boolean(33),
                    'level' => $this->faker->biasedNumberBetween(1, 3),
                    'publish_status' => \CourseStatic::PUBLISH_SUCCESS,
                    'category_id' => $category_id,
                    'teacher_id' => $teacher_id
                );
                $this->db->insert('classes', $data_class);

                $class_id = $this->db->insert_id();
                $dateTime = $this->faker->dateTimeBetween('+10 days', '+30 days');
                $data_schedule = array(
                    'address_id' => $address_id,
                    'class_id' => $class_id,
                    'available_seat_left' => $available_seat,
                    'date' => $dateTime->format("Y-m-d"),
                    'start_time' => $this->faker->time(),
                    'end_time' => $this->faker->time()
                );
                $dateTime = $this->faker->dateTimeBetween('+10 days', '+30 days');
                $this->db->insert('schedules', $data_schedule);
                $schedule_id = $this->db->insert_id();

                if ($type == 2 or $type == 3) {
                    $data_address = array(
                        'address_line1' => $this->faker->streetAddress,
                        'postal_code' => $this->faker->postcode,
                        'city' => $city,
                        'state' => $state,
                        'country' => $country,
                        'latitude' => $this->faker->latitude,
                        'longitude' => $this->faker->longitude,
                        'name' => $this->faker->sentence(5),
                    );

                    $this->db->insert('addresses', $data_address);

                    $address_id = $this->db->insert_id();

                    $this->db->insert('schedules', [
                        'address_id' => $address_id,
                        'class_id' => $class_id,
                        'available_seat_left' => $available_seat,
                        'date' => $dateTime->format("Y-m-d"),
                        'start_time' => $this->faker->time('H:i'),
                        'end_time' => $this->faker->time(),
                    ]);
                }
                $this->load->model('course_model');
                $this->course_model->generate_unique_id($class_id);
            }
        }

        echo PHP_EOL;
    }

    function _seed_comments($limit_comment)
    {
        echo "seeding $limit_comment comments for all courses for all users";
        $query = "SELECT * FROM classes";
        $row = $this->db->query($query);
        $count_course = $row->num_rows();

        $query = "SELECT * FROM users WHERE users.is_student = 1";
        $row = $this->db->query($query);
        $count_user = $row->num_rows();

        // create comment
        for ($user_id = 1; $user_id <= $count_user; $user_id++) {
            for ($i = 1; $i <= $count_course; $i++ ) {
                for ($j = 0; $j < $limit_comment; $j++) {
                    echo ".";

                    $data = array(
                        'user_id' => $user_id,
                        'comment' => $this->faker->paragraph($nbSentences = 3, $variableNbSentences = true),
                        'status' => $this->faker->biasedNumberBetween(0, 1),
                        'reply_to' => 0,
                    );
                    $this->db->insert('comments', $data);

                    $comment_id = $this->db->insert_id();
                    $data_class_comments = array(
                        'comment_id' => $comment_id,
                        'class_id' => $i,
                    );
                    $this->db->insert('class_comments', $data_class_comments);
                }
            }
        }

        echo PHP_EOL;
    }

    function _seed_wishlists($limit_wishlist)
    {
        echo "seeding $limit_wishlist wishlist for all users";
        $query = "SELECT * FROM classes";
        $row = $this->db->query($query);
        $count_course = $row->num_rows();

        $query = "SELECT * FROM users WHERE users.is_student = 1";
        $row = $this->db->query($query);
        $count_user = $row->num_rows();

        $limit_wishlist = $limit_wishlist > $count_course ? $count_course : $limit_wishlist;

        // create rating
        for ($user = 1; $user <= $count_user; $user++) {
            for ($i = 1; $i <= $limit_wishlist; $i++) {
                echo ".";

                $data = array(
                    'user_id' => $user,
                    'class_id' => $i,
                    );

                $this->db->insert('class_wishlists', $data);
            }
        }
        echo PHP_EOL;
    }

    /**
     * Seed orders, current classes, prev classes
     * credits, vouchers
     */
    function _seed_orders($limit_order)
    {
        echo "seeding $limit_order orders for all students";

        $query = "SELECT * FROM users WHERE users.is_teacher = 1";
        $row = $this->db->query($query);
        $count_teacher = $row->num_rows();
        $teachers = $row->result();
        $teacher_ids = array();

        foreach($teachers as $teacher) {
            $teacher_ids[] = $teacher->id;
        }

        $query = "SELECT * FROM users WHERE users.is_student = 1";
        $row = $this->db->query($query);
        $count_student = $row->num_rows();
        $students = $row->result();

        // Seed order data
        foreach ($students as $student) {
        //for ($student_id = 1; $student_id <= $count_student; $student_id++) {
            for ($i = 0; $i < $limit_order; $i++) {
            echo ".";

            $teacher_id = $this->faker->randomElement($teacher_ids);

            $currency = $this->faker->randomElement(['SGD', 'IDR']);
            if ($currency == "IDR") {
                $this->faker = Faker\Factory::create('id_ID');
                $state = $this->faker->state;
                $city = $this->faker->city;
                $country = "INDONESIA";
            } else {
                $this->faker = Faker\Factory::create('en_SG');
                $state = $this->faker->country;
                $country = "SINGAPORE";
                $city = $this->faker->townName;
            }

            $data_address = array(
                'address_line1' => $this->faker->streetAddress,
                'postal_code' => $this->faker->postcode,
                'city' => $city,
                'state' => $state,
                'country' => $country,
                'latitude' => $this->faker->latitude,
                'longitude' => $this->faker->longitude,
                'name' => $this->faker->sentence(5),
            );
            $this->db->insert('addresses', $data_address);

            $address_id = $this->db->insert_id();

            do {
                $category_id = $this->faker->biasedNumberBetween(1, 38);
            } while (in_array($category_id, [1, 15, 21, 25, 30, 34]));

            // Seed attended classes
            {
                $class_price = $this->faker->randomNumber(3);
                $type = $this->faker->biasedNumberBetween(1, 3);
                $title = $this->faker->sentence(4);

                $available_seat = $this->faker->randomNumber(2);
                $data_class = array(
                    'title' => $title,
                    'slug' => $this->slug($title),
                    'description' => $this->faker->sentence(10),
                    'content' => $this->faker->text(500),
                    'prerequisite_skill' => $this->faker->boolean(33),
                    'end_goal' => $this->faker->sentence(6),
                    'class_leader' => $this->faker->name,
                    'about_leader' => $this->faker->sentence(12),
                    'type' => $type,
                    'price' => $class_price,
                    'currency' => $currency,
                    'available_seat' => $available_seat,
                    'special_equipment' => '',
                    'pack' => $this->faker->boolean(33),
                    'level' => $this->faker->biasedNumberBetween(1, 3),
                    'publish_status' => \CourseStatic::PUBLISH_SUCCESS,
                    'category_id' => $category_id,
                    'teacher_id' => $teacher_id
                );
                $this->db->insert('classes', $data_class);
                $class_id = $this->db->insert_id();

                $dateTime = $this->faker->dateTimeBetween('-40 days', '-1 days');
                $data_schedule = array(
                    'address_id' => $address_id,
                    'class_id' => $class_id,
                    'available_seat_left' => $available_seat,
                    'date' => $dateTime->format("Y-m-d"),
                    'start_time' => $this->faker->time(),
                    'end_time' => $this->faker->time()
                );

                $dateTime = $this->faker->dateTimeBetween('-40 days', '-1 days');
                $this->db->insert('schedules', $data_schedule);
                $schedule_id = $this->db->insert_id();

                if ($type == 2 or $type == 3) {
                    $data_address = array(
                        'address_line1' => $this->faker->streetAddress,
                        'postal_code' => $this->faker->postcode,
                        'city' => $city,
                        'state' => $state,
                        'country' => $country,
                        'latitude' => $this->faker->latitude,
                        'longitude' => $this->faker->longitude,
                        'name' => $this->faker->sentence(5),
                    );
                    $this->db->insert('addresses', $data_address);

                    $address_id = $this->db->insert_id();

                    $this->db->insert('schedules', [
                        'address_id' => $address_id,
                        'class_id' => $class_id,
                        'available_seat_left' => $available_seat,
                        'date' => $dateTime->format("Y-m-d"),
                        'start_time' => $this->faker->time('H:i'),
                        'end_time' => $this->faker->time(),
                    ]);
                }
                $this->load->model('course_model');
                $this->course_model->generate_unique_id($class_id);

                $start_schedule = $this->course_model->get_date_start($class_id);

                $rated = 0;
                for($j = 0; $j < 2; $j++) {
                    $created_at_order = date('Y-m-d', strtotime($start_schedule . " -7 days"));
                    $created_at_payment = date('Y-m-d', strtotime($start_schedule . " -5 days"));
                    $created_at_order = ($created_at_order > date('Y-m-d',strtotime('today'))) ? date('Y-m-d', strtotime('today')) : $created_at_order;
                    $created_at_payment = ($created_at_payment > date('Y-m-d',strtotime('today'))) ? date('Y-m-d', strtotime('today')) : $created_at_payment;

                    // Seed orders and order_details
                    $data_order = array(
                        'user_id' => $student->id,
                        'status' => 3, // Order success
                        'total' => $class_price,
                        'currency' => $currency,
                        'created_at' => $created_at_order,
                    );
                    $this->db->insert('orders', $data_order);
                    $order_id = $this->db->insert_id();
                    $this->load->model('order_model');
                    $order = $this->order_model->get_order($order_id);

                    $data_order_detail = array(
                        'order_id' => $order_id,
                        'class_id' => $class_id,
                        'schedule_id' => $schedule_id,
                        'price' => $class_price,
                        'pax' => 2,
                        'created_at' => $created_at_order,
                    );
                    $this->db->insert('order_details', $data_order_detail);
                    $class_detail_id = $this->db->insert_id();

                    $payment_method = ($currency == "SGD") ? 2 : 1; //$this->faker->biasedNumberBetween(1, 2);

                    // Seed bank payments for attended classes
                    if ($payment_method == 1) {
                        $data_payment = array(
                            'order_id' => $order_id,
                            'payment_method' => 1,
                            'payment_date' => $order->created_at,
                            'amount' => $class_price,
                            'paypal_email' => '',
                            'paypal_transaction_id' => '',
                            'bank_destination_name' => '',
                            'bank_account_name' => '',
                            'bank_account_number' => '',
                            'note' => '',
                            'photo' => '',
                            'bank_name' => 'Bank Example',
                            'created_at' => $created_at_payment,
                        );
                        $this->db->insert('payments', $data_payment);
                    } else {
                        // Seed paypal payments for attended classes
                        $data_payment = array(
                            'order_id' => $order_id,
                            'payment_method' => 2,
                            'payment_date' => $order->created_at,
                            'amount' => $class_price,
                            'paypal_email' => '',
                            'paypal_transaction_id' => '',
                            'bank_destination_name' => '',
                            'bank_account_name' => '',
                            'bank_account_number' => '',
                            'note' => '',
                            'photo' => '',
                            'bank_name' => 'Bank Example',
                            'created_at' => $created_at_payment,
                        );
                        $this->db->insert('payments', $data_payment);
                    }
                    $this->order_model->generate_receipt_code($order_id);

                    // attender or not
                    $is_attended = $this->faker->biasedNumberBetween(0, 1);

                    $this->load->model('voucher_model');
                    $course = $this->course_model->get_course($class_id, false, false);

                    if ($is_attended == 1) {
                        // Seed vouchers for attended classes 3 times
                        for ($i = 0; $i < 2; $i++) {

                            $voucher_code = $this->voucher_model->generate_voucher($course);
                            $data_voucher = array(
                                'user_id' => $student->id,
                                'voucher_code' => $voucher_code,
                                'status' => 1,
                                'order_detail_id' => $class_detail_id,
                                'created_at' => $created_at_order,
                                );
                            $this->db->insert('vouchers', $data_voucher);
                            $voucher_id = $this->db->insert_id();

                            // Update updated_at
                            $last_schedule = $this->course_model->get_date_end($class_id);
                            $update_to_date = date('Y-m-d', strtotime($last_schedule . " + 1 days"));
                            $this->db->where('id', $voucher_id);
                            $this->db->update('vouchers', ['updated_at' => $update_to_date]);

                            // Seed class_attendees
                            $data_class_attendees = array(
                                'class_id' => $class_id,
                                'voucher_id' => $voucher_id,
                                'created_at' => $update_to_date,
                                );
                            $this->db->insert('class_attendees', $data_class_attendees);
                            $data_class_attendees_id = $this->db->insert_id();

                            // Create payout
                            $is_payout = ($this->course_model->check_date_end_last_month($class_id)) ? 1 : 0;
                            $is_payout_paid = $this->faker->biasedNumberBetween(0, 1);

                            // Payout amount after deducting the skillagogo commision
                            $course_price = $class_price;

                            // Calculate commission based on the currency
                            if ($currency == "SGD") {
                                $teacher_takehome_amount = $course_price - ($course_price*\PayoutStatic::SKILLAGOGO_COMMISSION);
                            } elseif ($currency == "IDR") {
                                $teacher_takehome_amount = $course_price - (floor($course_price*\PayoutStatic::SKILLAGOGO_COMMISSION));
                            }

                            if ($is_payout && $is_payout_paid) {

                                $date = date_create('now');
                                $payout_date = date_format($date, 'Y-m-d');

                                $data_payout = array(
                                    'teacher_id' => $teacher_id,
                                    'amount' => $teacher_takehome_amount,
                                    'status' => 1,
                                    'currency' => $currency,
                                    'payment_date' => $payout_date,
                                    );
                            } else {
                                $data_payout = array(
                                    'teacher_id' => $teacher_id,
                                    'amount' => $teacher_takehome_amount,
                                    'currency' => $currency,
                                    'status' => 0,
                                    );
                            }
                            $this->db->insert('payouts', $data_payout);
                            $data_payout_id = $this->db->insert_id();

                            // Update updated_at
                            // $this->db->where('id', $data_payout_id);
                            // $this->db->update('payouts', ['created_at' => $update_to_date]);

                            $this->db->where('id', $data_class_attendees_id);
                            $this->db->update('class_attendees', ['payout_id' => $data_payout_id]);

                            $this->db->where('id', $voucher_id);
                            $this->db->update('vouchers', ['is_redeemed' => 1]);

                            $this->load->model('payout_model');
                            $this->payout_model->generate_invoice_code($data_payout_id);
                        }

                        // Seed ratings
                        if (!$rated) {
                            $data_rating = array(
                                'user_id' => $student->id,
                                'review' => $this->faker->paragraph($nbSentences = 3, $variableNbSentences = true),
                                'rate' => $this->faker->numberBetween($min = 1, $max = 5),
                                'status' => $this->faker->biasedNumberBetween(0, 1),
                                'reply_to' => 0,
                                'class_id' => $class_id,
                                );
                            $this->db->insert('ratings', $data_rating);
                        }
                        $rated = 1;

                    } else {
                        // Seed vouchers for not attended classes
                        $voucher_code = $this->voucher_model->generate_voucher($course);
                        $data_voucher = array(
                            'user_id' => $student->id,
                            'voucher_code' => $voucher_code,
                            'status' => 3,
                            'order_detail_id' => $class_detail_id,
                            'created_at' => $created_at_order,
                            );
                        $this->db->insert('vouchers', $data_voucher);
                        $voucher_id = $this->db->insert_id();

                        // Update updated_at
                        $last_schedule = $this->course_model->get_date_end($class_id);
                        $update_to_date = date('Y-m-d', strtotime($last_schedule . " + 3 days"));
                        $this->db->where('id', $voucher_id);
                        $this->db->update('vouchers', ['updated_at' => $update_to_date]);

                        $date = date_create('now');
                        date_add($date, date_interval_create_from_date_string('1 year'));
                        $expired_date = date_format($date, 'Y-m-d');

                        // Seed skillagogo credits
                        $data_credit = array(
                            'voucher_id' => $voucher_id,
                            'user_id' => $student->id,
                            'initial_amount' => $class_price,
                            'expired_date' => $expired_date,
                            'amount_used' => 0,
                            'currency' => $currency,
                            'reason' => 'not_attending',
                            'created_at' => $update_to_date,
                            );
                        $this->db->insert('credits', $data_credit);
                        $credit_id = $this->db->insert_id();

                        $this->db->insert('credit_histories', [
                            'credit_id' => $credit_id,
                            'debit' => $class_price,
                            'description' => 'not_attending',
                            'order_id' => $order_id
                        ]);

                    }
                }
            }

            // Seed will-attend classes
            {
                $class_price = $this->faker->randomNumber(3);
                $type = $this->faker->biasedNumberBetween(1, 3);
                $title = $this->faker->sentence(4);

                $available_seat = $this->faker->randomNumber(2);
                $data_class = array(
                    'title' => $title,
                    'slug' => $this->slug($title),
                    'description' => $this->faker->sentence(10),
                    'content' => $this->faker->text(500),
                    'prerequisite_skill' => $this->faker->boolean(33),
                    'end_goal' => $this->faker->sentence(6),
                    'class_leader' => $this->faker->name,
                    'about_leader' => $this->faker->sentence(12),
                    'type' => $type,
                    'price' => $class_price,
                    'currency' => $currency,
                    'available_seat' => $available_seat,
                    'special_equipment' => '',
                    'pack' => $this->faker->boolean(33),
                    'level' => $this->faker->biasedNumberBetween(1, 3),
                    'publish_status' => \CourseStatic::PUBLISH_SUCCESS,
                    'category_id' => $category_id,
                    'teacher_id' => $teacher_id
                );
                $this->db->insert('classes', $data_class);

                $class_id = $this->db->insert_id();
                $dateTime = $this->faker->dateTimeBetween('+10 days', '+30 days');
                $data_schedule = array(
                    'address_id' => $address_id,
                    'class_id' => $class_id,
                    'available_seat_left' => $available_seat,
                    'date' => $dateTime->format("Y-m-d"),
                    'start_time' => $this->faker->time(),
                    'end_time' => $this->faker->time()
                );

                $dateTime = $this->faker->dateTimeBetween('+10 days', '+30 days');
                $this->db->insert('schedules', $data_schedule);
                $schedule_id = $this->db->insert_id();

                if ($type == 2 or $type == 3) {

                    $data_address = array(
                        'address_line1' => $this->faker->streetAddress,
                        'postal_code' => $this->faker->postcode,
                        'city' => $city,
                        'state' => $state,
                        'country' => $country,
                        'latitude' => $this->faker->latitude,
                        'longitude' => $this->faker->longitude,
                        'name' => $this->faker->sentence(5),
                    );
                    $this->db->insert('addresses', $data_address);

                    $address_id = $this->db->insert_id();

                    $this->db->insert('schedules', [
                        'address_id' => $address_id,
                        'class_id' => $class_id,
                        'available_seat_left' => $available_seat,
                        'date' => $dateTime->format("Y-m-d"),
                        'start_time' => $this->faker->time('H:i'),
                        'end_time' => $this->faker->time(),
                    ]);
                }
                $this->load->model('course_model');
                $this->course_model->generate_unique_id($class_id);

                $payment_method = ($currency == "SGD") ? 2 : 1; //$this->faker->biasedNumberBetween(1, 2);

                $start_schedule = $this->course_model->get_date_start($class_id);
                $created_at_order = date('Y-m-d', strtotime($start_schedule . " -7 days"));
                $created_at_payment = date('Y-m-d', strtotime($start_schedule . " -5 days"));
                $created_at_order = ($created_at_order > date('Y-m-d',strtotime('today'))) ? date('Y-m-d', strtotime('today')) : $created_at_order;
                $created_at_payment = ($created_at_payment > date('Y-m-d',strtotime('today'))) ? date('Y-m-d', strtotime('today')) : $created_at_payment;

                // Seed bank payments for attended classes
                if ($payment_method == 1) {

                    // Seed orders and order_details
                    $data_order = array(
                        'user_id' => $student->id,
                        'status' => 1, // Waiting for confirmation
                        'total' => $class_price,
                        'currency' => $currency,
                        'created_at' => $created_at_order,
                    );
                    $this->db->insert('orders', $data_order);
                    $order_id = $this->db->insert_id();
                    $this->load->model('order_model');
                    $order = $this->order_model->get_order($order_id);
                    // $this->order_model->generate_receipt_code($order_id);

                    $data_order_detail = array(
                        'order_id' => $order_id,
                        'class_id' => $class_id,
                        'schedule_id' => $schedule_id,
                        'price' => $class_price,
                        'pax' => 1,
                        'created_at' => $created_at_order,
                    );
                    $this->db->insert('order_details', $data_order_detail);
                    $class_detail_id = $this->db->insert_id();

                    $data_payment = array(
                        'order_id' => $order_id,
                        'payment_method' => 1,
                        'payment_date' => $order->created_at,
                        'amount' => $class_price,
                        'paypal_email' => '',
                        'paypal_transaction_id' => '',
                        'bank_destination_name' => '',
                        'bank_account_name' => '',
                        'bank_account_number' => '',
                        'note' => '',
                        'photo' => '',
                        'bank_name' => 'Bank Example',
                        'created_at' => $created_at_payment,
                    );
                    $this->db->insert('payments', $data_payment);
                } else {

                    // Seed orders and order_details
                    $data_order = array(
                        'user_id' => $student->id,
                        'status' => 3, // Order success
                        'total' => $class_price,
                        'currency' => $currency,
                        'created_at' => $created_at_order,
                    );
                    $this->db->insert('orders', $data_order);
                    $order_id = $this->db->insert_id();
                    $this->load->model('order_model');
                    $order = $this->order_model->get_order($order_id);
                    $this->order_model->generate_receipt_code($order_id);

                    $data_order_detail = array(
                        'order_id' => $order_id,
                        'class_id' => $class_id,
                        'schedule_id' => $schedule_id,
                        'price' => $class_price,
                        'pax' => 1,
                        'created_at' => $created_at_order,
                    );
                    $this->db->insert('order_details', $data_order_detail);
                    $class_detail_id = $this->db->insert_id();

                    // Seed paypal payments for attended classes
                    $data_payment = array(
                        'order_id' => $order_id,
                        'payment_method' => 2,
                        'payment_date' => $order->created_at,
                        'amount' => $class_price,
                        'paypal_email' => '',
                        'paypal_transaction_id' => '',
                        'bank_destination_name' => '',
                        'bank_account_name' => '',
                        'bank_account_number' => '',
                        'note' => '',
                        'photo' => '',
                        'bank_name' => 'Bank Example',
                        'created_at' => $created_at_payment,
                    );
                    $this->db->insert('payments', $data_payment);
                    $this->order_model->generate_receipt_code($order_id);
                }

                // Seed vouchers for attended classes
                $this->load->model('voucher_model');
                $course = $this->course_model->get_course($class_id, false, false);
                $voucher_code = $this->voucher_model->generate_voucher($course);
                $data_voucher = array(
                    'user_id' => $student->id,
                    'voucher_code' => $voucher_code,
                    'status' => 0,
                    'order_detail_id' => $class_detail_id,
                    'created_at' => $created_at_order,
                );
                $this->db->insert('vouchers', $data_voucher);
                $voucher_id = $this->db->insert_id();
            }

            // Seed attended classes that ended in < 2 days but voucher not redeemed
            {
                $class_price = $this->faker->randomNumber(3);
                $type = $this->faker->biasedNumberBetween(1, 3);
                $title = $this->faker->sentence(4);

                $available_seat = $this->faker->randomNumber(2);
                $data_class = array(
                    'title' => $title,
                    'slug' => $this->slug($title),
                    'description' => $this->faker->sentence(10),
                    'content' => $this->faker->text(500),
                    'prerequisite_skill' => $this->faker->boolean(33),
                    'end_goal' => $this->faker->sentence(6),
                    'class_leader' => $this->faker->name,
                    'about_leader' => $this->faker->sentence(12),
                    'type' => $type,
                    'price' => $class_price,
                    'currency' => $currency,
                    'available_seat' => $available_seat,
                    'special_equipment' => '',
                    'pack' => $this->faker->boolean(33),
                    'level' => $this->faker->biasedNumberBetween(1, 3),
                    'publish_status' => \CourseStatic::PUBLISH_SUCCESS,
                    'category_id' => $category_id,
                    'teacher_id' => $teacher_id
                );
                $this->db->insert('classes', $data_class);
                $class_id = $this->db->insert_id();

                $dateTime = $this->faker->dateTimeBetween('-3 days', '-0 days');
                $data_schedule = array(
                    'address_id' => $address_id,
                    'class_id' => $class_id,
                    'available_seat_left' => $available_seat,
                    'date' => $dateTime->format("Y-m-d"),
                    'start_time' => $this->faker->time(),
                    'end_time' => $this->faker->time()
                );

                $dateTime = $this->faker->dateTimeBetween('-3 days', '-0 days');
                $this->db->insert('schedules', $data_schedule);
                $schedule_id = $this->db->insert_id();

                if ($type == 2 or $type == 3) {

                    $data_address = array(
                        'address_line1' => $this->faker->streetAddress,
                        'postal_code' => $this->faker->postcode,
                        'city' => $city,
                        'state' => $state,
                        'country' => $country,
                        'latitude' => $this->faker->latitude,
                        'longitude' => $this->faker->longitude,
                        'name' => $this->faker->sentence(5),
                    );
                    $this->db->insert('addresses', $data_address);

                    $address_id = $this->db->insert_id();
                    
                    $this->db->insert('schedules', [
                        'address_id' => $address_id,
                        'class_id' => $class_id,
                        'available_seat_left' => $available_seat,
                        'date' => $dateTime->format("Y-m-d"),
                        'start_time' => $this->faker->time('H:i'),
                        'end_time' => $this->faker->time(),
                    ]);
                }
                $this->load->model('course_model');
                $this->course_model->generate_unique_id($class_id);

                $start_schedule = $this->course_model->get_date_start($class_id);
                $created_at_order = date('Y-m-d', strtotime($start_schedule . " -7 days"));
                $created_at_payment = date('Y-m-d', strtotime($start_schedule . " -5 days"));
                $created_at_order = ($created_at_order > date('Y-m-d',strtotime('today'))) ? date('Y-m-d', strtotime('today')) : $created_at_order;
                $created_at_payment = ($created_at_payment > date('Y-m-d',strtotime('today'))) ? date('Y-m-d', strtotime('today')) : $created_at_payment;

                // Seed orders and order_details
                $data_order = array(
                    'user_id' => $student->id,
                    'status' => 3, // Order success
                    'total' => $class_price,
                    'currency' => $currency,
                    'created_at' => $created_at_order,
                );
                $this->db->insert('orders', $data_order);
                $order_id = $this->db->insert_id();
                $this->load->model('order_model');
                $order = $this->order_model->get_order($order_id);

                $data_order_detail = array(
                    'order_id' => $order_id,
                    'class_id' => $class_id,
                    'schedule_id' => $schedule_id,
                    'price' => $class_price,
                    'pax' => 1,
                    'created_at' => $created_at_order,
                );
                $this->db->insert('order_details', $data_order_detail);
                $class_detail_id = $this->db->insert_id();

                $payment_method = ($currency == "SGD") ? 2 : 1; //$this->faker->biasedNumberBetween(1, 2);

                // Seed bank payments for attended classes
                if ($payment_method == 1) {
                    $data_payment = array(
                        'order_id' => $order_id,
                        'payment_method' => 1,
                        'payment_date' => $order->created_at,
                        'amount' => $class_price,
                        'paypal_email' => '',
                        'paypal_transaction_id' => '',
                        'bank_destination_name' => '',
                        'bank_account_name' => '',
                        'bank_account_number' => '',
                        'note' => '',
                        'photo' => '',
                        'bank_name' => 'Bank Example',
                        'created_at' => $created_at_payment,
                    );
                    $this->db->insert('payments', $data_payment);
                } else {
                    // Seed paypal payments for attended classes
                    $data_payment = array(
                        'order_id' => $order_id,
                        'payment_method' => 2,
                        'payment_date' => $order->created_at,
                        'amount' => $class_price,
                        'paypal_email' => '',
                        'paypal_transaction_id' => '',
                        'bank_destination_name' => '',
                        'bank_account_name' => '',
                        'bank_account_number' => '',
                        'note' => '',
                        'photo' => '',
                        'bank_name' => 'Bank Example',
                        'created_at' => $created_at_payment,
                    );
                    $this->db->insert('payments', $data_payment);
                }
                $this->order_model->generate_receipt_code($order_id);

                // attender or not
                $is_attended = $this->faker->biasedNumberBetween(0, 1);

                $this->load->model('voucher_model');
                $course = $this->course_model->get_course($class_id, false, false);
                $voucher_code = $this->voucher_model->generate_voucher($course);

                if ($is_attended == 1) {
                    // Seed vouchers for attended classes
                    $data_voucher = array(
                        'user_id' => $student->id,
                        'voucher_code' => $voucher_code,
                        'status' => 0,
                        'order_detail_id' => $class_detail_id,
                        'created_at' => $created_at_order,
                        );
                    $this->db->insert('vouchers', $data_voucher);
                    $voucher_id = $this->db->insert_id();
                } else {
                    // Seed vouchers for not attended classes
                    $data_voucher = array(
                        'user_id' => $student->id,
                        'voucher_code' => $voucher_code,
                        'status' => 2,
                        'order_detail_id' => $class_detail_id,
                        'created_at' => $created_at_order,
                        );
                    $this->db->insert('vouchers', $data_voucher);
                    $voucher_id = $this->db->insert_id();

                    // Update updated_at
                    $last_schedule = $this->course_model->get_date_end($class_id);
                    $update_to_date = date('Y-m-d', strtotime($last_schedule . " + 3 days"));
                    $this->db->where('id', $voucher_id);
                    $this->db->update('vouchers', ['updated_at' => $update_to_date]);

                    $date = date_create('now');
                    date_add($date, date_interval_create_from_date_string('1 year'));
                    $expired_date = date_format($date, 'Y-m-d');

                    // Seed skillagogo credits
                    $data_credit = array(
                        'voucher_id' => $voucher_id,
                        'user_id' => $student->id,
                        'initial_amount' => $class_price,
                        'expired_date' => $expired_date,
                        'amount_used' => 0,
                        'currency' => $currency,
                        'reason' => 'not_attending',
                        'created_at' => $update_to_date,
                        );
                    $this->db->insert('credits', $data_credit);
                    $credit_id = $this->db->insert_id();

                    $this->db->insert('credit_histories', [
                        'credit_id' => $credit_id,
                        'debit' => $class_price,
                        'description' => 'not_attending',
                        'order_id' => $order_id
                    ]);
                }
            }

            }
        }
        echo PHP_EOL;
    }

//    private function _truncate_db()
//    {
//        $this->truncate();
//    }
}
