<?php

require APPPATH . 'libraries/Dashboard_Controller.php';

class Payment extends Dashboard_Controller
{
    function __construct()
    {
        parent::__construct();
        if (isset($this->data['user_login_admin']) && $this->data['user_login_admin']['type'] != \AdminStatic::TYPE_ADMIN)
            $this->redirect_if_not_student();
        $this->load->model('payment_model');
    }

    // public function setting()
    // {
    //     $this->data['menu_left'] = "student_payment";
    //     $this->data['menu_top'] = "setting";
    //     $this->twig->display('dashboard/student/payment/setting', $this->data);
    // }

    public function history()
    {
        $option['student_id'] = $this->session->userdata('login')['user_id'];
        $option['currency'] = $this->session->userdata('currency') == 'Rp' ? 'IDR' : 'SGD';

        // pagination settings
        $this->load->library('pagination');
        $config['base_url'] = '/dashboard/student/payment/history';
        $config['total_rows'] = count($this->payment_model->get_student_payments($option));
        $config['per_page'] = 10;

        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        // get payments
        $option['offset'] = $this->uri->segment(5);
        $option['limit'] = $config['per_page'];
        $this->data['payments'] = $this->payment_model->get_student_payments($option);

        $this->data['menu_left'] = "student_payment";
        $this->data['menu_top'] = "history";
        $this->twig->display('dashboard/student/payment/history', $this->data);
    }

    public function receipt($receipt_code)
    {
        $this->load->model('order_model');
        $this->load->model('payment_model');
        $receipt = $this->order_model->get_order_by_receipt_code($receipt_code);
        if ( !$receipt )
        {
            redirect('dashboard/student/payment/history');
        }

        // Check receipt owner, and also not admin
        if($receipt->user_id != $this->session->userdata('login')['user_id'] and $this->check_admin_only() == false)
            redirect('dashboard');


        $this->data['order'] = $receipt;
        $this->data['payment'] = $this->payment_model->get_payment_by_receipt_code($this->data['order']->receipt_code);
        $this->data['with_buttons'] = true;

        if (isset($this->data['user_login_admin']) && $this->data['user_login_admin']['type'] == \AdminStatic::TYPE_ADMIN) {
            if ($receipt->currency == "IDR") {
                $this->session->set_userdata('lang',"indonesian");
            } else {
                $this->session->set_userdata('lang',"english");
            }
        }

        $this->twig->display('dashboard/student/payment/receipt', $this->data);
    }

    public function confirmation($order_id)
    {
        $this->load->model('payment_model');
        $order=$this->payment_model->get_payment_by_order_id($order_id);

        if (!isset($order->id))
            redirect('/');

        $this->data['order'] = $order;
        $currency = $this->session->userdata('currency') == 'Rp' ? 'IDR' : 'SGD';

        if ($this->data['order']->payment_method == \PaymentStatic::PAYMENT_METHOD_PAYPAL or $currency != $order->currency)
        {
            redirect('dashboard/student/payment/history');
        }

        $order_id=$this->data['order']->id;
        $order_class=$this->payment_model->get_order_classes($order_id);
        $this->data['order_class']=$order_class;

        if ($this->is_post())
        {
            $post = $this->input->post();

            if (empty($_FILES['photo']['name']) == false) {
                $post['photo'] = $this->upload_transaction_bank();
            } else {
                $post['photo'] = $this->data['order']->photo;
            }

            $this->data['order'] = $post;
            $post['id'] = $order_id;

            if ($this->payment_model->payment_confirmation($post)) {
                $this->session->set_flashdata('alert_success', line('success_payment_confirmation','controller_js'));

                // Log payment bank
                $date = new DateTime();
                $message = $date->format('Ymd_H:i:s') . ',' .
                            $this->session->userdata('login')['user_id'] . ',' .
                            'PAY' . ',' .
                            $order_id . ';' .
                            'Bank' . ';' .
                            $order->amount;
                $this->log_activity_data_record($message);

                redirect('dashboard/student/payment/history');
            }

            if (validation_errors()) {
                $this->data['validation_error'] = validation_errors();
            }
        }


        $this->twig->display('dashboard/student/payment/payment_confirmation', $this->data);
        return;
    }
}
