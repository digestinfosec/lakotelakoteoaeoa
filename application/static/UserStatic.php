<?php defined('BASEPATH') OR exit('No direct script access allowed');

// users

// Column  Type    Null    Default Links to    Comments
// id (Primary)    int(10) No
// first_name  varchar(100)    Yes     NULL
// last_name   varchar(100)    Yes     NULL
// email   varchar(150)    No
// username    varchar(100)    Yes     NULL
// password    varchar(100)    Yes     NULL
// type    int(11) Yes     1
// reg_key varchar(32) Yes     NULL
// status  int(11) Yes     0
// is_teacher  tinyint(1)  No  0
// is_student  tinyint(1)  No  0
// last_login  datetime    No  CURRENT_TIMESTAMP
// forgot_key  varchar(32) Yes     NULL
// last_send_email datetime    No  CURRENT_TIMESTAMP
// pre_register    tinyint(1)  No  0
// send_updates    tinyint(1)  No  0
// fb_token    varchar(128)    Yes     NULL
// fb_id   varchar(128)    Yes     NULL
// profile_pic varchar(100)    No  no_profile.jpg
// created_at  timestamp   No  CURRENT_TIMESTAMP
// updated_at  timestamp   Yes     NULL

class UserStatic
{
    const STATUS_UNCONFIRMED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BANNED = 2;

    const TYPE_CUSTOMER = 1;
    const TYPE_ADMIN = 2;
    const TYPE_REVIEW = 3;
    const TYPE_MARKETING = 4;

    const STATUS_HASH =
    [
        self::STATUS_UNCONFIRMED => "Unconfirmed",
        self::STATUS_ACTIVE => "Active",
        self::STATUS_BANNED => "Banned"
    ];

    const TYPE_HASH =
    [
        self::TYPE_CUSTOMER => "Customer",
        self::TYPE_ADMIN => "Administrator",
        self::TYPE_REVIEW => "Review Officer",
        self::TYPE_MARKETING => "Marketing Officer"
    ];


    private static $model_rules = [
        'login' => [
            [
                'field' => 'email',
                'label' => 'email',
                'rules' => 'required'
            ],
            [
                'field' => 'password',
                'label' => 'password',
                'rules' => 'required'
            ],
        ],
        'register' => [
            [
                'field' => 'first_name',
                'label' => 'First Name',
                'rules' => 'required'
            ],
            [
                'field' => 'last_name',
                'label' => 'Last Name',
                'rules' => 'required'
            ],
            [
                'field' => 'email',
                'label' => 'Email Address',
                'rules' => 'required|is_unique[users.email]',
                'errors' => [
                    'is_unique' => '{field} is already in use.'
                ]
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required'
            ],
            [
                'field' => 'password_confirmation',
                'label' => 'Confirm Password',
                'rules' => 'required|matches[password]'
            ],
            [
                'field' => 'role',
                'label' => 'Role',
                'rules' => 'required'
            ]
        ],
        'pre_register' => [
            [
                'field' => 'first_name',
                'label' => 'First Name',
                'rules' => 'required'
            ],
            [
                'field' => 'last_name',
                'label' => 'Last Name',
                'rules' => 'required'
            ],
            [
                'field' => 'email',
                'label' => 'Email Address',
                'rules' => 'required|is_unique[users.email]',
                'errors' => [
                    'is_unique' => '{field} is already in use.'
                ]
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required'
            ],
            [
                'field' => 'password_confirmation',
                'label' => 'Confirm Password',
                'rules' => 'required|matches[password]'
            ],
            [
                'field' => 'role',
                'label' => 'Role',
                'rules' => 'required'
            ],
            [
                'field' => 'birth_date',
                'label' => 'Birthday',
                'rules' => 'required|date'
            ]
        ],
        'reset_password' => [
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required'
            ],
            [
                'field' => 'password_confirmation',
                'label' => 'Confirm Password',
                'rules' => 'required|matches[password]'
            ],
        ],
        'update_notification' => [
            [
                'field' => 'notification_newsletter',
                'label' => 'Newsletter Subscription',
                'rules' => 'integer'
            ],
        ],
        'resend' => [
            [
                'field' => 'email',
                'label' => 'email',
                'rules' => ['required', 'callback_check_email_resend'],
                'errors' => [
                    'check_email_resend' => "User with defined email is not found or you already activated."
                ]
            ]
        ],
        'forgot-password' => [
            [
                'field' => 'email',
                'label' => 'email',
                'rules' => ['required', 'callback_check_email'],
                'errors' => [
                    'check_email' => "User with defined email is not found."
                ]
            ]
        ],
        'send_email_contact_us' => [
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required'
            ]
        ],
        'update_password' => [
            [
                'field' => 'current_password',
                'label' => 'Current Password',
                'rules' => 'callback_check_update_password',
                'errors' => [
                    'check_update_password' => 'Your {field} is incorrect.'
                ]
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|regex_match[/^(?:(?=.*[a-zA-Z])(?:(?=.*[0-9]))).{8,}$/]',
                'errors' => [
                    'regex_match' => 'New Password must contain at least 8 characters, use a combination of letters and numbers.'
                ]
            ],
            [
                'field' => 'confirm_password',
                'label' => 'Confirm Password',
                'rules' => 'required|regex_match[/^(?:(?=.*[a-zA-Z])(?:(?=.*[0-9]))).{8,}$/]',
                'errors' => [
                    'regex_match' => 'Confirm New Password must contain at least 8 characters, use a combination of letters and numbers.'
                ]
            ],
            [
                'field' => 'confirm_password',
                'label' => 'Confirm Password',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'matches' => 'New Password did not match.'
                ]
            ],
        ],
        'update_password_admin' => [
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'regex_match[/^(?:(?=.*[a-zA-Z])(?:(?=.*[0-9]))).{8,}$/]',
                'errors' => [
                    'regex_match' => 'New Password must contain at least 8 characters, use a combination of letters and numbers.'
                ]
            ],
            [
                'field' => 'confirm_password',
                'label' => 'Confirm Password',
                'rules' => 'regex_match[/^(?:(?=.*[a-zA-Z])(?:(?=.*[0-9]))).{8,}$/]',
                'errors' => [
                    'regex_match' => 'Confirm New Password must contain at least 8 characters, use a combination of letters and numbers.'
                ]
            ],
            [
                'field' => 'confirm_password',
                'label' => 'Confirm Password',
                'rules' => 'matches[password]',
                'errors' => [
                    'matches' => 'New Password did not match.'
                ]
            ],
        ]
    ];

    public static function get_rule($action, $param = array())
    {
        switch ($action) {
            case 'update' :
                $rule = self::get_update_rule($param);
                break;
            case 'save_profile' :
                $rule = self::get_save_profile_rule($param);
                break;

            default :
                $rule = self::$model_rules[$action];
        }

        return $rule;
    }

    private static function get_update_rule($param)
    {
        var_dump($param);
        $rule = [
            [
                'field' => 'first_name',
                'label' => 'First name',
                'rules' => 'required'
            ],
            [
                'field' => 'last_name',
                'label' => 'Last name',
                'rules' => 'required'
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|valid_email|edit_unique[users.email.' . $param['id'] . ']',
                'errors' => [
                    'edit_unique' => '{field} is already in use.'
                ]
            ],
            [
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'edit_unique[users.username.' . $param['id'] . ']'
            ]
        ];
        return $rule;
    }

    private static function get_save_profile_rule($param)
    {
        $rule = [
            [
                'field' => 'email',
                'label' => 'email',
                'rules' => 'required|valid_email|edit_unique[users.email.' . $param['id'] . ']',
                'errors' => [
                    'edit_unique' => '{field} is already in use.'
                ]
            ],
            [
                'field' => 'first_name',
                'label' => 'First Name',
                'rules' => 'required'
            ],
            [
                'field' => 'last_name',
                'label' => 'Last Name',
                'rules' => 'required'
            ],
            [
                'field' => 'mobile_phone',
                'label' => 'Mobile Phone',
                'rules' => 'required'
            ],
            [
                'field' => 'birth_date',
                'label' => 'Birthday',
                'rules' => 'required|valid_date[y-m-d,-]'
            ],
            [
                'field' => 'gender',
                'label' => 'Gender',
                'rules' => 'numeric'
            ],
            [
                'field' => 'marital_status',
                'label' => 'Marital Status',
                'rules' => 'numeric'
            ],
            [
                'field' => 'academic_level',
                'label' => 'Academic Level',
                'rules' => 'alpha_dash'
            ]
        ];

        return $rule;

    }
}
