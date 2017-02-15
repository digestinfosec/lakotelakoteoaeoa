<?php

class Payment_model extends MY_Model
{
    // Get the payments for user
    // $option = 'student_id', 'currency', 'limit', 'offset'
    public function get_student_payments($option = [])
    {
        $this->db->select('orders.*, payments.*, orders.created_at as order_date, orders.id as order_id');
        
        // limit option for pagination
        if (isset($option['limit'])) {
            if (isset($option['offset'])) {
                $this->db->limit($option['limit'], $option['offset']);
            } else {
                $this->db->limit($option['limit']);
            }
        }

        $this->db->join('orders', 'orders.id = payments.order_id', 'left');
        $this->db->where('orders.user_id', $option['student_id']);
        $this->db->where('orders.currency', $option['currency']);
        $this->db->order_by('orders.created_at', 'desc');
        $query = $this->db->get('payments');
        $result = $query->result();
        
        foreach ($result as $payment) {
            // Untuk mencari alamat, jadwal, tempat dari class
            $this->db->select('order_details.*, classes.*, classes.id as course_id');
            $this->db->join('classes', 'classes.id = order_details.class_id', 'left');
            $order_details = $this->db->get_where('order_details', 'order_details.order_id = ' . $payment->order_id);
            $payment->order_details = $order_details->result();

        }

        return $result;
    }

    // Get a payment by the receipt code 
    public function get_payment_by_receipt_code($receipt_code)
    {
        $this->db->select('orders.*, payments.id as payment_id, payments.*');
        $this->db->where('receipt_code', $receipt_code);
        $this->db->join('payments', 'payments.order_id = orders.id');
        $query = $this->db->get('orders');
        $order = $query->row();
        return $order;
    }

    // Get a payment by the order ID
    public function get_payment_by_order_id($order_id)
    {
        $this->db->select('orders.*, payments.id as payment_id, payments.*');
        $this->db->join('payments', 'payments.order_id = orders.id');
        $this->db->where('orders.id', $order_id);
        $query = $this->db->get('orders');
        $order = $query->row();
        return $order;
    }

    // Get the order detail with classes and payments for an order ID
    public function get_order_classes($order_id)
    {
        $this->db->select('payments.*, order_details.id, order_details.class_id, classes.title as class_title');
        $this->db->where('order_details.order_id', $order_id);
        $this->db->join('classes', 'classes.id = order_details.class_id');
        $this->db->join('payments', 'payments.order_id = order_details.order_id');
        $query = $this->db->get('order_details')->result();
        return $query;
    }

    // Update the payment confirmation for a bank payment order
    public function payment_confirmation($post)
    {
        $rule = PaymentStatic::get_rule('edit');
        $rule = $this->_push_custom_lang($rule);
        if ($this->_validate($rule) == false) {
            return false;
        }

        $this->db->where('payments.id', $post['id']);
        $update = $this->db->update('payments', [
            'payment_date'  => $post['payment_date'],
            'amount'        => $post['amount'],
            'bank_destination_name' => $post['bank_destination_name'],
            'bank_account_name'     => $post['bank_account_name'],
            'bank_name'     => $post['bank_name'],
            'photo'         => $post['photo']
        ]);

        $this->db->where('payments.id', $post['id']);
        $payment = $this->db->get('payments')->row();

        #update order status to wait for confirmation
        $this->db->where('orders.id', $payment->order_id);
        $query = $this->db->get('orders');
        $order = $query->row();
        $order_status= (int)($order->status);

        if ($order_status != \OrderStatic::ORDER_SUCCESS)
        {
            $this->db->where('orders.id', $order->id);
            $this->db->update('orders', ['status' => \OrderStatic::ORDER_WAIT_FOR_CONFIRMATION, 'transaction_code' => $post['transaction_code']]);
        } 
        else 
        {
            // Update seat left in schedule for all classes in order
            $this->load->model('order_model');
            $order_with_details = $this->order_model->get_order($order->id);
            foreach ($order_with_details->details as $order_detail) {
                $schedule_id = $order_detail->schedule_id;
                $this->db->where('id',$schedule_id);
                $schedule = $this->db->get('schedules')->row();
                $this->load->model('course_model');
                $this->load->model('schedule_model');
                $course_type = $this->course_model->get_course($order_detail->class_id, false, false)->type;
                if ($schedule) {
                    $available_seat_left = $schedule->available_seat_left;
                    if ($course_type == 3) { // if staged 
                        $all_schedules = $this->schedule_model->get_schedules($order_detail->class_id);
                        foreach ($all_schedules as $staged_schedule) {
                            $this->db->where('id',$staged_schedule->schedule_id);
                            $this->db->update('schedules', ['available_seat_left' => ((int)$available_seat_left - (int)$order_detail->pax)]);
                        }
                    }
                    else { // repeated and single
                        $this->db->where('id',$schedule_id);
                        $this->db->update('schedules', ['available_seat_left' => ((int)$available_seat_left - (int)$order_detail->pax)]);
                    }
                }
            }
        }

        return $update;
    }
}
