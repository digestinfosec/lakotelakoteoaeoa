<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * App Class
 *
 * Stop talking and start faking!
 */
class Email extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function account_deletion_en()
    {
        $this->twig->display('email/account_deletion_en');
    }

    function activation_link_register_en()
    {
        $this->twig->display('email/activation_link_register_en');
    }

    function attendance_voucher_en()
    {
        $this->twig->display('email/attendance_voucher_en');
    }

    function class_cancellation_by_student_en()
    {
        $this->twig->display('email/class_cancellation_by_student_en');
    }

    function class_creation_modification_price_en()
    {
        $this->twig->display('email/class_creation_modification_price_en');
    }

    function class_creation_modification_schedule_student_en()
    {
        $this->twig->display('email/class_creation_modification_schedule_student_en');
    }

    function class_creation_modification_schedule_venue_other_info_teacher_en()
    {
        $this->twig->display('email/class_creation_modification_schedule_venue_other_info_teacher_en');
    }

    function class_creation_modification_venue_student_en()
    {
        $this->twig->display('email/class_creation_modification_venue_student_en');
    }

    function class_deletion_or_cancelled_student_en()
    {
        $this->twig->display('email/class_deletion_or_cancelled_student_en');
    }

    function class_deletion_or_cancelled_teacher_en()
    {
        $this->twig->display('email/class_deletion_or_cancelled_teacher_en');
    }

    function class_reminder_student_en()
    {
        $this->twig->display('email/class_reminder_student_en');
    }

    function class_reminder_teacher_en()
    {
        $this->twig->display('email/class_reminder_teacher_en');
    }

    function enrollment_confirmation_email_en()
    {
        $this->twig->display('email/enrollment_confirmation_email_en');
    }

    function new_classes_on_my_interest_student_en()
    {
        $this->twig->display('email/new_classes_on_my_interest_student_en');
    }

    function new_classes_on_my_location_student_en()
    {
        $this->twig->display('email/new_classes_on_my_location_student_en');
    }

    function preorder_summary()
    {
        $this->twig->display('email/preorder_summary');
    }

    function reset_password_en()
    {
        $this->twig->display('email/reset_password_en');
    }

    function reset_password_success_en()
    {
        $this->twig->display('email/reset_password_success_en');
    }

    function review_ratings_student_en()
    {
        $this->twig->display('email/review_ratings_student_en');
    }

    function review_ratings_teacher_en()
    {
        $this->twig->display('email/review_ratings_teacher_en');
    }

    function schedule_change_confirmation_new_schedule_student_en()
    {
        $this->twig->display('email/schedule_change_confirmation_new_schedule_student_en');
    }

    function schedule_change_student_en()
    {
        $this->twig->display('email/schedule_change_student_en');
    }

    function skillagogo_credit_conversion_en()
    {
        $this->twig->display('email/skillagogo_credit_conversion_en');
    }

    function skillagogo_credit_is_expiring_en()
    {
        $this->twig->display('email/skillagogo_credit_is_expiring_en');
    }

    function someone_added_to_my_wishlist_teacher_en()
    {
        $this->twig->display('email/someone_added_to_my_wishlist_teacher_en');
    }

    function someone_registered_to_my_class_teacher_en()
    {
        $this->twig->display('email/someone_registered_to_my_class_teacher_en');
    }

    function successful_class_publication_email_en()
    {
        $this->twig->display('email/successful_class_publication_email_en');
    }

    function successful_payout_transfer_en()
    {
        $this->twig->display('email/successful_payout_transfer_en');
    }

    function thank_you_for_attending_en()
    {
        $this->twig->display('email/thank_you_for_attending_en');
    }

    function welcome_email_student_en()
    {
        $this->twig->display('email/welcome_email_student_en');
    }

    function welcome_email_teacher_en()
    {
        $this->twig->display('email/welcome_email_teacher_en');
    }

    function your_class_delivery_en()
    {
        $this->twig->display('email/your_class_delivery_en');
    }

    function your_class_was_not_delivered_student_en()
    {
        $this->twig->display('email/your_class_was_not_delivered_student_en');
    }

    function contact_us()
    {
        $this->twig->display('email/dulu/contact_us');
    }

    function forgot_password()
    {
        $this->twig->display('email/dulu/forgot_password');
    }

    function pre_register()
    {
        $this->twig->display('email/dulu/pre_register');
    }

    function register()
    {
        $this->twig->display('email/dulu/register');
    }

    function reset_password()
    {
        $this->twig->display('email/dulu/reset_password');
    }

}