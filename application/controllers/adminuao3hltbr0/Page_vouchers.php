<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "libraries/Admin_Controller.php";

class Page_vouchers extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        if($this->check_admin_only() == false){
            redirect('adminuao3hltbr0/home');
        }

        // set active sidebar
        $this->data['page'] = "page vouchers";
    }


    public function index()
    {
        $this->load->model('voucher_model');
        $vouchers=$this->voucher_model->get_voucher_lists();
        $this->data['vouchers']=$vouchers;

        if ($this->input->post("download")) {

            //load our new PHPExcel library
            $this->load->library('excel');

            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);

            $this->excel->getActiveSheet()->setCellValue('A1', 'No');
            $this->excel->getActiveSheet()->setCellValue('B1', 'Voucher Id');
            $this->excel->getActiveSheet()->setCellValue('C1', 'Teacher');
            $this->excel->getActiveSheet()->setCellValue('D1', 'Created at');
            $this->excel->getActiveSheet()->setCellValue('E1', 'Updated at');
            $this->excel->getActiveSheet()->setCellValue('F1', 'Currency');
            $this->excel->getActiveSheet()->setCellValue('G1', 'Amount');
            $this->excel->getActiveSheet()->setCellValue('H1', 'Attendee');
            $this->excel->getActiveSheet()->setCellValue('I1', 'Is Redeemed');

            $col=2;
            $i=1;
            foreach ($vouchers as $voucher){
                $this->excel->getActiveSheet()->setCellValue('A'.$col, $i);
                $this->excel->getActiveSheet()->setCellValue('B'.$col, $voucher->voucher_code);
                $this->excel->getActiveSheet()->setCellValue('C'.$col, $voucher->teacher_first_name .  " " . $voucher->teacher_last_name);
                $this->excel->getActiveSheet()->setCellValue('D'.$col, $voucher->created_at);
                $this->excel->getActiveSheet()->setCellValue('E'.$col, $voucher->updated_at);
                $this->excel->getActiveSheet()->setCellValue('F'.$col, $voucher->currency);
                $this->excel->getActiveSheet()->setCellValue('G'.$col, $voucher->amount);
                $this->excel->getActiveSheet()->setCellValue('H'.$col, $voucher->attendee_first_name . " ". $voucher->attendee_last_name);

                if ($voucher->is_redeemed == 1){
                    $is_redeemed = "Yes";
                }
                else if($voucher->is_redeemed == 0 and $voucher->status == 2){
                    $is_redeemed = "Not Attended";
                }
                else{
                    $is_redeemed = "Not Yet";
                }

                $this->excel->getActiveSheet()->setCellValue('I'.$col, $is_redeemed);

                $i=$i+1;
                $col=$col+1;
            }

            $filename='Vouchers';
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
            $this->twig->display('adminuao3hltbr0/page_vouchers', $this->data);
        }
        return;
    }
}
