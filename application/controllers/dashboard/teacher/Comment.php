<?php

require APPPATH . 'libraries/Dashboard_Controller.php';

class Comment extends Dashboard_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->redirect_if_not_teacher();
        $this->load->model('comment_model');
    }

    public function index()
    {
        // pagination settings
        $this->load->library('pagination');

        $user = $this->session->userdata('login')['user_id'];

        $option['strict'] = true;
        $option['directory_class_only'] = true;
        $option['sort_by'] = "finished_recently";

        $config['base_url'] = '/dashboard/teacher/comment/index';
        $config['total_rows'] = count($this->comment_model->get_comments_teacher($user, $option));
        $config['per_page'] = 5;

        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        // get courses
        $option['offset'] = $this->uri->segment(5);
        $option['limit'] = $config['per_page'];
        $this->data['courses'] = $this->comment_model->get_comments_teacher($user, $option);

        $this->data['menu_left'] = "teacher_comment";
        $this->twig->display('dashboard/teacher/comment/index', $this->data);
    }
}
