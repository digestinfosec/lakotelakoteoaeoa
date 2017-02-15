<?php

require APPPATH . 'libraries/Dashboard_Controller.php';

class Course extends Dashboard_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->redirect_if_not_student();
        $this->load->model('course_model');
    }

    public function index()
    {
        $student_id = $this->session->userdata('login')['user_id'];

       // pagination settings
        $this->load->library('pagination');
        $config['base_url'] = '/dashboard/student/course/index';
        $config['total_rows'] = count($this->course_model->get_student_current_courses($student_id));
        $config['per_page'] = 5;

        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        // get courses
        $option['offset'] = $this->uri->segment(5);
        $option['limit'] = $config['per_page'];
        $this->data['courses'] = $this->course_model->get_student_current_courses($student_id, $option);
        $this->data['type_hash'] = CourseStatic::TYPE_HASH;

        $this->data['menu_left'] = "student_course";
        $this->data['menu_top'] = "current";
        $this->data['is_current'] = 1;
        $this->twig->display('dashboard/student/course/schedule', $this->data);
    }

    public function past()
    {
        $student_id = $this->session->userdata('login')['user_id'];

        // pagination settings
        $this->load->library('pagination');
        $config['base_url'] = '/dashboard/student/course/past';
        $config['total_rows'] = count($this->course_model->get_student_past_courses($student_id));
        $config['per_page'] = 5;

        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        // get courses
        $option['offset'] = $this->uri->segment(5);
        $option['limit'] = $config['per_page'];
        $this->data['courses'] = $this->course_model->get_student_past_courses($student_id, $option);
        $this->data['type_hash'] = CourseStatic::TYPE_HASH;

        $this->data['menu_left'] = "student_course";
        $this->data['menu_top'] = "past";
        $this->data['is_past'] = 1;
        $this->twig->display('dashboard/student/course/schedule', $this->data);
    }

    public function cancelled()
    {
        $student_id = $this->session->userdata('login')['user_id'];

        // pagination settings
        $this->load->library('pagination');
        $config['base_url'] = '/dashboard/student/course/cancelled';
        $config['total_rows'] = count($this->course_model->get_student_cancelled_courses($student_id));
        $config['per_page'] = 5;

        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        // get courses
        $option['offset'] = $this->uri->segment(5);
        $option['limit'] = $config['per_page'];
        $this->data['courses'] = $this->course_model->get_student_cancelled_courses($student_id, $option);
        $this->data['type_hash'] = CourseStatic::TYPE_HASH;

        $this->data['menu_left'] = "student_course";
        $this->data['menu_top'] = "cancelled";
        $this->data['is_cancelled'] = 1;
        $this->twig->display('dashboard/student/course/schedule', $this->data);
    }

    public function become_teacher()
    {
        if ($this->input->get("confirm")) {
            if ($this->input->get('confirm') == 'true') {
                $this->load->model('user_model');
                $this->user_model->become_teacher();
                $this->update_session($this->user_model->get_user(['email' => $this->session->userdata('login')['email']]));
                redirect('dashboard/profile/teacher');
            }
        }

        redirect('/');

    }

    public function show_voucher($voucher_code)
    {
        $this->load->model("course_model");

        $register = $this->course_model->get_register_information($voucher_code);

        if (!$register) {
            show_404();
        }

        // Check owner
        if ($register->id != $this->session->userdata('login')['user_id']){
            show_error(line('error_no_permission','controller_js'), '403', 'Forbidden Access');
        }

        //check owner
        $this->load->library('ciqrcode');

        ob_start();
        $params['data'] = $voucher_code;
        $params['size'] = 10;
        $params['savename'] = 'images/class/' . $voucher_code . '.png';
        $this->ciqrcode->generate($params);
        $this->data['qrcode'] = base64_encode(ob_get_contents());
        ob_end_clean();

        $this->data['course'] = $this->course_model->get_course($register->class_id);
        $this->data['voucher_code'] = $voucher_code;
        $this->twig->display('dashboard/student/course/voucher', $this->data);
    }

    public function cancel()
    {
        // If not a post
        if ($this->is_post() == false) {
            show_error(line('error_no_permission','controller_js'), '404', 'Not Found');
        }

        // Get registration and voucher information
        $this->load->model(['course_model', 'voucher_model', 'user_model', 'schedule_model', 'order_model']);
        $voucher_code = $this->input->post('voucher_code');
        $register = $this->course_model->get_register_information($voucher_code);
        $voucher = $this->voucher_model->get($voucher_code);

        // var_dump($register);
        // var_dump($voucher);

        // Check ID
        if ($register->user_id != $this->session->userdata('login')['user_id']){
            show_error(line('error_no_permission','controller_js'), '403', 'Forbidden Access');
        }

        // Check if start date of class is < 5 minutes
        $this->load->model(['schedule_model']);
        $this->load->helper('date');
        $course = $this->course_model->get_course($voucher->class_id);
        $start_time = new DateTime($this->schedule_model->get_first_time($course->id));
        $interval = new DateInterval("PT5H");
        $interval->invert = 1;
        $start_time = new DateTime($start_time->add($interval)->format("Y-m-d"));
        $now = new DateTime(unix_to_human(now(), TRUE, 'eu'));
        if ($now > $start_time) {
            $this->session->set_flashdata('alert_error', line('error_course_cancel_1','controller_js'));
            redirect('dashboard/student/course');
            return;
        }

        // Check status cancellation
        if ($voucher->status == VoucherStatic::VOUCHER_CONVERTED) {
            $this->session->set_flashdata('alert_error', line('error_course_cancel_2','controller_js'));
            redirect('dashboard/student/course');
            return;
        }

        // Get cancellation reason
        $reason = $this->input->post('cancel_reason');

        //////////////////////////////
        //// ORDER CANCELLATION //////
        //////////////////////////////
        $this->load->model('credit_model');

        // Convert payment to skillagogo credit
        $credit_id = $this->credit_model->convert_to_credit($register, $voucher, \CreditStatic::REASON_STUDENT_CANCELLED, \CreditStatic::HISTORY_CANCELLATION_STUDENT);
        $this->voucher_model->update($voucher->voucher_id, ['status' => \VoucherStatic::VOUCHER_CONVERTED, 'cancel_reason' => $reason]);

        // Reupdate available seat left
        $order_detail = $this->order_model->get_detail($voucher->order_detail_id);
        $schedule = $this->schedule_model->get_schedule_by_id($order_detail->schedule_id);

        $this->load->model('course_model');
        $this->load->model('schedule_model');
        $course_type = $this->course_model->get_course($order_detail->class_id, false, false)->type;
        if ($course_type == 3) { // if staged 
            $all_schedules = $this->schedule_model->get_schedules($order_detail->class_id);
            foreach ($all_schedules as $staged_schedule) {
                $this->schedule_model->revoke_seat($staged_schedule->schedule_id, $staged_schedule->available_seat_left);
            }
        }
        else { // repeated and single
            $this->schedule_model->revoke_seat($order_detail->schedule_id, $schedule->available_seat_left);
        }

        // Send credit conversion email to student
        $data_email['student'] = $this->user_model->get_by_id($register->user_id);
        $data_email['credit'] = $this->credit_model->get_credit_by_id($credit_id);
        $data_email['email'] = $this->user_model->get_by_id($register->user_id)->email;
        $this->send_notification_email($data_email, line('email_course_cancel_1','controller_js'), 'email/skillagogo_credit_conversion_en');

        // $this->twig->display("email/skillagogo_credit_conversion_en", $data_email);
        // return;

        // Send class cancellation confirmation email to student
        $data_email['student'] = $this->user_model->get_by_id($register->user_id);
        $data_email['course'] = $course;
        $data_email['teacher'] = $this->user_model->get_by_id($course->teacher_id);
        $data_email['schedules'] = $this->schedule_model->get_schedules($course->id);
        $this->send_notification_email($data_email, line('email_course_cancel_2','controller_js'), 'email/class_cancellation_by_student_en');

        // $this->twig->display("email/class_cancellation_by_student_en", $data_email);
        // return;

        // Log
        $date = new DateTime();
        $message = $date->format('Ymd_H:i:s') . ',1005,' .
            $this->session->userdata('login')['user_id'] . ',' .
            'CANCELCLASSSTUDENT' . ',' .
            $course->course_id . ';' .
            $reason . ';' . 'seat_left:' .(string)($schedule->available_seat_left+1);
        $this->log_activity_data_record($message);


        $this->session->set_flashdata('alert_success', line('success_course_cancel','controller_js'));
        redirect('dashboard/student/course');
    }

    public function change_schedule($course_id)
    {
        // Change schedule, only for repeated class

        // Send schedule_change_student_en.twig
    }

    public function reject_changed_schedule($reject_code)
    {

    }

}

