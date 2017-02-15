<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "libraries/Admin_Controller.php";

class Page_comment extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        if($this->check_admin_review() == false){
            redirect('adminuao3hltbr0/home');
        }
        $this->load->model('admin_model');

        $this->data['page'] = "page comment";
    }


    public function index()
    {

        if ($this->input->post("publish") && $this->input->post("id")) {
            $this->data['status_publish'] = $this->input->post("id");

            $this->admin_model->update_comments($this->data['status_publish'], \CommentStatic::STATUS_ACCEPTED);
            $this->data['alert']['success'] = "Your data has been saved";
        }

        if ($this->input->post("unpublish") && $this->input->post("id")) {
            $this->data['status_unpublish'] = $this->input->post("id");

            $this->admin_model->update_comments($this->data['status_unpublish'], \CommentStatic::STATUS_REJECTED);
            $this->data['alert']['success'] = "Your data has been saved";
        }

        if ($this->input->post("delete") && $this->input->post("id")) {
            $this->data['delete'] = $this->input->post("id");
            $this->admin_model->delete_comments($this->data['delete']);
            $this->data['alert']['deleted'] = "Your data has been deleted";
        }

        if ($this->input->post("del")) {
            $id = $this->input->post("del");
            $this->admin_model->delete_comments([$id]);
            $this->data['alert']['deleted'] = "Your data has been deleted";
        }

        $this->data['comments'] = $this->admin_model->get_comments();
        $this->data['status'] = \CommentStatic::STATUS_HASH;
        $this->data['status_pending'] = \CommentStatic::STATUS_PENDING;
        $this->data['status_accepted'] = \CommentStatic::STATUS_ACCEPTED;

        $this->twig->display('adminuao3hltbr0/page_comment', $this->data);
    }

    public function detail($comment_id)
    {
        $this->data['page'] = "page comment";

        if ($this->input->post("publish")) {
            $this->admin_model->update_comments([$comment_id], \CommentStatic::STATUS_ACCEPTED);
            $this->data['alert']['success'] = "Your data has been saved";
        }

        if ($this->input->post("unpublish")) {
            $this->admin_model->update_comments([$comment_id], \CommentStatic::STATUS_PENDING);
            $this->data['alert']['success'] = "Your data has been saved";
        }

        if ($this->input->post("delete")) {
            $this->admin_model->delete_comments([$comment_id]);
            $this->session->set_flashdata('alert_deleted', "Your data has been deleted");
            redirect('adminuao3hltbr0/page_comment');
        }

        $this->data['comment'] = $this->admin_model->get_comments($comment_id);
        $this->data['status_pending'] = \CommentStatic::STATUS_PENDING;
        $this->data['status_accepted'] = \CommentStatic::STATUS_ACCEPTED;
        // var_dump($this->data['comment']);
        // die();

        $this->twig->display('adminuao3hltbr0/page_detail/detail_comment', $this->data);
    }

    public function edit($comment_id)
    {
        $this->load->model('comment_model');
        $comment = $this->comment_model->get_by_id($comment_id);
        $this->data['comment'] = $comment;

        #redirect if null
        if($this->data['comment']==NULL){
            redirect('adminuao3hltbr0/home');
        }

        // Check admin type
        if( $this->data['user_login_admin']['type'] != \AdminStatic::TYPE_REVIEW and $this->data['user_login_admin']['type'] != \AdminStatic::TYPE_ADMIN) {
            redirect('adminuao3hltbr0/home');
        }

        if ($this->is_post()) {
            $post = $this->input->post();
            $post['id'] = (int)$comment_id;
            $post['user_id'] = (int)$comment->commenter_id;
            $post['status'] = $comment->status;
            $post['reply_to'] = $comment->reply_to;

            // untuk mengisi lagi form edit comment
            $this->data['comment'] = $post;

            if ($this->admin_model->edit_comment($comment_id, $comment->commenter_id, $post)) {
                $this->session->set_flashdata('alert_success', "Your data has been saved");
                redirect(current_url());
            }

            // save error validation to variable
            if (validation_errors()) {
                $this->data['validation_error'] = validation_errors();
            }
        }

        $this->twig->display('adminuao3hltbr0/page_detail/edit_comment', $this->data);
    }


}
