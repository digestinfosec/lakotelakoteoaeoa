<?php

class Attendee_model extends MY_Model
{
    // Get class attendees for a course
    public function get_attendees($course_id)
    {
        $this->db->select('users.* vouchers.*, vouchers.id as voucher_id');
        $this->db->where('class_id', $course_id);
        $this->db->join('vouchers', 'vouchers.id = class_attendees.voucher_id', 'left');
        $this->db->join('users', 'users.id = vouchers.user_id', 'left');
        $query = $this->db->get('class_attendees');
        return $query->row();
    }

    // Get a class attendee with $course_id and $voucher_code
    public function check_attendees($course_id, $voucher_code)
    {
        $this->db->join('vouchers', 'vouchers.id = class_attendees.voucher_id', 'left');
        $this->db->where('class_id', $course_id);
        $this->db->where('voucher_code', $voucher_code);
        $query = $this->db->get('class_attendees');
        return $query->row();
    }
}
