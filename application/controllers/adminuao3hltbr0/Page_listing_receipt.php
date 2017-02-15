<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "libraries/Admin_Controller.php";

class Page_listing_receipt extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        if($this->check_admin_review() == false){
            redirect('adminuao3hltbr0/home');
        }
        $this->load->model('admin_model');

        // set active sidebar
        $this->data['page'] = "page receipt";
    }


    public function index()
    {
        $orders=$this->admin_model->get_orders();
        $this->data['orders'] = $orders;
        $orders_status=\OrderStatic::ORDER_STATUS_HASH;
        $this->data['status'] = $orders_status;
        $this->data['payment_bank_transfer'] = \PaymentStatic::PAYMENT_METHOD_BANK;

        if ($this->input->post("download")) {

            //load our new PHPExcel library
            $this->load->library('excel');

            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);

            $this->excel->getActiveSheet()->setCellValue('A1', 'No');
            $this->excel->getActiveSheet()->setCellValue('B1', 'Receipt Code');
            $this->excel->getActiveSheet()->setCellValue('C1', 'Name');
            $this->excel->getActiveSheet()->setCellValue('D1', 'Receipt Date');
            $this->excel->getActiveSheet()->setCellValue('E1', 'Currency');
            $this->excel->getActiveSheet()->setCellValue('F1', 'Total');
            $this->excel->getActiveSheet()->setCellValue('G1', 'Status');
            $this->excel->getActiveSheet()->setCellValue('H1', 'Payment Method');
            $this->excel->getActiveSheet()->setCellValue('I1', 'Payment Date');
            $this->excel->getActiveSheet()->setCellValue('J1', 'amount');
            $this->excel->getActiveSheet()->setCellValue('K1', 'paypal_email');
            $this->excel->getActiveSheet()->setCellValue('L1', 'paypal_transaction_id');
            $this->excel->getActiveSheet()->setCellValue('M1', 'bank_destination_name');
            $this->excel->getActiveSheet()->setCellValue('N1', 'bank_account_name');
            $this->excel->getActiveSheet()->setCellValue('O1', 'bank_account_number');
            $this->excel->getActiveSheet()->setCellValue('P1', 'note');
            $this->excel->getActiveSheet()->setCellValue('Q1', 'bank_name');
            $this->excel->getActiveSheet()->setCellValue('R1', 'with_credit');
            $this->excel->getActiveSheet()->setCellValue('S1', 'credit_amount');


            $col=2;
            $i=1;
            foreach ($orders as $order){
                $this->excel->getActiveSheet()->setCellValue('A'.$col, $i);
                $this->excel->getActiveSheet()->setCellValue('B'.$col, $order['receipt_code']);
                $this->excel->getActiveSheet()->setCellValue('C'.$col, $order['customer_first_name'] .  " " . $order['customer_last_name']);
                $this->excel->getActiveSheet()->setCellValue('D'.$col, $order['created_at']);
                $this->excel->getActiveSheet()->setCellValue('E'.$col, $order['currency']);
                $this->excel->getActiveSheet()->setCellValue('F'.$col, $order['total']);
                $this->excel->getActiveSheet()->setCellValue('G'.$col, $orders_status[$order['status']]);
                $this->excel->getActiveSheet()->setCellValue('H'.$col, $order['payment_method']);
                $this->excel->getActiveSheet()->setCellValue('I'.$col, $order['payment_date']);
                $this->excel->getActiveSheet()->setCellValue('J'.$col, $order['amount']);
                $this->excel->getActiveSheet()->setCellValue('K'.$col, $order['paypal_email']);
                $this->excel->getActiveSheet()->setCellValue('L'.$col, $order['paypal_transaction_id']);
                $this->excel->getActiveSheet()->setCellValue('M'.$col, $order['bank_destination_name']);
                $this->excel->getActiveSheet()->setCellValue('N'.$col, $order['bank_account_name']);
                $this->excel->getActiveSheet()->setCellValue('O'.$col, $order['bank_account_number']);
                $this->excel->getActiveSheet()->setCellValue('P'.$col, $order['note']);
                $this->excel->getActiveSheet()->setCellValue('Q'.$col, $order['bank_name']);
                $this->excel->getActiveSheet()->setCellValue('R'.$col, $order['with_credit']);
                $this->excel->getActiveSheet()->setCellValue('S'.$col, $order['credit_amount']);

                if($order['payment_method']==1){
                    $payment_method = 'Bank Transfer';
                }
                else{
                    $payment_method= 'Paypal';
                }
                $this->excel->getActiveSheet()->setCellValue('H'.$col, $payment_method);

                $i=$i+1;
                $col=$col+1;
            }

            $filename='Receipt';
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename="'.$filename.'.csv"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'CSV');
            $objWriter->setDelimiter(';');
            $objWriter->setEnclosure('');
            $objWriter->setLineEnding("\r\n");
            $objWriter->setSheetIndex(0);
            $objWriter->save('php://output');

        } else {
            $this->twig->display('adminuao3hltbr0/page_listing_receipt', $this->data);
        }

        return;
    }

    public function detail($order_id)
    {

        $this->data['orders']= $this->admin_model->get_order($order_id);
        $this->data['categories']=\CategoryStatic::CATEGORIES;

        $this->twig->display('adminuao3hltbr0/page_detail/detail_receipt', $this->data);
        return;

    }

    public function confirm_payment_bank($order_id)
    {
        $this->load->model('payment_model');

        $this->data['payment']=$this->payment_model->get_payment_by_order_id($order_id);
        $this->data['status'] = \OrderStatic::ORDER_STATUS_HASH;
        $this->data['status_paid'] = \OrderStatic::ORDER_SUCCESS;
        // var_dump($this->data['status_paid']);
        // die();

        // If not bank transfer, redirect back to listing receipt
        if ($this->data['payment']->payment_method != \PaymentStatic::PAYMENT_METHOD_BANK){
            redirect('adminuao3hltbr0/page_listing_receipt');
        }

        if($this->data['payment']->status != \OrderStatic::ORDER_SUCCESS) {
            // Konfirmasi pembayaran bank transfer
            if ($this->input->post('confirm')) {
                $this->load->model('order_model');
                $order_id=$this->data['payment']->id;
                $this->admin_model->change_order_status($order_id);

                // Generate receipt after the payment confirmation
                $receipt_code = $this->order_model->generate_receipt_code($order_id);

                $this->load->model(['voucher_model', 'course_model', 'schedule_model', 'user_model']);
                $order = $this->order_model->get_order($order_id);
                $user_id = $order->user_id;
                foreach ($order->details as $detail) {
                    $course = $this->course_model->get_course($detail->class_id);
                    for ($i = 0; $i < $detail->pax; $i++) {
                        $voucher_code = $this->voucher_model->generate_voucher($course);
                        $this->voucher_model->save_from_admin($voucher_code, $detail, $user_id);

                        // Send attendance_voucher_en
                        $data_email['student'] = $this->user_model->get_by_id($user_id);
                        $data_email['teacher'] = $this->user_model->get_by_id($course->teacher_id);
                        $data_email['course'] = $course;
                        $data_email['order'] = $order;
                        $data_email['voucher_code'] = $voucher_code;
                        $data_email['schedule'] = $this->schedule_model->get_schedule_by_id($detail->schedule_id);
                        $data_email['email'] = $this->user_model->get_by_id($user_id)->email;

                        //check owner
                        $this->load->library('ciqrcode');

                        ob_start();
                        $params['data'] = $voucher_code;
                        $params['size'] = 10;
                        $params['savename'] = 'images/class/' . $voucher_code . '.png';
                        $this->ciqrcode->generate($params);
                        $this->data['qrcode'] = base64_encode(ob_get_contents());
                        ob_end_clean();
                        
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

                    // Log payment bank
                    $date = new DateTime();
                    $message = $date->format('Ymd_H:i:s') . ',1005,' .
                                $user_id . ',' .
                                'PAY' . ',' .
                                $order_id . ';' .
                                'Bank' . ';' .
                                $order->amount;
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

                }

                $payment = $this->data['payment'];
                if ($payment->with_credit)
                {
                    $this->load->model('credit_model');
                    $this->credit_model->pay($order->user_id, $payment->credit_amount, $order_id);
                }

                $this->session->set_flashdata('alert_success', "Your data has been saved");
                redirect('adminuao3hltbr0/page_listing_receipt');
            }
        }

        $this->twig->display('adminuao3hltbr0/page_detail/detail_payment_confirmation', $this->data);
    }

}
