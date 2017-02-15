<?php
require APPPATH . 'libraries/Dashboard_Controller.php';

class Profile extends Dashboard_Controller
{
    use \Skillagogo\Callback\UserCallback;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function index()
    {
        // set active sidebar
        $this->data['menu_top'] = "profile";
        $this->data['menu_left'] = "user_profile";

        if ($this->is_post()) {
            $post = $this->input->post();

            // if not change picture, set profile_pic to default
            if (empty($_FILES['avatar']['name']) == false) {
                $post['profile_pic'] = $this->upload_avatar();
            } else {
                $post['profile_pic'] = $this->session->userdata('login')['avatar'];
            }

            // untuk mengisi lagi form profile
            $this->data['profile'] = $post;

            // ketika berhasil save profile, update session
            if ($this->user_model->save_profile($post)) {

                $all_inputs = "";
                $first = 0;
                foreach ($post as $key => $value) {
                    if (!$first) {
                        $all_inputs = $value;
                        $first = 1;
                    } else {
                        $all_inputs = $all_inputs . ", " . $value;
                    }
                }

                // Log update profile
                $date = new DateTime();
                $message = $date->format('Ymd_H:i:s') . ',1009,' .
                            $this->session->userdata('login')['user_id'] . ',' .
                            'UPDATEPROFILE' . ';' . $all_inputs;
                $this->log_activity_data_record($message);

                $user = $this->user_model->get_user(['email' => $post['email']]);
                $this->update_session($user);
                $this->session->set_flashdata('alert_success', line('success_profile_index','controller_js'));
                if ($referrer = $this->input->get('referrer'))
                    redirect($referrer);
                redirect(current_url());
            }

            // save error validation to variable
            if (validation_errors()) {
                $this->data['validation_error'] = validation_errors();
            }
        } else {
            $this->data['profile'] = $this->user_model->get_by_id();
        }
        // print_r($this->session->userdata('login'));

        $this->twig->display('dashboard/shareds/profile/index', $this->data);
    }

    public function teacher()
    {
        $this->redirect_if_not_teacher();

        if ($this->is_post()) {
            $post = $this->input->post();

            if ($this->user_model->update_teacher_profile($post)) {

                // Log update profile
                $date = new DateTime();
                $message = $date->format('Ymd_H:i:s') . ',' .
                            $this->session->userdata('login')['user_id'] . ',' .
                            'UPDATEPROFILE' . ',' .
                            $this->input->ip_address();
                $this->log_activity_data_record($message);

                $this->session->set_flashdata('alert_success', line('success_profile_index','controller_js'));
                redirect(current_url());
            }
            // save error validation to variable
            if (validation_errors()) {
                $this->data['validation_error'] = validation_errors();
            }
        } else {
            $this->data['values'] = $this->user_model->get_teacher_details(['user_id' => $this->session->userdata('login')['user_id']]);
        }


        $this->load->model('bank_model');
        $this->data['banks'] = $this->bank_model->get_banks();

        $this->data['menu_top'] = "teacher";
        $this->data['menu_left'] = "user_profile";
        $this->twig->display('dashboard/shareds/profile/teacher', $this->data);
    }

    public function password_setting()
    {
        if ($this->is_post()) {
            $post = $this->input->post();

            if ($this->user_model->update_password($post)) {
                $this->session->set_flashdata('alert_success', line('success_profile_password_setting','controller_js'));
                redirect(current_url());
            };

            // save error validation to variable
            if (validation_errors()) {
                $this->data['validation_error'] = validation_errors();
            }
        }

        $user = $this->user_model->get_user(['users.id' => $this->session->userdata('login')['user_id']]);

        $this->data['menu_top'] = "password";
        $this->data['menu_left'] = "user_profile";
        $this->data['password'] = $user->password;
        $this->twig->display('dashboard/shareds/profile/password', $this->data);
    }

    public function notification_setting()
    {
        if ($this->is_post()) {
            $post = $this->input->post();

            if ($this->user_model->update_notification($post)) {
                $this->user_model->update_notification_newsletter($post['notification_newsletter'], $this->user_model->get_user(['user_id' => $this->session->userdata('login')['user_id']])->email);
                $this->session->set_flashdata('alert_success', line('success_profile_notification','controller_js'));
                redirect(current_url());
            };

            // save error validation to variable
            if (validation_errors()) {
                $this->data['validation_error'] = validation_errors();
            }
        } else {
            $this->data['user_details'] = $this->user_model->get_user(['user_id' => $this->session->userdata('login')['user_id']]);
            $this->data['teacher_details'] = $this->user_model->get_teacher_details(['user_id' => $this->session->userdata('login')['user_id']]);
        }

        $this->data['menu_top'] = "notification";
        $this->data['menu_left'] = "user_profile";
        $this->twig->display('dashboard/shareds/profile/notification', $this->data);
    }

}
