<?php defined('BASEPATH') OR exit('No direct script access allowed');

// ratings

// Column  Type    Null    Default Links to    Comments
// id (Primary)    int(10) No
// user_id int(10) No      users -> id
// review  longtext    Yes     NULL
// rate    int(11) Yes     NULL
// status  int(11) No  0
// reply_to    int(10) No  0
// created_at  timestamp   No  CURRENT_TIMESTAMP
// updated_at  timestamp   Yes     NULL

// ----

// class_ratings

// Column  Type    Null    Default Links to    Comments
// rating_id (Primary) int(10) No      ratings -> id
// class_id (Primary)  int(10) No      classes -> id
// created_at  timestamp   No  CURRENT_TIMESTAMP
// updated_at  timestamp   Yes     NULL

class RatingStatic
{
    const STATUS_PENDING = 0;
    const STATUS_ACCEPTED = 1;
    const STATUS_REJECTED = 2;

    const STATUS_HASH =
    [
        self::STATUS_PENDING => "Pending",
        self::STATUS_ACCEPTED => "Accepted",
        self::STATUS_REJECTED => "Rejected"
    ];

    private static $model_rules = [
        'add' => [
            [
                'field' => 'class_id',
                'label' => 'Class ID',
                'rules' => 'required|double_unique_current_user[ratings.class_id.user_id]',
                'errors' => [
                    'double_unique_current_user' => "Duplicate entry"
                ]
            ],
            [
                'field' => 'rate',
                'label' => 'Rate',
                'rules' => 'required|greater_than[0]|less_than[6]'
            ],
            [
                'field' => 'review',
                'label' => 'Review',
                'rules' => 'required'
            ]
        ],
        'update' => [
            [
                'field' => 'class_id',
                'label' => 'Class ID',
                'rules' => 'required'
            ],
            [
                'field' => 'rate',
                'label' => 'Rate',
                'rules' => 'required|greater_than[0]|less_than[6]'
            ],
            [
                'field' => 'review',
                'label' => 'Review',
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
