<?php

require_once APPPATH . "libraries/REST_Controller.php";

class User extends REST_Controller
{
    public function index_get($id)
    {
        echo $id;

        $this->load->model('user_m');

        $id = $this->get('id');
        $user = $this->user_m->get($id);

        $this->response($user);

    }
}
