<?php

class Admin_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();

        $this->user_id = $this->session->userdata('login_admin')['admin_id'];
    }

    private function _sanitize_input($post, $mode = null)
    {
        $post = $this->input->post();
        switch ($mode) {
            case 'create':
                $this->load->helper('string');
                $this->load->library('encrypt');
                $data = [
                    'username' => $post['username'],
                    'first_name' => $post['first_name'],
                    'last_name' => $post['last_name'],
                    'email' => $post['email'],
                    'status' => UserStatic::STATUS_ACTIVE,
                    'type' => $post['type'],
                    'password' => $this->encrypt->encode($post['password'])
                ];
                break;
            case 'edit':
                $this->load->helper('string');
                $data = [
                    'username' => $post['username'],
                    'first_name' => $post['first_name'],
                    'last_name' => $post['last_name'],
                    'email' => $post['email'],
                    'status' => UserStatic::STATUS_ACTIVE,
                    'type' => $post['type'],
                ];
                break;
        }

        return $data;
    }

    public function get_users($is_teacher=NULL, $is_student=NULL)
    {

        $this->db->select('user_details.*, teacher_details.*, users.*');
        $this->db->select('teacher_details.user_id as teacher_id');
        $this->db->join('teacher_details', 'teacher_details.user_id = users.id', 'left');
        $this->db->join('user_details', 'user_details.user_id = users.id', 'left');
        // $this->db->where('users.type', \UserStatic::TYPE_CUSTOMER);
        $this->db->order_by('users.id', 'asc');

        if (!$is_teacher==NULL) {
            $this->db->where('is_teacher', $is_teacher);
        }

        if (!$is_student==NULL) {
            $this->db->where('is_student', $is_student);
        }

        $query = $this->db->get('users');
        return $query->result_array();
    }

    public function get_admins()
    {
        $this->db->select('admins.*');
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('admins');
        return $query->result();
    }

    public function get_admin($admin)
    {
        $this->db->select('admins.*');
        $this->db->where($admin);
        $query = $this->db->get('admins');

        return $query->row();
    }
    /**
     * Get login admin
     * This function handle validation and get query for admin login
     *
     * @param $data
     * @return bool|mixed|null|string
     */
    public function get_admin_login($data)
    {
        $rule = UserStatic::get_rule('login');
        if ($this->_validate($rule) == false) {
            return false;
        }

        $field = (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) ? 'email' : 'username';
        $option = [
            $field => $data['email'],
            'status' => AdminStatic::STATUS_ACTIVE
        ];

        return $this->get_admin($option);
    }

    public function get_comments($comment_id=NULL)
    {
        $this->db->select('comments.*,
            comments.created_at as comment_time,
            commenter.first_name,
            commenter.last_name,
            commenter.profile_pic,
            classes.title as class_title');
        $this->db->join('class_comments', 'comments.id = class_comments.comment_id', 'left');
        $this->db->join('classes', 'classes.id = class_comments.class_id', 'left');
        $this->db->join('users commenter', 'commenter.id = comments.user_id', 'left');

        if ($comment_id!=NULL){
            $this->db->where('comments.id', $comment_id);
            $query = $this->db->get('comments');
            return $query->row();
        }

        $query = $this->db->get('comments');
        return $query->result();
    }

    public function get_ratings($rating_id=NULL)
    {
        $this->db->select('ratings.*,
            ratings.created_at as rating_time,
            reviewers.first_name,
            reviewers.last_name,
            reviewers.profile_pic,
            classes.title,
            classes.teacher_id,
            teacher.first_name as teacher_first_name,
            teacher.last_name as teacher_last_name');
        $this->db->join('users reviewers', 'reviewers.id = ratings.user_id', 'left');
        $this->db->join('classes', 'classes.id = ratings.class_id', 'left');
        $this->db->join('users teacher', 'teacher.id = classes.teacher_id', 'left');

        if ($rating_id!=NULL){
            $this->db->where('ratings.id', $rating_id);
            $query = $this->db->get('ratings');
            return $query->row();
        }

        $query = $this->db->get('ratings');
        return $query->result();
    }

    public function get_static_page($title)
    {
        $this->db->select('static_pages.*')
            ->where('title', $title)
            ->order_by('id', 'desc');
        $query = $this->db->get('static_pages');
        return $query->result();
    }

    public function get_static_page_with_lang($title, $lang)
    {
        $this->db->select('static_pages.*')
            ->where('title', $title)
            ->where('language', $lang)
            ->order_by('id', 'desc')
            ->limit(1);
        $query = $this->db->get('static_pages');
        return $query->result();
    }

    public function get_orders()
    {
        $this->db->select('orders.id,
                        orders.receipt_code,
                        users.first_name as customer_first_name,
                        users.last_name as customer_last_name,
                        orders.created_at,
                        orders.currency,
                        orders.total,
                        orders.status,
                        payments.payment_method,
                        payments.payment_date,
                        payments.amount,
                        payments.paypal_email,
                        payments.paypal_transaction_id,
                        payments.bank_destination_name,
                        payments.bank_account_name,
                        payments.bank_account_number,
                        payments.note,
                        payments.bank_name,
                        payments.with_credit,
                        payments.credit_amount,
                    ');
        $this->db->join('users', 'users.id = orders.user_id', 'left');
        $this->db->join('payments', 'payments.order_id = orders.id');
        $this->db->order_by('orders.created_at', 'desc');
        $query = $this->db->get('orders');
        return $query->result_array();
    }

    public function get_order($order_id)
    {
        $this->db->select('orders.*, order_details.*, payments.*,
                        users.first_name as customer_first_name,
                        users.last_name as customer_last_name,
                        classes.title as class_title,
                        classes.id as class_id,
                        classes.price,
                        classes.unique_id,
                        categories.name as category_name,
                        teacher.first_name as teacher_first_name,
                        teacher.last_name as teacher_last_name');
        $this->db->join('order_details', 'orders.id = order_details.order_id', 'left');
        $this->db->join('payments', 'payments.order_id = orders.id');
        $this->db->join('users', 'users.id = orders.user_id', 'left');
        $this->db->join('classes', 'classes.id = order_details.class_id', 'left');
        $this->db->join('categories', 'categories.id = classes.category_id', 'left');
        $this->db->join('users as teacher', 'teacher.id = classes.teacher_id', 'left');
        $this->db->where('orders.id', $order_id);

        $query = $this->db->get('orders');
        return $query->result();
    }

    public function create_admin($post)
    {
        $rule = AdminStatic::get_rule('add');
        if ($this->_validate($rule) == false) {
            return false;
        }

        $this->db->trans_start();
        $user_data = $this->_sanitize_input($post, 'create');

        $this->db->insert('admins', $user_data);
        $this->db->trans_complete();
        return $user_data;
    }

    public function update_comments($post,$status)
    {
        foreach ($post as $id)
        {
            $this->db->where('id', $id);
            $this->db->update('comments', ['status' => $status]);
        }
    }

    public function update_ratings($post,$status)
    {
        foreach ($post as $id)
        {
            $this->db->where('id', $id);
            $this->db->update('ratings', ['status' => $status]);
        }
    }

    public function update_users($ids, $status)
    {
        foreach ($ids as $id)
        {
            $this->db->where('id', $id);
            $this->db->update('users', ['status' => $status]);
        }
    }

    public function update_password($post, $id)
    {
        // get rules for save_profile
        $rules = AdminStatic::get_rule('update_password');
        if ($this->_validate($rules) == false) {
            return false;
        }
        $this->load->library('encrypt');
        $this->db->set('password', $this->encrypt->encode($post['password']));
        $this->db->where('id', $id);
        return $this->db->update('admins');
    }

    /**
     * update static page
     * @param $post
     * @param null $id
     * @return bool|CI_DB_active_record|CI_DB_result
     */
    public function update_static_page($post)
    {

        $rule = StaticStatic::get_rule('update');
        if ($this->_validate($rule) == false) {
            return false;
        }

        $this->db->where('id', $post['id']);
        $update = $this->db->update('static_pages', [
            'content' => $post['content'],
            'last_editor_id' => $post['last_editor_id']
        ]);

        return $update;
    }

    public function change_order_status($order_id)
    {
        $this->db->where('id', $order_id);
        $this->db->update('orders', ['status' => \OrderStatic::ORDER_SUCCESS]);
    }

    public function edit_admin($id, $post)
    {
        $rule = AdminStatic::get_rule('update', $post);
        if ($this->_validate($rule) == false) {
            return false;
        }

        $user_data = $this->_sanitize_input($post, 'edit');

        if (isset($post['profile_pic'])) {
            $user_data['profile_pic'] = $post['profile_pic'];
        }

        $this->db->where('id', $id);
        $update = $this->db->update('admins', $user_data);
        return $user_data;
    }

    public function edit_user($id, $post)
    {
        $ret = true;

        // Update user using User Model
        $this->load->model('user_model');
        $user = $this->user_model->get_by_id($id);
        if ((int)$post['is_teacher']) $this->user_model->become_teacher($id);
        else $this->user_model->stop_become_teacher($id);
        if ((int)$post['is_student']) $this->user_model->become_student($id);
        else $this->user_model->stop_become_student($id);
        $this->user_model->update_notification_newsletter($post['notification_newsletter'], $post['email']);
        if ($post['password']) $ret &= $this->user_model->update_password($post, $id);
        if (isset($post['notification_class_register'])) $ret &= $this->user_model->update_notification($post, $id);
        if ($user->is_teacher && (int)$post['is_teacher']) $ret &= $this->user_model->update_teacher_profile($post, $id);
        $ret &= $this->user_model->save_profile($post, $id);
        return $ret;
     }

    public function edit_comment($comment_id, $user_id, $post)
    {
        $this->load->model('comment_model');
        return $this->comment_model->update_comment($comment_id, $post, $user_id);
    }

    public function edit_rating($rating_id, $user_id, $post)
    {
        $this->load->model('rating_model');
        return $this->rating_model->update_rating($rating_id, $post, $user_id);
    }

    public function delete_comments($ids)
    {
        foreach ($ids as $id)
        {
            $this->db->where('id', $id);
            $this->db->delete('comments');
        }
    }

    public function delete_ratings($ids)
    {
        foreach ($ids as $id)
        {
            $this->db->where('id', $id);
            $this->db->delete('ratings');
        }
    }

    public function delete_classes($ids)
    {
        foreach ($ids as $id)
        {
            $this->db->where('id', $id);
            $this->db->update('classes', ['publish_status' => \CourseStatic::PUBLISH_DELETED]);
        }
    }

    public function delete_admin($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('admins');
    }
}
