<?php

if (!function_exists('admin_url')) {
    function admin_url($uri = '', $protocol = null)
    {
        return get_instance()->config->base_url(get_instance()->config->item('admin_url') . '/' . $uri, $protocol);
    }
}

if (!function_exists('dashboard_url')) {
    function dashboard_url($uri = '', $protocol = null)
    {
        return get_instance()->config->base_url(get_instance()->config->item('dashboard_url') . '/' . $uri, $protocol);
    }
}

if (!function_exists('redirect_back'))
{
    function redirect_back()
    {
        if(isset($_SERVER['HTTP_REFERER']))
        {
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
        else
        {
            header('Location: http://'.$_SERVER['SERVER_NAME']);
        }
        exit;
    }
}

if (!function_exists('url_to_html'))
{
    function url_to_html($text)
    {
        $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
        $text = preg_replace($url, '<a href="http$2://$4" target="_blank" title="$0">$0</a>', $text);
        return $text;
    }
}
function current_url()
{
    $CI =& get_instance();

    $url = $CI->config->site_url($CI->uri->uri_string());
    return isset($_SERVER['QUERY_STRING']) ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
}
