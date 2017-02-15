<?php

require APPPATH . 'libraries/Dashboard_Controller.php';

class Payout extends Dashboard_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (isset($this->data['user_login_admin']) && $this->data['user_login_admin']['type'] != \AdminStatic::TYPE_ADMIN)
            $this->redirect_if_not_teacher();
        $this->load->model('payout_model');
        $this->load->model('voucher_model');
    }

    public function index()
    {
        $teacher_id = $this->session->userdata('login')['user_id'];
        $currency = $this->session->userdata('currency') == 'Rp' ? 'IDR' : 'SGD';

        $payouts=$this->payout_model->get_payout_lists_with_id_cur($teacher_id, $currency);
        $this->data['payout']=$payouts;
        $this->data['currency'] = $currency;
        // print_r($payouts);

        $this->data['menu_top'] = "payment_history";
        $this->data['menu_left'] = "teacher_payout";
        $this->twig->display('dashboard/teacher/payout/index', $this->data);
    }

    public function voucher()
    {
        $teacher_id = $this->session->userdata('login')['user_id'];
        $currency = $this->session->userdata('currency') == 'Rp' ? 'IDR' : 'SGD';
        
        $this->data['cur_month_vouchers']=$this->voucher_model->get_cur_month_voucher_lists($teacher_id, $currency);        
        $this->data['currency'] = $currency;

        $this->data['menu_top'] = "voucher";
        $this->data['menu_left'] = "teacher_payout";
        $this->twig->display('dashboard/teacher/payout/voucher', $this->data);
    }

    public function invoice($invoice_code)
    {
        $this->load->model('order_model');
        $this->load->model('payment_model');
        $this->load->model('voucher_model');
        $invoice = $this->payout_model->get_payout_by_invoice_code($invoice_code);
        if ( !$invoice )
        {
            redirect('dashboard/teacher/payout/index');
        }

        $this->data['payout'] = $invoice;
        $vouchers = $this->voucher_model->get_by_invoice_code($invoice_code);

        // Check invoice owner, and also not admin
        foreach($vouchers as $voucher) {
            if($voucher->teacher_id != $this->session->userdata('login')['user_id'] and $this->check_admin_only() == false)
                redirect('dashboard');
        }

        $this->data['vouchers'] = $vouchers;
        $this->data['total'] = $this->voucher_model->get_totals_by_invoice_code($invoice_code);
        $this->data['with_buttons'] = true;
        $this->twig->display('dashboard/teacher/payout/invoice', $this->data);
    }
}
