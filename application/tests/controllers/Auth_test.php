<?php

class Auth_test extends TestCase
{
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        $CI =& get_instance();
        $CI->load->library('Migration');
        $CI->load->library('Twig');
        $CI->migration->latest();
    }

    public function test_login_index()
    {
        $output = $this->request('get', 'auth/login');
        $this->assertContains('<form method="post" action="' . base_url() . 'login">', $output);
    }

    public function test_admin_login_failure()
    {
        $this->request('POST', 'auth/post_login', [
            'username' => 'admin@skillagogo.com',
            'password' => 'admin'
        ]);

        $this->assertRedirect('login');
    }

    public function test_user_login_success()
    {

    }

    public function test_user_login_email_not_registered()
    {

    }

    public function test_user_login_wrong_password()
    {

    }

    public function test_register()
    {

    }
}
