<?php

class Payout_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Get all payouts
    public function get_payout_lists()
    {
        $this->db->select('payouts.teacher_id, teachers.first_name, teachers.last_name, payouts.currency');
        $this->db->select('sum(CASE WHEN payouts.created_at <= LAST_DAY(curdate() - INTERVAL 1 MONTH) AND payouts.created_at >= DATE_FORMAT(CURDATE() - INTERVAL 1 MONTH,"%Y-%m-01") then payouts.amount else 0 end) as total_last_month');
        $this->db->select('sum(CASE WHEN payouts.created_at <= LAST_DAY(curdate()) AND payouts.created_at >= DATE_FORMAT(CURDATE(),"%Y-%m-01") then payouts.amount else 0 end) as total_cur_month');
        $this->db->select('sum(CASE WHEN payouts.created_at <= LAST_DAY(curdate()-INTERVAL 1 MONTH) then 1 else 0 end) as total_num_payout_last_month');
        $this->db->select('sum(CASE WHEN payouts.created_at <= LAST_DAY(curdate()-INTERVAL 1 MONTH) then payouts.status else 0 end) as total_status_payout_last_month');
        $this->db->join('users as teachers', 'teachers.id=payouts.teacher_id');
        $this->db->group_by('teacher_id, currency');
        $query=$this->db->get('payouts');
        return $query->result_array();
    }

    // Get all payouts with teacher ID and currency
    public function get_payout_lists_with_id_cur($teacher_id, $currency)
    {
        $this->db->select('payouts.teacher_id, payouts.currency, payouts.invoice_code');
        $this->db->select('sum(CASE WHEN payouts.created_at <= LAST_DAY(curdate() - INTERVAL 1 MONTH) AND payouts.created_at >= DATE_FORMAT(CURDATE() - INTERVAL 1 MONTH,"%Y-%m-01") then payouts.amount else 0 end) as total_last_month');
        $this->db->select('sum(CASE WHEN payouts.created_at <= LAST_DAY(curdate()) AND payouts.created_at >= DATE_FORMAT(CURDATE(),"%Y-%m-01") then payouts.amount else 0 end) as total_cur_month');
        $this->db->select('sum(CASE WHEN payouts.created_at <= LAST_DAY(curdate()-INTERVAL 1 MONTH) then 1 else 0 end) as total_num_payout_last_month');
        $this->db->select('sum(CASE WHEN payouts.created_at <= LAST_DAY(curdate()-INTERVAL 1 MONTH) then payouts.status else 0 end) as total_status_payout_last_month');
        $this->db->where('payouts.teacher_id', $teacher_id);
        $this->db->where('payouts.currency', $currency);
        $query=$this->db->get('payouts');
        return $query->row();
    }

    // Get previous month payout list for a teacher
    public function get_prev_month_payout_lists($teacher_id, $currency)
    {
        $this->db->select('classes.*, payouts.*, vouchers.*, payouts.status as payout_status, vouchers.status as voucher_status, users.first_name as attendee_first_name, users.last_name as attendee_last_name, payouts.id as payout_id, classes.title as class_name, classes.id as class_id');
        $this->db->where('payouts.created_at <=', date('Y-m-d', strtotime('last day of last month')) );
        $this->db->where('payouts.created_at >=', date('Y-m-d', strtotime('first day of last month')) );
        $this->db->where('payouts.teacher_id', $teacher_id);
        $this->db->where('payouts.currency', $currency);
        $this->db->join('class_attendees', 'class_attendees.payout_id=payouts.id');
        $this->db->join('classes', 'class_attendees.class_id=classes.id');
        $this->db->join('vouchers', 'class_attendees.voucher_id=vouchers.id');
        $this->db->join('users', 'users.id=vouchers.user_id');
        $query=$this->db->get('payouts');
        return $query->result();
    }

    // Get current month payout list for a teacher
    public function get_cur_month_payout_lists($teacher_id, $currency)
    {
        $this->db->select('classes.*, payouts.*, vouchers.*, payouts.status as payout_status, vouchers.status as voucher_status, users.first_name as attendee_first_name, users.last_name as attendee_last_name, payouts.id as payout_id, classes.title as class_name, classes.id as class_id, payouts.created_at as payout_date');
        $this->db->where('payouts.created_at <=', date('Y-m-d', strtotime('last day of this month')) );
        $this->db->where('payouts.created_at >=', date('Y-m-d', strtotime('first day of this month')) );
        $this->db->where('payouts.teacher_id', $teacher_id);
        $this->db->where('payouts.currency', $currency);
        $this->db->join('class_attendees', 'class_attendees.payout_id=payouts.id');
        $this->db->join('classes', 'class_attendees.class_id=classes.id');
        $this->db->join('vouchers', 'class_attendees.voucher_id=vouchers.id');
        $this->db->join('users', 'users.id=vouchers.user_id');
        $query=$this->db->get('payouts');
        return $query->result();
    }

    // Get all payout with the quantity (students) for a course
    public function get_all_payout_lists()
    {
        $this->db->select('classes.*, payouts.*, vouchers.*, order_details.*, payouts.status as payout_status, vouchers.status as voucher_status, attendees.first_name as attendee_first_name, attendees.last_name as attendee_last_name, teachers.first_name as teacher_first_name, teachers.last_name as teacher_last_name, payouts.id as payout_id, classes.title as class_name, classes.id as class_id');
        $this->db->join('class_attendees', 'class_attendees.payout_id=payouts.id');
        $this->db->join('classes', 'class_attendees.class_id=classes.id');
        $this->db->select('CASE classes.currency WHEN "SGD" then 0.15*classes.price WHEN "IDR" then FLOOR(0.15*classes.price) END as skillagogo_commission');
        $this->db->join('vouchers', 'class_attendees.voucher_id=vouchers.id');
        $this->db->join('order_details', 'order_details.id=vouchers.order_detail_id');
        $this->db->join('users as attendees', 'attendees.id=vouchers.user_id');
        $this->db->join('users as teachers', 'teachers.id=payouts.teacher_id');
        $this->db->group_by('classes.id');        
        $query=$this->db->get('payouts');
        $result = $query->result();
        foreach($result as $payout) {
            $payout->total_pax = $this->get_total_pax_for_course_id($payout->class_id);
        }
        return $query->result();
    }

    // Get the quantity (students) for a class
    public function get_total_pax_for_course_id($class_id)
    {
        $this->db->select('vouchers.*, count(*) as total_pax');
        $this->db->join('class_attendees', 'class_attendees.payout_id=payouts.id');
        $this->db->join('classes', 'class_attendees.class_id=classes.id');
        $this->db->join('vouchers', 'class_attendees.voucher_id=vouchers.id');
        $this->db->where('classes.id', $class_id);
        $query = $this->db->get('payouts');
        $row = $query->row();
        return $row->total_pax;
    }

    // Get a payout by ID
    public function get_payout_by_id($payout_id)
    {
        $this->db->select('classes.*, payouts.*, vouchers.*, payouts.status as payout_status, vouchers.status as voucher_status, attendees.first_name as attendee_first_name, attendees.last_name as attendee_last_name, teachers.first_name as teacher_first_name, teachers.last_name as teacher_last_name, payouts.id as payout_id, classes.title as class_name, classes.id as class_id');
        $this->db->join('class_attendees', 'class_attendees.payout_id=payouts.id');
        $this->db->join('classes', 'class_attendees.class_id=classes.id');
        $this->db->join('vouchers', 'class_attendees.voucher_id=vouchers.id');
        $this->db->join('users as attendees', 'attendees.id=vouchers.user_id');
        $this->db->join('users as teachers', 'teachers.id=payouts.teacher_id');
        $this->db->where('payouts.id', $payout_id);
        $query = $this->db->get('payouts');
        return $query->row();
    }

    // Get all payouts by the invoice code
    // Invoice code can be duplicated accross payouts
    // Depending on the generated date
    public function get_payout_by_invoice_code($invoice_code)
    {
        $this->db->select('classes.*, payouts.*, vouchers.*, user_details.*, payouts.status as payout_status, vouchers.status as voucher_status, attendees.first_name as attendee_first_name, attendees.last_name as attendee_last_name, teachers.first_name as teacher_first_name, teachers.last_name as teacher_last_name, payouts.id as payout_id, classes.title as class_name, classes.id as class_id, addresses.address_line1, addresses.address_line2, addresses.city, addresses.state, addresses.country, addresses.postal_code');
        $this->db->join('class_attendees', 'class_attendees.payout_id=payouts.id');
        $this->db->join('classes', 'class_attendees.class_id=classes.id');
        $this->db->join('vouchers', 'class_attendees.voucher_id=vouchers.id');
        $this->db->join('users as attendees', 'attendees.id=vouchers.user_id');
        $this->db->join('users as teachers', 'teachers.id=payouts.teacher_id');
        $this->db->join('user_details', 'user_details.user_id = teachers.id', 'left');
        $this->db->join('addresses', 'addresses.id = user_details.address_id', 'left');
        $this->db->where('payouts.invoice_code', $invoice_code);
        $query = $this->db->get('payouts');
        return $query->result();
    }

    // Get all payouts for a course
    public function get_payout_by_course_id($course_id)
    {
        $this->db->select('classes.*, payouts.*, vouchers.*, user_details.*, payouts.status as payout_status, vouchers.status as voucher_status, attendees.first_name as attendee_first_name, attendees.last_name as attendee_last_name, teachers.first_name as teacher_first_name, teachers.last_name as teacher_last_name, payouts.id as payout_id, classes.title as class_name, classes.id as class_id, addresses.address_line1, addresses.address_line2, addresses.city, addresses.state, addresses.country, addresses.postal_code');
        $this->db->join('class_attendees', 'class_attendees.payout_id=payouts.id');
        $this->db->join('classes', 'class_attendees.class_id=classes.id');
        $this->db->select('CASE classes.currency WHEN "SGD" then 0.15*classes.price WHEN "IDR" then FLOOR(0.15*classes.price) END as skillagogo_commission');
        $this->db->join('vouchers', 'class_attendees.voucher_id=vouchers.id');
        $this->db->join('users as attendees', 'attendees.id=vouchers.user_id');
        $this->db->join('users as teachers', 'teachers.id=payouts.teacher_id');
        $this->db->join('user_details', 'user_details.user_id = teachers.id', 'left');
        $this->db->join('addresses', 'addresses.id = user_details.address_id', 'left');
        $this->db->where('classes.id', $course_id);
        $this->db->group_by('payouts.invoice_code');
        $query = $this->db->get('payouts');
        $result = $query->result();
        foreach ($result as $payout) {
            $payout->count_data = $this->get_count_by_invoice_code($payout->invoice_code);
        }
        return $result;
    }

    // Get all payouts for a course, which vouchers are generated today
    public function get_payout_by_course_id_today($course_id)
    {
        $this->db->select('classes.*, payouts.*, vouchers.*, user_details.*, payouts.status as payout_status, vouchers.status as voucher_status, attendees.first_name as attendee_first_name, attendees.last_name as attendee_last_name, teachers.id as teacher_id, teachers.first_name as teacher_first_name, teachers.last_name as teacher_last_name, payouts.id as payout_id, classes.title as class_name, classes.id as class_id, addresses.address_line1, addresses.address_line2, addresses.city, addresses.state, addresses.country, addresses.postal_code');
        $this->db->join('class_attendees', 'class_attendees.payout_id=payouts.id');
        $this->db->join('classes', 'class_attendees.class_id=classes.id');
        $this->db->join('vouchers', 'class_attendees.voucher_id=vouchers.id');
        $this->db->join('users as attendees', 'attendees.id=vouchers.user_id');
        $this->db->join('users as teachers', 'teachers.id=payouts.teacher_id');
        $this->db->join('user_details', 'user_details.user_id = teachers.id', 'left');
        $this->db->join('addresses', 'addresses.id = user_details.address_id', 'left');
        $this->db->where('payouts.created_at <', date('Y-m-d 00:00:00', strtotime('+1 day')) );
        $this->db->where('payouts.created_at >=', date('Y-m-d 00:00:00', strtotime('today')) );
        $this->db->where('class_attendees.class_id', $course_id);
        $this->db->where('payouts.invoice_code !=', NULL);
        $this->db->group_by('payouts.invoice_code');
        $query = $this->db->get('payouts');
        $result = $query->result();
        return $result;
    }

    // Get all payouts generated yesterday
    public function get_payouts_yesterday()
    {
        $this->db->select('classes.*, payouts.*, vouchers.*, user_details.*, payouts.status as payout_status, vouchers.status as voucher_status, attendees.first_name as attendee_first_name, attendees.last_name as attendee_last_name, teachers.id as teacher_id, teachers.first_name as teacher_first_name, teachers.last_name as teacher_last_name, payouts.id as payout_id, classes.title as class_name, classes.id as class_id, addresses.address_line1, addresses.address_line2, addresses.city, addresses.state, addresses.country, addresses.postal_code');
        $this->db->join('class_attendees', 'class_attendees.payout_id=payouts.id');
        $this->db->join('classes', 'class_attendees.class_id=classes.id');
        $this->db->join('vouchers', 'class_attendees.voucher_id=vouchers.id');
        $this->db->join('users as attendees', 'attendees.id=vouchers.user_id');
        $this->db->join('users as teachers', 'teachers.id=payouts.teacher_id');
        $this->db->join('user_details', 'user_details.user_id = teachers.id', 'left');
        $this->db->join('addresses', 'addresses.id = user_details.address_id', 'left');
        $this->db->where('payouts.created_at <', date('Y-m-d 00:00:00', strtotime('today')) );
        $this->db->where('payouts.created_at >=', date('Y-m-d 00:00:00', strtotime('-1 day')) );
        $this->db->where('payouts.invoice_code !=', NULL);
        $this->db->group_by('payouts.invoice_code');
        $query = $this->db->get('payouts');
        $result = $query->result();
        return $result;
    }

    // Get the number of payouts which have the same invoice code
    public function get_count_by_invoice_code($invoice_code)
    {
        $this->db->select('count(*) as count_data');
        $this->db->where('payouts.invoice_code', $invoice_code);
        $query = $this->db->get('payouts');
        return $query->row()->count_data;  
    }

    // Update the payout status
    public function update_payout_status($post,$status)
    {
        foreach ($post as $id)
        {
            $this->db->where('id', $id);
            if ($status == \PayoutStatic::STATUS_PAID) {
                $this->db->update('payouts', ['status' => $status, 'payment_date' => date('Y-m-d', strtotime('today'))]);
            } else {
                $this->db->update('payouts', ['status' => $status, 'payment_date' => date('Y-m-d', strtotime('0000-00-00'))]);

            }
        }
    }

    // Generate the invoice code for a payout
    // For a same class, invoice code will be the same if it's generated on the same day
    public function generate_invoice_code($payout_id)
    {
        $payout = $this->get_payout_by_id($payout_id);

        $invoice_code = (string)$payout_id;
        $ctr_code = "I-SAG";

        //$this->db->select('payouts.*');
        if ($payout->currency=="IDR") {
            // JKT invoice
            $ctr_code = "I-JKT";
            $this->db->where('payouts.invoice_code like "I-JKT%"');
        } elseif ($payout->currency == "SGD") {
            // SGP invoice
            $ctr_code = "I-SGP";
            $this->db->where('payouts.invoice_code like "I-SGP%"');
        } else {
            // default: SAG invoice -- fallback
            $ctr_code = "I-SAG";
            $this->db->where('payouts.invoice_code like "I-SAG%"');
        }
        $this->db->order_by("payouts.invoice_code", "desc");
        $this->db->limit(1);
        $last_payout = $this->db->get('payouts')->row();

        if (!$last_payout) $invoice_code = "1";
        else {
            // Generate invoice based on the last generated date
            $last_generated_date = (string)(date('Y-m-d', strtotime($last_payout->created_at)));
            $generated_date = (string)(date('Y-m-d', strtotime('today')));

            // Check current class ID, and check if that class ID has been generated today with invoice_code
            $this_class_id = $payout->class_id;
            $today_payouts_by_this_class_id = $this->get_payout_by_course_id_today($this_class_id);

            if (count($today_payouts_by_this_class_id) > 0) {
                // If yes, copy paste that class invoice code
                $invoice_code = (string)(intval(substr($today_payouts_by_this_class_id[0]->invoice_code, 5, 6)));
            } else {
                // If not, then generate invoice code based on the last class generated today
                $invoice_code = (string)(intval(substr($last_payout->invoice_code, 5, 6)) + 1);
            }
        }
        $invoice_code = $ctr_code . str_pad($invoice_code, 6, "0", STR_PAD_LEFT);

        $this->db->where('id', $payout_id);
        $this->db->update('payouts', ['invoice_code' => $invoice_code]);

        return $invoice_code;
    }
}


