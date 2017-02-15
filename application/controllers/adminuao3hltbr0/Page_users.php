<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "libraries/Admin_Controller.php";

class Page_users extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        if($this->check_admin_only() == false){
            redirect('adminuao3hltbr0/home');
        }
        $this->load->model('admin_model');

        // set active sidebar
        $this->data['page'] = "page users";
    }


    public function index()
    {
        if ($this->input->post("active") && $this->input->post("id")) {
            $this->data['status_active'] = $this->input->post("id");

            $this->admin_model->update_users($this->data['status_active'], \UserStatic::STATUS_ACTIVE);
            $this->data['alert']['success'] = "Your data has been saved";
        }

        if ($this->input->post("delete") && $this->input->post("id")) {
            $this->data['status_banned'] = $this->input->post("id");

            $this->admin_model->update_users($this->data['status_banned'], \UserStatic::STATUS_BANNED);
            $this->data['alert']['success'] = "Your data has been saved";
        }

        // delete user (ganti status user ke STATUS_BANNED)
        if ($this->input->post("del")) {
            $id = $this->input->post("del");
            $this->admin_model->delete_users([$id], \UserStatic::STATUS_BANNED);
            $this->data['alert']['deleted'] = "Your data has been deleted";
        }

        $users=$this->admin_model->get_users();
        $this->data['users']=$users;
        $users_status=\UserStatic::STATUS_HASH;
        $this->data['user_status']=$users_status;

        if ($this->input->post("download")) {
            
            //load our new PHPExcel library
            $this->load->library('excel');

            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setCellValue('A1', 'No');
            $this->excel->getActiveSheet()->setCellValue('B1', 'Full Name');
            $this->excel->getActiveSheet()->setCellValue('C1', 'Email');
            $this->excel->getActiveSheet()->setCellValue('D1', 'Status');
            $this->excel->getActiveSheet()->setCellValue('E1', 'Is teacher');
            $this->excel->getActiveSheet()->setCellValue('F1', 'Is student');
            $this->excel->getActiveSheet()->setCellValue('G1', 'password');
            $this->excel->getActiveSheet()->setCellValue('H1', 'type');
            $this->excel->getActiveSheet()->setCellValue('I1', 'last_login');
            $this->excel->getActiveSheet()->setCellValue('J1', 'created_at');
            $this->excel->getActiveSheet()->setCellValue('K1', 'updated_at');
            $this->excel->getActiveSheet()->setCellValue('L1', 'reg_key');
            $this->excel->getActiveSheet()->setCellValue('M1', 'forgot_key');
            $this->excel->getActiveSheet()->setCellValue('N1', 'last_send_email');
            $this->excel->getActiveSheet()->setCellValue('O1', 'pre_register');
            $this->excel->getActiveSheet()->setCellValue('P1', 'send_updates');
            $this->excel->getActiveSheet()->setCellValue('Q1', 'fb_token');
            $this->excel->getActiveSheet()->setCellValue('R1', 'fb_id');

            $this->excel->getActiveSheet()->setCellValue('S1', 'Birth date');
            $this->excel->getActiveSheet()->setCellValue('T1', 'Home Phone');
            $this->excel->getActiveSheet()->setCellValue('U1', 'Mobile Phone');
            $this->excel->getActiveSheet()->setCellValue('V1', 'gender');
            $this->excel->getActiveSheet()->setCellValue('W1', 'marital_status');
            $this->excel->getActiveSheet()->setCellValue('X1', 'academic_level');
            $this->excel->getActiveSheet()->setCellValue('Y1', 'email_notification');
            $this->excel->getActiveSheet()->setCellValue('Z1', 'nationality');
            $this->excel->getActiveSheet()->setCellValue('AA1', 'language_preference');
            $this->excel->getActiveSheet()->setCellValue('AB1', 'home_address');
            $this->excel->getActiveSheet()->setCellValue('AC1', 'business_address');
            $this->excel->getActiveSheet()->setCellValue('AD1', 'notification_newsletter');
            $this->excel->getActiveSheet()->setCellValue('AE1', 'send_updates');
            $this->excel->getActiveSheet()->setCellValue('AF1', 'fb_token');
            $this->excel->getActiveSheet()->setCellValue('AG1', 'fb_id');

            $this->excel->getActiveSheet()->setCellValue('AH1', 'payout_option');
            $this->excel->getActiveSheet()->setCellValue('AI1', 'monthly_class_envisaged ');
            $this->excel->getActiveSheet()->setCellValue('AJ1', 'goal');
            $this->excel->getActiveSheet()->setCellValue('AK1', 'objective');
            $this->excel->getActiveSheet()->setCellValue('AL1', 'website_blog');
            $this->excel->getActiveSheet()->setCellValue('AM1', 'paypal_email');
            $this->excel->getActiveSheet()->setCellValue('AN1', 'bio');
            $this->excel->getActiveSheet()->setCellValue('AO1', 'teacher_type');
            $this->excel->getActiveSheet()->setCellValue('AP1', 'job');
            $this->excel->getActiveSheet()->setCellValue('AQ1', 'identity_type');
            $this->excel->getActiveSheet()->setCellValue('AR1', 'identity_id');
            $this->excel->getActiveSheet()->setCellValue('AS1', 'bank_branch_name');
            $this->excel->getActiveSheet()->setCellValue('AT1', 'bank_account_number');
            $this->excel->getActiveSheet()->setCellValue('AU1', 'office_address');
            $this->excel->getActiveSheet()->setCellValue('AV1', 'notification_class_register');
            $this->excel->getActiveSheet()->setCellValue('AW1', 'notification_class_add_wishlist');

            $col=2;
            $i=1;
            foreach ($users as $user){
                $this->excel->getActiveSheet()->setCellValue('A'.$col, $i);
                $this->excel->getActiveSheet()->setCellValue('B'.$col, $user['first_name'] .  " " . $user['last_name']);   
                $this->excel->getActiveSheet()->setCellValue('C'.$col, $user['email']);
                $this->excel->getActiveSheet()->setCellValue('D'.$col, $users_status[$user['status']]);

                if($user['is_teacher']==1){
                    $is_teacher='Yes';
                }
                else{
                    $is_teacher='No';
                }

                if($user['is_student']==1){
                    $is_student='Yes';
                }
                else{
                    $is_student='No';
                }
                $this->excel->getActiveSheet()->setCellValue('E'.$col, $is_teacher);
                $this->excel->getActiveSheet()->setCellValue('F'.$col, $is_student);
                $this->excel->getActiveSheet()->setCellValue('G'.$col, $user['password']);
                $this->excel->getActiveSheet()->setCellValue('H'.$col, $user['type']);
                $this->excel->getActiveSheet()->setCellValue('I'.$col, $user['last_login']);
                $this->excel->getActiveSheet()->setCellValue('J'.$col, $user['created_at']);
                $this->excel->getActiveSheet()->setCellValue('K'.$col, $user['updated_at']);
                $this->excel->getActiveSheet()->setCellValue('L'.$col, $user['reg_key']);
                $this->excel->getActiveSheet()->setCellValue('M'.$col, $user['forgot_key']);
                $this->excel->getActiveSheet()->setCellValue('N'.$col, $user['last_send_email']);
                $this->excel->getActiveSheet()->setCellValue('O'.$col, $user['pre_register']);
                $this->excel->getActiveSheet()->setCellValue('P'.$col, $user['send_updates']);
                $this->excel->getActiveSheet()->setCellValue('Q'.$col, $user['fb_token']);
                $this->excel->getActiveSheet()->setCellValue('R'.$col, $user['fb_id']);

                $this->excel->getActiveSheet()->setCellValue('S'.$col, $user['birth_date']);
                $this->excel->getActiveSheet()->setCellValue('T'.$col, $user['home_phone']);
                $this->excel->getActiveSheet()->setCellValue('U'.$col, $user['mobile_phone']);
                $this->excel->getActiveSheet()->setCellValue('V'.$col, $user['gender']);
                $this->excel->getActiveSheet()->setCellValue('W'.$col, $user['marital_status']);
                $this->excel->getActiveSheet()->setCellValue('X'.$col, $user['academic_level']);
                $this->excel->getActiveSheet()->setCellValue('Y'.$col, $user['email_notification']);
                $this->excel->getActiveSheet()->setCellValue('Z'.$col, $user['nationality']);
                $this->excel->getActiveSheet()->setCellValue('AA'.$col, $user['language_preference']);
                $this->excel->getActiveSheet()->setCellValue('AB'.$col, $user['home_address']);
                $this->excel->getActiveSheet()->setCellValue('AC'.$col, $user['business_address']);
                $this->excel->getActiveSheet()->setCellValue('AD'.$col, $user['notification_newsletter']);
                $this->excel->getActiveSheet()->setCellValue('AE'.$col, $user['send_updates']);
                $this->excel->getActiveSheet()->setCellValue('AF'.$col, $user['fb_token']);
                $this->excel->getActiveSheet()->setCellValue('AG'.$col, $user['fb_id']);

                $user_bio=str_replace("\n", " ", strip_tags($user['bio']));
                
                $this->excel->getActiveSheet()->setCellValue('AH'.$col, $user['payout_option']);
                $this->excel->getActiveSheet()->setCellValue('AI'.$col, $user['monthly_class_envisaged']);
                $this->excel->getActiveSheet()->setCellValue('AJ'.$col, $user['goal']);
                $this->excel->getActiveSheet()->setCellValue('AK'.$col, $user['objective']);
                $this->excel->getActiveSheet()->setCellValue('AL'.$col, $user['website_blog']);
                $this->excel->getActiveSheet()->setCellValue('AM'.$col, $user['paypal_email']);
                $this->excel->getActiveSheet()->setCellValue('AN'.$col, $user_bio);
                $this->excel->getActiveSheet()->setCellValue('AO'.$col, $user['teacher_type']);
                $this->excel->getActiveSheet()->setCellValue('AP'.$col, $user['job']);
                $this->excel->getActiveSheet()->setCellValue('AQ'.$col, $user['identity_type']);
                $this->excel->getActiveSheet()->setCellValue('AR'.$col, $user['identity_id']);
                $this->excel->getActiveSheet()->setCellValue('AS'.$col, $user['bank_branch_name']);
                $this->excel->getActiveSheet()->setCellValue('AT'.$col, $user['bank_account_number']);
                $this->excel->getActiveSheet()->setCellValue('AU'.$col, $user['office_address']);
                $this->excel->getActiveSheet()->setCellValue('AV'.$col, $user['notification_class_register']);
                $this->excel->getActiveSheet()->setCellValue('AW'.$col, $user['notification_class_add_wishlist']);

                $i=$i+1;   
                $col=$col+1;       
            }

            $filename='List Users';

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
            $this->twig->display('adminuao3hltbr0/page_users', $this->data);
        }

        return;
    }

    public function detail($user_id)
    {
        $this->load->model('user_model');

        // set active sidebar
        $this->data['page'] = "page user detail";
        $this->data['user'] = $this->user_model->get_user(['users.id' => $user_id]);

        $this->twig->display('adminuao3hltbr0/page_detail/detail_users', $this->data);
        return;
    }

    public function edit($user_id)
    {
        $this->load->model('user_model');
        $user = $this->user_model->get_by_id($user_id);
        $this->data['user'] = $user;
        $this->data['is_teacher'] = $user->is_teacher;
        $this->load->model('bank_model');
        $this->data['banks'] = $this->bank_model->get_banks();
        $this->data['teacher_details'] = $this->user_model->get_teacher_details(['user_id' => $user_id]);

        #redirect if null
        if($this->data['user']==NULL){
            redirect('adminuao3hltbr0/home');
        }

        if( $this->data['user_login_admin']['type'] != \AdminStatic::TYPE_ADMIN and $this->data['user_login_admin']['admin_id'] != $user_id) {
            redirect('adminuao3hltbr0/home');
        }

        if ($this->is_post()) {
            $post = $this->input->post();
            $post['id'] = (int)$user_id;

            // if not change picture, set profile_pic to default
            if (empty($_FILES['avatar']['name']) == false) {
                $post['profile_pic'] = $this->upload_avatar();
            } else {
                $post['profile_pic'] = $user->profile_pic;
            }

            // untuk mengisi lagi form edit user
            $this->data['user'] = $post;
            $this->data['teacher_details'] = $this->user_model->get_teacher_details(['user_id' => $user_id]);

            if ($this->admin_model->edit_user($user_id, $post)) {
                $this->session->set_flashdata('alert_success', "Your data has been saved");
                redirect(current_url());
            }

            // save error validation to variable
            if (validation_errors()) {
                $this->data['validation_error'] = validation_errors();
            }
        }

        $this->twig->display('adminuao3hltbr0/page_detail/edit_user', $this->data);
    }

}
