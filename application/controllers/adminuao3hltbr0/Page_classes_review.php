<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "libraries/Admin_Controller.php";

class Page_classes_review extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        if($this->check_admin_review() == false){
            redirect('adminuao3hltbr0/home');
        }
        $this->load->model('course_model');
        $this->load->model('admin_model');

        // set active sidebar
        $this->data['page'] = "page classes review";
    }


    public function index()
    {

        $option['all_country']='';
        $option['publish_status']=\CourseStatic::PUBLISH_SUCCESS;
        $courses = $this->course_model->get_courses($option);
        $this->data['courses'] = $courses;

        // delete multiple class (ganti publish status ke PUBLISH_DELETED)
        if ($this->input->post("delete") && $this->input->post("id")) {
            $this->data['delete'] = $this->input->post("id");
            $this->admin_model->delete_classes($this->data['delete']);
            $this->data['alert']['deleted'] = "Your data has been deleted";
        }

        // delete class (ganti publish status ke PUBLISH_DELETED)
        if ($this->input->post("del")) {
            $id = $this->input->post("del");
            $this->admin_model->delete_classes([$id]);
            $this->data['alert']['deleted'] = "Your data has been deleted";
        }

        if ($this->input->post("download")) {

            //load our new PHPExcel library
            $this->load->library('excel');

            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);

            $this->excel->getActiveSheet()->setCellValue('A1', 'No');
            $this->excel->getActiveSheet()->setCellValue('B1', 'Unique Id');
            $this->excel->getActiveSheet()->setCellValue('C1', 'Teacher');      
            $this->excel->getActiveSheet()->setCellValue('D1', 'Created at');
            $this->excel->getActiveSheet()->setCellValue('E1', 'Updated at');
            $this->excel->getActiveSheet()->setCellValue('F1', 'Category');
            $this->excel->getActiveSheet()->setCellValue('G1', 'Type');    
            $this->excel->getActiveSheet()->setCellValue('H1', 'Currency');
            $this->excel->getActiveSheet()->setCellValue('I1', 'Price');
            $this->excel->getActiveSheet()->setCellValue('J1', 'Available seat');

            $col=2;
            $i=1;
            foreach ($courses as $course){
                $this->excel->getActiveSheet()->setCellValue('A'.$col, $i);
                $this->excel->getActiveSheet()->setCellValue('B'.$col, $course->unique_id);
                $this->excel->getActiveSheet()->setCellValue('C'.$col, $course->first_name .  " " . $course->last_name);
                $this->excel->getActiveSheet()->setCellValue('D'.$col, $course->created_at);
                $this->excel->getActiveSheet()->setCellValue('E'.$col, $course->updated_at);
                $this->excel->getActiveSheet()->setCellValue('F'.$col, $course->category_name);
                $this->excel->getActiveSheet()->setCellValue('G'.$col, $course->type);
                $this->excel->getActiveSheet()->setCellValue('H'.$col, $course->currency);
                $this->excel->getActiveSheet()->setCellValue('I'.$col, $course->price);
                $this->excel->getActiveSheet()->setCellValue('J'.$col, $course->available_seat);

                // if ($voucher['is_redeemed'] == 1){
                //     $is_redeemed = "Yes";
                // }
                // else if($voucher['is_redeemed'] == 0 and $voucher['status'] == 2){
                //     $is_redeemed = "Not Attended";
                // }
                // else{
                //     $is_redeemed = "Not Yet";
                // }



                $i=$i+1;
                $col=$col+1;
            }

            $filename='Courses';
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename="'.$filename.'.csv"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'CSV');
            $objWriter->setDelimiter(';');
            $objWriter->setEnclosure('');
            $objWriter->setLineEnding("\r\n");
            $objWriter->setSheetIndex(0);
            $objWriter->save('php://output');
        } else{
            $this->twig->display('adminuao3hltbr0/page_classes_review', $this->data);
        return;
        }
    }

}
