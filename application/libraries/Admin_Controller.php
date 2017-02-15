<?php

require_once "Public_Controller.php";

class Admin_Controller extends Public_Controller
{
    function __construct()
    {
        parent::__construct();

        if ($this->is_login_admin() == false) {
            redirect('adminuao3hltbr0/login');
        }
        
        $this->data['alert'] = array(
            'error' => $this->session->flashdata('alert_error'),
            'success' => $this->session->flashdata('alert_success'),
            'form_errors' => $this->session->flashdata('alert_form_errors'),
            'deleted' => $this->session->flashdata('alert_deleted'),
        );
    }
}
