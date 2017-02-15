<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "libraries/Admin_Controller.php";

class How_to_teach extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        if($this->check_admin_marketing() == false){
            redirect('adminuao3hltbr0/home');
        }
        $this->load->model('admin_model');
    }

    public function index()
    {
        // set active sidebar
        $this->data['page'] = "page";
        $this->data['sidebar'] = "static how to teach";

        if ($this->is_post()) {
            $post = $this->input->post();
            $post['last_editor_id'] = (int)$post['last_editor_id'];

            // untuk mengisi lagi form static_page
            $this->data['static_page'] = $post;

            if ($this->admin_model->update_static_page($post)) {
                $this->data['alert']['success'] = "Static Page is successfully updated";
            }

            // save error validation to variable
            if (validation_errors()) {
                $this->data['validation_error'] = validation_errors();
            }
        }

        $lang = ($this->input->get('lang')) ?: \StaticStatic::ENGLISH;
        $this->data['static_page'] = $this->admin_model->get_static_page_with_lang('how to teach', $lang);

        $this->twig->display('adminuao3hltbr0/static_page/static_page_how_to_teach', $this->data);
        return;
    }

}
