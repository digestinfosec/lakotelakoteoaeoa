<?php

class Credit_model extends MY_Model
{
    // Update the amount used of credit, and put the usage history to credit_histories
    private function pay_process($credit, $current_used_credit, $total_used_credit, $order_id)
    {
        $this->db->where('id', $credit->id);
        $this->db->update('credits', [
            'amount_used' => $total_used_credit,
        ]);

        $this->db->insert('credit_histories', [
            'credit_id' => $credit->id,
            'credit' => $current_used_credit,
            'description' => \CreditStatic::HISTORY_PAYMENT,
            'order_id' => $order_id
        ]);
    }

    // Get credits for a user for the selected country/currency
    public function get_credits($user_id, $currency)
    {
        $this->db->select('credit_histories.*, credits.amount_used, credits.expired_date');
        $this->db->join('credit_histories', 'credits.id = credit_histories.credit_id');
        $this->db->where('user_id', $user_id);
        $this->db->where('currency', $currency);
        $this->db->where('credit_histories.debit > 0');
        $this->db->where('credits.expired_date >=', date('Y-m-d', strtotime('today')));
        $this->db->order_by('credit_histories.created_at', 'ASC');
        $query = $this->db->get('credits');

        return $query->result();
    }

    // Get all credits expiring in five days
    public function get_credits_expiring_five_days_later()
    {
        $this->db->select('credits.*');
        $this->db->where('credits.expired_date <=', date('Y-m-d', strtotime('+6 day')) );
        $this->db->where('credits.expired_date >=', date('Y-m-d', strtotime('+5 day')) );
        $this->db->where('credits.amount_used < credits.initial_amount ');
        $this->db->order_by('credits.created_at', 'ASC');
        $query = $this->db->get('credits');
        return $query->result();
    }

    // Get credit by ID
    public function get_credit_by_id($credit_id)
    {
        $this->db->select('credit_histories.*, credits.amount_used, credits.expired_date');
        $this->db->join('credit_histories', 'credits.id = credit_histories.credit_id', 'right');
        $this->db->where('credits.id', $credit_id);
        $query = $this->db->get('credits');

        return $query->row();
    }

    // Get all credit histories for a user
    public function get_history($user_id, $currency)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('currency', $currency);
        $this->db->join('credits', 'credit_histories.credit_id = credits.id');
        $query = $this->db->get('credit_histories');

        return $query->result();
    }

    // Get total credit balance for a user
    public function get_balance($user_id)
    {
        $this->db->select('SUM(credits.initial_amount - credits.amount_used) as total');
        $this->db->where('user_id', $user_id);
        $currency = $this->session->userdata('currency') == 'Rp' ? 'IDR' : 'SGD';
        $this->db->where('currency', $currency);
        $this->db->where('credits.expired_date >=', date('Y-m-d', strtotime('today')));
        $query = $this->db->get('credits');

        return $query->row();
    }

    // Convert a voucher payment to a credit because of $reason
    public function convert_to_credit($register, $voucher, $reason, $history, $order_id = null) 
    {
        // Set expiration date of credit
        $date = date_create('now');
        date_add($date, date_interval_create_from_date_string('1 year'));
        $expired_date = date_format($date, 'Y-m-d H:i:s');

        // Insert credit data to database
        $this->load->model('order_model');
        $order = $this->order_model->get_order($register->order_id);
        $order_detail = $this->order_model->get_detail($register->order_detail_id);
        $this->db->where('id', $voucher->voucher_id);
        $this->db->insert('credits', [
            'voucher_id' => $voucher->voucher_id,
            'user_id' => $register->user_id,
            'initial_amount' => $order_detail->price,
            'currency' => $order->currency,
            'expired_date' => $expired_date,
            'reason' => $reason
        ]);

        // Insert debit history to credit history
        $credit_id = $this->db->insert_id();
        $this->db->insert('credit_histories', [
            'credit_id' => $credit_id,
            'debit' => $order_detail->price,
            'description' => $history,
            'order_id' => $order_id
        ]);

        return $credit_id;
    }

    // Pay an $order using credit with amount of $sc_amount for a user
    public function pay($user_id, $sc_amount, $order_id)
    {
        $currency = $this->session->userdata('currency') == 'Rp' ? 'IDR' : 'SGD';
        $this->db->where('currency', $currency);
        $this->db->where('user_id', $user_id);
        $this->db->where('(initial_amount - amount_used) > 0');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('credits');

        $credits = $query->result();

        foreach ($credits as $credit) {
            if ($sc_amount <= 0 )
            {
                break;
            }

            // check remaining credit di kredit terakhir
            $credit_remain = $credit->initial_amount - $credit->amount_used;

            // kurangi amount dengan remaining credit
            $credit_diff = $credit_remain - $sc_amount; // -- check if remaining credit is bigger
            $total_used_credit = ($credit_diff > 0) ? $credit->amount_used + $sc_amount : $credit->initial_amount;
            $current_used_credit = ($credit_diff > 0) ? $sc_amount : $credit_remain;

            $this->pay_process($credit, $current_used_credit, $total_used_credit, $order_id);

            // Renew remaining credits to pay
            $sc_amount -= $current_used_credit;
        }
    }

}
