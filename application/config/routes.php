<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['login'] = 'auth/login';
$route['register'] = 'auth/register';
$route['logout'] = 'auth/logout';
$route['resend-confirmation'] = 'auth/resend_confirmation';
$route['forgot-password'] = 'auth/forgot_password';
$route['coming-soon'] = 'home/coming-soon';
$route['maintenance'] = 'home/maintenance';
$route['thank-you'] = 'home/thank-you';
$route['terms-of-service'] = 'home/terms-of-service';
$route['privacy-policy'] = 'home/privacy-policy';
$route['change-location'] = 'location/change_location';
$route['class/(:num)'] = 'public/course/detail/$1';
$route['teacher/(:num)'] = 'teacher/index/$1';
$route['dashboard'] = 'dashboard/dashboard';
$route['default_controller'] = "home";
$route['translate_uri_dashes'] = true;
$route['become-teacher'] = 'dashboard/student/course/become_teacher';
$route['adminuao3hltbr0/login'] = 'adminuao3hltbr0/auth/login';
$route['adminuao3hltbr0/logout'] = 'adminuao3hltbr0/auth/logout';

/* End of file routes.php */
/* Location: ./application/config/routes.php */
