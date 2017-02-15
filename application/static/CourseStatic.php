<?php defined('BASEPATH') OR exit('No direct script access allowed');

// classes

// Column  Type    Null    Default Links to    Comments
// id (Primary)    int(10) No
// teacher_id  int(10) No      users -> id
// institution_id  int(10) Yes     NULL    institutions -> id
// title   varchar(100)    No
// slug    varchar(100)    No
// description longtext    No
// content longtext    No
// prerequisite_skill  tinyint(1)  No
// end_goal    longtext    No
// class_leader    varchar(100)    No
// about_leader    longtext    No
// type    int(11) No
// price   decimal(10,0)   No
// available_seat  int(11) No
// special_equipment   longtext    Yes     NULL
// pack    tinyint(1)  No
// level   int(11) No
// publish_status  int(11) No
// category_id int(10) No
// changed_by  int(10) Yes     NULL
// currency    varchar(255)    No  IDR
// created_at  timestamp   No  CURRENT_TIMESTAMP
// updated_at  timestamp   Yes     NULL

// ----

// class_comments

// Column  Type    Null    Default Links to    Comments
// comment_id (Primary)    int(10) No      comments -> id
// class_id (Primary)  int(10) No      classes -> id
// created_at  timestamp   No  CURRENT_TIMESTAMP
// updated_at  timestamp   Yes     NULL

// ----

// class_ratings

// Column  Type    Null    Default Links to    Comments
// rating_id (Primary) int(10) No      ratings -> id
// class_id (Primary)  int(10) No      classes -> id
// created_at  timestamp   No  CURRENT_TIMESTAMP
// updated_at  timestamp   Yes     NULL

class CourseStatic
{
    const CLASS_SINGLE = 1;
    const CLASS_REPEATED = 2;
    const CLASS_STAGED = 3;

    const PUBLISH_DRAFT = 1;
    const PUBLISH_PENDING = 2;
    const PUBLISH_REJECT = 3;
    const PUBLISH_SUCCESS = 4;
    const PUBLISH_DELETED = 5;

    const STATUS_NOT_STARTED = 1;
    const STATUS_STARTED = 2;
    const STATUS_FINISHED = 3;
    const STATUS_CANCELLED = 4;
    const STATUS_DELETED = 5;

    const LEVEL_BEGINNER = 1;
    const LEVEL_INTERMEDIATE = 2;
    const LEVEL_ADVANCED = 3;

    const TYPE_HASH =
    [
        self::CLASS_SINGLE => "Single",
        self::CLASS_REPEATED => "Repeated",
        self::CLASS_STAGED => "Staged"
    ];

    protected $_table = "classes";

    //region #Model Rules
    protected static $model_rules = [
        'publish' => [
            [
                'field' => 'title',
                'label' => 'Class Title',
                'rules' => 'required'
            ],
            [
                'field' => 'description',
                'label' => 'Class Description',
                'rules' => 'required'
            ],
            [
                'field' => 'content',
                'label' => 'Class Content',
                'rules' => 'required'
            ],
            [
                'field' => 'prerequisite_skill',
                'label' => 'Prerequisite Skill',
                'rules' => 'required'
            ],
            [
                'field' => 'end_goal',
                'label' => 'Class Objectives',
                'rules' => 'required'
            ],
            [
                'field' => 'class_leader',
                'label' => 'Class Leader',
                'rules' => 'required'
            ],
            [
                'field' => 'about_leader',
                'label' => 'About the Class Leader',
                'rules' => 'required'
            ],
            [
                'field' => 'type',
                'label' => 'Class Type',
                'rules' => 'required'
            ],
            [
                'field' => 'price',
                'label' => 'Class Price',
                'rules' => 'required'
            ],
            [
                'field' => 'available_seat',
                'label' => 'Available Seat',
                'rules' => 'required'
            ],
            [
                'field' => 'special_equipment',
                'label' => 'Special Equipments',
                'rules' => 'required|max_length[500]'
            ],
            [
                'field' => 'pack',
                'label' => 'Class Pack',
                'rules' => 'required'
            ],
            [
                'field' => 'level',
                'label' => 'Level',
                'rules' => 'required'
            ],
        ],
        'create_step1' => [
            [
                'field' => 'title',
                'label' => 'Class Title',
                'rules' => 'required'
            ],
            [
                'field' => 'description',
                'label' => 'Class Description',
                'rules' => 'required'
            ],
            [
                'field' => 'content',
                'label' => 'Class Content',
                'rules' => 'required'
            ],
            [
                'field' => 'prerequisite_skill',
                'label' => 'Prerequisite Skill',
                'rules' => 'required'
            ],
            [
                'field' => 'end_goal',
                'label' => 'Class Objectives',
                'rules' => 'required'
            ],
            [
                'field' => 'class_leader',
                'label' => 'Class Leader',
                'rules' => 'required'
            ],
            [
                'field' => 'about_leader',

                'label' => 'About the Class Leader',
                'rules' => 'required'
            ]
        ]
    ];
    //endregion

    public static function get_rule($action, $param = array())
    {
        switch ($action) {
            default :
                $rule = self::$model_rules[$action];
        }

        return $rule;
    }
}
