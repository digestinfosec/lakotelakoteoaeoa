<?php

$lang['error_update_billing_address'] = "Please update your billing address first";
$lang['error_no_permission'] = "Permission denied";
$lang['error_cant_process'] = "We couldn't process your request";
$lang['error_data_not_found'] = "We couldn't find your data";
$lang['error_forbidden_to_change'] = "Change forbidden";
$lang['error_forbidden_access'] = "Access forbidden";
$lang['email_sent_to_you'] = "An email was just sent to you. Please check your mailbox!";

// dashboard/student/Course.php
$lang['error_course_cancel_1'] = "You cannot cancel this class";
$lang['error_course_cancel_2'] = "Class was already cancelled";
$lang['success_course_cancel'] = "You have successfully cancelled the class";
$lang['email_course_cancel_1'] = "[skillagogo] Credit Conversion Notification";
$lang['email_course_cancel_2'] = "[skillagogo] Credit Cancellation Notification";

// dashboard/student/Order.php
$lang['error_order_add'] = "You are not allowed to enroll in your own class";
$lang['error_order_finish'] = "You don't have enough skillagogo credits";
$lang['error_order_finish_2'] = "Please select the payment method";

// dashboard/student/Payment.php
$lang['success_payment_confirmation'] = "You have successfully sent the payment confirmation";

// dashboard/student/Wishlist.php
$lang['error_wishlist_change'] = "You are not allowed to add your own class to your wishlist";
$lang['success_wishlist_change'] = "You have successfully added this class to your wishlist";
$lang['success_wishlist_change_2'] = "You have successfully removed this class from your wishlist";
$lang['email_wishlist_change'] = "Your class was just added to a wishlist!";

// dashboard/teacher/Course.php
$lang['email_course_create'] = "[skillagogo] Your class was successfully published";
$lang['success_course_create'] = "You have successfully saved this class as a draft";
$lang['success_course_create_2'] = "You have successfully published this class";
$lang['success_course_update'] = "You have successfully updated this class";
$lang['error_course_update'] = "Class update failed, please try again later";
$lang['success_course_delete'] = "You have successfully deleted your class";
$lang['error_course_delete'] = "Class deletion failed, please try again later";
$lang['error_course_change_price'] = "You have successfully changed the class price";
$lang['error_course_change_price_2'] = "You can't change the price, because students already enrolled in the class. Please reach us at teachercare@skillagogo.com for assistance";
$lang['error_course_change_price_3'] = "You cannot change the class price because the class has already started";
//$lang['error_course_change_price_4'] = "Your old price is wrong";
$lang['email_course_change_price'] = "[skillagogo] Class Price Change Notification";
$lang['success_course_change_price'] = "You have successfully changed the class price";

$lang['error_course_change_venue'] = "You have succesfully changed the class venue";
$lang['email_course_change_venue'] = "[skillagogo] Class Venue Change Notification";
$lang['success_course_change_venue'] = "You have successfully changed the class venue(s)";

$lang['error_course_change_schedule'] = "You have successfully changed the schedule(s)";
$lang['email_course_change_schedule'] = "[skillagogo] Class Schedule Change Notification";
$lang['success_course_change_schedule'] = "You have successfully changed the class schedule(s)";

$lang['error_course_cancel'] = "You are not allowed to cancel a class happening in less than 48 hours";
$lang['error_course_cancel_2'] = "Your class was already cancelled";
$lang['email_course_cancel'] = "[skillagogo] Class Cancellation Notification";
$lang['success_course_cancel'] = "You have successfully cancelled the class";

$lang['error_course_check_voucher'] = "You can't claim this voucher because it has already expired";
$lang['error_course_check_voucher_2'] = "You can only claim vouchers after the class is completed";
$lang['error_course_check_voucher_3'] = "This voucher code number can't be found or has already been claimed";
$lang['error_course_check_voucher_4'] = "You have successfully claimed this voucher";
$lang['error_course_check_voucher_5'] = "Please insert the voucher code";

$lang['email_thank_you_attending'] = "[skillagogo] Thank you for your attendance to this class";

// dashboard/Comment.php
$lang['error_comment_add'] = "You can only post comments if you are registered for this class";
$lang['success_comment_add'] = "Your comment is awaiting approval";
$lang['success_comment_edit'] = "You have successfully updated your comment";
$lang['success_comment_remove'] = "You have successfully deleted your comment";
$lang['error_comment_remove'] = "Comment deletion failed, please try again later";

// dashboard/Paypal.php
$lang['email_paypal_complete'] = "[skillagogo] Class Attendance Voucher";
$lang['email_paypal_complete_2'] = "[skillagogo] Class Enrollment Confirmation";
$lang['email_paypal_complete_3'] = "[skillagogo] Someone has registered to your class";

// dashboard/Profile.php
$lang['success_profile_index'] = "You have successfully updated your profile";
$lang['success_profile_password_setting'] = "You have successfully updated your password";
$lang['success_profile_notification'] = "You have successfully updated your notification settings";

// dashboard/Rating.php
$lang['error_rating_add'] = "Please confirm you have read and agreed to our Terms of Service and Privacy Policy";
$lang['success_rating_add'] = "Your review is awaiting admin approval";

// Auth.php
$lang['error_auth_login'] = "Invalid username or password";
$lang['error_auth_login_2'] = "Profile is not found or not activated yet";
$lang['email_auth_register'] = "[skillagogo] Email Activation";
$lang['success_auth_register'] = "Almost done! Please activate your account by clicking the link sent to ";
$lang['email_auth_confirm'] = "[skillagogo] Welcome to skillagogo";
$lang['success_auth_confirm'] = "Welcome to skillagogo! You have successfully activated your account";
$lang['error_auth_confirm'] = "Your confirmation key is invalid";
$lang['email_auth_forgot_password'] = "[skillagogo] Password Reset ";
$lang['error_auth_forgot_password'] = "There is no user registered with this email address";
$lang['email_auth_reset_password'] = "[skillagogo] Successful Password Reset";
$lang['email_auth_resend_confirmation'] = "[skillagogo] Email Activation (Redelivered)";

// Page.php 
$lang['email_page_contact_us'] = "[skillagogo] Contact Us";
$lang['success_page_contact_us'] = "Thanks for your message! We will process it shortly and get back to you.";

// Teacher.php
$lang['success_teacher_recommend'] = "Thanks! Your recommendation was successfully submitted";

// dashboard/shareds/profile/index
$lang['dropify_confirm'] = "Do you really want to delete ";
$lang['dropify_deleted'] = "File is deleted";

$lang['dropify_default'] = 'Drag and drop a file here or click';
$lang['dropify_replace'] = 'Drag and drop or click to replace';
$lang['dropify_remove'] =  'Remove';
$lang['dropify_error'] =   'Ooops, something wrong appended';

// dashboard/teacher/course/form
$lang['are_you_sure'] = "Are you sure?";
$lang['must_save'] = "You must save this class as a draft before the preview";
$lang['validation_set_correct_date'] = "Please set the correct date";
$lang['validation_set_price'] = "Please enter an integer value without decimal";
$lang['validation_set_date_after_today'] = "Date must be in the future";
$lang['validation_start_before_end'] = "Start time must occur earlier than end time";
$lang['validation_class_description'] = "Description is limited to 500 characters only";
$lang['validation_class_content'] = "Content is limited to 9999 characters only";
$lang['validation_class_equipment'] = "Description of class equipment is limited to 500 characters only";
$lang['validation_type_of_class'] = "A repeated or staged class needs more than one schedule";
$lang['validation_type_of_class_2'] = "A single class requires one schedule only";
$lang['validation_location_detail'] = "Please enter a location using our maps feature";

// public/auth/forgot_password
$lang['validation_check'] = "Please check your input";
$lang['validation_email'] = "Invalid email address";
$lang['validation_email2'] = "Please enter a valid email address";
$lang['validation_password'] = "Invalid email address or password";
$lang['validation_password_minlength'] = "Password must contain at least 8 characters and use a combination of letters and numbers";

$lang['validation_first_name'] = "Please enter your first name without numbers or special characters";
$lang['validation_last_name'] = "Please enter your last name without numbers or special characters";
$lang['validation_password_confirmation_equalto'] = "Password does not match our record";
$lang['validation_role'] = "Please select your role";
$lang['validation_birthday'] = "Please select your birthday";

// public/course/index
$lang['search'] = "Your search returned 0 results";

// Admin -- payout
$lang['email_make_payout'] = "[skillagogo] Your payout has been successfully transfered";

// CronMailer.php
$lang['cron_email_reminder'] = "[skillagogo] Your class starts tomorrow!";
$lang['cron_email_class_delivery'] = "[skillagogo] Your class delivery today";
$lang['cron_email_credit_expiring'] = "[skillagogo] Your skillagogo credit is expiring soon";

$lang['email_order_finish_bank'] = "[skillagogo] Preorder Summary";
