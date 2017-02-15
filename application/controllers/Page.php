<?php

class Page extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("admin_model");
    }

    public function terms_of_service()
    {
        $this->data['static_page_en'] = $this->admin_model->get_static_page_with_lang('terms of service', \StaticStatic::ENGLISH);
        $this->data['static_page_id'] = $this->admin_model->get_static_page_with_lang('terms of service', \StaticStatic::INDONESIA);
        $this->show_static_page();
        $this->twig->display('public/page/terms_of_service', $this->data);
    }

    public function privacy_policy()
    {
        $this->data['static_page_en'] = $this->admin_model->get_static_page_with_lang('privacy policy', \StaticStatic::ENGLISH);
        $this->data['static_page_id'] = $this->admin_model->get_static_page_with_lang('privacy policy', \StaticStatic::INDONESIA);
        $this->show_static_page();
        $this->twig->display('public/page/privacy_policy', $this->data);
    }

    public function about_us()
    {
        $this->data['static_page_en'] = $this->admin_model->get_static_page_with_lang('about us', \StaticStatic::ENGLISH);
        $this->data['static_page_id'] = $this->admin_model->get_static_page_with_lang('about us', \StaticStatic::INDONESIA);
        $this->show_static_page();
        $this->twig->display('public/page/about_us', $this->data);
    }

    public function faq()
    {
        $this->data['static_page_en'] = $this->admin_model->get_static_page_with_lang('faq', \StaticStatic::ENGLISH);
        $this->data['static_page_id'] = $this->admin_model->get_static_page_with_lang('faq', \StaticStatic::INDONESIA);
        $this->show_static_page();
        $this->twig->display('public/page/faq', $this->data);
    }

    public function career()
    {
        $this->data['static_page_en'] = $this->admin_model->get_static_page_with_lang('career', \StaticStatic::ENGLISH);
        $this->data['static_page_id'] = $this->admin_model->get_static_page_with_lang('career', \StaticStatic::INDONESIA);
        $this->show_static_page();
        $this->data['content_en_new']=str_replace('{{ base_url }}', '', $this->data['content_en_new']);
        $this->twig->display('public/page/career', $this->data);
    }

    public function how_to_teach()
    {
        $this->data['static_page_en'] = $this->admin_model->get_static_page_with_lang('how to teach', \StaticStatic::ENGLISH);
        $this->data['static_page_id'] = $this->admin_model->get_static_page_with_lang('how to teach', \StaticStatic::INDONESIA);
        $this->show_static_page();
        $this->twig->display('public/page/how_to_teach', $this->data);
    }

    public function how_to_learn()
    {
        $this->data['static_page_en'] = $this->admin_model->get_static_page_with_lang('how to learn', \StaticStatic::ENGLISH);
        $this->data['static_page_id'] = $this->admin_model->get_static_page_with_lang('how to learn', \StaticStatic::INDONESIA);
        $this->show_static_page();
        $this->twig->display('public/page/how_to_learn', $this->data);
    }

    public function contact_us()
    {
        $this->load->model('user_model');
        $this->load->helper('form');
        $this->load->helper('sg_form');

        if ($this->is_post()) {
            $post = $this->input->post();

            // untuk mengisi lagi form profile
            $this->data['profile'] = $post;
            $post = array_merge($post);
            $post = $this->user_model->send_email_contact_us($post);

            if ($post) {
                $this->send_email_contact_us((array)$post, line('email_page_contact_us','controller_js'), 'email/dulu/contact_us');
                $this->data['message_content'] = line('success_page_contact_us','controller_js');
                $this->twig->display("public/home/confirmation", $this->data);
                return;
            }
            $this->data['error'] = validation_errors() ? validation_errors() : "Unknown Error";
        } else {
            $this->data['profile'] = $this->user_model->get_by_id();
        }

        $this->twig->display('public/page/contact_us', $this->data);
    }

    public function show_static_page()
    {
        $this->data['content_en']=html_entity_decode($this->data['static_page_en'][0]->content);
        $this->data['content_id']=html_entity_decode($this->data['static_page_id'][0]->content);

        $content_en_new=str_replace('{{ base_url() }}', base_url(), $this->data['content_en']);
        $content_id_new=str_replace('{{ base_url() }}', base_url(), $this->data['content_id']);
        $this->data['content_en_new']=$content_en_new;
        $this->data['content_id_new']=$content_id_new;
        return;
    }
}
