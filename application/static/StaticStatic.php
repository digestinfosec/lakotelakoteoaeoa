<?php defined('BASEPATH') OR exit('No direct script access allowed');

class StaticStatic
{

    const INDONESIA = 1;
    const ENGLISH = 2;

    private static $model_rules = [
        'update' => [
            [
                'field' => 'last_editor_id',
                'label' => 'Last Editor ID',
                'rules' => 'required|integer'
            ],
            [
                'field' => 'content',
                'label' => 'Content',
                'rules' => 'required'
            ]
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
