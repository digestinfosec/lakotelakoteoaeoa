<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "libraries/Public_Controller.php";

class Home extends Public_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('course_model');
    }

    public function index()
    {
        $this->setCurrentUrl();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = $this->input->post();
            $email = $post['email'];
            $this->user_model->update_notification_newsletter(true, $email);
        }

        $option['publish_status'] = CourseStatic::PUBLISH_SUCCESS;
        $option['search'] = $this->input->get('search');
        $option['strict'] = true;
        $option['directory_class_only'] = true;
        $option['sort_by'] = "home_list";
        $option['limit'] = 12;
        $this->data['courses'] = $this->course_model->get_courses($option);
        $this->data['values'] = $this->input->get();

        $this->twig->display('public/home/index', $this->data);
        return;
    }

    public function coming_soon()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = $this->input->post();
            $user = $this->user_model->pre_register($post);
            if ($user) {
                $this->send_notification_email((array)$user, '[skillagogo] Notification of registration',
                    'email/dulu/pre_register');
            }
        }

        $this->data['loginUrl'] = $this->generate_facebook();

        $this->load->helper('language_line');
        $this->twig->display('public/home/coming_soon', $this->data);
        return;
    }

    public function thank_you()
    {
        $this->twig->display('public/home/thank_you', []);
        return;
    }

    // public function payment_confirmation()
    // {
    //     $this->twig->display('public/home/payment_confirmation', $this->data);
    //     return;
    // }

}
