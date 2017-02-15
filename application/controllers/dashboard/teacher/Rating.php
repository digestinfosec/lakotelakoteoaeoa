<?php

require APPPATH . 'libraries/Dashboard_Controller.php';

class Rating extends Dashboard_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->redirect_if_not_teacher();
        $this->load->model('rating_model');
    }

    public function index()
    {
        $user = $this->session->userdata('login')['user_id'];

        // $option['sort_by'] = "finished_recently";
        $option['finished_class_only'] = true;

        // pagination settings
        $this->load->library('pagination');
        $config['base_url'] = '/dashboard/teacher/rating/index';
        $config['total_rows'] = count($this->rating_model->get_ratings_courses($user, $option));
        $config['per_page'] = 5;

        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        // get courses
        $option['offset'] = $this->uri->segment(5);
        $option['limit'] = $config['per_page'];
        $this->data['courses'] = $this->rating_model->get_ratings_courses($user, $option);

        $this->data['menu_left'] = "teacher_review";
        $this->twig->display('dashboard/teacher/rating/index', $this->data);
    }
}
