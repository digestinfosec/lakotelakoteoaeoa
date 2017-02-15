<?php

class Address_model extends MY_Model
{
    /**
     * @param $address_id
     * @return Obj for address
     */
    public function get_address($address_id)
    {
        $this->db->where('id', $address_id);
        $query = $this->db->get('addresses');

        return $query->row();
    }

    /**
     * @param $data
     * @return int
     */
    public function create_address($data)
    {
        $this->db->insert('addresses', $data);
        return $this->db->insert_id();
    }

    /**
     * @param $id
     * @param $data
     * @return bool
     */
    public function update_address($id, $data)
    {
        $this->db->where('id', $id);
        $update = $this->db->update('addresses', $data);

        if ($update)
            return $id;
        else
            return false;
    }
}
