<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "libraries/Admin_Controller.php";

class Page_administrators extends Admin_Controller
{
    use \Skillagogo\Callback\UserCallback;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');

        // set active sidebar
        $this->data['page'] = "page administrator";
    }

    public function index()
    {
        if($this->check_admin_only() == false){
            redirect('adminuao3hltbr0/home');
        }

        if ($this->input->post("del") && $this->input->post("del") != $this->session->userdata('login_admin')['admin_id']) {
            $this->data['delete'] = $this->input->post("del");
            $this->admin_model->delete_admin($this->data['delete']);
            $this->data['alert']['deleted'] = "Your data has been deleted";
        }

        $this->data['admins']=$this->admin_model->get_admins();
        $this->data['admin_status']=\AdminStatic::STATUS_HASH;
        $this->data['admin_type']=\AdminStatic::TYPE_HASH;
        $this->twig->display('adminuao3hltbr0/page_administrators', $this->data);
        return;
    }

    public function new_admin()
    {
        if($this->check_admin_only() == false){
            redirect('adminuao3hltbr0/home');
        }

        if ($this->is_post()) {
            $post = $this->input->post();

            if ($this->admin_model->create_admin($post)) {
                $this->session->set_flashdata('alert_success', "Your data has been saved");
                redirect('adminuao3hltbr0/page_administrators');
            }

            // save error validation to variable
            if (validation_errors()) {
                $this->data['validation_error'] = validation_errors();
            }
        }

        $this->twig->display('adminuao3hltbr0/page_create_user', $this->data);
    }

    public function edit($user_id)
    {
        //$this->load->model('admin_model');
        $this->data['user']=$this->admin_model->get_admin(['admins.id' => $user_id]);
        $this->data['user_type']=AdminStatic::TYPE_HASH;
        $this->data['type_admin']=AdminStatic::TYPE_ADMIN;


        #redirect if null
        if($this->data['user']==NULL){
            redirect('adminuao3hltbr0/home');
        }

        if( $this->data['user_login_admin']['type'] != \AdminStatic::TYPE_ADMIN and $this->data['user_login_admin']['admin_id'] != $user_id) {
            redirect('adminuao3hltbr0/home');
        }

        if ($this->is_post()) {
            $post = $this->input->post();
            $post['id'] = (int)$user_id;

            // if not change picture, set profile_pic to default
            if (empty($_FILES['avatar']['name']) == false) {
                $post['profile_pic'] = $this->upload_avatar();

            } else {
                $post['profile_pic'] = $this->session->userdata('login_admin')['avatar'];
            }

            // untuk mengisi lagi form edit user
            $this->data['user'] = $post;

            if ($this->admin_model->edit_admin($user_id, $post)) {

                if ($user_id==$this->session->userdata('login_admin')['admin_id']){
                    $user = $this->admin_model->get_admin(['email' => $post['email']]);
                    $this->update_admin_session($user);
                }
                $this->session->set_flashdata('alert_success', "Your data has been saved");
                redirect(current_url());
            }

            // save error validation to variable
            if (validation_errors()) {
                $this->data['validation_error'] = validation_errors();
            }
        }

        $this->twig->display('adminuao3hltbr0/page_edit_user', $this->data);
    }

    public function change_password($user_id)
    {
        //$this->load->model('admin_model');
        $this->data['user']=$this->admin_model->get_admin(['admins.id' => $user_id]);

        #redirect if null
        if($this->data['user']==NULL){
            redirect('adminuao3hltbr0/home');
        }

        if( $this->data['user_login_admin']['type'] != \AdminStatic::TYPE_ADMIN and $this->data['user_login_admin']['admin_id'] != $user_id) {
            redirect('adminuao3hltbr0/home');
        }

        if ($this->is_post()) {
            $post = $this->input->post();

            if ($this->admin_model->update_password($post, $user_id)) {
                $this->session->set_flashdata('alert_success', "Password is successfully updated");
                redirect(current_url());
            }
            else {
                $this->data['validation_error'] = validation_errors();
            }
        }
        $this->twig->display('adminuao3hltbr0/page_change_password', $this->data);
    }
}
