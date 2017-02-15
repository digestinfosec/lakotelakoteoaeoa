<?php

class Paypal extends MY_Controller
{
    public function complete()
    {
        if (!$this->is_login()) {
            redirect('/');
        }

        // Check if cart empty, redirect to root
        $carts = $this->cart->contents();
        $cart_class_ids = array_column($carts, 'id');
        if (count($cart_class_ids) == 0) {
            $this->session->set_userdata('deposit', false);
            $this->session->set_userdata('credit_usage', 0);  
            $this->session->unset_userdata('carts');  
            redirect('/');
        }

        $payment = new \Skillagogo\Payment\PaypalPayment();
        $txid = $payment->complete($this->cart);
        $this->load->model('order_model');
        $order_id = $this->order_model->save('paypal', $this->session->userdata('credit_usage'), $txid);

        $this->load->model(['voucher_model', 'course_model', 'schedule_model', 'user_model']);
        $order = $this->order_model->get_order($order_id);
        $user_id = $order->user_id;
        foreach ($order->details as $detail) {
            $course = $this->course_model->get_course($detail->class_id);
            for ($i = 0; $i < $detail->pax; $i++) {
                $voucher_code = $this->voucher_model->generate_voucher($course);
                $this->voucher_model->save($voucher_code, $detail);

                //check owner
                $this->load->library('ciqrcode');

                ob_start();
                $params['data'] = $voucher_code;
                $params['size'] = 10;
                $params['savename'] = 'images/class/' . $voucher_code . '.png';
                $this->ciqrcode->generate($params);
                $this->data['qrcode'] = base64_encode(ob_get_contents());
                ob_end_clean();
                
                // Send attendance_voucher_en
                $data_email['student'] = $this->user_model->get_by_id($user_id);
                $data_email['teacher'] = $this->user_model->get_by_id($course->teacher_id);
                $data_email['course'] = $course;
                $data_email['order'] = $order;
                $data_email['voucher_code'] = $voucher_code;
                $data_email['schedule'] = $this->schedule_model->get_schedule_by_id($detail->schedule_id);
                $data_email['email'] = $this->user_model->get_by_id($user_id)->email;
                $this->send_notification_email($data_email, line('email_paypal_complete','controller_js'), 'email/attendance_voucher_en');

                // Send enrollment_confirmation_email_en.twig
                $this->send_notification_email($data_email, line('email_paypal_complete_2','controller_js'), 'email/enrollment_confirmation_email_en');

                // $this->twig->display("email/enrollment_confirmation_email_en", $data_email);
                // return;

                // $this->twig->display("email/attendance_voucher_en", $data_email);
                // return;
            }
            // Log join class
            $date = new DateTime();
            $message = $date->format('Ymd_H:i:s') . ',1005,' .
                $user_id . ',' .
                'JOINCLASS' . ',' .
                $course->course_id . ';';
            $this->log_activity_data_record($message);

            // Send someone_registered_to_my_class_teacher
            $data_email['detail'] = $detail;
            $data_email['course'] = $course;
            $data_email['teacher'] = $this->user_model->get_by_id($course->teacher_id);
            $data_email['email'] = $this->user_model->get_by_id($course->teacher_id)->email;
            $this->send_notification_email($data_email, line('email_paypal_complete_3','controller_js'), 'email/someone_registered_to_my_class_teacher_en');
        }

        // Log payment paypal
        $date = new DateTime();
        $message = $date->format('Ymd_H:i:s') . ',1005,' .
                    $this->session->userdata('login')['user_id'] . ',' .
                    'PAY' . ',' .
                    $order_id . ';' .
                    'Paypal' . ';' .
                    $order->amount;
        $this->log_activity_data_record($message);

        $this->cart->destroy();
        $this->session->unset_userdata('deposit');
        $this->session->unset_userdata('credit_usage');  

        redirect('dashboard/student/payment/history');
    }

    public function cancel()
    {
        redirect('dashboard/student/order/checkout');
    }

}
