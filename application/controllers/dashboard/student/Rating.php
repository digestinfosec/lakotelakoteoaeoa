<?php

require APPPATH . 'libraries/Dashboard_Controller.php';

class Rating extends Dashboard_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->redirect_if_not_student();
        $this->load->model('rating_model');
    }

    public function index()
    {
        // $option['sort_by'] = "finished_recently";
        $option['finished_class_only'] = true;

        // pagination settings
        $this->load->library('pagination');
        $config['base_url'] = '/dashboard/student/rating/index';
        $config['total_rows'] = count($this->rating_model->get_student_ratings($option));
        $config['per_page'] = 3;

        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        // get courses
        $option['offset'] = $this->uri->segment(5);
        $option['limit'] = $config['per_page'];
        $this->data['courses'] = $this->rating_model->get_student_ratings($option);

        $this->data['menu_left'] = "student_review";
        $this->twig->display('dashboard/student/rating/index', $this->data);
    }
}
