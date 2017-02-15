<?php
require APPPATH . 'libraries/Dashboard_Controller.php';

class Order extends Dashboard_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('cart');
    }

    public function add()
    {
        $this->load->model('course_model');
        $id = $this->input->post('id');

        if ($this->course_model->check_owner($id)) {
            $this->session->set_flashdata('alert_error', line('error_order_add','controller_js'));
            $course = $this->course_model->get_course($id);
            redirect('/course/detail/' . $course->unique_id . '-' . $course->slug);
        }

        if ($this->is_student() == false)
        {
            $this->load->model('user_model');
            $this->user_model->become_student();
            $this->update_session($this->user_model->get_user(['email' => $this->session->userdata('login')['email']]));
        }

        $schedule_id = $this->input->post('schedule_id');
        $pax = $this->input->post('pax') ?: 1;

        if ($id) {
            $course = $this->course_model->get_course($id);
            if ($course) {
                $data = [
                    'id' => $id,
                    'qty' => $pax,
                    'price' => $course->price,
                    'name' => $course->title,
                    'schedule_id' => $schedule_id,
                ];

                $row_id = md5($id);

                if ($this->cart->get_item($row_id) == false) {
                    $this->cart->insert($data);
                }
            }
        }

        // print_r($this->session->userdata('location'));
        // print_r($course);

        // $this->twig->display('dashboard/student/order/cart', $this->data);

        $this->session->set_userdata('carts', $this->cart->contents());
        redirect('dashboard/student/order/cart');
    }

    public function delete()
    {
        $this->redirect_if_not_student();

        $this->load->model('course_model');
        $id = $this->input->get('id');

        // $row_id = md5($id);
        $this->cart->remove($id);

        redirect('dashboard/student/order/cart');
    }

    public function cart()
    {
        $this->redirect_if_not_student();

        // Check if cart empty, redirect to payment history
        $carts = $this->cart->contents();
        $cart_class_ids = array_column($carts, 'id');
        if (count($cart_class_ids) == 0) {
            $this->session->set_userdata('deposit', false);
            $this->session->set_userdata('credit_usage', 0);
            $this->session->unset_userdata('carts');
            redirect('/');
        }

        $this->load->model('course_model');
        $carts = $this->cart->contents();

        $cart_class_ids = array_column($carts, 'id');
        $cart_schedule_ids = array_column($carts, 'schedule_id');
        $cart_rowids = array_column($carts, 'rowid');
        if (count($cart_schedule_ids) > 0) {
            $this->data['courses'] = $this->course_model->get_course_by_schedules($cart_schedule_ids);

            $i = 0;
            foreach ($this->data['courses'] as $course) {
                $course->rowid = $cart_rowids[$i];
                $i++;
            }
        } else {
            $this->session->set_userdata('deposit', false);
            $this->session->set_userdata('credit_usage', 0);
        }

        $this->data['total'] = $this->cart->total();
        $this->data['carts'] = $this->cart->contents();
        $this->data['is_cart'] = true;

        // $this->cart->destroy();

        $this->twig->display('dashboard/student/order/cart', $this->data);
    }

    public function update_cart()
    {
        $this->redirect_if_not_student();

        $update = $this->input->post();
        foreach ($update['rowid'] as $key => $value) {
            $data = [
                'rowid' => $value,
                'qty' => $update['pax'][$key]
            ];
            $this->cart->update($data);
        }

        // skillagogo credits
        $row_id = md5(0);

        // Remove skillagogo credits first
        if ($this->cart->get_item($row_id) == true) $this->cart->remove($row_id);

        // Check if cart empty, redirect to payment history
        $carts = $this->cart->contents();
        $cart_class_ids = array_column($carts, 'id');
        if (count($cart_class_ids) == 0) {
            $this->session->set_userdata('deposit', false);
            $this->session->set_userdata('credit_usage', 0);
            $this->session->unset_userdata('carts');
            redirect('/');
        }

        $b_deposit = $this->input->post('deposit') ? true : false;

        // Check balance
        $this->load->model('credit_model');
        $balance = $this->credit_model->get_balance($this->session->userdata('login')['user_id']);
        $this->session->set_userdata('balance', $balance);

        // If balance is not enough
        if ($balance->total < $this->input->post('price_deposit')) {
            $this->session->set_flashdata('alert_error', line('error_order_finish','controller_js'));
            redirect('/dashboard/student/order/checkout');

            // Remove skillagogo credits
            if ($this->cart->get_item($row_id) == true) $this->cart->remove($row_id);
            $this->session->set_userdata('deposit', false);
            $this->session->set_userdata('credit_usage', 0);

        } else if ($b_deposit) {

            // If credit usage is bigger than total
            if ((int)$this->input->post('price_deposit') > $this->cart->total()) {
                $credit_usage = $this->cart->total();
            } else {
                $credit_usage = (int)$this->input->post('price_deposit');
            }

            $sc_amount = -1 * abs($credit_usage);

            if ($this->cart->get_item($row_id) == false) {
                $data = [
                    'id' => 0,
                    'qty' => 1,
                    'price' => $sc_amount,
                    'name' => "credit"
                ];
                $this->cart->insert($data);
            }

            $this->session->set_userdata('deposit', true);
            $this->session->set_userdata('credit_usage', $credit_usage);
        } else {
            // Remove skillagogo credits
            if ($this->cart->get_item($row_id) == true) $this->cart->remove($row_id);
            $this->session->set_userdata('deposit', false);
            $this->session->set_userdata('credit_usage', 0);
        }

        return redirect('dashboard/student/order/checkout');
    }

    public function checkout()
    {
        $this->redirect_if_not_student();

        // Check if cart empty, redirect to payment history
        $carts = $this->cart->contents();
        $cart_class_ids = array_column($carts, 'id');
        if (count($cart_class_ids) == 0) {
            $this->session->set_userdata('deposit', false);
            $this->session->set_userdata('credit_usage', 0);
            $this->session->unset_userdata('carts');
            redirect('/');
        }

        $this->load->model('user_model');
        $user = $this->user_model->get_by_id($this->session->userdata('login')['user_id']);
        if (!$user->address_id) {
            $this->session->set_flashdata('alert_error', line('error_update_billing_address','controller_js'));
            redirect('dashboard/profile/index' . '?referrer=' . urlencode(base_url('dashboard/student/order/cart')));
        }

        $this->load->model(['course_model', 'credit_model']);
        $this->data['credit'] = $this->credit_model->get_balance($this->session->userdata('login')['user_id'])->total;
        $this->data['carts'] = $this->cart->contents();
        $this->data['total'] = $this->cart->total();

        // print_r($this->data['total'] . "\n");
        // print_r($this->data['carts']);
        // var_dump($this->cart->contents());

        $this->twig->display('dashboard/student/order/checkout', $this->data);
    }

    public function finish()
    {
        $this->redirect_if_not_student();

        $this->load->model('order_model');
        $this->load->model('payment_model');
        $payment = $this->input->post('payment');
        $sc_amount = 0;

        // Check if cart empty, redirect to home
        $carts = $this->cart->contents();
        $cart_class_ids = array_column($carts, 'id');
        if (count($cart_class_ids) == 0) {
            $this->session->unset_userdata('carts');
            redirect('/');
        }

        // Check available seat for each item
        $this->load->model('schedule_model');
        $this->load->model('course_model');
        $flag_error_schedule = false;
        $error_msg = "";
        foreach ($this->cart->contents() as $item)
        {
            if($item['id'] == 0) continue;
            $asked_seat = $item['qty'];
            $schedule_id = $item['schedule_id'];
            $available_seat_left_from_schedule = (int)($this->schedule_model->get_schedule_by_id($schedule_id)->available_seat_left);
            $ordered_class = $this->course_model->get_course($item['id'], false, false);
            if ($asked_seat > $available_seat_left_from_schedule) {
                $error_msg .= "<p>\n" . line('only', 'field') . " " . (string)($available_seat_left_from_schedule) . " " . line('seats_left', 'field') . " " . line('for_class', 'field') . " <span style='font-family: gotham-bold;'>" . $ordered_class->title . "</span></p>";
                $flag_error_schedule = true;
            }
        }

        if ($flag_error_schedule) {
            $this->session->set_flashdata('alert_form_errors', $error_msg);
            redirect('/dashboard/student/order/checkout');
        }

        // if using credit check credit
        if ($this->input->post('deposit'))
        {
            $this->load->model('credit_model');
            $sc_amount = $this->input->post("price_deposit");

            // Check balance
            $balance = $this->credit_model->get_balance($this->session->userdata('login')['user_id']);

            // If balance is not enough
            if ((int) $balance->total < $sc_amount) {
                $this->session->set_flashdata('alert_error', line('error_order_finish','controller_js'));
                redirect('/dashboard/student/order/checkout');
            }

            // If balance is the same as cart total
            if ($this->cart->total() == 0) {

                if ($payment && $payment == 'bank') {
                    $order_id = $this->order_model->save($payment, $sc_amount);
                } else if ($payment && $payment == 'paypal') {
                    $order_id = $this->order_model->save($payment, $sc_amount, NULL);
                } else {
                    $this->session->set_flashdata('alert_error', line('error_order_finish_2','controller_js'));
                    redirect('/dashboard/student/order/checkout');
                }

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


                    // If ORDER_SUCCESS, update seat left in schedule
                    $this->db->where('id',$detail->schedule_id);
                    $schedule = $this->db->get('schedules')->row();
                    $this->load->model('course_model');
                    $this->load->model('schedule_model');
                    $course_type = $this->course_model->get_course($detail->class_id, false, false)->type;
                    if ($schedule) {
                        $available_seat_left = $schedule->available_seat_left;
                        if ($course_type == 3) { // if staged 
                            $all_schedules = $this->schedule_model->get_schedules($detail->class_id);
                            foreach ($all_schedules as $staged_schedule) {
                                $this->db->where('id',$staged_schedule->schedule_id);
                                $this->db->update('schedules', ['available_seat_left' => ((int)$available_seat_left - (int)$detail->pax)]);
                            }
                        }
                        else { // repeated and single
                            $this->db->where('id',$schedule->id);
                            $this->db->update('schedules', ['available_seat_left' => ((int)$available_seat_left - (int)$detail->pax)]);
                        }
                    }

                    $this->load->model('credit_model');
                    $this->credit_model->pay($order->user_id, $sc_amount, $order_id);

                }

                if ($payment && $payment == 'bank') {
                    // Log payment bank
                    $date = new DateTime();
                    $message = $date->format('Ymd_H:i:s') . ',1005,' .
                                $user_id . ',' .
                                'PAY' . ',' .
                                $order_id . ';' .
                                'Bank' . ';' .
                                $order->amount;
                    $this->log_activity_data_record($message);
                } else if ($payment && $payment == 'paypal') {
                    // Log payment paypal
                    $date = new DateTime();
                    $message = $date->format('Ymd_H:i:s') . ',1005,' .
                                $user_id . ',' .
                                'PAY' . ',' .
                                $order_id . ';' .
                                'Paypal' . ';' .
                                $order->amount;
                    $this->log_activity_data_record($message);

                }

                $this->cart->destroy();
                $this->session->unset_userdata('deposit');
                $this->session->unset_userdata('credit_usage');  

                redirect('dashboard/student/payment/history');
            }

        }

        if ($payment && $payment == 'bank') {
            $order_id = $this->order_model->save($payment, $sc_amount);

            // Send preorder_summary
            $this->load->model('user_model');
            $this->load->model('order_model');
            $data_email['student'] = $this->user_model->get_by_id($this->session->userdata('login')['user_id']);
            $data_email['order'] = $this->order_model->get_order($order_id);
            $data_email['total'] = $this->cart->total();
            $data_email['credit_usage'] = $sc_amount;
            $data_email['email'] = $this->user_model->get_by_id($this->session->userdata('login')['user_id'])->email;
            $this->send_notification_email($data_email, line('email_order_finish_bank','controller_js'), 'email/preorder_summary');

            // $this->twig->display("email/preorder_summary", $data_email);
            // return;

            $this->cart->destroy();
            $this->session->set_userdata('deposit', false);
            $this->session->set_userdata('credit_usage', 0);

        } else if ($payment && $payment == 'paypal') {
            $payment = new \Skillagogo\Payment\PaypalPayment();
            $payment->pay($this->cart);
        } else {
            $this->session->set_flashdata('alert_error', line('error_order_finish_2','controller_js'));
            redirect('/dashboard/student/order/checkout');
        }

        $this->data['payment'] = $payment;
        $this->data['order'] = $this->order_model->get_order($order_id);
        $this->data['payment_detail'] = $this->payment_model->get_payment_by_order_id($order_id);

        $this->twig->display('dashboard/student/order/finish', $this->data);
    }
}
