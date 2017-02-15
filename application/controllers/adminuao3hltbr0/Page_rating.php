<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "libraries/Admin_Controller.php";

class Page_rating extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        if($this->check_admin_review() == false){
            redirect('adminuao3hltbr0/home');
        }
        $this->load->model('admin_model');

        // set active sidebar
        $this->data['page'] = "page rating";
    }


    public function index()
    {

        if ($this->input->post("publish") && $this->input->post("id")) {
            $this->data['status_publish'] = $this->input->post("id");

            $this->admin_model->update_ratings($this->data['status_publish'], \RatingStatic::STATUS_ACCEPTED);
            $this->data['alert']['success'] = "Your data has been saved";

            // Email Notification student for give a review
            $this->load->model('course_model');
            $this->load->model('rating_model');
            $this->load->model('user_model');

            foreach ($this->input->post('id') as $rating_id) {
                $rating = $this->rating_model->get_rating_by_id($rating_id);
                $course = $this->course_model->get_course($rating->class_id);
                $data = array_merge((array)$rating,(array)$course,(array)$this->user_model->get_by_id($rating->user_id));
                $this->send_notification_email((array)$data, '[skillagogo] Review Notification', 'email/review_ratings_student_en');

                // $this->twig->display("email/review_ratings_student_en", (array)$data);
                // return;

                // Send email notification teacher for given a review
                $data2 = array();
                $data2 = array_merge((array)$rating,(array)$course,(array)$this->user_model->get_by_id($course->teacher_id));
                // var_dump($data2);
                $this->send_notification_email((array)$data2, '[skillagogo] Review Notification', 'email/review_ratings_teacher_en');

                // $this->twig->display("email/review_ratings_teacher_en", (array)$data);
                // return;                
            }
        }

        if ($this->input->post("unpublish") && $this->input->post("id")) {
            $this->data['status_unpublish'] = $this->input->post("id");

            $this->admin_model->update_ratings($this->data['status_unpublish'], \RatingStatic::STATUS_REJECTED);
            $this->data['alert']['success'] = "Your data has been saved";
        }

        if ($this->input->post("delete") && $this->input->post("id")) {
            $this->data['delete'] = $this->input->post("id");
            $this->admin_model->delete_ratings($this->data['delete']);
            $this->data['alert']['deleted'] = "Your data has been deleted";
        }

        if ($this->input->post("del")) {
            $id = $this->input->post("del");
            $this->admin_model->delete_ratings([$id]);
            $this->data['alert']['deleted'] = "Your data has been deleted";
        }

        $this->data['ratings'] = $this->admin_model->get_ratings();
        $this->data['status'] = \RatingStatic::STATUS_HASH;
        $this->twig->display('adminuao3hltbr0/page_rating', $this->data);
    }

    public function detail($rating_id)
    {

        // set active sidebar
        $this->data['page'] = "page rating";

        if ($this->input->post("publish")) {
            $this->admin_model->update_ratings([$rating_id], \RatingStatic::STATUS_ACCEPTED);
            $this->data['alert']['success'] = "Your data has been saved";

            // Email Notification student for give a review
            $this->load->model('course_model');
            $this->load->model('rating_model');
            $this->load->model('user_model');
            $rating = $this->rating_model->get_rating_by_id($rating_id);
            $course = $this->course_model->get_course($rating->class_id);
            $user_sender = $this->user_model->get_by_id($rating->user_id);
            $data = array_merge((array)$user_sender, $this->input->post(), (array)$course, (array)$rating);

            // var_dump($data);

            $this->send_notification_email((array)$data, '[skillagogo] Review Notification', 'email/review_ratings_student_en');

            // $this->twig->display("email/review_ratings_student_en", (array)$data);
            // return;

            // Send email notification teacher for given a review
            $this->load->model('user_model');
            $data = array();
            $data = array_merge((array)$this->user_model->get_by_id($course->teacher_id),
                $this->input->post(),
                (array)$course,
                (array)$rating);
            $this->send_notification_email((array)$data, '[skillagogo] Review Notification', 'email/review_ratings_teacher_en');

            // var_dump($data);

        }

        if ($this->input->post("unpublish")) {
            $this->admin_model->update_ratings([$rating_id], \RatingStatic::STATUS_PENDING);
            $this->data['alert']['success'] = "Your data has been saved";
        }

        if ($this->input->post("delete")) {
            $this->admin_model->delete_ratings([$rating_id]);
            $this->session->set_flashdata('alert_deleted', "Your data has been deleted");
            redirect('adminuao3hltbr0/page_rating');
        }

        $this->data['rating'] = $this->admin_model->get_ratings($rating_id);
        $this->data['rate'] = (int)$this->data['rating']->rate;
        $this->data['status_pending'] = \RatingStatic::STATUS_PENDING;
        $this->data['status_accepted'] = \RatingStatic::STATUS_ACCEPTED;

        $this->twig->display('adminuao3hltbr0/page_detail/detail_rating', $this->data);
    }

    public function edit($rating_id)
    {
        $this->load->model('rating_model');
        $rating = $this->rating_model->get_rating_by_id($rating_id);
        $this->data['rating'] = $rating;

        #redirect if null
        if($this->data['rating']==NULL){
            redirect('adminuao3hltbr0/home');
        }

        // Check admin type
        if( $this->data['user_login_admin']['type'] != \AdminStatic::TYPE_REVIEW and $this->data['user_login_admin']['type'] != \AdminStatic::TYPE_ADMIN) {
            redirect('adminuao3hltbr0/home');
        }

        if ($this->is_post()) {
            $post = $this->input->post();
            $post['id'] = (int)$rating_id;
            $post['user_id'] = (int)$rating->user_id;
            $post['status'] = $rating->status;
            $post['rate'] = $rating->rate;
            $post['reply_to'] = $rating->reply_to;

            // untuk mengisi lagi form edit rating
            $this->data['rating'] = $post;

            if ($this->admin_model->edit_rating($rating_id, $rating->user_id, $post)) {
                $this->session->set_flashdata('alert_success', "Your data has been saved");

                // Log update rating
                $date = new DateTime();
                $message = $date->format('Ymd_H:i:s') . ',1009,' .
                            $this->data['user_login_admin']['admin_id'] . ',' .
                            'ADMINUPDATEREVIEW' . ',' .
                            $course->id . ';' .
                            $post['review'];
                $this->log_content_data_record($message);

                redirect(current_url());
            }

            // save error validation to variable
            if (validation_errors()) {
                $this->data['validation_error'] = validation_errors();
            }
        }

        $this->twig->display('adminuao3hltbr0/page_detail/edit_rating', $this->data);
    }

}
