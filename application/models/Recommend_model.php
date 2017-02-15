<?php

class Recommend_model extends MY_Model
{
    public function send_recommendation($data)
    {
        $rule = RecommendStatic::get_rule('recommend_teacher');
        $rule = $this->_push_custom_lang($rule);
        if ($this->_validate($rule) == false) {
            return false;
        }
        $data['status'] = RecommendStatic::STATUS_UNREAD;
        return $this->db->insert('recommend_teachers', $data);
    }
}
