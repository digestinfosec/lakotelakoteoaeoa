<?php

class Bank_model extends MY_Model
{
    /**
     * Get built option banks
     *
     * this function is for teacher profile,
     * I think this is wrong when populate bank field from user languange.
     * Is it necessary to add nationality to user profile.
     *
     * @param string $language
     * @return array
     */
    public function get_banks($language = null) 
    {
        if ($language == null) $language = $this->session->userdata('lang');

        $country_code = $language == 'indonesian' ? 'IDN' : 'SGP';

        $this->db->where('country_code', $country_code);
        $query = $this->db->get('banks');

        $result = $query->result_array();
        array_unshift($result, ['name' => line('choose_one', 'field'), 'id' => '']);
        return \Scienceguard\SG_Util::arrayMapOption($result, 'name', 'id');
    }
}
