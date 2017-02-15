<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "libraries/Admin_Controller.php";

class Page_teacher_fees_payment extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        if($this->check_admin_only() == false){
            redirect('adminuao3hltbr0/home');
        }

        // set active sidebar
        $this->data['page'] = "page teacher fees";
    }


    public function index()
    {
        $this->load->model('payout_model');
        $payouts=$this->payout_model->get_payout_lists();
        $this->data['payouts']=$payouts;

        if ($this->input->post("download")) {
            
            //load our new PHPExcel library
            $this->load->library('excel');

            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);

            $this->excel->getActiveSheet()->setCellValue('A1', 'No');
            $this->excel->getActiveSheet()->setCellValue('B1', 'Teacher');
            $this->excel->getActiveSheet()->setCellValue('C1', 'Currency');
            $this->excel->getActiveSheet()->setCellValue('D1', 'Prev Month Balance');
            $this->excel->getActiveSheet()->setCellValue('E1', 'Prev Month Status');
            $this->excel->getActiveSheet()->setCellValue('F1', 'Current Month Balance');

            $col=2;
            $i=1;
            foreach ($payouts as $payout){
                $this->excel->getActiveSheet()->setCellValue('A'.$col, $i);
                $this->excel->getActiveSheet()->setCellValue('B'.$col, $payout['first_name'] .  " " . $payout['last_name']);   
                $this->excel->getActiveSheet()->setCellValue('C'.$col, $payout['currency']);
                $this->excel->getActiveSheet()->setCellValue('D'.$col, $payout['total_last_month']);

                if($payout['total_num_payout_last_month'] == 0){
                    $prev_month_status='-';
                }                
                else{
                    if ($payout['total_num_payout_last_month'] == $payout['total_status_payout_last_month']){
                        $prev_month_status='All Paid';
                    }
                    else{
                        $prev_month_status='Pending';
                    }
                }
                $this->excel->getActiveSheet()->setCellValue('E'.$col, $prev_month_status);

                $this->excel->getActiveSheet()->setCellValue('F'.$col, $payout['total_cur_month']);

                $i=$i+1;   
                $col=$col+1;       
            }

            $filename='Payout';

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
            $this->data['status_paid']=\PayoutStatic::STATUS_PAID;
            $this->twig->display('adminuao3hltbr0/page_teachers_payout', $this->data);
        }

        return;
    }

    public function detail($teacher_id)
    {
        $this->load->model('payout_model');
        $this->load->model('user_model');
        $this->load->model('course_model');

        $currency = $this->input->get("currency");

        if ($this->input->post("paid") && $this->input->post("id")) {
            $this->data['status_paid'] = $this->input->post("id");
            $currency = $this->input->post("currency");

            $this->payout_model->update_payout_status($this->data['status_paid'], \PayoutStatic::STATUS_PAID);
            $this->data['alert']['success'] = "Your data has been saved";

            foreach ($this->input->post("id") as $id)
            {
                // Send successful_payout_transfer_en
                $payout = $this->payout_model->get_payout_by_id($id);
                $teacher = $this->user_model->get_by_id($payout->teacher_id);
                $course = $this->course_model->get_course($payout->class_id, true, false);
                $schedules = $course->schedules;
                $data_email['teacher'] = $teacher;
                $data_email['course'] = $course;
                $data_email['email'] = $teacher->email;
                $data_email['schedules'] = $schedules;
                $this->send_notification_email($data_email, line('email_make_payout','controller_js'), 'email/successful_payout_transfer_en');
            }
        }

        if ($this->input->post("pending") && $this->input->post("id")) {
            $this->data['status_paid'] = $this->input->post("id");
            $currency = $this->input->post("currency");

            $this->payout_model->update_payout_status($this->data['status_paid'], \PayoutStatic::STATUS_PENDING);
            $this->data['alert']['success'] = "Your data has been saved";
        }

        $this->data['prev_month_payouts']=$this->payout_model->get_prev_month_payout_lists($teacher_id, $currency);
        $this->data['cur_month_payouts']=$this->payout_model->get_cur_month_payout_lists($teacher_id, $currency);
        $this->data['teacher']=$this->user_model->get_teacher($teacher_id);
        $this->data['currency']=$currency;

        $this->data['status_paid']=\PayoutStatic::STATUS_PAID;
        $this->twig->display('adminuao3hltbr0/page_teacher_fees_payment', $this->data);
        return;
    }

}
