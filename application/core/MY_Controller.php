<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require_once APPPATH . "../src/skillagogo/Email/Sendpulse/sendpulseInterface.php";
require_once APPPATH . "../src/skillagogo/Email/Sendpulse/sendpulse.php";

class MY_Controller extends CI_Controller
{
    protected $data = array();

    public function __construct()
    {
        parent::__construct();

        $timezone = 'UTC';
        if (file_exists('/etc/sysconfig/clock')) {
            // RHEL / CentOS
            $data = parse_ini_file('/etc/sysconfig/clock');
            if (!empty($data['ZONE'])) {
                $timezone = $data['ZONE'];
            }
        } elseif (is_link('/etc/localtime')) {
            // Mac OS X (and older Linuxes)    
            // /etc/localtime is a symlink to the 
            // timezone in /usr/share/zoneinfo.
            $filename = readlink('/etc/localtime');
            if (strpos($filename, '/usr/share/zoneinfo/') === 0) {
                $timezone = substr($filename, 20);
            }
        } elseif (file_exists('/etc/timezone')) {
            // Ubuntu / Debian.
            $data = file_get_contents('/etc/timezone');
            if ($data) {
                $timezone = $data;
            }
        }
        date_default_timezone_set($timezone);
        $this->session->set_userdata('ip_address', $this->input->ip_address());        

        $this->load->helper('language_line');
        $this->load->helper('timezone');

        if ($this->config->item('maintenance') == true) {
            $this->twig->display('maintenance');
            $this->output->_display();
            exit();
        }

        $this->data['alert'] = array(
            'error' => $this->session->flashdata('alert_error'),
            'success' => $this->session->flashdata('alert_success'),
            'form_errors' => $this->session->flashdata('alert_form_errors'),
            'deleted' => $this->session->flashdata('alert_deleted'),
        );

        $whitelist = ['coming-soon', 'thank-you', 'auth/confirm', 'auth/fb-login'];
        if ((in_array(uri_string(), $whitelist) || $this->config->item('coming_soon') == false)
            == false
        ) {
            redirect('coming-soon');
        }

        $this->set_location();
        $this->define_twig_global();
        $this->load->library('cart');
        $this->session->set_userdata('carts', $this->cart->contents());        
    }

    public function define_twig_global()
    {
        $this->twig->addGlobal('session', $this->session->all_userdata());

        if ($this->is_login()) {
            $this->data['user_login'] = $this->session->userdata('login');
        } else {
            if ($this->uri->segment(2) !== 'fb-login') {
                $this->data['loginUrl'] = $this->generate_facebook();
            }
        }

        if ($this->is_login_admin()) {
            $this->data['user_login_admin'] = $this->session->userdata('login_admin');
            $this->data['type_admin'] = \AdminStatic::TYPE_ADMIN;
            $this->data['type_marketing'] = \AdminStatic::TYPE_MARKETING;
            $this->data['type_review'] = \AdminStatic::TYPE_REVIEW;
        }
    }

    public function check_login()
    {
        if ($this->is_login()) {
            redirect('/dashboard');
        }
    }

    public function check_login_admin()
    {
        if ($this->is_login_admin()) {
            redirect('adminuao3hltbr0/home');
        }
    }

    public function setCurrentUrl()
    {
        $this->session->set_userdata('current_url', current_url());
    }

    public function is_login()
    {
        return isset($this->session->userdata('login')['status']) ? true : false;
    }

    public function is_login_admin()
    {
        return isset($this->session->userdata('login_admin')['status']) ? true : false;
    }

    public function check_admin_marketing()
    {
        if ($this->session->userdata('login_admin')['type']==\AdminStatic::TYPE_ADMIN or $this->session->userdata('login_admin')['type']==\AdminStatic::TYPE_MARKETING) {
            return true;
        }
        else {
            return false;
        }
    }

    public function check_admin_review()
    {
        if ($this->session->userdata('login_admin')['type']==\AdminStatic::TYPE_ADMIN or $this->session->userdata('login_admin')['type']==\AdminStatic::TYPE_REVIEW) {
            return true;
        }
        else {
            return false;
        }
    }

    public function check_admin_only()
    {
        if ($this->session->userdata('login_admin')['type']==\AdminStatic::TYPE_ADMIN) {
            return true;
        }
        else {
            return false;
        }
    }

    public function is_teacher()
    {
        if ($this->is_login()) {
            return $this->session->userdata('login')['is_teacher'] ? true : false;
        }
        return false;
    }

    public function is_student()
    {
        if ($this->is_login()) {
            return $this->session->userdata('login')['is_student'] ? true : false;
        }
        return false;
    }

    public function set_location($location = '', $update = false)
    {
        // if config lang is already in item
        if ($this->session->userdata('location') && $update == false) {
            return;
        }

        if ($update == false) {
            $ip = $this->input->ip_address();
            $location = geoip_country_code_by_name($ip);
            if (!in_array($location, ['SG', 'ID'])) {
                $location = 'SG';
            }
            if ($ip == "127.0.0.1") $location = 'ID';
        }
        $past_location = $this->session->userdata('location');

        if ($past_location != $location) {
            $this->load->library('cart');
            $this->cart->destroy();
        }

        $this->set_language($location);
        $this->set_currency($location);

        $this->config->set_item('location', $location);
        $this->session->set_userdata('location', $location);
    }

    /**
     * @param $location
     */
    protected function set_language($location)
    {
        $language = $location == 'ID' ? 'indonesian' : 'english';
        $this->config->set_item('lang', $language);
        $this->session->set_userdata('lang', $language);
    }

    /**
     * @param $location
     */
    protected function set_currency($location)
    {
        $currency = $location == 'ID' ? 'Rp' : 'S$';
        $this->config->set_item('currency', $currency);
        $this->session->set_userdata('currency', $currency);
    }

    public function checkSocialMediaAgent()
    {
        return (
            strpos($_SERVER["HTTP_USER_AGENT"], "facebookexternalhit/") !== false ||
            strpos($_SERVER["HTTP_USER_AGENT"], "Facebot") !== false ||
            strpos($_SERVER["HTTP_USER_AGENT"], "Twitterbot") !== false ||
            strpos($_SERVER["HTTP_USER_AGENT"], "Google") !== false ||
            strpos($_SERVER["HTTP_USER_AGENT"], "LinkedInBot") !== false ||
            strpos($_SERVER["HTTP_USER_AGENT"], "Pinterest") !== false
        ) ? true : false;
    }

    // protected function send_notification_email($data, $subject, $template)
    // {
    //     // TODO: Send email by sendpulse

    //     $this->load->library('email');
    //     $this->email->set_newline("\r\n");

    //     $this->email->from('no-reply@skillagogo.com', 'The team at skillagogo');
    //     $this->email->to($data['email']);

    //     $this->email->subject($subject);
    //     $message = $this->twig->render($template, $data);
    //     $this->email->message($message);

    //     $this->email->send();
    //     return;
    // }

    // With Sendpulse SMTP

    protected function send_notification_email($data, $subject, $template, $attachments = [])
    {
        $pubkey = '
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDAYQzP0TqvR8z4LVlJ+tkRw1W5
wbmLmJsQSGr5Ypqenpct7jWL8qU4FWzjQRaFXF9x3sTi0pk2Rj5Orx/1Rwst/szY
nBUDzZs/qRriapFOFRM+WmEFcZlobcnkgGka761y8R8090tNoIZRRPS2M6MuHJT4
kgxs4cgayD3zaYReIQIDAQAB
-----END PUBLIC KEY-----
';

        $api_user_id = getenv('SENDPULSE_API_USER_ID');
        $api_secret = getenv('SENDPULSE_API_SECRET');

        // $oApi = new \Skillagogo\Email\Sendpulse\SmtpApi($pubkey);
        //  $res = $oApi->send_email([
        //     'html' => $this->twig->render($template, $data),
        //     'encoding' => 'UTF-8',
        //     'subject' => $subject,
        //     'from' => [
        //         'name' => 'The team at skillagogo',
        //         'email' => 'no-reply@skillagogo.com'
        //     ],
        //     'to' => [
        //         [
        //             'email' => $data['email']
        //         ]
        //     ]
        // ]);

        // var_dump($api_user_id);
        // var_dump($api_secret);

        $SPApiProxy = new SendpulseApi( $api_user_id, $api_secret, 'file');
        // Send mail using SMTP
        $email = array(
            'html' => $this->twig->render($template, $data),
            'text' => $this->twig->render($template, $data),
            'subject' => $subject,
            'from' => array(
                'name' => 'The team at skillagogo',
                'email' => 'no-reply@skillagogo.com'
                ),
            'to' => array(
                array(
                    'email' => $data['email']
                    )
                ),
            'attachments' => $attachments
            );
        $res = $SPApiProxy->smtpSendMail($email);
        // var_dump($res);

        if (isset($res->is_error)){ // check if operation succeeds
            die('Error: ' . $res->message);
        } else {
            // success
        }
    }

    protected function send_email_contact_us($data, $subject, $template)
    {
        // TODO: Send email by sendpulse
        $this->load->library('email');
        $this->email->set_newline("\r\n");

        $this->email->from('no-reply@skillagogo.com');
        $this->email->to('contact@skillagogo.com');

        $this->email->subject($subject);
        $message = $this->twig->render($template, $data);
        $this->email->message($message);

        $this->email->send();
        return;
    }

    protected function generate_facebook()
    {
        $fb = new \Facebook\Facebook([
            'app_id' => $this->config->item('facebook_id'), // Replace {app-id} with your app id
            'app_secret' => $this->config->item('facebook_secret'),
            'default_graph_version' => 'v2.6',
        ]);
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['public_profile', 'email', 'user_birthday'];
        return $helper->getLoginUrl(base_url() . 'auth/fb-login', $permissions);
    }

    protected function is_post()
    {
        return ($_SERVER['REQUEST_METHOD'] == "POST");
    }

    /**
     * @param $title
     * @param $text
     * @param $image
     * @return array
     */
    protected function share_link($title, $text, $image)
    {
        $share = new \SocialLinks\Page([
            'url' => current_url(),
            'title' => $title,
            'text' => $text,
            'image' => $image,
            'twitterUser' => '@skillagogo'
        ]);

        $data['facebook'] = $share->facebook;
        $data['twitter'] = $share->twitter;
        $data['linkedin'] = $share->linkedin;
        $data['pinterest'] = $share->pinterest;
        $data['plus'] = $share->plus;
        return $data;
    }

    function _validate($rules)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules($rules);
        return $this->form_validation->run();
    }


    protected function update_session($user)
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
            'nationality' => $nationality
        ]);
    }

    protected function update_admin_session($admin)
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

    /**
     * @param $post
     * @return mixed
     */
    protected function upload_avatar()
    {
        Intervention\Image\ImageManagerStatic::configure();

        $this->load->helper('string');
        $image_name = random_string('alnum', 16) . time();
        $image = Intervention\Image\ImageManagerStatic::make($_FILES['avatar']['tmp_name']);
        $extension = image_type_to_extension(exif_imagetype($_FILES['avatar']['tmp_name']));
        $extension = $extension == '.jpeg' ? '.jpg' : $extension;
        $image->fit(400, 400);
        $image->save(FCPATH . '/images/avatar/' . $image_name . $extension);
        $image->fit(100, 100);
        $image->save(FCPATH . '/images/avatar/' . $image_name . '_small' . $extension);

        return $image_name . $extension;;
    }

    protected function upload_transaction_bank()
    {
        $this->load->helper('string');
        $image_name = random_string('alnum', 16) . time();
        $image = Intervention\Image\ImageManagerStatic::make($_FILES['photo']['tmp_name']);
        $extension = image_type_to_extension(exif_imagetype($_FILES['photo']['tmp_name']));
        $extension = $extension == '.jpeg' ? '.jpg' : $extension;
        $image->save(FCPATH . '/images/transaction_bank/' . $image_name . $extension);

        return $image_name . $extension;;
    }

    protected function log_activity_data_record($message)
    {
        $log = new Logger('activity_logger');
        $log->pushHandler(new StreamHandler(APPPATH . 'logs/activity_data_record-' . (string)(date('Y-m-d',strtotime('today'))) . '.log', LOGGER::INFO));
        $log->info($message);
    }

    protected function log_content_data_record($message)
    {
        $log = new Logger('activity_logger');
        $log->pushHandler(new StreamHandler(APPPATH . 'logs/content_data_record-' . (string)(date('Y-m-d',strtotime('today'))) . '.log', LOGGER::INFO));
        $log->info($message);
    }
}
