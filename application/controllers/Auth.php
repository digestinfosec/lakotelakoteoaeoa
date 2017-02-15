<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "libraries/Public_Controller.php";

/**
 * Class Auth
 */
class Auth extends Public_Controller
{

    protected $setCurrentUrl = false;

    use \Skillagogo\Callback\UserCallback;

    /**
     * Auth constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('encrypt');
        $this->load->model('user_model');
    }

    /**
     * Handle User Login
     */
    public function login()
    {
        if ($this->is_post()) {

            $post = $this->input->post();
            $user = $this->user_model->get_user_login($post);

            if ($user) {
                if ($this->encrypt->decode($user->password) == $post['password']) {
                    $this->set_login_session($user, $post);

                    // Log login
                    $date = new DateTime();
                    $message = $date->format('Ymd_H:i:s') . ',1000,' .
                        $user->id . ',' .
                        'LOGIN' . ',' .
                        $this->input->ip_address() . ';' .
                        'Email';
                    $this->log_activity_data_record($message);

                    if ($referrer = $this->input->get('referrer')) {
                        redirect($referrer);
                    }
                    redirect('/');
                }
                $this->data['error'] = line('error_auth_login', 'controller_js');
            } else {
                $this->data['error'] = line('error_auth_login_2', 'controller_js');
            }
            $this->data['error'] = validation_errors() ? validation_errors() : $this->data['error'];
        }

        $this->check_login();
        $this->twig->display("public/auth/login", $this->data);
    }

    /**
     * Logout User
     */
    public function logout()
    {
        // Log logout
        $date = new DateTime();
        $message = $date->format('Ymd_H:i:s') . ',1001,' .
            $this->session->userdata('login')['user_id'] . ',' .
            'LOGOUT' . ',' .
            $this->input->ip_address() . ';';
        $this->log_activity_data_record($message);

        $this->session->unset_userdata('login');
        $this->session->unset_userdata('location');
        $this->session->unset_userdata('lang');
        $user_data = $this->session->all_userdata();

        foreach ($user_data as $key => $value) {
            if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
                $this->session->unset_userdata($key);
            }
        }

        redirect('/');
    }

    /**
     * Register User
     */
    public function register()
    {
        if ($this->is_post()) {

            $this->check_login();
            $post = $this->input->post();

            !empty($post['role']) && $post['role'] == 'teacher' ? $post['is_teacher'] = 1 : $post['is_student'] = 1;
            $post = array_merge($post);

            $user = $this->user_model->register($post);

            if ($user) {
                $this->send_notification_email((array)$user, line('email_auth_register', 'controller_js'),
                    'email/activation_link_register_en');

                // $this->check_login();
                // $this->twig->display("email/activation_link_register_en", $user);
                // return;

                // Log register
                $date = new DateTime();
                $message = $date->format('Ymd_H:i:s') . ',1004,' .
                    $user['id'] . ',' .
                    'REGISTER' . ',' .
                    $this->input->ip_address();
                $this->log_activity_data_record($message);

                $this->data['message_content'] = line('success_auth_register', 'controller_js') . $post['email'];
                $this->twig->display("public/home/confirmation", $this->data);
                return;

            }
            $this->data['error'] = validation_errors() ? validation_errors() : '<p>Unknown Error.</p>';
        }

        $this->check_login();
        $this->twig->display("public/auth/register", $this->data);
    }

    /**
     * @param $reg_key
     */
    public function confirm($reg_key = "")
    {
        $user = $this->user_model->get_user(['reg_key' => $reg_key]);

        if ($user) {

            // If user is already activated
            if ($user->status == UserStatic::STATUS_ACTIVE) {
                redirect('/');
            }

            $this->user_model->set_status($user->id, UserStatic::STATUS_ACTIVE, true);
            $user = $this->user_model->get_user(['users.id' => $user->id]);
            $this->set_login_session($user);

            if ($user->is_teacher == 1) {
                $this->send_notification_email((array)$user, line('email_auth_confirm', 'controller_js'),
                    'email/welcome_email_teacher_en');
            } else {
                $this->send_notification_email((array)$user, line('email_auth_confirm', 'controller_js'),
                    'email/welcome_email_student_en');
            }

            $this->data['message_content'] = line('success_auth_confirm', 'controller_js');
            $this->twig->display("public/home/confirmation", $this->data);
            return;
        }

        $this->data['message_content'] = line('error_auth_confirm', 'controller_js');
        $this->twig->display("public/home/confirmation", $this->data);
    }

    public function forgot_password()
    {
        if ($this->is_login()) {
            redirect('/');
        }

        if ($this->is_post()) {
            $this->load->helper('date');
            $post = $this->input->post();
            $user = $this->user_model->forgot_password($post);

            if ($user) {
                $this->send_notification_email((array)$user, line('email_auth_forgot_password', 'controller_js'),
                    'email/reset_password_en');

                // $this->twig->display("email/reset_password_en", (array)$user);
                // return;

                $this->data['message_content'] = line('email_sent_to_you', 'controller_js');
                $this->twig->display("public/home/confirmation", $this->data);
                return;
            }

            $this->session->set_flashdata('reset_pw_error', line('error_auth_forgot_password', 'controller_js'));
            $this->data['reset_pw_error'] = $this->session->flashdata('reset_pw_error');
        }

        $this->twig->display('public/auth/forgot_password', $this->data);
    }

    /**
     *
     */
    public function reset_password()
    {
        $email = urldecode($this->uri->segment(3));
        $key = $this->uri->segment(4);

        if (isset($email) && isset($key)) {
            $check = $this->user_model->check_reset_password(['email' => $email, 'forgot_key' => $key]);
            if ($check) {
                $this->load->helper('form');

                if ($this->is_post()) {
                    $post = $this->input->post();
                    $post['email'] = $email;
                    $reset = $this->user_model->reset_password($post);

                    if ($reset) {
                        $user = $this->user_model->get_user(['email' => $email]);
                        // Log
                        $date = new DateTime();
                        $message = $date->format('Ymd_H:i:s') . ',1003,' .
                            $user->id . ',' .
                            'CHANGEPASSWORD';
                        $this->log_activity_data_record($message);

                        // Send email
                        $this->send_notification_email((array)$user,
                            line('email_auth_reset_password', 'controller_js'),
                            'email/reset_password_success_en');
                        $this->data['message_content'] = line('email_sent_to_you', 'controller_js');
                        $this->twig->display("public/home/confirmation", $this->data);
                        return;
                    }

                }

                $this->twig->display('public/auth/reset_password', []);
                return;
            }
        }
        redirect('/');
    }

    /**
     *
     */
    public function resend_confirmation()
    {
        $this->load->helper('form');

        if ($this->is_post()) {
            $post = $this->input->post();
            $user = $this->user_model->resend_email($post);

            if ($user) {
                // If user is already activated
                if ($user->status == UserStatic::STATUS_ACTIVE) {
                    redirect('/');
                }
                $this->send_notification_email((array)$user, line('email_auth_resend_confirmation', 'controller_js'),
                    'email/activation_link_register_en');
                $this->data['message_content'] = line('email_sent_to_you', 'controller_js');
                $this->twig->display("public/home/confirmation", $this->data);
                return;
            }
            $this->session->set_flashdata('resend_confirmation_error', line('error_auth_forgot_password', 'controller_js'));
            $this->data['resend_confirmation_error'] = $this->session->flashdata('resend_confirmation_error');                
        }

        $this->twig->display('public/auth/resend_confirmation', $this->data);
    }

    /**
     * @throws \Facebook\Exceptions\FacebookSDKException
     * TODO: Exception Handler for all errors in facebook login / register
     */
    public function fb_login()
    {
        if ($this->input->get('error')) {
            redirect('/');
        }

        $this->session->set_userdata('fb_login', $this->input->get('form'));

        $fb = new \Facebook\Facebook([
            'app_id' => $this->config->item('facebook_id'),
            'app_secret' => $this->config->item('facebook_secret'),
            'default_graph_version' => 'v2.6',
        ]);
        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            //show_404();
            echo 'Graph returned an error: ' . $e->getMessage();
            //exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            //show_404();
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            //exit;
        }

        if (!isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            //exit;
            show_404();
        }
        $oAuth2Client = $fb->getOAuth2Client();
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        $tokenMetadata->validateAppId($this->config->item('facebook_id'));
        $tokenMetadata->validateExpiration();

        if (!$accessToken->isLongLived()) {
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
                //exit;
                //show_404();
            }
        }
        $response = $fb->get('/me?fields=id,first_name,last_name,email,birthday,verified,picture,locale', $accessToken);

        $response_granted = $fb->get('me/permissions/email', $accessToken);
        $body = $response->getDecodedBody();

        if ($response_granted->getDecodedBody()['data'][0]['status'] == 'declined') {
            $fb = new \Facebook\Facebook([
                'app_id' => $this->config->item('facebook_id'), // Replace {app-id} with your app id
                'app_secret' => $this->config->item('facebook_secret'),
                'default_graph_version' => 'v2.6',
            ]);
            $helper = $fb->getRedirectLoginHelper();
            $permissions = ['public_profile', 'email', 'user_birthday'];
            $reAuthUrl = $helper->getReRequestUrl(base_url() . 'auth/fb-login', $permissions);

            redirect($reAuthUrl);
        } else {
            $user = $this->user_model->get_user(['fb_id' => $body['id']]);
            // If user already connect to facebook
            if ($user) {
                $user->user_id = $user->id;
                $user->fb_token = $accessToken;
                $this->user_model->fb_register($user, true);
            } else {
                $user = $this->user_model->get_user(['email' => $body['email']]);
                // if facebook email already registered
                if ($user) {
                    $user->fb_id = $body['id'];
                    $user->fb_token = $accessToken;
                    $this->user_model->fb_register($user, true);
                    //if facebook email not registered
                } else {
                    $this->user_data['email'] = $body['email'];
                    $this->user_data['first_name'] = $body['first_name'];
                    $this->user_data['last_name'] = $body['last_name'];
                    $this->user_data['birth_date'] = date("Y-m-d", strtotime($body['birthday']));
                    $this->user_data['fb_id'] = $body['id'];
                    $this->user_data['fb_token'] = $accessToken;
                    $this->user_data['is_student'] = 1;

                    $this->user_model->fb_register($this->user_data);
                    $user = $this->user_model->get_user(['email' => $body['email']]);
                    $this->send_notification_email((array)$user, line('email_auth_confirm', 'controller_js'),
                        'email/welcome_email_student_en');
                }
            }
            if ($this->config->item('coming-soon') == true) {
                redirect('thank-you');
            }

            // Log FB Login
            $date = new DateTime();
            $message = $date->format('Ymd_H:i:s') . ',1000,' .
                $user->id . ',' .
                'LOGIN' . ',' .
                $this->input->ip_address() . ';' .
                'Facebook';
            $this->log_activity_data_record($message);

            $this->set_login_session($user);
            redirect('/');
        }

    }

    /**
     * Set Login Session
     *
     * @param $user
     * @param null $post
     */
    protected function set_login_session($user, $post = null)
    {
        $nationality = $user->nationality == "IDN" ? "Indonesia" : "Singapore";

        $this->session->set_userdata('login', [
            'status' => true,
            'email' => $user->email,
            'avatar' => $user->profile_pic,
            'user_id' => $user->id,
            'is_teacher' => $user->is_teacher,
            'is_student' => $user->is_student,
            'type' => $user->type,
            'name' => $user->first_name . " " . $user->last_name,
            'first_name' => $user->first_name,
            'country_id' => $user->nationality,
            'nationality' => $nationality,
        ]);

        // TODO: Fix Remember Me
        if (isset($post['remember_me'])) {
            //$this->config->set_item('sess_expiration', '1209600');
            //$this->config->set_item('sess_expire_on_close', 0);

            //$this->session->sess_update();
        }
    }

}
/* End of file '/Auth.php' */
/* Location: ./application/controllers//Auth.php */
