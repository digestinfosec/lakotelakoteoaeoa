<?php

require APPPATH . 'libraries/Dashboard_Controller.php';

class Comment extends Dashboard_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->redirect_if_not_student();
        $this->load->model('comment_model');
    }

    public function index()
    {
        // pagination settings
        $this->load->library('pagination');

        // $option['strict'] = true;
        // $option['directory_class_only'] = true;
        $option['publish_status'] = CourseStatic::PUBLISH_SUCCESS;
        $option['sort_by'] = "finished_recently";

        $config['base_url'] = '/dashboard/student/comment/index';
        $config['total_rows'] = count($this->comment_model->get_comments_student($option));
        $config['per_page'] = 5;

        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        // get courses
        $option['offset'] = $this->uri->segment(5);
        $option['limit'] = $config['per_page'];
        $this->data['courses'] = $this->comment_model->get_comments_student($option);

        $this->data['menu_left'] = "student_comment";
        $this->twig->display('dashboard/student/comment/index', $this->data);
    }
}
