<?php defined('BASEPATH') OR exit('No direct script access allowed');

// user_details

// Column  Type    Null    Default Links to    Comments
// user_id (Primary)   int(10) No      users -> id
// birth_date  date    No
// home_phone  varchar(30) Yes     NULL
// mobile_phone    varchar(30) No
// gender  int(11) No
// marital_status  int(11) No
// academic_level  varchar(50) No
// email_notification  tinyint(1)  No  1
// nationality varchar(3)  No  IDN
// language_preference varchar(2)  No  id
// created_at  timestamp   No  CURRENT_TIMESTAMP
// updated_at  timestamp   Yes     NULL

class UserDetailStatic
{
    const GENDER_EMPTY = 0;
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    const MARITAL_EMPTY = 0;
    const MARITAL_SINGLE = 1;
    const MARITAL_RELATIONSHIP = 2;
    const MARITAL_MARRIED = 3;

    const ACADEMIC_INDONESIAN_SMA = 'academic_sma';
    const ACADEMIC_INDONESIAN_DIPLOMA = 'academic_diploma';
    const ACADEMIC_INDONESIAN_S1 = 'academic_sarjana';
    const ACADEMIC_INDONESIAN_MASTER = 'academic_master';
    const ACADEMIC_INDONESIAN_DOKTOR = 'academic_doktor';

    const ACADEMIC_SINGAPORE_SECONDARY = 'academic_secondary';
    const ACADEMIC_SINGAPORE_POSTSECONDARY = 'academic_postsecondary';
    const ACADEMIC_SINGAPORE_UNIVERSITY = 'academic_university';
    const ACADEMIC_SINGAPORE_POSTGRADUATE = 'academic_postgraduate';

    private static $model_rules = [
        'update' => [
            [
                'field' => 'birth_date',
                'label' => 'User ID',
                'rules' => 'valid_date[y-m-d, -]'
            ],
            [
                'field' => 'user_id',
                'label' => 'User ID',
                'rules' => 'required|integer'
            ],
            [
                'field' => 'comment',
                'label' => 'Comment',
                'rules' => 'required'
            ]
        ]
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
