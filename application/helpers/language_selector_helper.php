<?php
if (!function_exists('lang_select')) {
    function lang_select($lang_id = "IDN")
    {
        get_instance()->session->set_userdata('lang', $lang_id);
    }
}
