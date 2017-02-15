<?php

class MY_Exceptions extends CI_Exceptions
{
    /**
     * 404 Error Handler
     *
     * @uses	MY_Exceptions::show_error()
     *
     * @param	string	$page		Page URI
     * @param 	bool	$log_error	Whether to log the error
     * @return	void
     */
    public function show_404($page = '', $log_error = TRUE)
    {
        if (is_cli())
        {
            $heading = 'Not Found';
            $message = 'The controller/method pair you requested was not found.';
        }
        else
        {
            $heading = 'Page Not Found';
            $message = 'Sorry, but we couldn\'t find the page you are looking for';
        }

        // By default we log this, but allow a dev to skip it
        if ($log_error)
        {
            log_message('error', $heading.': '.$page);
        }

        echo $this->show_error($heading, $message, 'error_404', 404);
        exit(4); // EXIT_UNKNOWN_FILE
    }

    /**
     * General Error Page
     *
     * Takes an error message as input (either as a string or an array)
     * and displays it using the specified template.
     *
     * @param	string		$heading	Page heading
     * @param	string|string[]	$message	Error message
     * @param	string		$template	Template name
     * @param 	int		$status_code	(default: 500)
     *
     * @return	string	Error page output
     */
    public function show_error($heading, $message, $template = 'error_general', $status_code = 500)
    {

        $templates_path = 'errors'.DIRECTORY_SEPARATOR;

        if (is_cli())
        {
            $message = "\t".(is_array($message) ? implode("\n\t", $message) : $message);
            $template = 'cli'.DIRECTORY_SEPARATOR.$template;
        }
        else
        {
            set_status_header($status_code);
            $message = '<p>'.(is_array($message) ? implode('</p><p>', $message) : $message).'</p>';
            $template = 'html'.DIRECTORY_SEPARATOR.$template;
        }

        $CI =& get_instance();
        if (null == $CI) {
            $CI = new CI_Controller();
            $CI->load->library('twig');
        }
        $buffer = $CI->twig->render($templates_path.$template, [
            'message' => $message,
            'status_code' => $status_code,
            'heading' => $heading
        ]);
        return $buffer;
    }
}
