<?php

use Scienceguard\SG_Util;

class Rating_model extends MY_Model
{
    var $user_id;

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->user_id = $this->session->userdata('login')['user_id'];
    }

    private function _sanitize_input($mode = 'update', $input = array())
    {
        $post = empty($input) ? $this->input->post() : $input;

        $this->load->helper('htmlpurifier');
        $data = array(
            'user_id' => $this->user_id,
            'class_id' => SG_Util::val($post, 'class_id'),
            'rate' => SG_Util::val($post, 'rate'),
            'review' => html_purify(SG_Util::val($post, 'review'), 'tinymce'),
            'status' => SG_Util::val($post, 'status', 0),
            'reply_to' => SG_Util::val($post, 'reply_to', 0),
        );

        if ($mode == 'update') {
            unset($data['created_at']);
            $data['user_id'] = SG_Util::val($post, 'user_id', 0);
        }

        return $data;
    }

    // Untuk menampilkan daftar review di dashboard student
    public function get_student_ratings($option = array())
    {
        $student_id = $this->user_id;
        $option['is_rating'] = true;

        $this->load->model('course_model');
        $result = $this->course_model->get_student_courses($student_id, $option);

        foreach ($result as $course) {
            $option = [
                'course_id' => $course->course_id,
                'student_id' => $student_id,
                'limit' => 3
            ];

            $course->ratings = $this->get_ratings($option);
            $course->rating_count = count($course->ratings);
        }
        return $result;
    }

    // Untuk menampilkan rating seorang pada semua kelas yang dia buat
    // Contoh penggunaan di public teacher profile
    public function get_teacher_rating($user_id, $option = [])
    {
        $this->db->select('ratings.*, reviewers.first_name, reviewers.last_name, reviewers.profile_pic, classes.title')
            ->join('classes', 'classes.id = ratings.class_id', 'left')
            ->join('users', 'users.id = classes.teacher_id', 'left')
            ->join('users reviewers', 'reviewers.id = ratings.user_id', 'left')
            ->where('ratings.status', \RatingStatic::STATUS_ACCEPTED)
            ->where('classes.teacher_id', $user_id);

        if (isset($option['limit'])) {
            if (isset($option['offset'])) {
                $this->db->limit($option['limit'], $option['offset']);
            } else {
                $this->db->limit($option['limit']);
            }
        }

        $query = $this->db->get('ratings');

        return $query->result();
    }

    // Untuk menghitung rating guru dengan rata2 dari rating kelas yang dia buat
    public function get_teacher_average_rate($teacher_id)
    {
        $this->db->select('AVG(ratings.rate) as rate_avg')
            ->join('classes', 'classes.id = ratings.class_id', 'left')
            ->where('classes.teacher_id', $teacher_id)
            ->where('ratings.status', \RatingStatic::STATUS_ACCEPTED);
        $query = $this->db->get('ratings');
        return $query->row();
    }

    // Untuk menghitung rating kelas dengan rata2 dari setiap murid yg mengikuti
    public function get_class_average_rate($class_id)
    {
        $this->db->select('AVG(ratings.rate) as rate_avg')
            ->join('classes', 'classes.id = ratings.class_id', 'left')
            ->where('classes.id', $class_id)
            ->where('ratings.status', \RatingStatic::STATUS_ACCEPTED);
        $query = $this->db->get('ratings');
        return $query->row();
    }

    // Untuk menghitung jumlah rating dari suatu kelas
    public function get_count_rating($course_id)
    {
        $this->db->select('count(1) as data');
        $this->db->where('class_id', $course_id);
        $this->db->where('ratings.status', \RatingStatic::STATUS_ACCEPTED);
        $this->db->from('ratings');

        $query = $this->db->get();
        return (int)$query->row()->data;
    }

    // Untuk menghitung jumlah rating dari suatu guru
    public function get_count_rating_teacher($teacher_id)
    {
        $this->db->select('count(1) as data');
        $this->db->join('classes', 'classes.id = ratings.class_id', 'left');
        $this->db->where('classes.teacher_id', $teacher_id);
        $this->db->where('ratings.status', \RatingStatic::STATUS_ACCEPTED);
        $this->db->from('ratings');

        $query = $this->db->get();
        return (int)$query->row()->data;
    }

    // Untuk menampilkan semua rating murid pada suatu kelas
    // Dengan aturan ==> Tampilkan kelas, semua rating, kelas lagi, dan semua rating lagi
    // Contoh penggunaan di dashboard teacher Reviews
    public function get_ratings_courses($teacher_id, $option = [])
    {
        $this->load->model('course_model');

        $result = $this->course_model->get_teacher_past_courses($teacher_id, $option);

        foreach ($result as $course) {
            $option = [
                'course_id' => $course->id,
                'limit' => 3
            ];

            $course->ratings = $this->get_ratings($option);
            $course->rating_count = count($course->ratings);
        }

        return $result;
    }

    // Untuk menampilkan rating dari semua murid suatu kelas
    // TODO: menampilkan class attended dari suatu user
    public function get_ratings($option = array())
    {
        $this->db->select('ratings.*,
            ratings.created_at as rating_time,
            reviewers.first_name,
            reviewers.last_name,
            reviewers.profile_pic');
        $this->db->join('users reviewers', 'reviewers.id = ratings.user_id', 'left');
        $this->db->where('ratings.status', \RatingStatic::STATUS_ACCEPTED);

        if (isset($option['course_id']))
            $this->db->where('ratings.class_id', $option['course_id']);

        if (isset($option['limit'])) {
            if (isset($option['offset'])) {
                $this->db->limit($option['limit'], $option['offset']);
            } else {
                $this->db->limit($option['limit']);
            }
        }

        if (isset($option['student_id'])) {
            $this->db->where('ratings.user_id', $option['student_id']);
        }

        $query = $this->db->get('ratings');

        return $query->result();
    }

    public function get_rating_by_id($rating_id)
    {
        $this->db->select('ratings.*,
            ratings.created_at as rating_time,
            reviewers.first_name,
            reviewers.last_name,
            reviewers.profile_pic');
        $this->db->join('users reviewers', 'reviewers.id = ratings.user_id', 'left');
        $this->db->where('ratings.id', $rating_id);
        $query = $this->db->get('ratings');
        return $query->row();
    }

    public function get_rating_by_student_and_class_id($student_id, $class_id)
    {
        $this->db->select('ratings.*');
        $this->db->where('ratings.user_id', $student_id);
        $this->db->where('ratings.class_id', $class_id);
        $query = $this->db->get('ratings');
        return $query->row();
    }


    // Untuk menambah rating pada suatu kelas
    public function add_rating($input = array())
    {
        $rules = RatingStatic::get_rule('add');
        $rules = $this->_push_custom_lang($rules);
        // validate input
        if (!$this->_validate($rules)) {
            return false;
        }

        $this->db->trans_start();

        // insert to ratings table
        $data = $this->_sanitize_input('insert', $input);
        $this->db->insert('ratings', $data);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // Update a rating
    public function update_rating($rating_id, $input = array(), $user_id = null)
    {
        // if not admin, set id to current user login
        if ($user_id == null) {
            $user_id = $this->session->userdata('login')['user_id'];
        }

        // validate input
        $rule = RatingStatic::get_rule('update');
        if (!$this->_validate($rule)) {
            return false;
        }

        // prepare data
        $data = $this->_sanitize_input('insert', $input);

        $this->db->where('id', $rating_id);
        $this->db->where('user_id', $user_id);

        return $this->db->update('ratings', $data);
    }

}
