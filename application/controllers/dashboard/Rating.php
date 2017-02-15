<?php
require APPPATH . 'libraries/Dashboard_Controller.php';

class Rating extends Dashboard_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('rating_model');
        $this->load->helper('timezone');
    }

    public function view($course_id)
    {
        $this->load->model('course_model');
        $option['course_id'] = $course_id;

        $this->data['course'] = $this->course_model->get_course($course_id);

        // pagination settings
        $this->load->library('pagination');
        $config['base_url'] = '/dashboard/rating/view/' . $course_id . '/index';
        $config['total_rows'] = $this->rating_model->get_count_rating($course_id);
        $config['per_page'] = 5;

        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        // get ratings
        $option['offset'] = $this->uri->segment(5);
        $option['limit'] = $config['per_page'];
        $this->data['ratings'] = $this->rating_model->get_ratings($option);

        $this->twig->display('public/rating/index', $this->data);
    }

    public function view_teacher($teacher_id)
    {
        // pagination settings
        $this->load->library('pagination');
        $config['base_url'] = '/dashboard/rating/view_teacher/' . $teacher_id . '/index';
        $config['total_rows'] = $this->rating_model->get_count_rating_teacher($teacher_id);
        $config['per_page'] = 5;

        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        // get ratings
        $option['offset'] = $this->uri->segment(5);
        $option['limit'] = $config['per_page'];
        $this->data['ratings'] = $this->rating_model->get_teacher_rating($teacher_id, $option);

        $this->twig->display('public/rating/index', $this->data);
    }

    public function new_rating($course_id)
    {
        $this->redirect_if_not_student();

        $this->load->model('course_model');
        $this->data['course'] = $this->course_model->get_course($course_id);

        $option['course_id'] = $course_id;
        $option['offset'] = $this->uri->segment(5);
        $option['limit'] = 3;

        // get ratings        
        $this->data['ratings'] = $this->rating_model->get_ratings($option);

        $this->twig->display('dashboard/student/rating/new', $this->data);
    }

    public function add()
    {
        $this->redirect_if_not_student();

        if ($this->is_post()) {

            if (empty($this->input->post('checkbox'))) {
                $this->session->set_flashdata('alert_error', line('error_rating_add','controller_js'));
                redirect('dashboard/rating/new_rating/' . $this->input->post('class_id'));
            }

            if ($this->rating_model->add_rating()) {
                $this->session->set_flashdata('alert_success', line('success_rating_add','controller_js'));

                // Log add rating
                $date = new DateTime();
                $message = $date->format('Ymd_H:i:s') . ',1009,' .
                            $this->session->userdata('login')['user_id'] . ',' .
                            'CREATEREVIEW' . ',' .
                            $course->id . ';' .
                            $post['review'];
                $this->log_content_data_record($message);

                redirect('dashboard/rating/view/' . $this->input->post('class_id'));
            } elseif (validation_errors()) {
                $this->session->set_flashdata('alert_form_errors', validation_errors());
                redirect('dashboard/rating/new_rating/' . $this->input->post('class_id'));
            } else {
                $this->session->set_flashdata('alert_error', 'Add rating failed');
                redirect('dashboard/rating/new_rating/' . $this->input->post('class_id'));
            }
        }
    }

    // TODO : Untuk mengedit rating
    public function edit($rating_id)
    {
    }

    // TODO : Untuk menghapus rating
    public function remove($rating_id)
    {
    }
}

