<?php

    function set_checkbox($field, $value = '', $default = FALSE, $method = 'post')
    {
        $CI =& get_instance();

        if (isset($CI->form_validation) && is_object($CI->form_validation) && $CI->form_validation->has_rule($field))
        {
            return $CI->form_validation->set_checkbox($field, $value, $default);
        }

        // Form inputs are always strings ...
        $value = (string) $value;
        if($method == 'post')
            $input = $CI->input->post($field, FALSE);
        else
            $input = $CI->input->get($field, FALSE);

        if (is_array($input))
        {
            // Note: in_array('', array(0)) returns TRUE, do not use it
            foreach ($input as &$v)
            {
                if ($value === $v)
                {
                    return ' checked="checked"';
                }
            }

            return '';
        }

        // Unchecked checkbox and radio inputs are not even submitted by browsers ...
        if ($CI->input->method() === 'post')
        {
            return ($input === $value) ? ' checked="checked"' : '';
        }

        return ($default === TRUE) ? ' checked="checked"' : '';
}
