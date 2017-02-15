<?php defined('BASEPATH') OR exit('No direct script access allowed');

class AdminStatic
{

    const STATUS_UNCONFIRMED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BANNED = 2;

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
        self::TYPE_ADMIN => "Administrator",
        self::TYPE_REVIEW => "Review Officer",
        self::TYPE_MARKETING => "Marketing Officer"
    ];

    private static $model_rules = [
        'add' => [
            [
                'field' => 'username',
                'label' => 'Your Username',
                'rules' => 'required|is_unique[users.username]'

            ],
            [
                'field' => 'first_name',
                'label' => 'First name',
                'rules' => 'required'
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|is_unique[users.email]'
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
                'field' => 'password_confirmation',
                'label' => 'Confirm Password',
                'rules' => 'required|regex_match[/^(?:(?=.*[a-zA-Z])(?:(?=.*[0-9]))).{8,}$/]',
                'errors' => [
                    'regex_match' => 'Confirm New Password must contain at least 8 characters, use a combination of letters and numbers.'
                ]
            ],
            [
                'field' => 'password_confirmation',
                'label' => 'Confirm Password',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'matches' => 'New Password did not match.'
                ]
            ]
        ],
        'update_password' => [
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|regex_match[/^(?:(?=.*[a-zA-Z])(?:(?=.*[0-9]))).{8,}$/]',
                'errors' => [
                    'regex_match' => 'New Password must contain at least 8 characters, use a combination of letters and numbers.'
                ]
            ],
            [
                'field' => 'password_confirmation',
                'label' => 'Confirm Password',
                'rules' => 'required|regex_match[/^(?:(?=.*[a-zA-Z])(?:(?=.*[0-9]))).{8,}$/]',
                'errors' => [
                    'regex_match' => 'Confirm New Password must contain at least 8 characters, use a combination of letters and numbers.'
                ]
            ],
            [
                'field' => 'password_confirmation',
                'label' => 'Confirm Password',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'matches' => 'New Password did not match.'
                ]
            ],
        ]
    ];

    private static function get_update_rule($param)
    {
        $rule = [
            [
                'field' => 'first_name',
                'label' => 'First name',
                'rules' => 'required'
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|valid_email|edit_unique[users.email.' . $param['id'] . ']'
            ],
            [
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required|edit_unique[users.username.' . $param['id'] . ']'
            ]
        ];
        return $rule;
    }

    public static function get_rule($action, $param = array())
    {
        switch ($action) {

            case 'update' :
                $rule = self::get_update_rule($param);
                break;
            default :
                $rule = self::$model_rules[$action];
        }

        return $rule;
    }
}
