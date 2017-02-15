<?php defined('BASEPATH') OR exit('No direct script access allowed');

// comments

// Column  Type    Null    Default Links to    Comments
// id (Primary)    int(10) No
// user_id int(10) No      users -> id
// comment longtext    No
// status  int(11) No  0
// reply_to    int(10) No  0
// created_at  timestamp   No  CURRENT_TIMESTAMP
// updated_at  timestamp   Yes     NULL

// ----

// class_comments

// Column  Type    Null    Default Links to    Comments
// comment_id (Primary)    int(10) No      comments -> id
// class_id (Primary)  int(10) No      classes -> id
// created_at  timestamp   No  CURRENT_TIMESTAMP
// updated_at  timestamp   Yes     NULL

class CommentStatic
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
                'rules' => 'required|integer'
            ],
            [
                'field' => 'comment',
                'label' => 'Comment',
                'rules' => 'required|max_length[500]'
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
