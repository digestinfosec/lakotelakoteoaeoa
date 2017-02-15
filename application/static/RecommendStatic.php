<?php defined('BASEPATH') or exit('No direct script access allowed');

// recommend_teachers

// Column  Type    Null    Default Links to    Comments
// id (Primary)    int(10) No
// submitter_name  varchar(100)    No
// submitter_email varchar(100)    No
// teacher_name    varchar(100)    No
// teacher_contact varchar(100)    No
// teacher_email   varchar(100)    No
// teacher_website varchar(100)    No
// status  int(11) No  0
// teacher_expertise   int(11) No
// created_at  timestamp   No  CURRENT_TIMESTAMP
// updated_at  timestamp   Yes     NULL

class RecommendStatic
{
    const STATUS_UNREAD = 0;
    const STATUS_UNPROCESSED = 1;
    const STATUS_PROCESSED = 2;
    const STATUS_REJECTED = 3;

    private static $model_rules = [
        'recommend_teacher' => [
            [
                'field' => 'submitter_name',
                'label' => 'Your Name',
                'rules' => 'required'
            ],
            [
                'field' => 'submitter_email',
                'label' => 'Your Email',
                'rules' => 'required'
            ],
            [
                'field' => 'teacher_name',
                'label' => 'Teacher Name',
                'rules' => 'required'
            ],
            [
                'field' => 'teacher_contact',
                'label' => 'Teacher Contact',
                'rules' => 'required'
            ],
            [
                'field' => 'teacher_email',
                'label' => 'Teacher Email',
                'rules' => 'required'
            ],
            [
                'field' => 'teacher_expertise',
                'label' => 'Teacher Expertise',
                'rules' => 'required|integer'
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
