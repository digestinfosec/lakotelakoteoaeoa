<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Data_Controller extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('language_line');
    }

    public function is_login()
    {
        return isset($this->session->get_userdata('login')['status']) ? true : false;
    }
}
