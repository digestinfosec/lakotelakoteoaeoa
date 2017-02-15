<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "libraries/Public_Controller.php";


class Auth extends Public_Controller
{
    use \Skillagogo\Callback\UserCallback;

    /**
     * Auth constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('encrypt');
        $this->load->model('admin_model');
    }

    /**
     * Handle User admin Login
     */
    public function login()
    {
        if ($this->is_post()) {

            $post = $this->input->post();
            $admin = $this->admin_model->get_admin_login($post);

            if ($admin) {
                if ($this->encrypt->decode($admin->password) == $post['password'] and ( $admin->type==\AdminStatic::TYPE_ADMIN or $admin->type==\AdminStatic::TYPE_REVIEW or $admin->type==\AdminStatic::TYPE_MARKETING )) {
                    $this->set_login_admin_session($admin, $post);

                    redirect('adminuao3hltbr0/home');
                }
                $this->data['error'] = "<p>Username or Password invalid</p>";
            } else {
                $this->data['error'] = "<p>User not found</p>";
            }
            $this->data['error'] = validation_errors() ? validation_errors() : $this->data['error'];
        }

        $this->check_login_admin();
        $this->twig->display('adminuao3hltbr0/login', $this->data);
    }

    /**
     * Logout User admin
     */
    public function logout()
    {
        $this->session->unset_userdata('login_admin');
        redirect('adminuao3hltbr0/login');
    }

    /**
     * Set Login Session
     *
     * @param $user
     * @param null $post
     */
    protected function set_login_admin_session($admin, $post = null)
    {
        $this->session->set_userdata('login_admin', [
            'status' => true,
            'email' => $admin->email,
            'avatar' => $admin->profile_pic,
            'admin_id' => $admin->id,
            'type' => $admin->type,
            'username' => $admin->username,
            'name' => $admin->first_name . " " . $admin->last_name,
        ]);
    }

}
