<?php

if (!function_exists('line')) {
    function line($line, $file)
    {
        $lang = get_instance()->session->userdata('lang');
        get_instance()->load->language($file, $lang);
        $line = get_instance()->lang->line($line);

        return $line;
    }
}
