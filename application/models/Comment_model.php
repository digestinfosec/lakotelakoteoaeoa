<?php

use Scienceguard\SG_Util;

class Comment_model extends MY_Model
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
            'comment' => html_purify(SG_Util::val($post, 'comment'), 'tinymce'),
            'status' => SG_Util::val($post, 'status', 0),
            'reply_to' => SG_Util::val($post, 'reply_to', 0),
        );

        if ($mode == 'update') {
            // unset($data['created_at']);
            $data['user_id'] = SG_Util::val($post, 'user_id', 0);
        }

        return $data;
    }

    public function get_by_id($comment_id)
    {
        $this->db->select('comments.*,            
            comments.created_at as comment_time,
            commenter.id as commenter_id,
            commenter.first_name,
            commenter.last_name,
            commenter.profile_pic,
            class_comments.class_id as class_id,
            classes.title as class_title');
        $this->db->join('class_comments', 'comments.id = class_comments.comment_id', 'left');
        $this->db->join('classes', 'classes.id = class_comments.class_id', 'left');
        $this->db->join('users commenter', 'commenter.id = comments.user_id', 'left');
        $this->db->where('comments.id', $comment_id);
        $query = $this->db->get('comments');
        return $query->row();
    }

    // Get all comments with options
    public function get_comments($option = array())
    {
        $this->db->select('comments.*,
            comments.created_at as comment_time,
            commenter.first_name,
            commenter.last_name,
            commenter.profile_pic');
        $this->db->join('class_comments', 'comments.id = class_comments.comment_id', 'left');
        $this->db->join('users commenter', 'commenter.id = comments.user_id', 'left');
        $this->db->where('comments.status',\CommentStatic::STATUS_ACCEPTED);

        if (isset($option['course_id']))
            $this->db->where('class_comments.class_id', $option['course_id']);

        if (isset($option['limit'])) {
            if (isset($option['offset'])) {
                $this->db->limit($option['limit'], $option['offset']);
            } else {
                $this->db->limit($option['limit']);
            }
        }

        if (isset($option['student_id'])) {
            $this->db->where('comments.user_id', $option['student_id']);
        }

        $query = $this->db->get('comments');
        return $query->result();
    }

    // Get all comments for a teacher
    public function get_comments_teacher($teacher_id, $option = array())
    {
        $this->load->model('course_model');
        $result = $this->course_model->get_teacher_courses($teacher_id, $option);

        foreach ($result as $course) {
            $option = [
                'course_id' => $course->id,
                'limit' => 3
            ];

            $course->comments = $this->get_comments($option);
        }

        return $result;
    }

    // Get all comments from a student
    public function get_comments_student($option = array())
    {
        $student_id = $this->user_id;
        $option['is_comment'] = true;

        $this->load->model('course_model');
        $result = $this->course_model->get_student_courses($student_id, $option);

        foreach ($result as $course) {
            $option = [
                'course_id' => $course->course_id,
                'student_id' => $student_id,
                'limit' => 3
            ];

            $course->comments = $this->get_comments($option);
        }
        return $result;
    }

    // Get all comments for a course
    public function get_comments_course($course_id, $params = null)
    {
        $limit = SG_Util::val($params, 'limit');

        $this->db->select('*, users.*, comments.created_at as comment_date, comments.created_at as comment_time');
        $this->db->from('class_comments');
        $this->db->join('comments', 'comments.id = class_comments.comment_id', 'left');
        $this->db->join('users', 'users.id = comments.user_id', 'left');
        $this->db->where('class_id', $course_id);
        $this->db->where('comments.status', \CommentStatic::STATUS_ACCEPTED);

        if ($limit) {
            $this->db->limit($limit);
        }

        $this->db->order_by('comment_id', 'desc');


        $query = $this->db->get();
        return $query->result();
    }

    // Get the number of comments for a course
    public function get_count_comments_course($course_id, $params = null)
    {
        $this->db->select('count(1) as data');
        $this->db->from('class_comments');
        $this->db->join('comments', 'comments.id = class_comments.comment_id', 'left');
        $this->db->join('users', 'users.id = comments.user_id', 'left');
        $this->db->where('class_id', $course_id);
        $this->db->where('comments.status', \CommentStatic::STATUS_ACCEPTED);
        $query = $this->db->get();
        return (int)$query->row()->data;
    }

    // Create new comment
    public function add_comment($input = array())
    {
        // validate input
        $rule = CommentStatic::get_rule('add');
        if (!$this->_validate($rule)) {
            return false;
        }

        $this->db->trans_start();

        // insert to comments table
        $data = $this->_sanitize_input('insert', $input);
        $this->db->insert('comments', $data);
        $comment_id = $this->db->insert_id();

        // insert to class_comments table
        $data = array(
            'comment_id' => $comment_id,
            'class_id' => $this->input->post('class_id'),
        );
        $this->db->insert('class_comments', $data);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // Update a comment
    public function update_comment($comment_id, $input = array(), $user_id = null)
    {
        // if not admin, set id to current user login
        if ($user_id == null) {
            $user_id = $this->session->userdata('login')['user_id'];
        }

        // validate input
        $rule = CommentStatic::get_rule('add');
        if (!$this->_validate($rule)) {
            return false;
        }

        // prepare data
        $data = $this->_sanitize_input('update', $input);

        $this->db->where('id', $comment_id);
        $this->db->where('user_id', $user_id);

        return $this->db->update('comments', $data);
    }

    // Remove a comment
    public function remove_comment($comment_id)
    {
        $this->db->where('id', $comment_id);
        return $this->db->delete('comments');
    }

}
