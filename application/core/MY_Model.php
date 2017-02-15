<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model
{
    function _validate($rules)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules($rules);
        return $this->form_validation->run();
    }

    function _push_custom_lang($rules)
    {
        $_rules = array();
        foreach($rules as $rule) {
            $rule['label'] = line($rule['field'], 'field');
            $rule['errors'] = [
                "is_unique" => line('is_unique', 'form_validation'),
                "required" => line('required', 'form_validation'),
                "check_update_password" => line('check_update_password', 'form_validation'),
                "check_email" => line('check_email', 'form_validation'),
                "integer" => line('integer', 'form_validation'),
                "check_email_resend" => line('check_email_resend', 'form_validation'),
                "matches" => line('matches', 'form_validation'),
                "date" => line('date', 'form_validation'),
                "regex_match" => line('regex_match', 'form_validation'),
                "max_length" => line('max_length', 'form_validation'),
                "greater_than" => line('greater_than', 'form_validation'),
                "less_than" => line('less_than', 'form_validation'),
                "double_unique_current_user" => line('double_unique_current_user', 'form_validation'),
                "valid_url" => line('valid_url', 'form_validation'),
                "check_user_indonesia" => line('check_user_indonesia', 'form_validation'),
                "check_user_singapore" => line('check_user_singapore', 'form_validation')
            ];
            $_rules[] = $rule;
        }
        return $_rules;
    }
}
