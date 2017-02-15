<?php

class Order_model extends MY_Model
{
    // Create an order from booking from student, with the order details
    // Also, update the available seat for those booked schedules
    protected function add_order_from_cart($status = OrderStatic::ORDER_WAIT_FOR_PAYMENT)
    {
        // Remove skillagogo credits first
        $row_id = md5(0);
        if ($this->cart->get_item($row_id) == true) $this->cart->remove($row_id);

        $currency = $this->session->userdata('currency') == 'Rp' ? 'IDR' : 'SGD';
        $this->db->insert('orders', [
            'user_id' => $this->session->userdata('login')['user_id'],
            'status' => $status,
            'total' => $this->cart->total(),
            'currency' => $currency,
        ]);
        $order_id = $this->db->insert_id();

        foreach ($this->cart->contents() as $class) {
            $this->db->insert('order_details', [
                'order_id' => $order_id,
                'class_id' => $class['id'],
                'schedule_id' => $class['schedule_id'],
                'price' => $class['price'],
                'pax' => $class['qty']
            ]);

            // If ORDER_SUCCESS, update seat left in schedule
            if ($status == OrderStatic::ORDER_SUCCESS) {
                $this->db->where('id',$class['schedule_id']);
                $schedule = $this->db->get('schedules')->row();
                $this->load->model('course_model');
                $this->load->model('schedule_model');
                $course_type = $this->course_model->get_course($class['id'], false, false)->type;
                if ($schedule) {
                    $available_seat_left = $schedule->available_seat_left;
                    if ($course_type == 3) { // if staged 
                        $all_schedules = $this->schedule_model->get_schedules($class['id']);
                        foreach ($all_schedules as $staged_schedule) {
                            $this->db->where('id',$staged_schedule->schedule_id);
                            $this->db->update('schedules', ['available_seat_left' => ((int)$available_seat_left - (int)$class['qty'])]);
                        }
                    }
                    else { // repeated and single
                        $this->db->where('id',$schedule->id);
                        $this->db->update('schedules', ['available_seat_left' => ((int)$available_seat_left - (int)$class['qty'])]);
                    }
                }
            }
        }

        return $order_id;
    }

    // Get order with $id
    public function get_order($id)
    {
        $this->db->where('id', $id);
        $order = $this->db->get('orders')->row();

        $this->db->select("
                        orders.*, 
                        orders.id as order_id, 
                        order_details.*, 
                        order_details.price, 
                        order_details.pax, 
                        order_details.id as order_detail_id,
                        classes.title, 
                        classes.description, 
                        classes.unique_id, 
                        categories.name, 
                        teachers.first_name as teacher_first_name, 
                        teachers.last_name as teacher_last_name"
                        );
        $this->db->join('classes', 'classes.id = order_details.class_id', 'left');
        $this->db->join('users as teachers', 'teachers.id = classes.teacher_id', 'left');
        $this->db->join('orders', 'orders.id = order_details.order_id');
        $this->db->join('categories', 'categories.id = classes.category_id');
        $this->db->where('order_details.order_id', $order->id);
        $query = $this->db->get('order_details');
        $order->details = $query->result();

        return $order;
    }

    // Get all orders for a class
    public function get_orders_from_class($class_id)
    {
        $this->db->select('
                        orders.*, 
                        order_details.*, 
                        order_details.id as order_detail_id'
                        );
        $this->db->join('order_details', 'order_details.order_id = orders.id', 'left');
        $this->db->where('class_id', $class_id);
        $this->db->order_by('orders.created_at', 'desc');
        $query = $this->db->get('orders');
        return $query->result();
    }

    // Create a new order data --conected with the add_order_from_cart method
    public function save($payment, $sc_amount = 0, $txid = null)
    {
        $this->db->trans_start();
        $payment_method = ($payment == 'bank') ? PaymentStatic::PAYMENT_METHOD_BANK : PaymentStatic::PAYMENT_METHOD_PAYPAL;
        if ($payment_method == PaymentStatic::PAYMENT_METHOD_PAYPAL) {
            $order_id = $this->add_order_from_cart(OrderStatic::ORDER_SUCCESS);
            $data['paypal_transaction_id'] = $txid;
            $data['payment_date'] = date("Y-m-d");

            // For paypal, immediately generate a receipt
            $receipt_code = $this->generate_receipt_code($order_id);
        } else {
            // For bank payment, generate a receipt from the admin controller --after the bank payment is complete
            if ($this->cart->total() == 0) {
                $order_id = $this->add_order_from_cart(OrderStatic::ORDER_SUCCESS);
            } else {
                $order_id = $this->add_order_from_cart();
            }
        }

        $data = [
            'order_id' => $order_id,
            'payment_method' => $payment_method,
            'amount' => $this->cart->total()
        ];

        if ($sc_amount > 0)
        {
            $data['with_credit'] = true;
            $data['credit_amount'] = $sc_amount;
            $data['amount'] = $this->cart->total();
            // $this->load->model('credit_model');
            // $this->credit_model->pay($this->session->userdata('login')['user_id'], $sc_amount, $order_id);
        }

        $this->db->insert('payments', $data);
        $this->db->trans_complete();
        return $order_id;
    }

    // Get an order detail with ID
    public function get_detail($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('order_details');

        return $query->row();
    }

    // Get an order with receipt code
    public function get_order_by_receipt_code($receipt_code)
    {
        $this->db->select('orders.id, orders.user_id, users.first_name, users.last_name, orders.total, orders.receipt_code, 
        orders.currency, payments.payment_method, addresses.address_line1, addresses.address_line2, addresses.city, addresses.state, addresses.country, addresses.postal_code');
        $this->db->join('payments', 'orders.id = payments.order_id', 'left');
        $this->db->join('users', 'users.id = orders.user_id', 'left');
        $this->db->join('user_details', 'users.id = user_details.user_id', 'left');
        $this->db->join('addresses', 'addresses.id = user_details.address_id', 'left');
        $this->db->where('orders.receipt_code', $receipt_code);
        $query = $this->db->get('orders');
        $order = $query->row();

        $this->db->select("classes.title, classes.description, classes.unique_id, order_details.price, order_details.pax, categories.name");
        $this->db->join('classes', 'classes.id = order_details.class_id', 'left');
        $this->db->join('categories', 'categories.id = classes.category_id');
        $this->db->where('order_details.order_id', $order->id);
        $query = $this->db->get('order_details');
        $order->details = $query->result();

        return $order;
    }

    // Generate the receipt code for an order
    // Follow the sequence for each country
    public function generate_receipt_code($order_id)
    {
        $order = $this->get_order($order_id);

        $receipt_code = (string)$order_id;
        $ctr_code = "SAG";

        $this->db->select('orders.*');
        
        if ($order->currency=="IDR") {
            // JKT receipt
            $ctr_code = "JKT";
            $this->db->where('receipt_code like "JKT%"');
        } elseif ($order->currency == "SGD") {
            // SGP receipt
            $ctr_code = "SGP";
            $this->db->where('receipt_code like "SGP%"');
        } else {
            // default: SAG receipt -- fallback
            $ctr_code = "SAG";
            $this->db->where('receipt_code like "SAG%"');
        }
        $this->db->order_by("receipt_code", "desc");
        $this->db->limit(1);
        $last_order = $this->db->get('orders')->row();
        if (!$last_order) $receipt_code = "1";
        else $receipt_code = (string)(intval(substr($last_order->receipt_code, 3, 6)) + 1);
        $receipt_code = $ctr_code . str_pad($receipt_code, 6, "0", STR_PAD_LEFT);

        $this->db->where('id', $order_id);
        $this->db->update('orders', ['receipt_code' => $receipt_code]);

        return $receipt_code;
    }
}
