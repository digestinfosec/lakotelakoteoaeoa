<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "libraries/Admin_Controller.php";

class Page_skillagogo_commission extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        if($this->check_admin_only() == false){
            redirect('adminuao3hltbr0/home');
        }

        // set active sidebar
        $this->data['page'] = "page commission";
    }


    public function index()
    {
        $this->load->model('payout_model');
        $currency = $this->input->get("currency");

        $payouts=$this->payout_model->get_all_payout_lists();
        $this->data['payouts']=$payouts;

        if ($this->input->post("download")) {
            
            //load our new PHPExcel library
            $this->load->library('excel');

            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);

            $this->excel->getActiveSheet()->setCellValue('A1', 'No');
            $this->excel->getActiveSheet()->setCellValue('B1', 'Teacher\'s Name');
            $this->excel->getActiveSheet()->setCellValue('C1', 'Currency');
            $this->excel->getActiveSheet()->setCellValue('D1', 'Class ID');
            $this->excel->getActiveSheet()->setCellValue('E1', 'Payment Date');
            $this->excel->getActiveSheet()->setCellValue('F1', 'Quantity');
            $this->excel->getActiveSheet()->setCellValue('G1', 'Payout Amount');
            $this->excel->getActiveSheet()->setCellValue('H1', 'Skillagogo Commission');
            $this->excel->getActiveSheet()->setCellValue('I1', 'Total');

            $col=2;
            $i=1;
            foreach ($payouts as $payout){
                $this->excel->getActiveSheet()->setCellValue('A'.$col, $i);
                $this->excel->getActiveSheet()->setCellValue('B'.$col, $payout->teacher_first_name .  " " . $payout->teacher_last_name);   
                $this->excel->getActiveSheet()->setCellValue('C'.$col, $payout->currency);
                $this->excel->getActiveSheet()->setCellValue('D'.$col, $payout->unique_id);
                if ($payout->payment_date == "0000-00-00") {
                    $payment_date = "-";
                } else {
                    $payment_date = $payout->payment_date;
                }
                $this->excel->getActiveSheet()->setCellValue('E'.$col, $payment_date);
                $this->excel->getActiveSheet()->setCellValue('F'.$col, $payout->total_pax);
                $this->excel->getActiveSheet()->setCellValue('G'.$col, $payout->amount * $payout->total_pax);
                $this->excel->getActiveSheet()->setCellValue('H'.$col, $payout->skillagogo_commission * $payout->total_pax);
                $this->excel->getActiveSheet()->setCellValue('I'.$col, ($payout->skillagogo_commission + $payout->amount) * $payout->total_pax);

                $i=$i+1;   
                $col=$col+1;       
            }

            $filename='Payout and Commission';

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
            $this->twig->display('adminuao3hltbr0/page_skillagogo_commission', $this->data);
        }
    }

    public function detail($course_id)
    {
        $this->load->model('course_model');
        $this->load->model('payout_model');
        $this->data['course']=$this->course_model->get_course($course_id, false, false);
        $this->data['payouts']=$this->payout_model->get_payout_by_course_id($course_id);
        $this->twig->display('adminuao3hltbr0/page_teachers_payout_course_invoice', $this->data);
        return;
    }

}
