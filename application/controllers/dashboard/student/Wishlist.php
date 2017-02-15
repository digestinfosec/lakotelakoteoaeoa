<?php

require APPPATH . 'libraries/Dashboard_Controller.php';

class Wishlist extends Public_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->is_login() == false)
            redirect('/');
        if ($this->is_student() == false)
            redirect('dashboard');
        // $this->redirect_if_not_student();
        $this->load->model('course_model');

        $option['wishlist_student_id'] = $this->session->userdata('login')['user_id'];

        // pagination settings
        $this->load->library('pagination');

        // get courses
        $option['strict'] = true;
        $option['directory_class_only'] = true;

        $config['base_url'] = '/dashboard/student/wishlist/index';
        $config['total_rows'] = count($this->course_model->get_courses($option));
        $config['per_page'] = 6;

        $option['offset'] = $this->uri->segment(5);
        $option['limit'] = $config['per_page'];
        $this->data['courses'] = $this->course_model->get_courses($option);

        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        $this->data['menu_left'] = "student_wishlist";
        $this->twig->display('dashboard/student/wishlist/index', $this->data);
    }

    public function change()
    {
        if (!$this->is_login()) {
            $this->load->model('course_model');
            $course = $this->course_model->get_course($this->input->post('id'));
            echo json_encode(['success' => false, 'referrer' => urlencode(site_url('course/detail/' . $course->unique_id . '-' . $course->slug))]);
            return;
        }

        $this->output->set_content_type('text/json');
        $this->load->model('course_model');
        if ($this->course_model->check_owner($this->input->post('id'))) {
            echo json_encode(['success' => false, 'message' => line('error_wishlist_change','controller_js'), 'status' => 'remove']);
            return;
        }

        if ($this->is_student() == false)
        {
            $this->load->model('user_model');
            $this->user_model->become_student();
            $this->update_session($this->user_model->get_user(['email' => $this->session->userdata('login')['email']]));
        }

        $this->load->model('wishlist_model');
        $this->load->model('user_model');

        if ($this->wishlist_model->add_wishlist()) {

            // Email notification to teacher about her/his class
            // HARUS cek emailnya uda perna dikirim dari student itu belom
            // Set flag email_once_sent
            // Jadi kalo di klik2 terus ga send email terus.
            $wishlist = $this->wishlist_model->get_count_wishlist($this->input->post('id'));
            $user = $this->user_model->get_by_id($wishlist->teacher_id);
            $data_wishlist = array_merge((array)$user, (array)$wishlist);
            // sementara disable dulu
            $this->send_notification_email((array)$data_wishlist, line('email_wishlist_change','controller_js'), 'email/someone_added_to_my_wishlist_teacher_en');

            echo json_encode(['success' => true, 'message' => line('success_wishlist_change','controller_js'), 'status' => 'add']);
        } else {
            echo json_encode(['success' => true, 'message' => line('success_wishlist_change_2','controller_js'), 'status' => 'remove']);
        }
    }
}
