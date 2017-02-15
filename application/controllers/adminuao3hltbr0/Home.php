<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "libraries/Admin_Controller.php";

class Home extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->model('course_model');

        // set active sidebar
        $this->data['page'] = "dashboard";
    }


    public function index()
    {
        #count courses
        $this->data['count_courses'] = count($this->course_model->get_courses_for_admin_page());

        #count comments
        $this->data['count_comments']=count($this->admin_model->get_comments());

        #count teachers
        $is_teacher=1;
        $this->data['count_teachers']=count($this->admin_model->get_users($is_teacher,NULL));

        // count students
        $is_student=1;
        $this->data['count_students']=count($this->admin_model->get_users(NULL,$is_student));

        $this->twig->display('adminuao3hltbr0/home', $this->data);
        return;
    }

}
