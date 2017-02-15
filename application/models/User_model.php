<?php

class User_model extends MY_Model
{

    /**
     * @param $post
     * @param null $mode
     * @return array
     */
    private function _sanitize_input($post, $mode = null)
    {
        $data = [];

        switch ($mode) {
            case 'register':
                $this->load->helper('string');
                $this->load->library('encrypt');
                $is_student = $post['role'] == 'both' || $post['role'] == 'student' ? 1 : 0;
                $is_teacher = $post['role'] == 'both' || $post['role'] == 'teacher' ? 1 : 0;
                $is_send_updates = empty($post['send_updates']) ? 0 : 1;
                $data = [
                    'first_name' => $post['first_name'],
                    'last_name' => $post['last_name'],
                    'email' => $post['email'],
                    'send_updates' => $is_send_updates,
                    'is_student' => $is_student,
                    'is_teacher' => $is_teacher,
                    'status' => UserStatic::STATUS_UNCONFIRMED,
                    'type' => UserStatic::TYPE_CUSTOMER,
                    'reg_key' => random_string('alnum', 16),
                    'password' => $this->encrypt->encode($post['password'])
                ];
                break;
            case 'pre_register':
                $this->load->helper('string');
                $this->load->library('encrypt');
                $is_student = $post['role'] == 'both' || $post['role'] == 'student' ? 1 : 0;
                $is_teacher = $post['role'] == 'both' || $post['role'] == 'teacher' ? 1 : 0;
                $is_send_updates = empty($post['send_updates']) ? 0 : 1;
                $data = [
                    'first_name' => $post['first_name'],
                    'last_name' => $post['last_name'],
                    'email' => $post['email'],
                    'send_updates' => $is_send_updates,
                    'is_student' => $is_student,
                    'is_teacher' => $is_teacher,
                    'status' => UserStatic::STATUS_UNCONFIRMED,
                    'type' => UserStatic::TYPE_CUSTOMER,
                    'reg_key' => random_string('alnum', 16),
                    'password' => $this->encrypt->encode($post['password']),
                    'pre_register' => 1
                ];
                break;
            case 'register_detail':
                $data = [
                    'user_id' => $post['id'],
                    'birth_date' => $post['birth_date']
                ];
                break;
            case 'save_profile':
                $data = [
                    'email' => $post['email'],
                    'first_name' => $post['first_name'],
                    'last_name' => $post['last_name']
                ];
                break;
            case 'save_detail_profile':
                $data = [
                    'birth_date' => $post['birth_date'],
                    'gender' => $post['gender'],
                    'home_phone' => $post['home_phone'],
                    'mobile_phone' => $post['mobile_phone'],
                    'marital_status' => $post['marital_status'],
                    'academic_level' => $post['academic_level'],
                    // 'home_address' => $post['home_address'],
                    // 'business_address' => $post['business_address']
                ];
                break;
            case 'save_address':
                $data = [
                    'address_line1' => $post['address_line1'],
                    'address_line2' => $post['address_line2'],
                    'city' => $post['city'],
                    'state' => $post['state'],
                    'postal_code' => $post['postal_code'],
                    'country' => $post['country']
                ];
                break;
            case 'update_teacher':
                $this->load->helper('htmlpurifier');
                $data = [
                    'bank_id' => $post['bank_id'],
                    'bank_branch_name' => $post['bank_branch_name'],
                    'bank_account_number' => $post['bank_account_number'],
                    //'payout_option' => $post['payout_option'],
                    'monthly_class_envisaged' => $post['monthly_class_envisaged'],
                    'objective' => $post['objective'],
                    //'goal' => $post['goal'],
                    'teacher_type' => $post['teacher_type'],
                    //'identity_id' => $post['identity_id'],
                    'job' => $post['job'],
                    'bio' => html_purify($post['bio'], 'tinymce'),
                    'website_blog' => $post['website_blog'],
                    'paypal_email' => $post['paypal_email'],
                ];
                break;
            case 'update_notification_user':
                $data = [
                    'notification_newsletter' => $post['notification_newsletter'],
                ];
                break;
            case 'update_notification_teacher':
                $data = [
                    'notification_class_register' => $post['notification_class_register'],
                    'notification_class_add_wishlist' => $post['notification_class_add_wishlist'],
                ];
                break;
        }

        return $data;
    }

    /**
     * Get User with simple `where` array
     *
     * @param $user
     * @return bool|mixed|null|string
     */
    public function get_user($user)
    {
        $this->db->select('users.*, user_details.*, addresses.address_line1, addresses.address_line2, addresses.city, addresses.state, addresses.postal_code, addresses.country');
        $this->db->join('user_details', 'users.id = user_details.user_id', 'left');
        $this->db->join('addresses', 'addresses.id = user_details.address_id', 'left');
        $this->db->where($user);
        $query = $this->db->get('users');

        return $query->row();
    }

    /**
     * Get user and teacher details with simple `where` array
     *
     * @param $user
     * @return mixed
     */
    public function get_teacher_details($user)
    {
        $this->db->where($user);
        $this->db->join('teacher_details', 'users.id = teacher_details.user_id', 'left');
        $query = $this->db->get('users');

        return $query->row();
    }

    public function get_teacher($teacher_id)
    {
        $this->db->join('teacher_details as td', 'td.user_id = users.id', 'left');
        $this->db->join('user_details as ud', 'ud.user_id = users.id', 'left');
        $this->db->where('users.id', $teacher_id);

        $query = $this->db->get('users');
        return $query->row();
    }

    /**
     * Get user by id
     *
     * @param null $id
     * @return bool|mixed|null|string
     */
    public function get_by_id($id = null)
    {
        if ($id == null) {
            $id = $this->session->userdata('login')['user_id'];
        }

        return $this->get_user(['users.id' => $id]);
    }

    /**
     * Get login user
     * This function handle validation and get query for user login
     *
     * @param $data
     * @return bool|mixed|null|string
     */
    public function get_user_login($data)
    {
        $rule = UserStatic::get_rule('login');
        $rule = $this->_push_custom_lang($rule);
        if ($this->_validate($rule) == false) {
            return false;
        }

        $field = (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) ? 'email' : 'username';
        $option = [
            $field => $data['email'],
            'status' => UserStatic::STATUS_ACTIVE
        ];

        return $this->get_user($option);
    }

    /**
     * @param $post
     * @return array|bool
     */
    public function register($post)
    {
        $rule = UserStatic::get_rule('register');
        $rule = $this->_push_custom_lang($rule);
        if ($this->_validate($rule) == false) {
            return false;
        }

        $this->db->trans_start();
        $user_data = $this->_sanitize_input($post, 'register');

        $this->db->insert('users', $user_data);
        $post['id'] = $this->db->insert_id();
        if ($post['id'] == false) {
            return false;
        }

        $user_data['id'] = $post['id'];
        $user_detail = $this->_sanitize_input($post, 'register_detail');
        $this->db->insert('user_details', $user_detail);
        $this->db->trans_complete();
        return $user_data;
    }

    /**
     * @param $post
     * @return array|bool
     */
    public function pre_register($post)
    {
        $rule = UserStatic::get_rule('pre_register');
        $rule = $this->_push_custom_lang($rule);
        if ($this->_validate($rule) == false) {
            return false;
        }

        $this->db->trans_start();
        $user_data = $this->_sanitize_input($post, 'pre_register');
        $this->db->insert('users', $user_data);

        $post['id'] = $this->db->insert_id();
        if ($post['id'] == false) {
            return false;
        }

        $user_detail = $this->_sanitize_input($post, 'register_detail');
        $this->db->insert('user_details', $user_detail);
        $this->db->trans_complete();
        return $user_data;
    }

    /**
     * @param $user
     * @param bool $update
     * @return bool|CI_DB_active_record|CI_DB_result
     */
    public function fb_register($user, $update = false)
    {
        $this->db->trans_start();
        $user = (array) $user;
        if ($update) {
            $id = $user['id'];
            unset($user['id']);
            $this->db->where('users.id', $id);
            $result = $this->update_user($id, $user, false);
        } else {
            $this->load->helper('string');
            $user = array_merge($user, [
                'status' => \UserStatic::STATUS_ACTIVE,
                'type' => \UserStatic::TYPE_CUSTOMER,
                'reg_key' => random_string('alnum', 16),
                'pre_register' => 1,
                'send_updates' => 1
            ]);

            $user_detail['birth_date'] = $user['birth_date'];
            unset($user['birth_date']);

            $insert = $this->db->insert('users', $user);

            if (!$insert) {
                return false;
            }

            $user['id'] = $this->db->insert_id();

            $user_detail['user_id'] = $user['id'];
            $result = $this->db->insert('user_details', $user_detail);
        }

        $this->db->trans_complete();
        return $result;
    }

    /**
     * @param $id
     * @param $post
     * @param bool $validate
     * @return bool|CI_DB_active_record|CI_DB_result
     */
    public function update_user($id, $post, $validate = TRUE)
    {
        $param = ['id' => $id];
        $rule = UserStatic::get_rule('update', $param);
        $rule = $this->_push_custom_lang($rule);
        if ($validate == true) {
            if ($this->_validate($rule) == false) {
                return false;
            }
        }

        $this->db->where('users.id', $id);
        $result = $this->db->update('users', [
            'first_name' => $post['first_name'],
            'last_name' => $post['last_name'],
            'email' => $post['email'],
            'username' => $post['username']
        ]);

        return $result;
    }

    /**
     * Save user profile
     * Set the $id for admin use, otherwise it will grab current user id.
     *
     * @param $post
     * @param null $id
     * @return bool|CI_DB_active_record|CI_DB_result
     */
    public function save_profile($post, $id = null)
    {
        // if not admin, set id to current user login
        if ($id == null) {
            $id = $this->session->userdata('login')['user_id'];
        }

        // get rules for save_profile
        $post['id'] = $id;
        $rules = UserStatic::get_rule('save_profile', $post);
        $rules = $this->_push_custom_lang($rules);
        if ($this->_validate($rules) == false) {
            return false;
        }

        // sanitize input for each table (users and user_details)
        $user = $this->_sanitize_input($post, 'save_profile');
        if (isset($post['profile_pic'])) {
            $user['profile_pic'] = $post['profile_pic'];
        }
        $user_detail = $this->_sanitize_input($post, 'save_detail_profile');

        // save profile to users table
        $this->db->where('users.id', $id);
        $update = $this->db->update('users', $user);

        // save profile to user_details table
        $this->db->where('user_id', $id);
        $this->db->update('user_details', $user_detail);

        // save address to addresses table
        $rules = AddressStatic::get_rule('add', $post);
        $rules = $this->_push_custom_lang($rules);
        if ($this->_validate($rules) == false) {
            return false;
        }
        $address_data = $this->_sanitize_input($post, 'save_address');
        $user = $this->get_user(['users.id' => $id]);

        $this->load->model('address_model');
        $address = $this->address_model->get_address($user->address_id);

        // If address exists, update
        if ($address) {
            $this->address_model->update_address($address->id, $address_data);
        }
        // If not, make a new one
        else {
            $address_id = $this->address_model->create_address($address_data);
            // save profile to user_details table
            $this->db->where('user_id', $id);
            $this->db->update('user_details', ["address_id" => $address_id]);
        }

        return $update;
    }

    /**
     * Save teacher profile
     * Set the $id for admin use, otherwise it will grab current user id.
     *
     * @param $post
     * @param null $id
     * @return bool|CI_DB_active_record|CI_DB_result
     */
    public function update_teacher_profile($post, $id = null)
    {
        // if not admin, set id to current user login
        if ($id == null) {
            $id = $this->session->userdata('login')['user_id'];
            $rule = TeacherDetailStatic::get_rule('update');
        } else {
            $rule = TeacherDetailStatic::get_rule('update_admin');            
        }

        $rule = $this->_push_custom_lang($rule);
        if ($this->_validate($rule) == false) {
            return false;
        }

        // sanitize input for each table (users and user_details)
        $user = $this->_sanitize_input($post, 'update_teacher');

        // create teacher details if not exist before (for become teacher)
        $this->db->where('user_id', $id);
        $teacher_details = $this->db->get('teacher_details')->row();
        if ($teacher_details) {
            $this->db->where('user_id', $id);
            $update = $this->db->update('teacher_details', $user);
        } else {
            $user['user_id'] = $id;
            $update = $this->db->insert('teacher_details', $user);
        }

        return $update;
    }

    /**
     * Update password for teacher and student
     * Set the $id for admin use, otherwise it will grab current user id.
     *
     * @param $post
     * @param null $id
     * @return bool|CI_DB_active_record|CI_DB_result
     */
    public function update_password($post, $id = null)
    {
        // if not admin, set id to current user login
        if ($id == null) {
            $id = $this->session->userdata('login')['user_id'];
            $rules = UserStatic::get_rule('update_password');
        } else {
            $rules = UserStatic::get_rule('update_password_admin');            
        }

        // var_dump($post['password']);

        // get rules for save_profile
        $rules = $this->_push_custom_lang($rules);
        if ($this->_validate($rules) == false) {
            return false;
        }

        $this->load->library('encrypt');
        $this->db->set('password', $this->encrypt->encode($post['password']));
        $this->db->where('users.id', $id);
        return $this->db->update('users');

    }

    public function update_notification($post, $id = null)
    {
        // if not admin, set id to current user login
        if ($id == null) {
            $id = $this->session->userdata('login')['user_id'];
        }

        // get rules for update_notification
        $rules = UserStatic::get_rule('update_notification');
        $rules = $this->_push_custom_lang($rules);
        if ($this->_validate($rules) == false) {
            return false;
        }
        $user_detail = $this->_sanitize_input($post, 'update_notification_user');

        // get rules for update_notification
        $rules = TeacherDetailStatic::get_rule('update_notification');
        $rules = $this->_push_custom_lang($rules);
        if ($this->_validate($rules) == false) {
            return false;
        }
        $teacher_detail = $this->_sanitize_input($post, 'update_notification_teacher');

        $this->db->where('user_id', $id);
        $update = $this->db->update('user_details', $user_detail);

        $this->db->where('user_id', $id);
        $update &= $this->db->update('teacher_details', $teacher_detail);

        return $update;
    }

    public function update_notification_newsletter($notif, $user_email) 
    {
        if ($notif) {
            $already_notified = $this->db->where('email', $user_email)->get('notification_newsletters')->row();
            if (!$already_notified) {
                $this->db->insert('notification_newsletters', ['email' => $user_email]);
            }
        } else {
            $this->db->where('email', $user_email);
            $this->db->delete('notification_newsletters');
        }
    }

    /**
     * @param $id
     * @param $status
     * @param null $clearRegKey
     * @return bool|null|string
     */
    public function set_status($id, $status, $clearRegKey = null)
    {
        $data['status'] = $status;
        if ($clearRegKey != null) {
            $data['reg_key'] = "";
        }

        $this->db->where('users.id', $id);
        $user = $this->db->update('users', $data);
        return $user;
    }

    /**
     * @param $post
     * @return bool|mixed|null|string
     */
    public function forgot_password($post)
    {
        $rule = UserStatic::get_rule('forgot-password');
        $rule = $this->_push_custom_lang($rule);
        if ($this->_validate($rule) == false) {
            return false;
        }

        $user = $this->get_user(['email' => $post['email']]);

        if (!$user) {
            return null;
        }

        if (empty($user->forgot_key)) {
            $this->load->helper(['string', 'date']);
            $forgot_key = random_string('alnum', 16);
        } else {
            $forgot_key = $user->forgot_key;
        }

        $this->db->where('email', $post['email']);
        $this->db->update('users', [
            'forgot_key' => $forgot_key,
            'forgot_expire' => strftime("%Y-%m-%d %H:%M:%S", strtotime('+1 day', now()))
        ]);

        $user->forgot_key = $forgot_key;

        return $user;
    }

    /**
     * @param $user_data
     * @return bool|null|string
     */
    public function reset_password($user_data)
    {
        $rule = UserStatic::get_rule('reset_password');
        $rule = $this->_push_custom_lang($rule);
        if ($this->_validate($rule) == false) {
            return false;
        }

        $this->db->where('email', $user_data['email']);
        $result = $this->db->update('users', [
            'password' => $this->encrypt->encode($user_data['password']),
            'forgot_key' => ''
        ]);

        return $result;
    }

    /**
     * @param $post
     * @return bool|mixed|null|string
     */
    public function resend_email($post)
    {
        // TODO: define time limit for request send email
        $rule = UserStatic::get_rule('resend');
        $rule = $this->_push_custom_lang($rule);
        if ($this->_validate($rule) == false) {
            return false;
        }
        return $this->get_user(['email' => $post['email']]);
    }

    /**
     * Check email and forgot_key for reset password
     *
     * @param $post
     * @return bool
     */
    public function check_reset_password($post)
    {
        $user = $this->get_user(['email' => $post['email'], 'forgot_key' => $post['forgot_key']]);
        if ($user)
        {
            $this->load->helper('date');
            if (strtotime($user->forgot_expire) > now()) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $data
     * @return bool
     */
    public function send_email_contact_us($data)
    {
        $rule = UserStatic::get_rule('send_email_contact_us');
        $rule = $this->_push_custom_lang($rule);
        if ($this->_validate($rule) == false) {
            return false;
        }

        return $data;

    }

    public function become_student($id = null)
    {
        if ($id == null) {
            $id = $this->session->userdata('login')['user_id'];
        }
        $this->db->where('users.id', $id);
        $this->db->update('users', [
            'is_student' => 1
        ]);
    }

    public function stop_become_student($id = null)
    {
        if ($id == null) {
            $id = $this->session->userdata('login')['user_id'];
        }
        $this->db->where('users.id', $id);
        $this->db->update('users', [
            'is_student' => 0
        ]);
    }

    public function become_teacher($id = null)
    {
        if ($id == null) {
            $id = $this->session->userdata('login')['user_id'];
        }
        $this->db->where('users.id', $id);
        $this->db->update('users', [
            'is_teacher' => 1
        ]);
    }

    public function stop_become_teacher($id = null)
    {
        if ($id == null) {
            $id = $this->session->userdata('login')['user_id'];
        }
        $this->db->where('users.id', $id);
        $this->db->update('users', [
            'is_teacher' => 0
        ]);
    }
}
