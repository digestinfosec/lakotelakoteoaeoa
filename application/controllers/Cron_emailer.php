<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Cron_emailer extends MY_Controller
{
    function __construct()
    {
        parent::__construct();

        // can only be called from the command line
        if (!$this->input->is_cli_request()) {
            redirect('/');
        }

        // load any required models
        $this->load->model('order_model');
        $this->load->model('schedule_model');
        $this->load->model('course_model');
        $this->load->model('user_model');
        $this->load->model('voucher_model');
        $this->load->model('payout_model');
        $this->load->model('credit_model');
    }

    // EXECUTED AT today 00:00:00!!
    function emailer()
    {
        $date = date("Y-m-d", strtotime("-1 day"));
        $yesterday_schedules = $this->schedule_model->get_schedules_from_date($date);
        $date = date("Y-m-d", strtotime("+1 day"));
        $tomorrow_schedules = $this->schedule_model->get_schedules_from_date($date);
        $date = date("Y-m-d", strtotime("today"));
        $today_schedules = $this->schedule_model->get_schedules_from_date($date);
        // $date = date("Y-m-d", strtotime("+1 month"));
        // $next_month_schedules = $this->schedule_model->get_schedules_from_date($date);
        // $date = date("Y-m-d", strtotime("+14 days"));
        // $next_two_weeks_schedules = $this->schedule_model->get_schedules_from_date($date);
        // $date = date("Y-m-d", strtotime("+5 days"));
        // $next_five_days_schedules = $this->schedule_model->get_schedules_from_date($date);
        // $date = date("Y-m-d", strtotime("-3 days"));
        // $after_three_days_schedules = $this->schedule_model->get_schedules_from_date($date);
        
        // These emails are sent after each schedule/venue change!
        // foreach ($yesterday_schedules as $schedule) {

        //     $course = $this->course_model->get_course($schedule->class_id, false, false);
        //     $orders = $this->order_model->get_orders_from_class($schedule->class_id);

        //     if ($course->changed_schedule) {
        //         // class_creation_modification_schedule_student_en.twig
        //         foreach ($orders as $order) {

        //             $send = $this->user_model->get_user(['user_id' => $order->user_id]);
        //             $course = $this->course_model->get_course($schedule->class_id, false, false);
        //             $schedule_address = $this->schedule_model->get_schedules($schedule->class_id);
        //             $send->course = $course;
        //             $send->schedules = $schedule_address;

        //             $this->send_notification_email((array)$send, 'Class Schedule/Venue Change Notification',
        //                 'email/class_creation_modification_schedule_student_en');
        //         }
        //     }

        //     if ($course->changed_venue) {
        //         // class_creation_modification_venue_student_en.twig
        //         foreach ($orders as $order) {
        //             $send = $this->user_model->get_user(['user_id' => $order->user_id]);
        //             $course = $this->course_model->get_course($schedule->class_id, false, false);
        //             $schedule_address = $this->schedule_model->get_schedules($schedule->class_id);
        //             $send->course = $course;
        //             $send->schedules = $schedule_address;

        //             $this->send_notification_email((array)$send, 'Class Schedule/Venue Change Notification',
        //                 'email/class_creation_modification_venue_student_en');                    
        //         }
        //     }

        //     echo ".";
        // }

        // var_dump($date);

        foreach ($tomorrow_schedules as $schedule) {
            // echo $schedule->class_id . "\n";
            $orders = $this->order_model->get_orders_from_class($schedule->class_id);
            // echo count($orders) . "\n";

            foreach ($orders as $order) {

                // if ($order->user_id != 1) continue;

                // class_reminder_student_en.twig
                $send = $this->user_model->get_user(['user_id' => $order->user_id]);
                $course = $this->course_model->get_course($schedule->class_id, false, false);
                $schedule_address = $this->schedule_model->get_schedules($schedule->class_id);
                $send->teacher = $this->user_model->get_by_id($course->teacher_id);
                $send->course = $course;
                $send->schedules = $schedule_address;
                $this->send_notification_email((array)$send, line('cron_email_reminder','controller_js'), 'email/class_reminder_student_en');

                // class_reminder_teacher_en.twig
                $send = $this->user_model->get_user(['user_id' => $course->teacher_id]);
                $course = $this->course_model->get_course($schedule->class_id, false, false);
                $schedule_address = $this->schedule_model->get_schedules($schedule->class_id);
                $send->course = $course;
                $send->schedules = $schedule_address;
                $this->send_notification_email((array)$send, line('cron_email_reminder','controller_js'), 'email/class_reminder_teacher_en');
            }
        }

        // Get all payouts with classes redeemed today
        $payouts = $this->payout_model->get_payouts_yesterday();
        foreach ($payouts as $payout) {
            // your_class_delivery_en.twig
            // Send at the end of the day if the teacher inputs vouchers
            $send = $this->user_model->get_user(['user_id' => $payout->teacher_id]);
            $course = $this->course_model->get_course($payout->class_id, false, false);
            $schedule_address = $this->schedule_model->get_schedules($payout->class_id);
            $send->course = $course;
            $send->schedules = $schedule_address;

            $invoice = $this->payout_model->get_payout_by_invoice_code($payout->invoice_code);
            $this->data['payout'] = $invoice;
            $this->data['vouchers'] = $this->voucher_model->get_by_invoice_code($payout->invoice_code);
            $this->data['total'] = $this->voucher_model->get_totals_by_invoice_code($payout->invoice_code);
            $this->data['with_buttons'] = false;
            $html = $this->twig->render('dashboard/teacher/payout/invoice', $this->data);
            $attachments = [$payout->invoice_code . ".html" => $html];
            $this->send_notification_email((array)$send, line('cron_email_class_delivery','controller_js'), 'email/your_class_delivery_en', $attachments); 
        }

        // Skillagogo is expiring
        // 5 days before
        $credits = $this->credit_model->get_credits_expiring_five_days_later();
        foreach ($credits as $credit) {
            // skillagogo_credit_is_expiring_en.twig
            $send = $this->user_model->get_user(['user_id' => $credit->user_id]);
            $send->credit = $credit;
            $this->send_notification_email((array)$send, line('cron_email_credit_expiring','controller_js'), 'email/skillagogo_credit_is_expiring_en');
        }

    }
}

