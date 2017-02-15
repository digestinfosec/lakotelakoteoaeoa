<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Course extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("course_model");
    }

    public function index()
    {
        $this->setCurrentUrl();
        $this->load->model('category_model');
        $this->data['categories'] = $this->category_model->get_category_tree();
        $this->load->helper('sg_form');
        $param = $this->input->get();
        parse_str($_SERVER['QUERY_STRING'], $queryString);
        $this->data['queryString'] = str_replace("\"", "'", json_encode($queryString));
        $this->data['values'] = $this->input->get();

        $this->twig->display('public/course/index', $this->data);
    }

    public function get_ajax_courses()
    {
        $page = $this->input->get('page');
        $option = $this->input->get();
        $option['offset'] = 6 * $page;
        $option['limit'] = 6;
        $option['publish_status'] = CourseStatic::PUBLISH_SUCCESS;
        $option['search'] = $this->input->get('search');
        $option['strict'] = $this->input->get('strict') ? true : false;
        $option['directory_class_only'] = $this->input->get('strict') ? true : false;

        if ($option['search'] != '') {
            if ($option['search'] != '') {
                // Log logout
                $date = new DateTime();
                $message = $date->format('Ymd_H:i:s') . ',' .
                    $this->session->userdata('login')['user_id'] . ',' .
                    'SEARCH' . ',' .
                    $option['search'];
                $this->log_activity_data_record($message);
            }
        }

        // Untuk tombol load more hide
        $limit_load = $option['limit'] + $option['offset'];

        $sum_course = $this->course_model->get_count_courses($option);
        $finish = ($limit_load >= (int)$sum_course ? false : true);

        $courses = $this->course_model->get_courses($option);
        $result = '';

        foreach ($courses as $course) {
            $this->data['course'] = $course;
            $result .= '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">';
            $result .= $this->twig->render('public/course/course_card', $this->data);
            $result .= '</div>';
        }
        $result = [$result, $finish];
        echo json_encode($result);
    }

    public function detail($slug)
    {
        $this->setCurrentUrl();

        $this->load->model('rating_model');
        $this->load->model('schedule_model');
        $this->load->model('comment_model');
        $this->load->helper('shorten_string');
        $this->load->helper('rate');
        if (is_numeric($slug)) {
            $course = $this->course_model->get_course($slug);
            redirect('/course/detail/' . $course->unique_id . '-' . $course->slug);
        };


        $course = $this->course_model->get_course_by_slug($slug);
        if ($this->session->userdata('location') !== substr($course->currency, 0, 2) &&
            !$this->checkSocialMediaAgent() &&
            !$this->session->userdata('login_admin')['status']
        ) {
            redirect('/');
        }
        $this->data['course_rate'] = $this->rating_model->get_class_average_rate($course->id);
        $this->data['course_schedules'] = $this->schedule_model->get_schedules($course->id);
        $params['limit'] = 3;
        $this->data['course_comments'] = $this->comment_model->get_comments_course($course->id, $params);
        $this->data['count_comment'] = $this->comment_model->get_count_comments_course($course->id);
        $this->data['type_hash'] = CourseStatic::TYPE_HASH;

        $description = str_replace('', '', $course->description);
        $description = str_replace('', '', $description);
        $course->description = $description;

        $content = str_replace('', '', $course->content);
        $content = str_replace('', '', $content);
        $course->content = $content;

        $about_leader = str_replace('', '', $course->about_leader);
        $about_leader = str_replace('', '', $about_leader);
        $course->about_leader = $about_leader;

        $end_goal = str_replace('', '', $course->end_goal);
        $end_goal = str_replace('', '', $end_goal);
        $course->end_goal = $end_goal;

        // Class Recommendation other class from this course on course detail page
        $option['other_course_course_id'] = $course->id;
        $option['teacher_id'] = $course->teacher_id;
        $option['limit'] = 6;
        $option['strict'] = true;
        $this->data['courses'] = $this->course_model->get_courses($option);

        //meta
        $this->data['meta_title'] = $course->title;
        $this->data['meta_description'] = $course->description;
        $this->data['meta_image'] = isset($course->images[0]) ?
            base_url() . "images/class/" . $course->images[0]->title :
            base_url() . "assets/images/image_default_big.png";

        $this->data['share'] = $this->share_link($course->title, $course->description,
            $this->data['meta_image']);

        $this->data['count_student_registered'] = (int)$course->available_seat - $this->course_model->count_student_registered($course->id);
        $this->data['registered'] = $this->course_model->check_if_auth_user_registered($course->id);
        $this->data['course'] = $course;


        // Test Google Maps
        if ($this->data['course_schedules']) {
            $map_id = 0;
            $marker = array();
            foreach ($this->data['course_schedules'] as $schedule) {
                $this->load->library('googlemaps');
                $config['center'] = $schedule->latitude . ", " . $schedule->longitude;
                $config['zoom'] = 16;
                $config['apiKey'] = 'AIzaSyD9EqURdti6hiyW4KBDfVmQkcMznfqwDbs';
                $this->googlemaps->initialize($config);
                $marker['position'] = $schedule->latitude . ", " . $schedule->longitude;
                $marker['div_id'] = 'map_canvas' . (string)$map_id;
                $this->googlemaps->add_marker($marker);
                $this->data['maps'][] = $this->googlemaps->create_map('map_canvas' . (string)$map_id);
                $map_id += 1;
            }
        }
        $this->twig->display('public/course/detail', $this->data);
    }

    public function preview($course_id)
    {
        if ($this->course_model->check_owner($course_id) === false) {
            redirect('dashboard');
        }

        $this->load->model('rating_model');
        $this->load->model('schedule_model');
        $this->load->model('comment_model');
        $this->load->helper('shorten_string');
        $this->load->helper('rate');

        $this->data['course'] = $this->course_model->get_course($course_id);
        if ($this->session->userdata('location') !== substr($this->data['course']->currency, 0,
                2) and !$this->session->userdata('login_admin')['status']
        ) {
            redirect('/');
        }
        $this->data['course_rate'] = $this->rating_model->get_class_average_rate($course_id);
        $this->data['course_schedules'] = $this->schedule_model->get_schedules($course_id);
        $this->data['course_comments'] = $this->comment_model->get_comments_course($course_id);
        $this->data['count_comment'] = $this->comment_model->get_count_comments_course($course_id);
        $this->data['type_hash'] = CourseStatic::TYPE_HASH;

        $description = str_replace('', '', $this->data['course']->description);
        $description = str_replace('', '', $description);
        $this->data['course']->description = $description;

        $content = str_replace('', '', $this->data['course']->content);
        $content = str_replace('', '', $content);
        $this->data['course']->content = $content;

        $about_leader = str_replace('', '', $this->data['course']->about_leader);
        $about_leader = str_replace('', '', $about_leader);
        $this->data['course']->about_leader = $about_leader;

        $end_goal = str_replace('', '', $this->data['course']->end_goal);
        $end_goal = str_replace('', '', $end_goal);
        $this->data['course']->end_goal = $end_goal;

        // Class Recommendation other class from this course on course detail page
        $option['other_course_course_id'] = $course_id;
        $option['teacher_id'] = $this->data['course']->teacher_id;
        $option['limit'] = 6;
        $option['strict'] = true;
        $option['more_classes'] = true;
        $this->data['courses'] = $this->course_model->get_courses($option);

        $this->data['share'] = $this->share_link($this->data['course']->title, $this->data['course']->description, '');

        $this->data['count_student_registered'] = (int)$this->data['course']->available_seat - $this->course_model->count_student_registered($course_id);
        $this->data['registered'] = $this->course_model->check_if_auth_user_registered($course_id);

        if ($this->data['course_schedules']) {
            $map_id = 0;
            $marker = array();
            $this->load->library('googlemaps');
            foreach ($this->data['course_schedules'] as $schedule) {
                $config['center'] = ($schedule->latitude ?: "0") . ", " . ($schedule->longitude ?: "0");
                $config['zoom'] = 16;
                $config['apiKey'] = 'AIzaSyD9EqURdti6hiyW4KBDfVmQkcMznfqwDbs';
                $this->googlemaps->initialize($config);
                $marker['position'] = ($schedule->latitude ?: "0") . ", " . ($schedule->longitude ?: "0");
                $marker['div_id'] = 'map_canvas' . (string)$map_id;
                $this->googlemaps->add_marker($marker);
                $this->data['maps'][] = $this->googlemaps->create_map('map_canvas' . (string)$map_id);
                $map_id += 1;
            }
        }

        $this->twig->display('public/course/detail', $this->data);
    }

    public function get_course_title()
    {
        $this->load->model('course_model');

        $keyword = $this->input->get('query');
        $course = $this->course_model->get_title_course_row($keyword);

        echo json_encode($course);
    }
}
/* End of file '/Course.php' */
/* Location: ./application/controllers/Course.php */
