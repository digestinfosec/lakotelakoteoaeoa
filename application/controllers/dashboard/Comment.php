<?php
require APPPATH . 'libraries/Dashboard_Controller.php';

class Comment extends Dashboard_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('comment_model');
        $this->load->helper('timezone');
    }

    public function view($course_id)
    {
        $this->load->model('course_model');
        $option['course_id'] = $course_id;
        $course = $this->course_model->get_course($course_id);

        if (!isset($course->id))
            redirect('/');

        $this->data['course'] = $course;

        // pagination settings
        $this->load->library('pagination');
        $config['base_url'] = '/dashboard/comment/view/' . $course_id . '/index';
        $config['total_rows'] = $this->comment_model->get_count_comments_course($course_id);
        $config['per_page'] = 5;

        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        // get comments
        $option['offset'] = $this->uri->segment(5);
        $option['limit'] = $config['per_page'];
        $this->data['comments'] = $this->comment_model->get_comments($option);

        $this->twig->display('public/comment/index', $this->data);
    }

    public function add()
    {
        if ($this->is_post()) {
            $this->load->model('course_model');
            // check if user attending class
            if ($this->input->post('class_id') &&
                $this->course_model->check_if_auth_user_registered($this->input->post('class_id')) ==  false)
            {
                $this->session->set_flashdata('alert_error', line('error_comment_add','controller_js'));
                $course = $this->course_model->get_course($this->input->post('class_id'));
                redirect('/course/detail/' . $course->unique_id . '-' . $course->slug);            
            }

            if ($this->comment_model->add_comment()) {
                $this->session->set_flashdata('alert_success', line('success_comment_add','controller_js'));
            } elseif (validation_errors()) {
                $this->session->set_flashdata('alert_form_errors', validation_errors());
            } else {
                $this->session->set_flashdata('alert_error', line('error_cant_process','controller_js'));
            }

            $course = $this->course_model->get_course($this->input->post('class_id'));
            redirect('/course/detail/' . $course->unique_id . '-' . $course->slug);            
        }
    }

    public function edit($comment_id)
    {
        if ($this->is_post()) {

            if ($this->comment_model->update_comment($comment_id)) {
                $this->session->set_flashdata('alert_success', line('success_comment_edit','controller_js'));
            } else {
                $this->session->set_flashdata('alert_error', line('error_cant_process','controller_js'));
            }

            redirect('member/teacher/comment');
        }

        $this->data['values'] = $this->comment_model->get_comment($comment_id);

        if (!$this->data['values']) {
            $this->session->set_flashdata('alert_error', line('error_data_not_found','controller_js'));
            redirect('member/teacher/comment');
        }

        $this->load->model('public/public_comment');
        $this->load->helper('form');
        $this->load->helper('sg_form');
        $this->twig->display('member/teacher/comment/add', $this->data);
    }

    public function remove($comment_id)
    {
        if ($this->comment_model->remove_comment($comment_id)) {
            $this->session->set_flashdata('alert_success', line('success_comment_remove','controller_js'));
        } else {
            $this->session->set_flashdata('alert_error', line('error_comment_remove','controller_js'));
        }

        redirect('member/teacher/comment');
    }
}
