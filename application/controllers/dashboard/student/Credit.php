<?php

require APPPATH . 'libraries/Dashboard_Controller.php';

class Credit extends Dashboard_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->redirect_if_not_student();
    }

    public function index()
    {
        $this->data['menu_left'] = "student_credit";
        $this->data['menu_top'] = "index";

        $currency = $this->session->userdata('currency') == 'Rp' ? 'IDR' : 'SGD';
        $this->data['currency'] = $currency;

        $this->load->model('credit_model');
        $this->data['credits'] = $this->credit_model->get_credits($this->session->userdata('login')['user_id'], $currency);
        $total = $this->credit_model->get_balance($this->session->userdata('login')['user_id'])->total;
        $this->data['total'] = $total ? $total : 0;
        $this->twig->display('dashboard/student/credit/index', $this->data);
    }

//    public function history()
//    {
//        $this->data['menu_left'] = "student_credit";
//        $this->data['menu_top'] = "history";
//
//        $currency = $this->session->userdata('currency') == 'Rp' ? 'IDR' : 'SGD';
//        $this->data['currency'] = $currency;
//
//        $this->load->model('credit_model');
//        $this->data['histories'] = $this->credit_model->get_history($this->session->userdata('login')['user_id'], $currency);
//        $this->twig->display('dashboard/student/credit/history', $this->data);
//    }
}
