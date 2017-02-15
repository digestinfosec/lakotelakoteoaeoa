<?php

use Scienceguard\SG_Util;

class Wishlist_model extends MY_Model
{
    var $user_id;

    function __construct()
    {
        parent::__construct();
        $this->user_id = $this->session->userdata('login')['user_id'];
    }

    private function _sanitize_input($mode = 'update', $input = array())
    {
        $post = $this->input->post();

        $data = array(
            'user_id' => $this->user_id,
            'class_id' => SG_Util::val($post, 'id')
        );

        if ($mode == 'update') {
            unset($data['created_at']);
        }
        return $data;
    }

    public function add_wishlist($input = array())
    {
        if ($this->check_wishlist()) {
            // insert to class_wishlists table
            $data = $this->_sanitize_input('insert', $input);
            $this->db->insert('class_wishlists', $data);
            return true;
        } else {
            // delete from class_wishlists table
            $this->db->where('class_id', $this->input->post('id'));
            $this->db->where('user_id', $this->user_id);
            $this->db->delete('class_wishlists');
            return false;
        }
    }

    public function check_wishlist()
    {
        $class_id = $this->input->post('id');
        $user_id = $this->user_id;
        $this->db->select('user_id');
        $this->db->from('class_wishlists');
        $this->db->where('class_id', $class_id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        $num = $query->num_rows();
        if ($num > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function get_count_wishlist($course_id, $params = null)
    {
        $this->db->select('*, count(1) as data');
        $this->db->from('class_wishlists');
        $this->db->join('classes', 'classes.id = class_wishlists.class_id', 'left');
        $this->db->where('class_id', $course_id);
        $query = $this->db->get();
        return $query->row();
    }
}
