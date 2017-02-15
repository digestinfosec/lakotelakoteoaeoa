<?php

class Voucher_model extends MY_Model
{
    public function get($voucher_code)
    {
        $this->db->select('vouchers.*, vouchers.id as voucher_id, order_details.*');
        $this->db->where('voucher_code', $voucher_code);
        $this->db->join('order_details', 'order_details.id = vouchers.order_detail_id', 'left');
        $query = $this->db->get('vouchers');

        return $query->row();
    }

    public function get_voucher_lists()
    {
        $this->db->select('vouchers.*, vouchers.status as voucher_status, users.first_name as attendee_first_name, users.last_name as attendee_last_name, classes.title as class_name, classes.id as class_id, order_details.price as amount, teachers.first_name as teacher_first_name, teachers.last_name as teacher_last_name, orders.currency as currency');
        $this->db->join('order_details', 'order_details.id=vouchers.order_detail_id');
        $this->db->join('classes', 'order_details.class_id=classes.id');
        $this->db->join('orders', 'orders.id=order_details.order_id');
        $this->db->join('users', 'users.id=vouchers.user_id');
        $this->db->join('users as teachers', 'teachers.id=classes.teacher_id');
        $this->db->order_by('created_at', 'desc');
        $query=$this->db->get('vouchers');
        return $query->result();
    }

    public function get_voucher_lists_from_class($class_id, $currency)
    {
        $this->db->select('vouchers.*, vouchers.status as voucher_status, users.first_name as attendee_first_name, users.last_name as attendee_last_name, classes.title as class_name, classes.id as class_id, order_details.price as amount, teachers.first_name as teacher_first_name, teachers.last_name as teacher_last_name, orders.currency as currency');
        $this->db->join('order_details', 'order_details.id=vouchers.order_detail_id');
        $this->db->join('classes', 'order_details.class_id=classes.id');
        $this->db->join('orders', 'orders.id=order_details.order_id');
        $this->db->join('users', 'users.id=vouchers.user_id');
        $this->db->join('users as teachers', 'teachers.id=classes.teacher_id');
        $this->db->where('vouchers.is_redeemed', 1);
        $this->db->where('classes.id', $class_id);
        $this->db->where('classes.currency', $currency);
        $this->db->order_by('created_at', 'desc');
        $query=$this->db->get('vouchers');
        return $query->result();
    }

    public function get_cur_month_voucher_lists($teacher_id, $currency)
    {
        $this->db->select('vouchers.*, vouchers.status as voucher_status, users.first_name as attendee_first_name, users.last_name as attendee_last_name, classes.title as class_name, classes.id as class_id, order_details.price as amount, payouts.invoice_code');
        $this->db->where('vouchers.created_at <=', date('Y-m-d', strtotime('last day of this month')) );
        $this->db->where('vouchers.created_at >=', date('Y-m-d', strtotime('first day of this month')) );
        $this->db->join('class_attendees', 'class_attendees.voucher_id=vouchers.id', 'left');
        $this->db->join('payouts', 'class_attendees.payout_id=payouts.id', 'left');
        $this->db->join('order_details', 'order_details.id=vouchers.order_detail_id');
        $this->db->join('classes', 'order_details.class_id=classes.id');
        $this->db->join('users', 'users.id=vouchers.user_id');
        $this->db->where('classes.teacher_id', $teacher_id);
        $this->db->where('classes.currency', $currency);
        $query=$this->db->get('vouchers');
        return $query->result();
    }

    public function get_vouchers_redeemed_yesterday()
    {
        $this->db->select('vouchers.*, vouchers.status as voucher_status, users.first_name as attendee_first_name, users.last_name as attendee_last_name, classes.*, classes.id as class_id, order_details.price as amount');
        $this->db->where('vouchers.updated_at <=', date('Y-m-d', strtotime('-1 day')) );
        $this->db->where('vouchers.updated_at >=', date('Y-m-d', strtotime('-2 day')) );
        $this->db->where('vouchers.is_redeemed', 1);
        $this->db->join('order_details', 'order_details.id=vouchers.order_detail_id');
        $this->db->join('classes', 'order_details.class_id=classes.id');
        $this->db->join('users', 'users.id=vouchers.user_id');
        $this->db->group_by('classes.id');
        $query = $this->db->get('vouchers');
        return $query->result();
    }

    public function get_by_invoice_code($invoice_code)
    {
        $this->db->select('payouts.*, payouts.id as payout_id, vouchers.*, classes.*, vouchers.status as voucher_status');
        $this->db->join('class_attendees', 'class_attendees.voucher_id=vouchers.id');
        $this->db->join('payouts', 'payouts.id=class_attendees.payout_id');
        $this->db->join('classes', 'class_attendees.class_id=classes.id');
        $this->db->select('CASE classes.currency WHEN "SGD" then 0.15*classes.price WHEN "IDR" then FLOOR(0.15*classes.price) END as skillagogo_commission');
        $this->db->where('payouts.invoice_code', $invoice_code);
        $query = $this->db->get('vouchers');
        // var_dump($query->result());
        return $query->result();
    }

    public function get_totals_by_invoice_code($invoice_code)
    {
        $this->db->select('sum(CASE classes.currency WHEN "SGD" then 0.15*classes.price WHEN "IDR" then FLOOR(0.15*classes.price) END) as total_commission');
        $this->db->select('sum(payouts.amount) as total_amount');
        $this->db->select('sum(classes.price) as total_price');
        $this->db->join('class_attendees', 'class_attendees.voucher_id=vouchers.id');
        $this->db->join('payouts', 'payouts.id=class_attendees.payout_id');
        $this->db->join('classes', 'class_attendees.class_id=classes.id');
        $this->db->where('payouts.invoice_code', $invoice_code);
        $query = $this->db->get('vouchers');
        // var_dump($query->result());
        return $query->result();
    }

    public function get_from_teacher_courses_previous_month($teacher_id)
    {
        $this->db->where('voucher_code', $voucher_code);
        $this->db->join('order_details', 'order_details.id = vouchers.order_detail_id', 'right');
        $query = $this->db->get('vouchers');

        return $query->row();
    }

    public function get_from_teacher_courses_current_month($teacher_id)
    {
        $this->db->where('voucher_code', $voucher_code);
        $this->db->join('order_details', 'order_details.id = vouchers.order_detail_id', 'right');
        $query = $this->db->get('vouchers');

        return $query->row();
    }

    public function save($voucher_code, $detail)
    {
        $this->db->insert('vouchers', [
            'order_detail_id' => $detail->order_detail_id,
            'user_id' => $this->session->userdata('login')['user_id'],
            'voucher_code' => $voucher_code,
            'status' => \VoucherStatic::VOUCHER_UNUSED
        ]);
    }

    public function save_from_admin($voucher_code, $detail, $user_id)
    {
        $this->db->insert('vouchers', [
            'order_detail_id' => $detail->order_detail_id,
            'user_id' => $user_id,
            'voucher_code' => $voucher_code,
            'status' => \VoucherStatic::VOUCHER_UNUSED
        ]);
    }

    public function get_voucher($register)
    {
        $this->db->select('vouchers.*, vouchers.id as voucher_id, order_details.*');
        $this->db->join('order_details', 'order_details.id=vouchers.order_detail_id');
        $this->db->where('order_detail_id', $register->order_detail_id);
        $query = $this->db->get('vouchers');

        return $query->row();
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('vouchers', $data);
    }

    public function check_voucher($voucher_code, $course_id)
    {
        $this->db->where('voucher_code', $voucher_code);
        $this->db->where('class_id', $course_id);
        $this->db->where('status', \VoucherStatic::VOUCHER_UNUSED);
        $this->db->where('is_redeemed', 0);
        $this->db->join('order_details', 'order_details.id=vouchers.order_detail_id');
        $query = $this->db->get("vouchers");
        return $query->row();
    }

    public function add_voucher($voucher_code, $course_id)
    {
        $this->db->where('voucher_code', $voucher_code);
        $this->db->update('vouchers', [
            'status' => VoucherStatic::VOUCHER_USED,
            'is_redeemed' => 1
        ]);

        $voucher = $this->get($voucher_code);

        $this->db->insert('class_attendees', [
            'class_id' => $course_id,
            'voucher_id' => $voucher->id
        ]);
        $class_attendees_id = $this->db->insert_id();

        $this->load->model('course_model');
        $course = $this->course_model->get_course($course_id);

        // Payout amount after deducting the skillagogo commision
        $course_price = $course->price;

        // Calculate commission based on the currency
        if ($course->currency == "SGD") {
            $teacher_takehome_amount = $course_price - ($course_price*\PayoutStatic::SKILLAGOGO_COMMISSION); 
        } elseif ($course->currency == "IDR") {
            $teacher_takehome_amount = $course_price - (floor($course_price*\PayoutStatic::SKILLAGOGO_COMMISSION)); 
        }

        $data_payout = array(
            'teacher_id' => $course->teacher_id,
            'amount' => $teacher_takehome_amount,
            'currency' => $course->currency,
            'status' => PayoutStatic::STATUS_PENDING,
            );
        $this->db->insert('payouts', $data_payout);
        $payout_id = $this->db->insert_id();

        $this->load->model('payout_model');
        $this->payout_model->generate_invoice_code($payout_id);

        $this->db->where('id', $class_attendees_id);
        $this->db->update('class_attendees', ['payout_id' => $payout_id]);
    }

    public function generate_voucher($course)
    {
        // Generate unique id if null
        if ($course->unique_id == NULL) {
            $this->load->model('course_model');
            $course->unique_id = $this->course_model->generate_unique_id($course->id);
        }

        // Get category code
        $category_code = preg_replace("/[^A-Z]+/", "", $course->unique_id);

        do {
            $random1 = str_pad(rand(1, 999), 3, 0, STR_PAD_LEFT);
            $random2 = str_pad(rand(1, 999), 3, 0, STR_PAD_LEFT);
            $voucher_code = $category_code . $random1 . $random2 . substr($course->unique_id, -3);
        } while($this->get($voucher_code));

        return $voucher_code;
    }
}
