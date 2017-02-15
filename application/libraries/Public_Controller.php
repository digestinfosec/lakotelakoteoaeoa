<?php

class Public_Controller extends MY_Controller
{
    protected $caching_time = 600;

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('sg_form');

        // set default data values
        $this->data['values'] = $_POST;
        $this->data['get_values'] = $_GET;

        $this->data['alert'] = array(
            'error' => $this->session->flashdata('alert_error'),
            'success' => $this->session->flashdata('alert_success'),
            'form_errors' => $this->session->flashdata('alert_form_errors'),
            'deleted' => $this->session->flashdata('alert_deleted'),
        );

    }
}
