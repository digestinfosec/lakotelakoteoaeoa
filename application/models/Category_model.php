<?php

class Category_model extends MY_Model
{
    // Get all categories with their subcategories
    public function get_category_tree()
    {
        $this->db->select("id, name");
        $this->db->where('parent_id', 0);
        $query = $this->db->get('categories');
        $categories = $query->result();

        foreach ($categories as $key => $category) {
            $category->child = $this->db->select("id, name")
                ->where('parent_id', $category->id)
                ->get('categories')
                ->result();
        }

        return $categories;
    }

    // Get all categories
    public function get_categories()
    {
        $this->db->select('*');
        $this->db->from('categories');
        $query = $this->db->get();

        return $query->result();
    }

    // Get category with $id
    public function get_category($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('categories');

        return $query->row();
    }

    // Get category code
    public function get_category_code($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('categories');
        $category = $query->row();

        return $category->code;
    }
}
