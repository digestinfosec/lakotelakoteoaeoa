<?php

use Scienceguard\SG_Util;

class Course_model extends MY_Model
{
    /**
     * Get single course
     *
     * @param $course_id
     * @param null $teacher_id
     * @return mixed
     */
    public function get_course($course_id, $with_schedules = true, $with_images = true)
    {
        $this->db->select('classes.*, classes.id as course_id, us.first_name, us.last_name, td.job as teacher_job, td.bio as teacher_bio,
        us.profile_pic as teacher_avatar, ud.mobile_phone, categories.parent_id as category_parent');
        $this->db->from('classes');
        $this->db->join('users as us', 'us.id = classes.teacher_id', 'left');
        $this->db->join('categories', 'categories.id = classes.category_id');
        $this->db->join('teacher_details as td', 'td.user_id = classes.teacher_id', 'left');
        $this->db->join('user_details as ud', 'ud.user_id = classes.teacher_id', 'left');
        $this->db->join('ratings', 'classes.id = ratings.class_id', 'left');
        $this->db->where('classes.id', $course_id);

        $query = $this->db->get();
        $course = $query->row();

        // Untuk mencari alamat, jadwal, tempat dari class
        if ($with_schedules) {
            $this->db->select('*, addresses.*, schedules.id as schedule_id');
            $this->db->join('addresses', 'addresses.id = schedules.address_id', 'left');
            $this->db->order_by('date', 'asc');
            $schedules = $this->db->get_where('schedules', 'schedules.class_id = ' . $course_id);
            $course->schedules = $schedules->result();
        }

        if ($with_images) {
            $this->db->where('images.entity', 'classes');
            $this->db->where('images.entity_id', $course_id);
            $query = $this->db->get('images');
            $course->images = $query->result();
        }

        $this->db->where('class_id', $course_id);
        $this->db->where('user_id', $this->session->userdata('login')['user_id']);
        $query = $this->db->get('class_wishlists');
        $wish = $query->row();
        $course->wishlist_status = count($wish) > 0 ? true : false;

        $course->class_started = $this->check_date_started($course->id);

        return $course;
    }

    /**
     * Get single course
     *
     * @param $course_id
     * @param null $teacher_id
     * @return mixed
     */
    public function get_course_by_slug($long_slug, $with_schedules = true, $with_images = true)
    {
        $explode_str = explode('-', $long_slug, 2);
        $slug = $explode_str[1];
        $unique_id = $explode_str[0];

        $this->db->select('classes.*, us.first_name, us.last_name, td.job as teacher_job, td.bio as teacher_bio,
        us.profile_pic as teacher_avatar, ud.mobile_phone, categories.parent_id as category_parent');
        $this->db->from('classes');
        $this->db->join('users as us', 'us.id = classes.teacher_id', 'left');
        $this->db->join('categories', 'categories.id = classes.category_id');
        $this->db->join('teacher_details as td', 'td.user_id = classes.teacher_id', 'left');
        $this->db->join('user_details as ud', 'ud.user_id = classes.teacher_id', 'left');
        $this->db->join('ratings', 'classes.id = ratings.class_id', 'left');
        $this->db->where('classes.slug', $slug);
        $this->db->where('classes.unique_id', $unique_id);

        $query = $this->db->get();
        $course = $query->row();

        // Untuk mencari alamat, jadwal, tempat dari class
        if ($with_schedules) {
            $this->db->select('*, addresses.*');
            $this->db->join('addresses', 'addresses.id = schedules.address_id', 'left');
            $this->db->order_by('date', 'asc');
            $schedules = $this->db->get_where('schedules', 'schedules.class_id = ' . $course->id);
            $course->schedules = $schedules->result();
        }

        if ($with_images) {
            $this->db->where('images.entity', 'classes');
            $this->db->where('images.entity_id', $course->id);
            $query = $this->db->get('images');
            $course->images = $query->result();
        }

        $this->db->where('class_id', $course->id);
        $this->db->where('user_id', $this->session->userdata('login')['user_id']);
        $query = $this->db->get('class_wishlists');
        $wish = $query->row();
        $course->wishlist_status = count($wish) > 0 ? true : false;

        $course->class_started = $this->check_date_started($course->id);

        return $course;
    }

    /**
     * Get list student courses
     *
     * @param $student_id
     * @param $option
     * @return mixed
     */
    public function get_student_courses($student_id, $option)
    {
        $option['student_id'] = $student_id;
        return $this->get_courses($option);
    }

    /**
     * Get list student courses
     *
     * @param $student_id
     * @param $option
     * @return mixed
     */
    public function get_student_cancelled_courses($student_id, $option = [])
    {
        $this->db->select('order_details.*, classes.*, schedules.*, addresses.*, vouchers.*, order_details.id as order_detail_id, classes.id as course_id, categories.name as category_name');
        $this->db->join('schedules', 'schedules.id=order_details.schedule_id');
        $this->db->join('addresses', 'addresses.id=schedules.address_id');
        $this->db->join('classes', 'classes.id=order_details.class_id');
        $this->db->join('categories', 'categories.id = classes.category_id');
        $this->db->join('orders', 'orders.id=order_details.order_id');
        $this->db->join('vouchers', 'vouchers.order_detail_id=order_details.id');
        $this->db->where('vouchers.status !=', VoucherStatic::VOUCHER_USED);
        $this->db->where('vouchers.status !=', VoucherStatic::VOUCHER_UNUSED);
        //$this->db->where('schedules.date >=', date('Y-m-d', strtotime('today')));
        $this->db->where('orders.user_id', $student_id);
        $this->db->order_by('schedules.date', 'ASC');


        // limit option for pagination
        if (isset($option['limit'])) {
            if (isset($option['offset'])) {
                $this->db->limit($option['limit'], $option['offset']);
            } else {
                $this->db->limit($option['limit']);
            }
        }

        // Set currency
        $currency = $this->session->userdata('currency') == 'Rp' ? 'IDR' : 'SGD';
        $this->db->where('classes.currency', $currency);

        $query = $this->db->get('order_details');
        $result = $query->result();

        return $result;
    }

    /**
     * Get courses by teacher_id
     *
     * @param $teacher_id
     * @param $option
     * @return mixed
     */
    public function get_teacher_courses($teacher_id, $option)
    {
        $option['teacher_id'] = $teacher_id;
        return $this->get_courses($option);
    }

    public function get_student_current_courses($student_id, $option = [])
    {
        $this->db->select('order_details.*, classes.*, schedules.*, addresses.*, vouchers.*, order_details.id as order_detail_id, classes.id as course_id, categories.name as category_name, orders.*');
        $this->db->join('schedules', 'schedules.id=order_details.schedule_id');
        $this->db->join('addresses', 'addresses.id=schedules.address_id');
        $this->db->join('classes', 'classes.id=order_details.class_id');
        $this->db->join('categories', 'categories.id = classes.category_id');
        $this->db->join('orders', 'orders.id=order_details.order_id');
        $this->db->join('vouchers', 'vouchers.order_detail_id=order_details.id');
        $this->db->where('classes.status !=', CourseStatic::STATUS_CANCELLED);
        $this->db->where('classes.status !=', CourseStatic::STATUS_DELETED);
        $this->db->where('classes.status !=', CourseStatic::STATUS_FINISHED);
        $this->db->where('vouchers.status', VoucherStatic::VOUCHER_UNUSED);
        $this->db->where('schedules.date >=', date('Y-m-d', strtotime('today')));
        $this->db->where('orders.user_id', $student_id);
        $this->db->order_by('schedules.date', 'ASC');

        // limit option for pagination
        if (isset($option['limit'])) {
            if (isset($option['offset'])) {
                $this->db->limit($option['limit'], $option['offset']);
            } else {
                $this->db->limit($option['limit']);
            }
        }

        // Set currency
        $currency = $this->session->userdata('currency') == 'Rp' ? 'IDR' : 'SGD';
        $this->db->where('classes.currency', $currency);

        $query = $this->db->get('order_details');
        $result = $query->result();

        $this->load->model('attendee_model');
        $this->load->model('rating_model');
        foreach ($result as $course) {
            if ($this->attendee_model->check_attendees($course->course_id, $course->voucher_code) && !$this->rating_model->get_rating_by_student_and_class_id($student_id, $course->course_id)) {
            // if (!$this->attendee_model->check_attendees($course->course_id, $course->voucher_code)) {
                $course->add_rating_status = 1;
            }

            $course->can_cancel_status = 0;

            if ($this->check_date_for_cancel_student($course->course_id)) {
                $course->can_cancel_status = 1;
            }

            // Untuk mencari alamat, jadwal, tempat dari class
            $this->db->select('*, addresses.name as venue_name');
            $this->db->join('addresses', 'addresses.id = schedules.address_id', 'left');
            $this->db->order_by('date', 'asc');
            $schedules = $this->db->get_where('schedules', 'schedules.class_id = ' . $course->course_id);
            $course->schedules = $schedules->result();

            // Untuk mencari voucher
            // $this->db->select('voucher_code');
            // $schedules = $this->db->get_where('vouchers', 'vouchers.order_detail_id = ' . $course->order_detail_id);
            // $course->voucher_code = $schedules->row()->voucher_code;
        }

        return $result;
    }

    public function get_student_past_courses($student_id, $option = [])
    {
        $this->db->select('order_details.*, classes.*, schedules.*, addresses.*, vouchers.*, order_details.id as order_detail_id, classes.id as course_id, categories.name as category_name');
        $this->db->join('schedules', 'schedules.id=order_details.schedule_id');
        $this->db->join('addresses', 'addresses.id=schedules.address_id');
        $this->db->join('classes', 'classes.id=order_details.class_id');
        $this->db->join('categories', 'categories.id = classes.category_id');
        $this->db->join('orders', 'orders.id=order_details.order_id');
        $this->db->join('vouchers', 'vouchers.order_detail_id=order_details.id');
        $this->db->where('classes.status !=', CourseStatic::STATUS_CANCELLED);
        $this->db->where('classes.status !=', CourseStatic::STATUS_DELETED);
        // $this->db->where('vouchers.status', VoucherStatic::VOUCHER_USED);
        $this->db->where('schedules.date <', date('Y-m-d', strtotime('today')));
        $this->db->where('orders.user_id', $student_id);
        $this->db->order_by('schedules.date', 'DESC');
        $this->db->group_by('vouchers.voucher_code');

        // limit option for pagination
        if (isset($option['limit'])) {
            if (isset($option['offset'])) {
                $this->db->limit($option['limit'], $option['offset']);
            } else {
                $this->db->limit($option['limit']);
            }
        }

        // Set currency
        $currency = $this->session->userdata('currency') == 'Rp' ? 'IDR' : 'SGD';
        $this->db->where('classes.currency', $currency);

        $query = $this->db->get('order_details');
        $result = $query->result();
        // var_dump($result);

        $this->load->model('attendee_model');
        $this->load->model('rating_model');
        foreach ($result as $course) {
            if ($this->attendee_model->check_attendees($course->course_id, $course->voucher_code) && !$this->rating_model->get_rating_by_student_and_class_id($student_id, $course->course_id)) {
            // if (!$this->attendee_model->check_attendees($course->course_id, $course->voucher_code)) {
                $course->add_rating_status = 1;
            }

            $course->can_cancel_status = 0;

            if ($this->check_date_for_cancel_student($course->course_id)) {
                $course->can_cancel_status = 1;
            }

            // Untuk mencari alamat, jadwal, tempat dari class
            $this->db->select('*, addresses.name as venue_name');
            $this->db->join('addresses', 'addresses.id = schedules.address_id', 'left');
            $this->db->order_by('date', 'asc');
            $schedules = $this->db->get_where('schedules', 'schedules.class_id = ' . $course->course_id);
            $course->schedules = $schedules->result();

            // Untuk mencari voucher
            // $this->db->select('voucher_code');
            // $schedules = $this->db->get_where('vouchers', 'vouchers.order_detail_id = ' . $course->order_detail_id);
            // $course->voucher_code = $schedules->row()->voucher_code;
        }

        return $result;
    }

    public function get_teacher_past_courses($teacher_id, $option = [])
    {
        $this->db->select('classes.*, schedules.*, addresses.*, classes.id as course_id, categories.name as category_name');
        $this->db->join('schedules', 'schedules.class_id=classes.id');
        $this->db->join('addresses', 'addresses.id=schedules.address_id');
        $this->db->join('categories', 'categories.id = classes.category_id');
        $this->db->where('classes.status !=', CourseStatic::STATUS_CANCELLED);
        $this->db->where('classes.status !=', CourseStatic::STATUS_DELETED);
        $this->db->where('schedules.date <', date('Y-m-d', strtotime('today')));
        $this->db->where('classes.teacher_id', $teacher_id);
        $this->db->order_by('schedules.date', 'DESC');
        $this->db->group_by('classes.id');

        // limit option for pagination
        if (isset($option['limit'])) {
            if (isset($option['offset'])) {
                $this->db->limit($option['limit'], $option['offset']);
            } else {
                $this->db->limit($option['limit']);
            }
        }

        // Set currency
        $currency = $this->session->userdata('currency') == 'Rp' ? 'IDR' : 'SGD';
        $this->db->where('classes.currency', $currency);

        $query = $this->db->get('classes');
        $result = $query->result();

        foreach ($result as $course) {
            // Untuk mencari alamat, jadwal, tempat dari class
            $this->db->select('*, addresses.name as venue_name');
            $this->db->join('addresses', 'addresses.id = schedules.address_id', 'left');
            $this->db->order_by('date', 'asc');
            $schedules = $this->db->get_where('schedules', 'schedules.class_id = ' . $course->course_id);
            $course->schedules = $schedules->result();

            if ($this->check_date_for_deliver($course->course_id)) {
                $course->can_deliver = 1;
            }

            // Untuk menghitung jumlah wishlist kelas ini
            $course->wishlist_count = $this->get_number_of_wishlist($course->course_id);
        }

        return $result;
    }

    public function get_course_by_schedules($schedule_ids)
    {
        $this->db->select('classes.*, schedules.*, addresses.*, classes.id as course_id, categories.name as category_name, categories.parent_id as category_parent');
        $this->db->select('schedules.*');
        $this->db->join('addresses', 'addresses.id=schedules.address_id');
        $this->db->join('classes', 'classes.id=schedules.class_id');
        $this->db->join('categories', 'categories.id = classes.category_id');
        $this->db->where_in('schedules.id', $schedule_ids);

        // Set currency
        $currency = $this->session->userdata('currency') == 'Rp' ? 'IDR' : 'SGD';
        $this->db->where('classes.currency', $currency);

        $query = $this->db->get('schedules');
        $result = $query->result();

        foreach ($result as $course) {
            // Untuk mencari alamat, jadwal, tempat dari class
            $this->db->select('*, addresses.name as venue_name');
            $this->db->join('addresses', 'addresses.id = schedules.address_id', 'left');
            $this->db->order_by('date', 'asc');
            $schedules = $this->db->get_where('schedules', 'schedules.class_id = ' . $course->course_id);
            $course->schedules = $schedules->result();

            // Untuk menghitung banyaknya komen di class yang sudah di accept admin
            $this->db->select('count(*) as count');
            $this->db->join('class_comments', 'comments.id = class_comments.comment_id', 'left');
            $this->db->where('comments.status', \CommentStatic::STATUS_ACCEPTED);
            $this->db->where('class_comments.class_id', $course->course_id);
            $comments = $this->db->get('comments')->row();
            $course->comment_count = $comments->count;

            // Untuk mencari gambar2 yang diupload di class
            $this->db->where('images.entity', 'classes');
            $this->db->where('images.entity_id', $course->course_id);
            $query = $this->db->get('images');
            $course->images = $query->result();

            // Untuk menampilkan apakah termasuk wishlist dari user yang login class tersebut
            $this->db->where('class_id', $course->course_id);
            $this->db->where('user_id', $this->session->userdata('login')['user_id']);
            $query = $this->db->get('class_wishlists');
            $wish = $query->row();
            $course->wishlist_status = count($wish) > 0 ? true : false;

            // Untuk menghitung rating rata2 dari class tersebut
            $this->db->select('AVG(ratings.rate) as rate_avg');
            $average_rate = $this->db->get_where('ratings', 'class_id = ' . $course->course_id);
            $course->rate = $average_rate->row();
        }

        return $result;
    }

    public function get_student_future_courses($student_id)
    {

    }

    /**
     * Get courses with param
     *
     * @param array $option {
     * @var integer limit
     * @var string search
     * }
     *
     * @return mixed
     */
    public function get_courses($option = [])
    {
        $this->db->select('classes.*, classes.id as course_id, teacher.first_name,
            teacher.last_name, class_categories.name as category_name, class_categories.parent_id as category_parent,
            class_categories.code');

        // limit option for pagination
        if (isset($option['limit'])) {
            if (isset($option['offset'])) {
                $this->db->limit($option['limit'], $option['offset']);
            } else {
                $this->db->limit($option['limit']);
            }
        }

        if (isset($option['multiple_id'])) {
            $this->db->where_in('classes.id', $option['multiple_id']);
        }

        // search option for title search
        // TODO: search other than title
        if (isset($option['search'])) {
            $where_keyword = "(LOWER(title) LIKE '%" . strtolower($option['search']) . "%' OR
            LOWER(first_name) LIKE '%" . strtolower($option['search']) . "%' OR
            LOWER(last_name) LIKE '%" . strtolower($option['search']) . "%')";

            $this->db->where($where_keyword, null, false);
        }

        if (isset($option['publish_status'])) {
            $this->db->where('publish_status', $option['publish_status']);
        }

        if (isset($option['strict']) && $option['strict'] == true) {
            $this->db->where('publish_status !=', CourseStatic::PUBLISH_DRAFT);
            $this->db->select('(SELECT CONCAT(`date`, " ", `end_time`) as `end_date` FROM schedules WHERE schedules.class_id = classes.id ORDER BY `end_date` DESC LIMIT 1) `class_end`',
                true);
            $this->db->having('TIMESTAMPDIFF(SECOND, NOW(), `class_end`) > 0', null, false);
        }

        if (isset($option['directory_class_only']) && $option['directory_class_only'] == true) {
            $this->db->where('classes.status !=', CourseStatic::STATUS_CANCELLED);
            $this->db->where('classes.status !=', CourseStatic::STATUS_DELETED);
            $this->db->where('classes.status !=', CourseStatic::STATUS_FINISHED);
        }

        if (isset($option['finished_class_only']) && $option['finished_class_only'] == true) {
            $this->db->join('schedules', 'schedules.class_id = classes.id', 'left');
            $this->db->select('(SELECT CONCAT(`date`, " ", `end_time`) as `end_date` FROM schedules WHERE schedules.class_id = classes.id ORDER BY `end_date` DESC LIMIT 1) `class_end`',
                true);
            $this->db->having('TIMESTAMPDIFF(SECOND, NOW(), `class_end`) < 0', null, false);
            $this->db->order_by('`class_end`', 'desc');
        }

        // filter categories option
        if (isset($option['category'])) {
            $this->db->join('categories', 'categories.id = classes.category_id', 'left');
            $this->db->select('categories.parent_id');
            $this->db->where_in('categories.parent_id', $option['category']);
        }
        else if (isset($option['categories'])) {
            //$this->db->join('categories', 'categories.id = classes.category_id', 'left');
            $this->db->where_in('category_id', $option['categories']);
        }

        // filter level option
        if (isset($option['level'])) {
            $this->db->where_in('level', $option['level']);
        }

        // filter teacher option
        if (isset($option['teacher_id'])) {
            $this->db->where('teacher_id', $option['teacher_id']);
        }

        // Recommend other class from this teacher on teacher profile page
        if (isset($option['other_course_teacher_id'])) {
            $this->db->where('teacher_id !=', $option['other_course_teacher_id']);
        }

        // Recommend other class from this course on course detail page
        if (isset($option['other_course_course_id'])) {
            $this->db->where('classes.id !=', $option['other_course_course_id']);
        }

        // sort option
        if (isset($option['sort_by'])) {
            if ($option['sort_by'] == 'newest') {
                $this->db->order_by('classes.created_at', 'desc');
            } elseif ($option['sort_by'] == 'price-asc') {
                $this->db->order_by('price', 'asc');
            } elseif ($option['sort_by'] == 'price-desc') {
                $this->db->order_by('price', 'desc');
            } elseif ($option['sort_by'] == 'recommendation') {
                // TODO: recommendation get from where?
            } elseif ($option['sort_by'] == 'home_list') {
                $this->db->join('schedules', 'schedules.class_id = classes.id', 'left');
                $this->db->where('schedules.available_seat_left > 0');
                $this->db->order_by('schedules.available_seat_left', 'asc');
                $this->db->order_by('classes.created_at', 'desc');
                $this->db->group_by('classes.id');
            } elseif ($option['sort_by'] == 'finished_recently') {
                $this->db->join('schedules', 'schedules.class_id = classes.id', 'left');
                $this->db->select('(SELECT CONCAT(`date`, " ", `end_time`) as `end_date` FROM schedules WHERE schedules.class_id = classes.id ORDER BY `end_date` DESC LIMIT 1) `class_end`', true);
                $this->db->order_by('`class_end`', 'desc');
                $this->db->group_by('classes.id');
            }
        } else {
            $this->db->order_by('course_id', 'desc');
        }

        // Dashboard comment student
        if (isset($option['student_id']) and isset($option['is_comment'])) {
            $this->db->join('class_comments', 'class_comments.class_id = classes.id', 'left');
            $this->db->join('comments', 'comments.id = class_comments.comment_id', 'left');
            $this->db->join('users as student', 'comments.user_id = student.id', 'left');
            $this->db->group_by('class_comments.class_id');
            $this->db->where('student.id', $option['student_id']);
        }

        // Dashboard rating / review student
        if (isset($option['student_id']) and isset($option['is_rating'])) {
            $this->db->join('ratings', 'classes.id = ratings.class_id', 'left');
            $this->db->join('users as student', 'ratings.user_id = student.id', 'left');
            $this->db->group_by('ratings.class_id');
            $this->db->where('student.id', $option['student_id']);
        }

        // Dashboard wishlist student
        if (isset($option['wishlist_student_id'])) {
            $this->db->join('class_wishlists', 'class_wishlists.class_id = classes.id', 'left');
            $this->db->join('users', 'class_wishlists.user_id= users.id', 'left');
            $this->db->where('user_id', $option['wishlist_student_id']);
        }

        if (!isset($option['all_country'])) {
            $currency = $this->session->userdata('currency') == 'Rp' ? 'IDR' : 'SGD';
            $this->db->where('classes.currency', $currency);
        }

        // Untuk mengambil daftar kelas yang telah dibayar
        if (isset($option['courses_paid'])) {
            $this->db->select('vouchers.voucher_code, vouchers.status, vouchers.id as voucher_id');
            $user = $this->session->userdata('login')['user_id'];

            $this->db->join('order_details', 'classes.id = order_details.class_id', 'left');
            $this->db->join('vouchers', 'vouchers.order_detail_id = order_details.id', 'left');
            $this->db->join('orders', 'order_details.order_id = orders.id', 'left');
            $this->db->where('orders.user_id', $user);
            $this->db->where('orders.status', 3);
            $this->db->where('vouchers.status', VoucherStatic::VOUCHER_UNUSED);
        }

        $this->db->join('users as teacher', 'teacher.id = classes.teacher_id', 'left');
        $this->db->join('categories as class_categories', 'class_categories.id = classes.category_id', 'left');
        $query = $this->db->get('classes');
        $result = $query->result();

        $this->load->model('attendee_model');
        $this->load->model('rating_model');
        foreach ($result as $course) {
            if (isset($option['courses_paid'])) {
                if ($this->attendee_model->check_attendees($course->course_id, $course->voucher_code) && !$this->rating_model->get_rating_by_student_and_class_id($student_id, $course->course_id)) {
                // if (!$this->attendee_model->check_attendees($course->course_id, $course->voucher_code)) {
                    $course->add_rating_status = 1;
                }
            }

            $class_started = $this->check_date_started($course->id);
            $student_registered = $this->check_student_registered($course->id);

            $course->change_price_status = 0;
            $course->change_venue_status = 0;
            $course->change_schedule_status = 0;
            $course->can_cancel_status = 0;
            $course->can_deliver = 0;

            if ($course->changed_price == 1 || $student_registered || $class_started) {
                $course->change_price_status = 1;
            }

            if ($course->changed_venue == 1 || $class_started) {
                $course->change_venue_status = 1;
            }

            if ($course->changed_schedule == 1 || $class_started) {
                $course->change_schedule_status = 1;
            }

            if ($this->check_date_for_cancel_teacher($course->id) && $course->publish_status != CourseStatic::PUBLISH_DELETED) {
                $course->can_cancel_status = 1;
            }

            if ($this->check_date_for_deliver($course->id)) {
                $course->can_deliver = 1;
            }

            // Untuk mencari alamat, jadwal, tempat dari class
            $this->db->select('*, addresses.name as venue_name');
            $this->db->join('addresses', 'addresses.id = schedules.address_id', 'left');
            $this->db->order_by('date', 'asc');
            $schedules = $this->db->get_where('schedules', 'schedules.class_id = ' . $course->course_id);
            $course->schedules = $schedules->result();

            // Untuk menghitung banyaknya komen di class yang sudah di accept admin
            $this->db->select('count(*) as count');
            $this->db->join('class_comments', 'comments.id = class_comments.comment_id', 'left');
            $this->db->where('comments.status', \CommentStatic::STATUS_ACCEPTED);
            $this->db->where('class_comments.class_id', $course->course_id);
            $comments = $this->db->get('comments')->row();
            $course->comment_count = $comments->count;

            // Untuk mencari gambar2 yang diupload di class
            $this->db->where('images.entity', 'classes');
            $this->db->where('images.entity_id', $course->course_id);
            $query = $this->db->get('images');
            $course->images = $query->result();

            // Untuk menampilkan apakah termasuk wishlist dari user yang login class tersebut
            $this->db->where('class_id', $course->course_id);
            $this->db->where('user_id', $this->session->userdata('login')['user_id']);
            $query = $this->db->get('class_wishlists');
            $wish = $query->row();
            $course->wishlist_status = count($wish) > 0 ? true : false;

            // Untuk menghitung rating rata2 dari class tersebut
            $this->db->select('AVG(ratings.rate) as rate_avg');
            $average_rate = $this->db->get_where('ratings', 'class_id = ' . $course->course_id);
            $course->rate = $average_rate->row();

            // Untuk menghitung jumlah wishlist kelas ini
            $course->wishlist_count = $this->get_number_of_wishlist($course->id);
        }

        return $result;
    }

    public function get_courses_for_admin_page()
    {
        $this->db->select('*');
        $this->db->where('publish_status', CourseStatic::PUBLISH_SUCCESS);
        $query = $this->db->get('classes');
        $result = $query->result();

        return $result;
    }

    /**
     * @param $data
     * @return int
     */
    public function create_course($data)
    {
        $input = $this->_sanitize_input($data, 'create_update_class');

        $this->db->insert('classes', $input);
        return $this->db->insert_id();
    }

    /**
     * @param $id
     * @param $data
     * @return bool
     */
    public function update_course($id, $data, $teacher_id, $admin_edit = false, $currency_course = NULL)
    {
        $this->db->where('id', $id);
        $this->db->where('teacher_id', $teacher_id);
        $input = $this->_sanitize_input($data, 'create_update_class');

        if ($admin_edit) {
            $input['teacher_id'] = $teacher_id;
            $input['currency'] = $currency_course;
        }
        // var_dump($input);
        $update = $this->db->update('classes', $input);

        if ($update) {
            return $id;
        } else {
            return false;
        }

    }

    public function remove_course($course_id)
    {
        $this->db->where('id', $course_id);
        return $this->db->delete('classes');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function check_owner($id)
    {
        $user_id = $this->session->userdata('login')['user_id'];
        $this->db->where('teacher_id', $user_id);
        $this->db->where('id', $id);
        return $this->db->get('classes')->row();
    }

    public function get_count_courses($option = [])
    {
        $this->db->select('classes.id as course_id');
        $this->db->join('users as teacher', 'teacher.id = classes.teacher_id', 'left');
        if (isset($option['teacher_id'])) {
            $this->db->where('teacher_id', $option['teacher_id']);
        }

        // filter categories option
        if (isset($option['category'])) {
            $this->db->join('categories', 'categories.id = classes.category_id', 'left');
            $this->db->select('categories.parent_id');
            $this->db->where('categories.parent_id', $option['category']);
        }
        else if (isset($option['categories'])) {
//            $this->db->join('categories', 'categories.id = classes.category_id', 'left');
            $this->db->where_in('category_id', $option['categories']);
        }

        // filter level option
        if (isset($option['level'])) {
            $this->db->where_in('level', $option['level']);
        }

        if (isset($option['publish_status'])) {
            $this->db->where('publish_status', $option['publish_status']);
        }

        if (!isset($option['all_country'])) {
            $currency = $this->session->userdata('currency') == 'Rp' ? 'IDR' : 'SGD';
            $this->db->where('currency', $currency);
        }

        // search option for title search
        // TODO: search other than title
        if (isset($option['search'])) {
            $where_keyword = "(LOWER(title) LIKE '%" . strtolower($option['search']) . "%' OR
            LOWER(first_name) LIKE '%" . strtolower($option['search']) . "%' OR
            LOWER(last_name) LIKE '%" . strtolower($option['search']) . "%')";

            $this->db->where($where_keyword, null, false);
        }

        if (isset($option['strict']) && $option['strict'] == true) {
            $this->db->where('publish_status !=', CourseStatic::PUBLISH_DRAFT);
            $this->db->select('(SELECT CONCAT(`date`, " ", `end_time`) as `end_date` FROM schedules WHERE schedules.class_id = classes.id ORDER BY `end_date` DESC LIMIT 1) `class_end`',
                true);
            $this->db->having('TIMESTAMPDIFF(SECOND, NOW(), `class_end`) > 0', null, false);
        }

        if (isset($option['directory_class_only']) && $option['directory_class_only'] == true) {
            $this->db->where('classes.status !=', CourseStatic::STATUS_CANCELLED);
            $this->db->where('classes.status !=', CourseStatic::STATUS_DELETED);
            $this->db->where('classes.status !=', CourseStatic::STATUS_FINISHED);
        }

        if (isset($option['finished_class_only']) && $option['finished_class_only'] == true) {
            $this->db->join('schedules', 'schedules.class_id = classes.id', 'left');
            $this->db->select('(SELECT CONCAT(`date`, " ", `end_time`) as `end_date` FROM schedules WHERE schedules.class_id = classes.id ORDER BY `end_date` DESC LIMIT 1) `class_end`',
                true);
            $this->db->having('TIMESTAMPDIFF(SECOND, NOW(), `class_end`) < 0', null, false);
        }

        // sort option
        if (isset($option['sort_by'])) {
            if ($option['sort_by'] == 'newest') {
                $this->db->order_by('classes.created_at', 'desc');
            } elseif ($option['sort_by'] == 'price-asc') {
                $this->db->order_by('price', 'asc');
            } elseif ($option['sort_by'] == 'price-desc') {
                $this->db->order_by('price', 'desc');
            } elseif ($option['sort_by'] == 'recommendation') {
                // TODO: recommendation get from where?
            }
        } else {
            $this->db->order_by('course_id', 'desc');
        }

        $query = $this->db->get('classes');

        return count($query->result());
    }

    public function check_student_registered($id)
    {
        $this->db->join('order_details', 'orders.id = order_details.order_id', 'left');
        $this->db->where('order_details.class_id', $id);
        $this->db->where('orders.status', 3);
        $query = $this->db->get('orders');

        return ($query->result()) ? true : false;
    }

    // Untuk menghitung jumlah siswa yang terdaftar di suatu kelas
    public function count_student_registered($id)
    {
        $this->db->join('order_details', 'orders.id = order_details.order_id', 'left');
        $this->db->where('order_details.class_id', $id);
        $this->db->where('orders.status', 3);
        $query = $this->db->get('orders');

        return $query->num_rows();
    }

    public function check_date_for_cancel_student($id)
    {
        $this->db->select_min("schedules.date");
        $this->db->where('classes.id', $id);
        $this->db->join('schedules', 'schedules.class_id = classes.id', 'left');
        $query = $this->db->get('classes');
        $min_date = $query->row()->date;

        $this->load->helper('date');
        $now = strftime("%Y-%m-%d %H:%M:%S", now());
        $diff = date_diff(new DateTime($now), new DateTime($min_date));

        return ($diff->format('%R') == '+' and $diff->d > 2) ? true : false;
    }

    public function check_date_for_cancel_teacher($id)
    {
        $this->db->select_min("schedules.date");
        $this->db->where('classes.id', $id);
        $this->db->join('schedules', 'schedules.class_id = classes.id', 'left');
        $query = $this->db->get('classes');
        $min_date = $query->row()->date;

        $this->load->helper('date');
        $now = strftime("%Y-%m-%d %H:%M:%S", now());
        $diff = date_diff(new DateTime($now), new DateTime($min_date));

        return ($diff->format('%R') == '+' and $diff->d > 1) ? true : false;
    }

    public function check_date_for_deliver($id)
    {
        $this->db->select_max("schedules.date");
        $this->db->where('classes.id', $id);
        $this->db->join('schedules', 'schedules.class_id = classes.id', 'left');
        $query = $this->db->get('classes');
        $max_date = $query->row()->date;

        $this->load->helper('date');
        $now = strftime("%Y-%m-%d", now());
        $diff = date_diff(new DateTime($now), new DateTime($max_date));

        return ($diff->format('%R') == '-' and $diff->days >= 0 and $diff->days <= 9999) ? true : false;
    }

    public function check_date_started($id)
    {
        $this->db->select_min("schedules.date");
        $this->db->where('classes.id', $id);
        $this->db->join('schedules', 'schedules.class_id = classes.id', 'left');
        $query = $this->db->get('classes');
        $min_date = $query->row()->date;

        $this->load->helper('date');
        $now = strftime("%Y-%m-%d", now());
        $diff = date_diff(new DateTime($now), new DateTime($min_date));

        return ($diff->format('%R') == '-' and $diff->days > 0) ? true : false;
    }

    public function get_date_end($id)
    {
        $this->db->select_max("schedules.date");
        $this->db->where('classes.id', $id);
        $this->db->join('schedules', 'schedules.class_id = classes.id', 'left');
        $query = $this->db->get('classes');
        $max_date = $query->row()->date;

        return $max_date;
    }

    public function get_date_start($id)
    {
        $this->db->select_min("schedules.date");
        $this->db->where('classes.id', $id);
        $this->db->join('schedules', 'schedules.class_id = classes.id', 'left');
        $query = $this->db->get('classes');
        $min_date = $query->row()->date;

        return $min_date;
    }

    public function check_date_end_last_month($id)
    {
        $this->db->select_max("schedules.date");
        $this->db->where('classes.id', $id);
        $this->db->join('schedules', 'schedules.class_id = classes.id', 'left');
        $query = $this->db->get('classes');
        $max_date = $query->row()->date;

        $this->load->helper('date');
        $now = strftime("%Y-%m-%d", now());
        $diff = date_diff(new DateTime($now), new DateTime($max_date));

        return ($diff->format('%R%m') < 0) ? true : false;
    }

    public function change_price($id, $price)
    {
        $this->db->where('id', $id);
        $this->db->update('classes', [
            'price' => $price,
            'changed_price' => 1
        ]);
    }

    public function set_changed_schedule($id, $value)
    {
        $this->db->where('id', $id);
        $this->db->update('classes', [
            'changed_schedule' => $value
        ]);
    }

    public function set_changed_venue($id, $value)
    {
        $this->db->where('id', $id);
        $this->db->update('classes', [
            'changed_venue' => $value
        ]);
    }

    public function get_registered_student($id)
    {
        $this->db->select('users.*,
                            users.id as user_id,
                            order_details.order_id,
                            order_details.class_id,
                            order_details.id as order_detail_id,
                            orders.status as order_status');
        $this->db->where('classes.id', $id);
        $this->db->join('order_details', 'classes.id = order_details.class_id', 'right');
        $this->db->join('orders', 'orders.id = order_details.order_id', 'left');
        $this->db->join('users', 'users.id = orders.user_id', 'left');
        $query = $this->db->get('classes');

        return $query->result();
    }

    public function get_register_information($voucher_code)
    {
        $this->db->select('users.*,
                            users.id as user_id,
                            order_details.order_id,
                            order_details.class_id,
                            order_details.id as order_detail_id,
                            orders.status as order_status');
        $this->db->join('order_details', 'classes.id = order_details.class_id', 'right');
        $this->db->join('vouchers', 'vouchers.order_detail_id = order_details.id', 'right');
        $this->db->join('orders', 'orders.id = order_details.order_id', 'left');
        $this->db->join('users', 'users.id = orders.user_id', 'left');
        $this->db->where('vouchers.voucher_code', $voucher_code);
        $query = $this->db->get('classes');

        return $query->row();
    }

    public function get_number_of_wishlist($course_id)
    {
        $this->db->select('count(*) as count');
        $this->db->where('class_wishlists.class_id', $course_id);
        $query = $this->db->get('class_wishlists');

        return $query->row()->count;
    }

    public function cancel_class($id, $reason)
    {
        $this->db->where('id', $id);
        $this->db->update('classes', [
            'status' => CourseStatic::STATUS_CANCELLED,
            'publish_status' => CourseStatic::PUBLISH_DELETED,
            'cancel_reason' => $reason,
            'cancel_date' => strftime("%Y-%m-%d", now())
        ]);
    }


    /**
     * @param $post
     * @param null $mode
     * @return array
     */
    private function _sanitize_input($post, $mode = null)
    {
        $currency = $this->session->userdata('currency') == 'Rp' ? 'IDR' : 'SGD';
        $this->load->helper('htmlpurifier');
        switch ($mode) {
            case 'create_update_class':
                $data = array(
                    'teacher_id' => $this->session->userdata('login')['user_id'],
                    'title' => SG_Util::val($post, 'title'),
                    'slug' => SG_Util::slug(SG_Util::val($post, 'title'), '-'),
                    'description' => html_purify(SG_Util::val($post, 'description'), 'tinymce'),
                    'content' => SG_Util::val($post, 'content') ? html_purify(SG_Util::val($post, 'content'), 'tinymce') : '',
                    'prerequisite_skill' => SG_Util::val($post, 'prerequisite_skill', 0),
                    'prerequisite_detail' => SG_Util::val($post, 'prerequisite_detail'),
                    'end_goal' => html_purify(SG_Util::val($post, 'end_goal'), 'tinymce'),
                    'class_leader' => SG_Util::val($post, 'class_leader'),
                    'about_leader' => html_purify(SG_Util::val($post, 'about_leader'), 'tinymce'),
                    'type' => SG_Util::val($post, 'type', 0),
                    'price' => SG_Util::val($post, 'price', 0),
                    'available_seat' => SG_Util::val($post, 'available_seat', 0),
                    'special_equipment' => html_purify(SG_Util::val($post, 'special_equipment'), 'tinymce'),
                    'category_id' => SG_Util::val($post, 'category_id'),
                    'pack' => SG_Util::val($post, 'pack', 0),
                    'package_detail' => SG_Util::val($post, 'package_detail'),
                    'level' => SG_Util::val($post, 'level', 0),
                    'publish_status' => SG_Util::val($post, 'publish_status', 0),
                    'currency' => $currency,
                    'draft_step' => SG_Util::val($post, 'draft_step', 1),
                );
                break;
            case 'input_schedule':
                $data = [

                ];
                break;
            case 'input_image':
                break;
        }

        return $data;
    }

    /**
     * @return mixed
     */
    public function get_courses_wishlist()
    {
        $this->db->select('*');
        $this->db->from('classes');
        $this->db->join('class_wishlists', 'class_wishlists.class_id = classes.id', 'left');
        $this->db->join('users', 'class_wishlists.user_id= users.id', 'left');
        $this->db->where('user_id', $this->session->userdata('login')['user_id']);

        // Set currency
        $currency = $this->session->userdata('currency') == 'Rp' ? 'IDR' : 'SGD';
        $this->db->where('classes.currency', $currency);

        $query = $this->db->get();

        $result = $query->result();

        return $result;
    }

    /**
     * @param $keyword
     * @return mixed
     */
    public function get_title_course_row($keyword)
    {
        $this->db->select('classes.*, teachers.first_name, teachers.last_name, classes.id as course_id');
        $this->db->join('users as teachers', 'teachers.id = classes.teacher_id', 'left');
        $this->db->where('publish_status !=', CourseStatic::PUBLISH_DRAFT);
        $this->db->select('(SELECT CONCAT(`date`, " ", `end_time`) as `end_date` FROM schedules WHERE schedules.class_id = classes.id ORDER BY `end_date` DESC LIMIT 1) `class_end`', true);
        $this->db->having('TIMESTAMPDIFF(SECOND, NOW(), `class_end`) > 0', null, false);

        $where_keyword = "(LOWER(title) LIKE '%" . strtolower($keyword) . "%' OR
        LOWER(first_name) LIKE '%" . strtolower($keyword) . "%' OR
        LOWER(last_name) LIKE '%" . strtolower($keyword) . "%')";
        $this->db->where($where_keyword, null, false);

        // Set currency
        $currency = $this->session->userdata('currency') == 'Rp' ? 'IDR' : 'SGD';
        $this->db->where('classes.currency', $currency);

        // $this->db->order_by('course_id', 'DESC');

        $query = $this->db->get('classes');
        $result = $query->result();

        $this->load->helper('delimiter');
        foreach ($result as $course) {
            // With images
            $this->db->where('images.entity', 'classes');
            $this->db->where('images.entity_id', $course->course_id);
            $query = $this->db->get('images');
            $course->images = $query->result();
            $course->currency_with_price = delimiter_number($course->currency, $course->price);
        }

        return $result;
    }

    public function generate_unique_id($id)
    {
        $this->load->model('category_model');
        $course = $this->get_course($id);
        $category_code = $this->category_model->get_category_code($course->category_id);

        if ($category_code != '') {
            $time = date('YmdHi', strtotime($course->schedules[0]->date . ' ' . $course->schedules[0]->start_time));
            do {
                $random_marker = str_pad(rand(1, 999), 3, 0, STR_PAD_LEFT);
                $unique_id = $category_code . $time . $random_marker;
            } while ($this->check_unique_id($unique_id));
        }
        $this->db->where('id', $id);
        $this->db->update('classes', ['unique_id' => $unique_id]);
        return $unique_id;
    }

    public function check_unique_id($unique_id)
    {
        $this->db->where('unique_id', $unique_id);
        $query = $this->db->get('classes');
        return $query->row();
    }

    public function check_if_auth_user_registered($class_id)
    {
        $this->db->join('order_details', 'orders.id = order_details.order_id', 'left');
        $this->db->where('order_details.class_id', $class_id);
        $this->db->where('orders.status', 3);
        $this->db->where('orders.user_id', $this->session->userdata('login')['user_id']);
        $query = $this->db->get('orders');

        return ($query->result()) ? true : false;
    }

}
