<?php defined('BASEPATH') OR exit('No direct script access allowed');

// images

// Column  Type    Null    Default Links to    Comments
// id (Primary)    int(10) No
// entity  varchar(20) No
// entity_id   int(10) No
// path    varchar(255)    No
// title   varchar(255)    Yes     NULL
// description longtext    Yes     NULL
// created_at  timestamp   No  CURRENT_TIMESTAMP
// updated_at  timestamp   Yes     NULL

class ImageStatic
{
    private static $model_rules = [
        'add' => [
            [
                'field' => 'entity',
                'label' => 'Entity',
                'rules' => 'required'
            ],
            [
                'field' => 'entity_id',
                'label' => 'Entity ID',
                'rules' => 'required|integer'
            ],
            [
                'field' => 'filename',
                'label' => 'Filename',
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
