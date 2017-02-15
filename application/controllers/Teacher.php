<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function profile($id = null)
    {
        $this->setCurrentUrl();

        $this->load->model('user_model');

        if (is_null($id)) {
            if ($this->is_teacher()) {
                $id = $this->session->userdata('login')['user_id'];
            } else {
                redirect('/');
            }
        }

        $user = $this->user_model->get_teacher($id);
        if ($user) {
            $this->load->model('course_model');
            $this->load->model('rating_model');

            $this->data['user'] = $user;

            // Review form teacher's classes
            $option['limit'] = 3;
            $this->data['ratings'] = $this->rating_model->get_teacher_rating($user->id, $option);
            $this->data['count_rating'] = $this->rating_model->get_count_rating_teacher($user->id);

            // Class Recommendation other class from this teacher on teacher profile page
            $option['teacher_id'] = $user->id;
            $option['limit'] = 6;
            $option['strict'] = true;
            $option['directory_class_only'] = true;
            $this->data['courses'] = $this->course_model->get_courses($option);

            // Teacher class count
            //$this->data['count'] = count($this->course_model->get_courses($user->id));

            // Average Rate from all classes by teacher
            $this->data['rate_avg'] = number_format($this->rating_model->get_teacher_average_rate($user->id)->rate_avg, 1);

            $this->data['title'] = "Teacher Profile : " . $user->first_name . " " . $user->last_name;
            $this->data['meta_title'] =  $user->first_name . " " . $user->last_name;
            $this->data['meta_description'] =  $user->bio;
            $this->data['meta_image'] = isset($user->profile_pic) ? base_url('images/avatar') . '/' . $user->profile_pic : base_url() . "assets/images/image_default_big.png";
            $this->data['share'] = $this->share_link($this->data['title'], $user->bio,
                $this->data['meta_image']);

            $this->twig->display('public/teacher/profile', $this->data);
            return;
        }

        show_404();
    }

    public function recommend()
    {
        $this->setCurrentUrl();
        if (!$this->is_login()) {
            if ($currentUrl = $this->session->userdata('current_url'))
                redirect('login?referrer=' . urlencode($currentUrl));
            else
                redirect('login');
        }

        $data = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $this->input->post();
            $data['user_id'] = (int)$this->data['user_login']['user_id'];
            $this->load->model('recommend_model');
            $recommend = $this->recommend_model->send_recommendation($data);

            if ($recommend) {
                $data['message_content'] = line('success_teacher_recommend','controller_js');
                $this->twig->display("public/home/confirmation", $data);
                return;
            }
            $data['error'] = validation_errors() ? validation_errors() : 'Unknown Error';
        }

        $this->load->model('category_model');
        $data['categories'] = $this->category_model->get_category_tree();
        $this->twig->display("public/teacher/recommend", $data);
    }
}
