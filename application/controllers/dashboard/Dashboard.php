<?php

require APPPATH . 'libraries/Dashboard_Controller.php';

class Dashboard extends Dashboard_Controller
{
    public function index()
    {
        if (!$this->is_login()) {
            redirect('login');
        }

        // check browser
        if ($this->session->userdata('login')['is_teacher']) {
            redirect('dashboard/teacher/course');
        } else {
            redirect('dashboard/student/course');
        }
    }
}
