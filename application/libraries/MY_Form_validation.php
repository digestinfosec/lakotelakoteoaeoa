<?php

/**
 * Class MY_Form_validation
 */
class MY_Form_validation extends CI_Form_validation
{

    /**
     * MY_Form_validation constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $str
     * @param $field
     * @return bool
     */
    public function edit_unique($str, $field)
    {
        sscanf($field, '%[^.].%[^.].%[^.]', $table, $field, $id);
        return isset($this->CI->db)
            ? ($this->CI->db->limit(1)->get_where($table, array($field => $str, 'id !=' => $id))->num_rows() === 0)
            : false;
    }

    function valid_date($str, $params)
    {
        // setup
        $params = explode(',', $params);
        $delimiter = $params[1];
        $date_parts = explode($delimiter, $params[0]);

        // get the index (0, 1 or 2) for each part
        $di = $this->valid_date_part_index($date_parts, 'd');
        $mi = $this->valid_date_part_index($date_parts, 'm');
        $yi = $this->valid_date_part_index($date_parts, 'y');

        // regex setup
        $dre = "(0?1|0?2|0?3|0?4|0?5|0?6|0?7|0?8|0?9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31)";
        $mre = "(0?1|0?2|0?3|0?4|0?5|0?6|0?7|0?8|0?9|10|11|12)";
        $yre = "([0-9]{4})";
        $red = '' . $delimiter; // escape delimiter for regex
        $rex = "/^[0]{$red}[1]{$red}[2]/";

        // do replacements at correct positions
        $rex = str_replace("[{$di}]", $dre, $rex);
        $rex = str_replace("[{$mi}]", $mre, $rex);
        $rex = str_replace("[{$yi}]", $yre, $rex);

        if (preg_match($rex, $str, $matches)) {
            // skip 0 as it contains full match, check the date is logically valid
            if (checkdate($matches[$mi + 1], $matches[$di + 1], $matches[$yi + 1])) {
                return true;
            } else {
                // match but logically invalid
                $this->CI->form_validation->set_message('valid_date', "The date is invalid.");
                return false;
            }
        }

        // no match
        $this->CI->form_validation->set_message('valid_date', "The date format is invalid. Use {$params[0]}");
        return false;
    }

    function valid_date_part_index($parts, $search)
    {
        for ($i = 0; $i <= count($parts); $i++) {
            if ($parts[$i] == $search) {
                return $i;
            }
        }
    }

    function valid_international_phone($str)
    {
        $regex = "/^\+(?:[0-9] ?){6,14}[0-9]$/";
        return $this->regex_match($str, $regex);
    }

    function double_unique($str, $field) {
        sscanf($field, '%[^.].%[^.].%[^.]', $table, $field1, $field2);
        return isset($this->CI->db)
            ? ($this->CI->db->limit(1)
                    ->get_where($table, array($field1 => $str, $field2 => $this->_field_data[$field2]['postdata']))
                    ->num_rows() === 0)
            : false;
    }

    function double_unique_current_user($str, $field) {
        sscanf($field, '%[^.].%[^.].%[^.]', $table, $field1, $field2);
        return isset($this->CI->db)
            ? ($this->CI->db->limit(1)
                    ->get_where($table, array($field1 => $str, $field2 => $this->CI->session->userdata('login')['user_id']))
                    ->num_rows() === 0)
            : false;
    }

    public function valid_url($str)
    {
        // return (filter_var($str, FILTER_VALIDATE_URL) !== FALSE);
        return @fsockopen("$str", 80, $errno, $errstr, 30);
        
    }

}
