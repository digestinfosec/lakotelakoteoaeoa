<?php defined('BASEPATH') OR exit('No direct script access allowed');

// teacher_details

// Column  Type    Null    Default Links to    Comments
// user_id (Primary)   int(10) No      users -> id
// bank_id int(10) No      banks -> id
// office_address_id   int(10) Yes     NULL    addresses -> id
// payout_option   varchar(50) No  teacher_detail.payout_monthly
// monthly_class_envisaged varchar(255)    No
// goal    varchar(255)    No
// objective   varchar(255)    No
// bio longtext    No
// teacher_type    int(11) No
// job varchar(255)    Yes     NULL
// identity_type   int(11) Yes     NULL
// identity_id varchar(50) Yes     NULL
// bank_branch_name    varchar(255)    Yes
// bank_account_number varchar(50) No
// created_at  timestamp   No  CURRENT_TIMESTAMP
// updated_at  timestamp   Yes     NULL

class TeacherDetailStatic
{
    const PAYOUT_MONTHLY = 1;
    const PAYOUT_ON_THE_GO = 2;

    const CLASSES_1_TO_3 = 1;
    const CLASSES_4_TO_6 = 2;
    const CLASSES_7_TO_10 = 3;
    const CLASSES_10_MORE = 4;

    const OBJECTIVE_SHARE = 1;
    const OBJECTIVE_EXTRA_INCOME = 2;
    const OBJECTIVE_GROW_BUSINESS = 3;
    const OBJECTIVE_MORE_STUDENT = 4;

    const TYPE_INDIVIDUAL = 1;
    const TYPE_INSTITUTION = 2;

    private static $model_rules = [
        'update' => [
            [
                'field' => 'bank_id',
                'label' => 'Bank',
                'rules' => 'integer|callback_check_user_indonesia',
                'errors' => [
                    'check_user_indonesia' => "Bank name is required."
                ]
            ],
            [
                'field' => 'bank_branch_name',
                'label' => 'Bank Branch Name',
                'rules' => 'callback_check_user_indonesia',
                'errors' => [
                    'check_user_indonesia' => "Bank branch name is required."
                ]
            ],
            [
                'field' => 'bank_account_number',
                'label' => 'Bank Account Number',
                'rules' => 'callback_check_user_indonesia',
                'errors' => [
                    'check_user_indonesia' => "Bank account number is required."
                ]
            ],
            //[
            //    'field' => 'payout_option',
            //    'label' => 'Payout Option',
            //    'rules' => 'integer|required'
            //],
            [
                'field' => 'monthly_class_envisaged',
                'label' => 'Monthly Class Envisaged',
                'rules' => 'integer|required'
            ],
            [
                'field' => 'objective',
                'label' => 'Objective',
                'rules' => 'integer|required'
            ],
            // [
            //     'field' => 'goal',
            //     'label' => 'Goal',
            //     'rules' => 'required'
            // ],
            [
                'field' => 'teacher_type',
                'label' => 'Teacher Type',
                'rules' => 'integer|required'
            ],
            [
                'field' => 'job',
                'label' => 'Job',
                'rules' => 'required'
            ],
            // [
            //     'field' => 'identity_id',
            //     'label' => 'Identity ID',
            //     'rules' => 'required'
            // ],
            [
                'field' => 'bio',
                'label' => 'Bio',
                'rules' => 'required'
            ],
            [
                'field' => 'website_blog',
                'label' => 'Website/Blog',
                'rules' => 'valid_url'
            ],
            [
                'field' => 'paypal_email',
                'label' => 'Paypal email address',
                'rules' => 'callback_check_user_singapore',
                'errors' => [
                    'check_user_singapore' => "Paypal email address is required."
                ]
            ]
        ],
        'update_admin' => [
            [
                'field' => 'monthly_class_envisaged',
                'label' => 'Monthly Class Envisaged',
                'rules' => 'integer|required'
            ],
            [
                'field' => 'objective',
                'label' => 'Objective',
                'rules' => 'integer|required'
            ],
            [
                'field' => 'teacher_type',
                'label' => 'Teacher Type',
                'rules' => 'integer|required'
            ],
            [
                'field' => 'job',
                'label' => 'Job',
                'rules' => 'required'
            ],
            [
                'field' => 'bio',
                'label' => 'Bio',
                'rules' => 'required'
            ],
            [
                'field' => 'website_blog',
                'label' => 'Website/Blog',
                'rules' => 'valid_url'
            ]
        ],
        'update_notification' => [
            [
                'field' => 'notification_class_register',
                'label' => 'Someone registers to my class',
                'rules' => 'integer'
            ],
            [
                'field' => 'notification_class_add_wishlist',
                'label' => 'Someone adds my class to their wishlist',
                'rules' => 'integer'
            ],
        ],
    ];

    public static function get_rule($action, $param = array())
    {
        switch ($action) {
            default :
                $rule = self::$model_rules[$action];
        }

        return $rule;
    }

}
