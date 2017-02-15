<?php

require_once "Public_Controller.php";

class Dashboard_Controller extends Public_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->set_role();

        if ($this->is_login() == false and ($this->data['user_login_admin']['type'] != \AdminStatic::TYPE_REVIEW and $this->data['user_login_admin']['type'] != \AdminStatic::TYPE_ADMIN) ) {
            if ($currentUrl = $this->session->userdata('current_url'))
                redirect('login?referrer=' . urlencode($currentUrl));
            else
                redirect('login');
        }
    }

    public function set_role($update = false, $role = null)
    {
        if ($this->config->item('role') && $update == false) {
            return;
        }

        if ($role == null) {
            $role = $this->session->userdata('login')['is_teacher'] ? 'teacher' : 'student';
        }

        $this->config->set_item('role', $role);
        $this->session->set_userdata('role', $role);
    }

    public function redirect_if_not_login()
    {
        if ($this->is_login() == false)
            redirect('/');
    }

    public function redirect_if_not_student()
    {
        $this->redirect_if_not_login();
        if ($this->is_student() == false)
            redirect('dashboard');
    }

    public function redirect_if_not_teacher()
    {
        $this->redirect_if_not_login();
        if ($this->is_teacher() == false)
            redirect('dashboard');
    }
}
