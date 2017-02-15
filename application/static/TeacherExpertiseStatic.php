<?php defined('BASEPATH') OR exit('No direct script access allowed');

// teacher_expertise

// Column  Type    Null    Default Links to    Comments
// id (Primary)    int(10) No
// user_id int(10) No      users -> id
// category_id int(11) No      categories -> id
// level   int(11) Yes     NULL
// created_at  timestamp   No  CURRENT_TIMESTAMP
// updated_at  timestamp   Yes     NULL

class TeacherExpertiseStatic
{
    const LEVEL_BEGINNER = 1;
    const LEVEL_ADVANCED = 1;
    const LEVEL_INTERMEDIATE = 1;

    private static $model_rules = [
        'add' => [
            [
                'field' => 'user_id',
                'label' => 'User ID',
                'rules' => 'required'
            ],
            [
                'field' => 'category_id',
                'label' => 'Category ID',
                'rules' => 'required'
            ],
            [
                'field' => 'level',
                'label' => 'Level',
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
