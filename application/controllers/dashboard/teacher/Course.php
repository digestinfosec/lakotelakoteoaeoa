<?php
require APPPATH . 'libraries/Dashboard_Controller.php';

use Intervention\Image\ImageManagerStatic as Image;

class Course extends Dashboard_Controller
{
    use \Skillagogo\Callback\CourseCallback;

    function __construct()
    {
        parent::__construct();
        $this->load->model('course_model');
        $this->load->model('user_model');
        $this->load->helper('ajax');
    }

    function index()
    {
        $this->redirect_if_not_teacher();

        $this->data['menu_left'] = 'teacher_course';
        $this->data['menu_top'] = 'published';
        $this->data['header_title'] = "Published";

        // pagination settings
        $this->load->library('pagination');
        $config['base_url'] = '/dashboard/teacher/course/index';
        $config['total_rows'] = $this->course_model->get_count_courses([
            'teacher_id' => $this->session->userdata('login')['user_id'],
            'publish_status' => CourseStatic::PUBLISH_SUCCESS
        ]);
        $config['per_page'] = 5;

        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        // get courses
        $option['publish_status'] = CourseStatic::PUBLISH_SUCCESS;
        $option['teacher_id'] = $this->session->userdata('login')['user_id'];
        $option['offset'] = $this->uri->segment(5);
        $option['limit'] = $config['per_page'];
        $option['directory_class_only'] = true;
        $this->data['result'] = $this->course_model->get_courses($option);
        $this->data['type_hash'] = CourseStatic::TYPE_HASH;

        $this->twig->display('dashboard/teacher/course/index', $this->data);
    }

    public function new_course()
    {
        if ($this->is_teacher() == false) {
            redirect('become-teacher');
        }

        $this->data['current_page'] = "new_course";

        $this->session->unset_userdata('create_update_class');

        $this->load->model('category_model');
        $this->load->helper('form');
        $this->load->helper('sg_form');
        $this->data['categories'] = $this->category_model->get_category_tree();
        $this->data['update_path'] = base_url("dashboard/teacher/course/update/");
        $this->data['submit_path'] = base_url("dashboard/teacher/course/create");
        $this->data['preview'] = 0;

        // Prefill about leader
        $this->data['course'] = array();
        $teacher = $this->user_model->get_teacher($this->session->userdata('login')['user_id']);
        $this->data['course']['class_leader'] = $teacher->first_name . " " . $teacher->last_name;
        $this->data['course']['about_leader'] = $teacher->bio;

        $this->twig->display('dashboard/teacher/course/form', $this->data);
    }

    public function edit($course_id)
    {
        if (($this->data['user_login_admin']['type'] != \AdminStatic::TYPE_REVIEW and $this->data['user_login_admin']['type'] != \AdminStatic::TYPE_ADMIN)) 
            $this->redirect_if_not_teacher();

        if (is_null($course_id)) {
            redirect('dashboard');
        }

        $this->session->set_userdata('class_admin_edit',$this->input->get("admin_edit"));
        $this->session->set_userdata('class_admin_edit', (int)$this->session->userdata('class_admin_edit'));

        // Check admin type
        if( $this->data['user_login_admin']['type'] != \AdminStatic::TYPE_REVIEW and $this->data['user_login_admin']['type'] != \AdminStatic::TYPE_ADMIN and (int)$this->input->get("admin_edit")) {
            redirect('adminuao3hltbr0/home');
        }

        if ($this->course_model->check_owner($course_id) === false and $this->data['user_login_admin']['type'] != \AdminStatic::TYPE_REVIEW and $this->data['user_login_admin']['type'] != \AdminStatic::TYPE_ADMIN or !(int)$this->input->get("admin_edit")) {
            redirect('dashboard');
        }

        $course = $this->course_model->get_course($course_id);
        if ($course->publish_status != CourseStatic::PUBLISH_DRAFT and $this->data['user_login_admin']['type'] != \AdminStatic::TYPE_REVIEW and $this->data['user_login_admin']['type'] != \AdminStatic::TYPE_ADMIN or !(int)$this->input->get("admin_edit")) {
            redirect('dashboard');            
        }

        $this->session->unset_userdata('create_update_class');

        $this->load->model('category_model');
        $this->load->model('schedule_model');
        $this->load->model('image_model');
        $this->load->helper('form');
        $this->load->helper('sg_form');
        $this->data['categories'] = $this->category_model->get_category_tree();
        $this->data['course'] = $this->course_model->get_course($course_id);
        $this->data['schedules'] = $this->schedule_model->get_schedules($course_id);
        $this->data['images'] = $this->image_model->get_images_from_class($course_id);
        $this->data['submit_path'] = base_url("dashboard/teacher/course/update/" . $course_id);
        $this->data['preview'] = 1;

        $this->twig->display('dashboard/teacher/course/form', $this->data);
    }

    public function create()
    {
        if ($this->is_teacher() == false) {
            redirect('become-teacher');
        }

        if ($this->is_post()) {

            $post = $this->input->post();
            $create = $this->session->userdata('create_update_class');
            if ($create) {
                $post = array_merge($post, $create);
            }

            if (isset($post['draft']) && $post['draft'] == true) {
                $post['publish_status'] = CourseStatic::PUBLISH_DRAFT;
            } else {
                $post['publish_status'] = CourseStatic::PUBLISH_SUCCESS;
            }

            $course_id = $this->course_model->create_course($post);

            if ($course_id) {

                // save schedule
                $this->load->model('schedule_model');
                $this->schedule_model->save_class_schedules($course_id);

                // save images
                $this->load->model('image_model');
                $this->image_model->save_image_for_class($course_id);
                if (!isset($post['draft']) || $post['draft'] == false)
                    $this->course_model->generate_unique_id($course_id);

                $course = $this->course_model->get_course($course_id);

                // Log create class
                $date = new DateTime();
                $message = $date->format('Ymd_H:i:s') . ',1005,' .
                    $this->session->userdata('login')['user_id'] . ',' .
                    'CREATECLASS' . ',' .
                    $course_id . ';';
                $this->log_activity_data_record($message);

                // Log create class
                $date = new DateTime();
                $message = $date->format('Ymd_H:i:s') . ',1005,' .
                    $this->session->userdata('login')['user_id'] . ',' .
                    'CREATECLASS' . ',' .
                    $course_id . ';' .
                    $course->title . ';' . $course->description . ';' . $course->content . ';' . CourseStatic::TYPE_HASH[$course->type] ;
                $this->log_content_data_record($message);

                $data_email['teacher'] = $this->user_model->get_by_id($this->session->userdata('login')['user_id']);
                $data_email['course'] = $this->course_model->get_course($course_id);
                $data_email['email'] = $this->user_model->get_by_id($this->session->userdata('login')['user_id'])->email;
                if (!isset($post['draft']) && $post['draft'] == false) {
                    $this->send_notification_email($data_email,
                        line('email_course_create', 'controller_js'),
                        'email/successful_class_publication_email_en');
                }

                $schedules = $this->schedule_model->get_schedules($course_id);
                $schedule_ids = array();
                $address_ids = array();
                foreach($schedules as $schedule) {
                    $schedule_ids[] = $schedule->schedule_id;
                    $address_ids[] = $schedule->address_id;
                }

                if (isAjax()) {
                    echo json_encode([
                        'success' => true,
                        'message' => ((isset($post['draft'])) ? line('success_course_create','controller_js') : line('success_course_create_2','controller_js')),
                        'course_id' => $course_id,
                        'schedule_ids' => $schedule_ids,
                        'address_ids' => $address_ids
                    ]);
                } else {
                    $this->session->set_flashdata('alert_success', ((isset($post['draftt'])) ? line('success_course_create','controller_js') : line('success_course_create_2','controller_js')));
                }
            } else {
                if (isAjax()) {
                    echo json_encode(['success' => false, 'message' => line('error_course_create_2','controller_js')]);
                } else {
                    $this->session->set_flashdata('alert_error', line('error_cant_process','controller_js'));
                }
            }

            if (isAjax() == false) {
                $course = $this->course_model->get_course($course_id);
                redirect('/course/detail/' . $course->unique_id . '-' . $course->slug);            
            }
        } else {
            redirect('dashboard');
        }
    }

    public function draft()
    {
        $this->redirect_if_not_teacher();

        $this->data['menu_left'] = "teacher_course";
        $this->data['menu_top'] = "draft";
        $this->data['header_title'] = "Drafts";

        // pagination settings
        $this->load->library('pagination');
        $config['base_url'] = '/dashboard/teacher/course/draft';
        $config['total_rows'] = $this->course_model->get_count_courses([
            'teacher_id' => $this->session->userdata('login')['user_id'],
            'publish_status' => CourseStatic::PUBLISH_DRAFT
        ]);
        $config['per_page'] = 5;

        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        // get courses
        $option['publish_status'] = CourseStatic::PUBLISH_DRAFT;
        $option['teacher_id'] = $this->session->userdata('login')['user_id'];
        $option['offset'] = $this->uri->segment(5);
        $option['limit'] = $config['per_page'];
        $this->data['result'] = $this->course_model->get_courses($option);

        $this->twig->display('dashboard/teacher/course/index', $this->data);
    }

    public function cancelled()
    {
        $this->redirect_if_not_teacher();

        $this->data['menu_left'] = "teacher_course";
        $this->data['menu_top'] = "cancelled";
        $this->data['header_title'] = "Cancelled";

        // pagination settings
        $this->load->library('pagination');
        $config['base_url'] = '/dashboard/teacher/course/cancelled';
        $config['total_rows'] = $this->course_model->get_count_courses([
            'teacher_id' => $this->session->userdata('login')['user_id'],
            'publish_status' => CourseStatic::PUBLISH_DELETED
        ]);
        $config['per_page'] = 5;

        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        // get courses
        $option['publish_status'] = CourseStatic::PUBLISH_DELETED;
        $option['status'] = CourseStatic::STATUS_CANCELLED;
        $option['teacher_id'] = $this->session->userdata('login')['user_id'];
        $option['offset'] = $this->uri->segment(5);
        $option['limit'] = $config['per_page'];
        $this->data['result'] = $this->course_model->get_courses($option);

        $this->twig->display('dashboard/teacher/course/index', $this->data);
    }

    public function finished()
    {
        $this->redirect_if_not_teacher();

        $this->data['menu_left'] = "teacher_course";
        $this->data['menu_top'] = "finished";
        $this->data['header_title'] = "Finished";

        // pagination settings
        $this->load->library('pagination');
        $config['base_url'] = '/dashboard/teacher/course/finished';
        $config['total_rows'] = count($this->course_model->get_teacher_past_courses($this->session->userdata('login')['user_id']));
        $config['per_page'] = 5;

        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();

        // get courses
        // $option['strict'] = true;
        // $option['publish_status'] = CourseStatic::PUBLISH_SUCCESS;
        // $option['teacher_id'] = $this->session->userdata('login')['user_id'];
        $option['offset'] = $this->uri->segment(5);
        $option['limit'] = $config['per_page'];
        $this->data['result'] = $this->course_model->get_teacher_past_courses($this->session->userdata('login')['user_id'], $option);

        $this->twig->display('dashboard/teacher/course/index', $this->data);
    }

    public function update($course_id)
    {
        if (isset($this->data['user_login_admin']) && $this->data['user_login_admin']['type'] != \AdminStatic::TYPE_REVIEW and $this->data['user_login_admin']['type'] != \AdminStatic::TYPE_ADMIN and !$this->session->userdata('class_admin_edit')) 
            $this->redirect_if_not_teacher();

        if (is_null($course_id)) {
            redirect('dashboard');
        }

        if ($this->course_model->check_owner($course_id) === false and $this->data['user_login_admin']['type'] != \AdminStatic::TYPE_REVIEW and $this->data['user_login_admin']['type'] != \AdminStatic::TYPE_ADMIN and !$this->session->userdata('class_admin_edit')) {
            redirect('dashboard');
        }

        if ($this->is_post()) {

            $post = $this->input->post();
            $update = $this->session->userdata('create_update_class');
            if ($update) {
                $post = array_merge($post, $update);
            }

            if (isset($post['draft']) && $post['draft'] == true) {
                $post['publish_status'] = CourseStatic::PUBLISH_DRAFT;
            } else {
                $post['publish_status'] = CourseStatic::PUBLISH_SUCCESS;
            }

            $teacher_id = $this->user_model->get_by_id($this->session->userdata('login')['user_id']);
            $admin_edit = false;
            $currency_course = NULL;
            if (isset($this->data['user_login_admin'])) {
                if ($this->data['user_login_admin']['type'] == \AdminStatic::TYPE_REVIEW or $this->data['user_login_admin']['type'] == \AdminStatic::TYPE_ADMIN and $this->session->userdata('class_admin_edit')) 
                {
                    $course = $this->course_model->get_course($course_id);
                    $teacher_id = $course->teacher_id;
                    $admin_edit = true;
                    $currency_course = $course->currency;
                }               
            }

            if ($class_id = $this->course_model->update_course($course_id, $post, $teacher_id, $admin_edit, $currency_course)) {

                if ($class_id) {
                    // save schedule
                    $this->load->model('schedule_model');
                    $this->schedule_model->save_class_schedules($class_id);

                    $schedules = $this->schedule_model->get_schedules($class_id);
                    $schedule_ids = array();
                    $address_ids = array();
                    foreach($schedules as $schedule) {
                        $schedule_ids[] = $schedule->schedule_id;
                        $address_ids[] = $schedule->address_id;
                    }

                    // save images
                    // Pertama, cek dulu berubah gak image2nya
                    $this->load->model('image_model');
                    $images = $this->image_model->get_images_from_class($class_id);

                    // Kalo jumlah gak berubah dan id gak berubah, ga usa save image2nya
                    $b_save_image = false;

                    $image_ids = $this->input->post('image_ids[]');
                    $len_image_ids = count($image_ids);
                    $len_images = count($images);
                    if ($len_image_ids != $len_images) {
                        $b_save_image = true;
                    } else {
                        $i = 0;
                        foreach ($images as $image) {
                            if ($image->id != $image_ids[$i]) {
                                $b_save_image = true;
                            }
                            $i++;
                        }
                    }

                    if ($b_save_image) {
                        $this->image_model->save_image_for_class($class_id);
                    }

                    // Log update class
                    $course = $this->course_model->get_course($class_id);
                    $date = new DateTime();
                    $message = $date->format('Ymd_H:i:s') . ',1006,' .
                        $this->session->userdata('login')['user_id'] . ',' .
                        'UPDATECLASS' . ',' .
                        $course_id . ';' .
                        $course->title . ';' . $course->description . ';' . $course->content . ';' . CourseStatic::TYPE_HASH[$course->type] ;
                    $this->log_content_data_record($message);

                }

                if (!isset($post['draft']) || $post['draft'] == false) {
                    $this->course_model->generate_unique_id($course_id);
                    if (isAjax()) {
                        echo json_encode(['success' => true, 'message' => line('success_course_create_2','controller_js'),
                        'schedule_ids' => $schedule_ids,
                        'address_ids' => $address_ids]);
                    } else {
                        $this->session->set_flashdata('alert_success', line('success_course_create_2','controller_js'));
                    }

                    // Log create class
                    $date = new DateTime();
                    $message = $date->format('Ymd_H:i:s') . ',1005,' .
                        $teacher_id . ',' .
                        'CREATECLASS' . ',' .
                        $course_id . ';';
                    $this->log_activity_data_record($message);

                    $data_email['teacher'] = $this->user_model->get_by_id($teacher_id);
                    $data_email['course'] = $this->course_model->get_course($course_id);
                    $data_email['email'] = $this->user_model->get_by_id($teacher_id)->email;
                    $this->send_notification_email($data_email,
                        line('email_course_create','controller_js'),
                        'email/successful_class_publication_email_en');
                }
                else {
                    if (isAjax()) {
                        echo json_encode(['success' => true, 'message' => line('success_course_update','controller_js'),
                        'schedule_ids' => $schedule_ids,
                        'address_ids' => $address_ids]);
                    } else {
                        $this->session->set_flashdata('alert_success', line('success_course_update','controller_js'));
                    }
                }
            } else {
                if (isAjax()) {
                    echo json_encode(['error' => false, 'message' => line('error_course_update','controller_js')]);
                } else {
                    $this->session->set_flashdata('alert_error', line('error_course_update','controller_js'));
                }
            }

            if (isAjax() == false) {
                $course = $this->course_model->get_course($course_id);
                // var_dump("aaaaaoioioio");
                if ($this->session->userdata('class_admin_edit')) {
                    $this->session->unset_userdata('class_admin_edit');
                    // var_dump("oioioio");
                    redirect('adminuao3hltbr0/page_classes_review');
                }
                redirect('/course/detail/' . $course->unique_id . '-' . $course->slug);            
            }
        } else {
            redirect('dashboard');
        }
    }

    function delete($course_id)
    {
        $this->redirect_if_not_teacher();

        if (is_null($course_id)) {
            redirect('dashboard');
        }

        if ($this->course_model->check_owner($course_id) === false) {
            redirect('dashboard');
        }

        $this->session->unset_userdata('create_update_class');

        if ($this->course_model->remove_course($course_id)) {
            $this->session->set_flashdata('alert_success', line('success_course_delete','controller_js'));
        } else {
            $this->session->set_flashdata('alert_error', line('error_course_delete','controller_js'));
        }

        redirect_back();
    }

    public function upload_image()
    {
        $this->redirect_if_not_teacher();

        $this->load->model('image_model');
        $this->image_model->save_image_to_server();
    }

    public function delete_image($image_id)
    {
        $this->redirect_if_not_teacher();

        $this->load->model('image_model');
        $this->image_model->remove_image_from_server($image_id);

        echo json_encode([]);
    }

    public function delete_image_from_cache($filename)
    {
        $this->redirect_if_not_teacher();

        $create = $this->session->userdata('create_update_class') ? $this->session->userdata('create_update_class') : [];
        $new_image = [];
        foreach ($create['image'] as $image) {
            if (substr($image['name'], 0, -4) == $filename) {
                unlink('images/class/' . $image['name']);
                unlink('images/class/' . substr($image['name'], 0, -4) . "_small" . substr($image['name'], -4));
                unlink('images/class/' . substr($image['name'], 0, -4) . "_thumb" . substr($image['name'], -4));
                continue;
            }
            $new_image[] = $image;
        }
        $create['image'] = $new_image;
        $this->session->set_userdata('create_update_class', $create);

        echo json_encode([]);
    }

    public function validate($action)
    {
        $this->redirect_if_not_teacher();

        $rules = CourseStatic::get_rule($action);

        $this->_validate($rules);

        if (validation_errors()) {
            $data['error'] = validation_errors();
            $data['result'] = false;
        } else {
            $data['result'] = true;
        }

        return $data;

    }

    public function change_price($id)
    {
        $this->redirect_if_not_teacher();

        if (is_null($id)) {
            redirect('dashboard');
        }

        if ($this->course_model->check_owner($id) === false) {
            redirect('dashboard');
        }

        $course = $this->course_model->get_course($id, false, false);

        if (!isset($course->id))
            redirect('dashboard');

        // Check owner
        if ($course->teacher_id != $this->session->userdata('login')['user_id']) {
            show_error(line('error_no_permission','controller_js'), '403', line('error_forbidden_access','controller_js'));
        }
        // Check if already changed (can only change once)
        if ($course->changed_price == true) {
            show_error(line('error_course_change_price','controller_js'), "403", line('error_forbidden_to_change','controller_js'));
        }
        // Check student registration
        if ($this->course_model->check_student_registered($id) == true) {
            show_error(line('error_course_change_price_2','controller_js'), "403", line('error_forbidden_to_change','controller_js'));
        }
        // Check if class has already started
        if ($this->course_model->check_date_started($id) == true) {
            show_error(line('error_course_change_price_3','controller_js'), "403", line('error_forbidden_to_change','controller_js'));
        }

        // check if request post
        if ($this->is_post()) {
            $price = $this->input->post('new_price');
            $this->course_model->change_price($id, $price);

            // 3. Send email notification to teacher
            $this->load->model('user_model');
            $send = $this->user_model->get_user(['user_id' => $this->session->userdata('login')['user_id']]);
            $send->course = $this->course_model->get_course($id, false, false);
            $this->send_notification_email((array)$send, line('email_course_change_price','controller_js'), 'email/class_creation_modification_price_en');

            // $this->twig->display("email/class_creation_modification_price_en", (array)$send);
            // return;

            // 4. Redirect to course
            $this->session->set_flashdata('alert_success', line('success_course_change_price','controller_js'));
            redirect('dashboard/teacher/course');
        }

        $this->data['old_price'] = $course->price;
        print_r($this->input->post('old_price'));

        // Show view
        $this->twig->display('dashboard/teacher/course/change_price', $this->data);
    }

    public function change_venue($id)
    {
        $this->redirect_if_not_teacher();

        if (is_null($id)) {
            redirect('dashboard');
        }

        if ($this->course_model->check_owner($id) === false) {
            redirect('dashboard');
        }

        $this->load->model('schedule_model');
        $course = $this->course_model->get_course($id, false, false);

        if (!isset($course->id))
            redirect('dashboard');

        // Check owner
        if ($course->teacher_id != $this->session->userdata('login')['user_id']) {
            show_error(line('error_no_permission','controller_js'), '403', line('error_forbidden_access','controller_js'));
        }
        // Check if already changed (can only change once)
        if ($course->changed_venue == true) {
            show_error(line('error_course_change_venue','controller_js'), "403", line('error_forbidden_to_change','controller_js'));
        }
        // Check if class has already started
        if ($this->course_model->check_date_started($id) == true) {
            show_error(line('error_course_change_price_3','controller_js'), "403", line('error_forbidden_to_change','controller_js'));
        }

        if ($this->is_post()) {

            // 1. Change schedule and status changed_schedule
            $this->schedule_model->change_venue();
            $this->course_model->set_changed_venue($id, true);

            // 2. Send email notification to Teacher
            $this->load->model('user_model');
            $send = $this->user_model->get_user(['user_id' => $this->session->userdata('login')['user_id']]);
            $course = $this->course_model->get_course($id, false, false);
            $schedule = $this->schedule_model->get_schedules($id);
            $send->course = $course;
            $send->schedules = $schedule;
            $this->send_notification_email((array)$send, line('email_course_change_venue','controller_js'), 'email/class_creation_modification_schedule_venue_other_info_teacher_en');

            // $this->twig->display("email/class_creation_modification_schedule_venue_other_info_teacher_en", (array)$send);
            // return;

            // 3.1 Get Student Registered
            $students = $this->course_model->get_registered_student($id);

            // 3.2 Send email to Student
            foreach ($students as $student) {
                $send = $student;
                $send->course = $course;
                $send->schedules = $schedule;
                $this->send_notification_email((array)$send, line('email_course_change_venue','controller_js'),
                    'email/class_creation_modification_venue_student_en');

                // $this->twig->display("email/class_creation_modification_venue_student_en", (array)$send);
                // return;
            }

            // student will receive email to accept the schedule change
            $this->session->set_flashdata('alert_success', line('success_course_change_venue','controller_js'));
            redirect('dashboard/teacher/course');
        }

        $this->data['course'] = $course;
        $this->data['schedules'] = $this->schedule_model->get_schedules($id);
        $this->twig->display('dashboard/teacher/course/change_venue', $this->data);
    }

    public function change_schedule($id)
    {
        $this->redirect_if_not_teacher();

        if (is_null($id)) {
            redirect('dashboard');
        }

        if ($this->course_model->check_owner($id) === false) {
            redirect('dashboard');
        }

        $this->load->model('schedule_model');
        $course = $this->course_model->get_course($id, false, false);

        if (!isset($course->id))
            redirect('dashboard');

        // Check owner
        if ($course->teacher_id != $this->session->userdata('login')['user_id']) {
            show_error(line('error_no_permission','controller_js'), '403', line('error_forbidden_access','controller_js'));
        }

        // Check if already changed (can only change once)
        if ($course->changed_schedule == true) {
            show_error(line('error_course_change_schedule','controller_js'), "403", line('error_forbidden_to_change','controller_js'));
        }

        // Check if class has already started
        if ($this->course_model->check_date_started($id) == true) {
            show_error(line('error_course_change_price_3','controller_js'), "403", line('error_forbidden_to_change','controller_js'));
        }

        if ($this->is_post()) {

            // 1. Change schedule and status changed_schedule
            $this->schedule_model->change_schedule();
            $this->course_model->set_changed_schedule($id, true);

            // 2. Send email notification to Teacher
            $this->load->model('user_model');
            $send = $this->user_model->get_user(['user_id' => $this->session->userdata('login')['user_id']]);
            $course = $this->course_model->get_course($id, false, false);
            $schedules = $this->schedule_model->get_schedules($id);
            $send->course = $course;
            $send->schedules = $schedules;
            $this->send_notification_email((array)$send, line('email_course_change_schedule','controller_js'), 'email/class_creation_modification_schedule_venue_other_info_teacher_en');

            // $this->twig->display("email/class_creation_modification_schedule_venue_other_info_teacher_en", (array)$send);
            // return;

            // 3.1 Get Student Registered
            $students = $this->course_model->get_registered_student($id);

            // 3.2 Send email to Student
            foreach ($students as $student) {
                $send = $student;
                $send->course = $course;
                $send->schedules = $schedules;
                $this->send_notification_email((array)$send, line('email_course_change_schedule','controller_js'), 'email/class_creation_modification_schedule_student_en');

                // $this->twig->display("email/class_creation_modification_schedule_student_en", (array)$send);
                // return;
            }

            // student will receive email to accept the schedule change
            $this->session->set_flashdata('alert_success', line('success_course_change_schedule','controller_js'));
            redirect('dashboard/teacher/course');
        }

        $this->data['course'] = $course;
        $this->data['schedules'] = $this->schedule_model->get_schedules($id);
        $this->twig->display('dashboard/teacher/course/change_schedule', $this->data);
    }

    public function cancel()
    {
        $this->redirect_if_not_teacher();

        if ($this->is_post()) {
            $id = $this->input->post('id');


            if (is_null($id)) {
                redirect('dashboard');
            }

            if ($this->course_model->check_owner($id) === false) {
                redirect('dashboard');
            }

            $reason = $this->input->post('cancel_reason');
            $course = $this->course_model->get_course($id, false, false);

            if (!isset($course->id))
                redirect('dashboard');

            // Check owner
            if ($course->teacher_id != $this->session->userdata('login')['user_id']) {
                show_error(line('error_no_permission','controller_js'), '403', line('error_forbidden_access','controller_js'));
            }
            // Check expiration cancellation
            if (!$this->course_model->check_date_for_change($id)) {
                show_error(line('error_course_cancel','controller_js'), '403', line('error_forbidden_to_change','controller_js'));
            }

            // Check status cancellation
            if ($course->status == CourseStatic::STATUS_CANCELLED){
                show_error(line('error_course_cancel_2','controller_js'), '404', 'Not Found');
            }

            // Cancellation
            $this->course_model->cancel_class($id, $reason);
            $this->load->model('user_model');
            $this->load->model('schedule_model');
            $send = $this->user_model->get_user(['user_id' => $this->session->userdata('login')['user_id']]);
            $send->course = $course;
            $send->teacher = $this->user_model->get_by_id($course->teacher_id);
            $send->schedules = $this->schedule_model->get_schedules($course->id);
            $this->send_notification_email((array)$send, line('email_course_cancel','controller_js'), 'email/class_deletion_or_cancelled_teacher_en');

            // $this->twig->display("email/class_deletion_or_cancelled_teacher_en", (array)$send);
            // return;

            // 3.1 Get Student Registered
            $registers = $this->course_model->get_registered_student($id);

            // 3.2 Send email to Student
            foreach ($registers as $register) {

                if ($register->order_status == OrderStatic::ORDER_SUCCESS) {
                    // 1. Get Voucher Code
                    $this->load->model('voucher_model');
                    $voucher = $this->voucher_model->get_voucher($register);
                    // 2. Convert to Credit
                    $this->load->model('credit_model');
                    $this->credit_model->convert_to_credit($register, $voucher,
                        \CreditStatic::REASON_TEACHER_CANCELLED, \CreditStatic::HISTORY_CANCELLATION_TEACHER);
                    $this->voucher_model->update($voucher->id, ['status' => \VoucherStatic::VOUCHER_CONVERTED]);
                }

                // Send email
                $send = $register;
                $send->course = $course;
                $send->teacher = $this->user_model->get_by_id($course->teacher_id);
                $send->schedules = $this->schedule_model->get_schedules($course->id);
                $this->send_notification_email((array)$send, line('email_course_cancel','controller_js'), 'email/class_deletion_or_cancelled_student_en');

                // $this->twig->display("email/class_deletion_or_cancelled_student_en", (array)$send);
                // return;
            }

            // Log
            $date = new DateTime();
            $message = $date->format('Ymd_H:i:s') . ',1005,' .
                $this->session->userdata('login')['user_id'] . ',' .
                'CANCELCLASSTEACHER' . ',' .
                $course->course_id . ';' .
                $reason . ';';
            $this->log_activity_data_record($message);


            $this->session->set_flashdata('alert_success', line('success_course_cancel','controller_js'));
            redirect('dashboard/teacher/course');
        }

    }

    public function delivered($id)
    {
        $this->redirect_if_not_teacher();

        if (is_null($id)) {
            redirect('dashboard');
        }

        if ($this->course_model->check_owner($id) === false) {
            redirect('dashboard');
        }

        $this->data['menu_top'] = "voucher";
        $this->data['menu_left'] = "teacher_payout";
        $this->data['header_title'] = "Vouchers";

        // CRON JOB:
        // Cek deadline class delivery confirmation date
        // If it exceeds the deadline, then send your_class_was_not_delivered
        // Also converts all students payment to credits
        // Send skillagogo_credit_conversion

        $this->load->model('voucher_model');
        $currency = $this->session->userdata('currency') == 'Rp' ? 'IDR' : 'SGD';
        $this->data['vouchers'] = $this->voucher_model->get_voucher_lists_from_class($id, $currency);

        // Here:
        // If it is delivered, send your_class_delivery

        $this->data['id'] = $id;
        $this->twig->display('dashboard/teacher/course/delivered', $this->data);
    }

    public function add_voucher()
    {
        $this->redirect_if_not_teacher();

        $voucher_code = $this->input->post('voucher_code');
        $id = $this->input->post('id');

        if (is_null($id)) {
            redirect('dashboard');
        }

        if ($this->course_model->check_owner($id) === false) {
            redirect('dashboard');
        }

        $course = $this->course_model->get_course($id, false, false);

        $this->check_voucher($voucher_code, $course);

        // redirect to class_delivery
        redirect("dashboard/teacher/course/delivered/" . $id);
    }

    private function check_voucher($voucher_code, $course)
    {
        $this->redirect_if_not_teacher();

        // check voucher code = ""
        if ($voucher_code == "") {
            $this->session->set_flashdata('alert_error', line('error_course_check_voucher_5','controller_js'));
            return;
        }

        // check owner
        if ($course->teacher_id != $this->session->userdata('login')['user_id']) {
            $this->session->set_flashdata('alert_error', line('error_no_permission','controller_js'));
            return;
        }

        // check if class ready to be delivered
        $this->load->model('schedule_model');
        $this->load->helper('date');
        $now = new DateTime(unix_to_human(now(), true, 'eu'));

        // Without expired time for now
        // -- Uncomment the lines below to add expired time
        // $expired_time = new DateTime($this->schedule_model->get_last_time($course->id));
        // $expired_time = new DateTime($expired_time->add(new DateInterval("P7D"))->format("Y-m-d"));

        // if ($now > $expired_time) {
        //     $this->session->set_flashdata('alert_error', line('error_course_check_voucher','controller_js'));
        //     return;
        // }

        $end_time = new DateTime($this->schedule_model->get_last_time($course->id));
        if ($now < $end_time) {
            $this->session->set_flashdata('alert_error', line('error_course_check_voucher_2','controller_js'));
            return;
        }

        // check voucher and add if possible
        $this->load->model('voucher_model');

        if ($this->voucher_model->check_voucher($voucher_code, $course->id) == null) {
            $this->session->set_flashdata('alert_error', line('error_course_check_voucher_3','controller_js'));
            return;
        }

        $this->voucher_model->add_voucher($voucher_code, $course->id);
        $this->session->set_flashdata('alert_success', line('error_course_check_voucher_4','controller_js'));

        // Send thank_you_for_attending to the corresponding student
        $voucher = $this->voucher_model->get($voucher_code);
        $teacher = $this->user_model->get_by_id($this->session->userdata('login')['user_id']);
        $student = $this->user_model->get_by_id($voucher->user_id);
        $course = $this->course_model->get_course($course->id, false, false);
        $data_email['teacher'] = $teacher;
        $data_email['student'] = $student;
        $data_email['course'] = $course;
        $data_email['email'] = $student->email;
        $this->send_notification_email($data_email, line('email_thank_you_attending','controller_js'), 'email/thank_you_for_attending_en');

        // Log create class
        $date = new DateTime();
        $message = $date->format('Ymd_H:i:s') . ',1005,' .
            $voucher->user_id . ',' .
            'ATTENDANCE' . ',' .
            $course->course_id . ';';
        $this->log_activity_data_record($message);

        return;
    }

}
