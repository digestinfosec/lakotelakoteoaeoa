<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "libraries/Admin_Controller.php";

class Page_settings extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        if($this->check_admin_marketing() == false){
            redirect('adminuao3hltbr0/home');
        }
        // set active sidebar
        $this->data['page'] = "page settings";
    }


    public function index()
    {

        $this->twig->display('adminuao3hltbr0/page_form_setting', $this->data);
        return;
    }

}
